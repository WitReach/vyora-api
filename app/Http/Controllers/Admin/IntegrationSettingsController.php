<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Razorpay\Api\Api;

class IntegrationSettingsController extends Controller
{
    // ── Integration Catalog ───────────────────────────────────────────────────

    private $integrations = [
        'razorpay' => [
            'name'        => 'Razorpay',
            'description' => 'Accept UPI, Cards, Net Banking & Wallets via Razorpay',
            'icon'        => 'razorpay',
            'status'      => 'active',
        ],
        
        'algolia' => [
            'name'        => 'Algolia Search',
            'description' => 'Lightning-fast, typo-tolerant search for your products',
            'icon'        => 'search',
            'status'      => 'active',
        ],
        'qikink' => [
            'name'        => 'Qikink',
            'description' => 'Automated Print on Demand and Dropshipping fulfillment',
            'icon'        => 'truck',
            'status'      => 'active',
        ],
        'smtp' => [
            'name'        => 'SMTP Email',
            'description' => 'Send transactional emails via a custom SMTP server',
            'icon'        => 'mail',
            'status'      => 'soon',
        ],
        'zoho-books' => [
            'name'        => 'Zoho Books',
            'description' => 'Sync orders with your Zoho Books accounting',
            'icon'        => 'book',
            'status'      => 'soon',
        ],
        'zoho-campaign' => [
            'name'        => 'Zoho Campaigns',
            'description' => 'Email marketing automation via Zoho',
            'icon'        => 'send',
            'status'      => 'soon',
        ],
        'whatsapp' => [
            'name'        => 'WhatsApp Business API',
            'description' => 'Connect WhatsApp for order notifications and customer support',
            'icon'        => 'whatsapp',
            'status'      => 'soon',
        ],
        'google-analytics' => [
            'name'        => 'Google Analytics',
            'description' => 'Track visitors and trace conversion data using GA4 properties',
            'icon'        => 'google-analytics',
            'status'      => 'soon',
        ],
        'meta-pixel' => [
            'name'        => 'Meta Pixel API',
            'description' => 'Track user behaviors and optimize Meta/Facebook ad campaigns',
            'icon'        => 'meta-pixel',
            'status'      => 'soon',
        ],
        'bing-webmaster' => [
            'name'        => 'Bing Webmaster',
            'description' => 'Submit sitemaps and index products with Microsoft Bing search engine',
            'icon'        => 'bing',
            'status'      => 'soon',
        ],
        'google-search-console' => [
            'name'        => 'Google Search Console',
            'description' => 'Monitor Google Search performance and crawl status for your storefront',
            'icon'        => 'google-search-console',
            'status'      => 'soon',
        ],
        'google-merchant' => [
            'name'        => 'Google Merchant Center',
            'description' => 'Sync your products with Google Shopping feeds and free listings',
            'icon'        => 'google-merchant',
            'status'      => 'soon',
        ],
        'ondc' => [
            'name'        => 'ONDC Network Integration',
            'description' => 'List and sell products across the open commerce network in India',
            'icon'        => 'ondc',
            'status'      => 'soon',
        ],
        'social-login' => [
            'name'        => 'Social Login Integration',
            'description' => 'Allow customers to log in using Google, Facebook, or Apple credentials',
            'icon'        => 'social-login',
            'status'      => 'soon',
        ],
        'twilio' => [
            'name'        => 'SMS Integration (Twilio)',
            'description' => 'Send instant order tracking and verification notifications via Twilio SMS API',
            'icon'        => 'twilio',
            'status'      => 'soon',
        ],
        'slack' => [
            'name'        => 'Slack Integration',
            'description' => 'Receive instant notifications for new orders and store alerts in your Slack channels',
            'icon'        => 'slack',
            'status'      => 'soon',
        ],
    ];

    // ── Index ─────────────────────────────────────────────────────────────────

    public function index()
    {
        // Attach live status from DB for each integration
        $settings = ThemeSetting::where('group', 'like', 'integration.%')->get()->keyBy(function ($s) {
            return $s->group . '.' . $s->key;
        });

        $integrations = collect($this->integrations)->map(function ($data, $slug) use ($settings) {
            $enabled = $settings->get("integration.{$slug}.enabled")?->value === '1';
            $mode    = $settings->get("integration.{$slug}.mode")?->value ?? 'test';
            $data['enabled'] = $enabled;
            $data['mode']    = $mode;
            return $data;
        });

        return view('admin.integrations.index', compact('integrations'));
    }

    // ── Show Individual Integration ───────────────────────────────────────────

    public function show($slug)
    {
        if (!array_key_exists($slug, $this->integrations)) {
            abort(404);
        }

        $integration = $this->integrations[$slug];
        $rows        = ThemeSetting::where('group', "integration.{$slug}")->get()->keyBy('key');

        // Pull saved settings (decrypt sensitive values)
        $saved = [
            'enabled'       => $rows->get('enabled')?->value === '1',
            'mode'          => $rows->get('mode')?->value ?? 'test',
            'app_id'          => $rows->get('app_id') ? $this->maybeDecrypt($rows->get('app_id')->value) : '',
            'admin_api_key'   => $rows->get('admin_api_key') ? $this->maskedSecret($rows->get('admin_api_key')->value) : '',
            'key_id'        => $rows->get('key_id') ? $this->maybeDecrypt($rows->get('key_id')->value) : '',
            'key_secret'    => $rows->get('key_secret') ? $this->maskedSecret($rows->get('key_secret')->value) : '',
            'client_id'     => $rows->get('client_id') ? $this->maybeDecrypt($rows->get('client_id')->value) : '',
            'client_secret' => $rows->get('client_secret') ? $this->maskedSecret($rows->get('client_secret')->value) : '',
        ];

        return view("admin.integrations.{$slug}", compact('integration', 'slug', 'saved'));
    }

    // ── Save Settings ─────────────────────────────────────────────────────────

    public function update(Request $request, $slug)
    {
        if (!array_key_exists($slug, $this->integrations)) {
            abort(404);
        }

        if ($slug === 'algolia') {
            return $this->updateAlgolia($request);
        }

        if ($slug === 'razorpay') {
            return $this->updateRazorpay($request);
        }

        if ($slug === 'qikink') {
            return $this->updateQikink($request);
        }

        return redirect()->back()->with('success', 'Integration settings updated successfully.');
    }

    private function updateRazorpay(Request $request)
    {
        $request->validate([
            'mode'       => 'required|in:test,live',
            'key_id'     => 'required|string',
            'key_secret' => 'required|string|min:4',
        ]);

        $group = 'integration.razorpay';

        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'enabled'],  ['value' => $request->boolean('enabled') ? '1' : '0']);
        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'mode'],     ['value' => $request->mode]);
        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'key_id'],   ['value' => Crypt::encryptString($request->key_id)]);

        // Only update secret if not the masked placeholder
        if (!str_contains($request->key_secret, '****')) {
            ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'key_secret'], ['value' => Crypt::encryptString($request->key_secret)]);
        }

        return redirect()->back()->with('success', 'Razorpay settings saved successfully.');
    }

    // ── Test Connection (AJAX) ────────────────────────────────────────────────

    public function testRazorpay(Request $request)
    {
        $group = 'integration.razorpay';
        $rows  = ThemeSetting::where('group', $group)->get()->keyBy('key');

        try {
            $keyId     = $this->maybeDecrypt($rows->get('key_id')?->value ?? '');
            $keySecret = $this->maybeDecrypt($rows->get('key_secret')?->value ?? '');

            if (!$keyId || !$keySecret) {
                return response()->json(['success' => false, 'message' => 'API credentials not configured. Save your keys first.']);
            }

            $api = new Api($keyId, $keySecret);

            // Lightweight read call — fetch last 1 payment (returns empty array if none, still auth-checks)
            $api->payment->all(['count' => 1]);

            return response()->json(['success' => true, 'message' => 'Connection successful! Razorpay credentials are valid.']);
        } catch (\Razorpay\Api\Errors\AuthenticationError $e) {
            return response()->json(['success' => false, 'message' => 'Authentication failed. Check your Key ID and Secret.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    public function testQikink(Request $request)
    {
        $group = 'integration.qikink';
        $rows  = ThemeSetting::where('group', $group)->get()->keyBy('key');

        try {
            $clientId     = $this->maybeDecrypt($rows->get('client_id')?->value ?? '');
            $clientSecret = $this->maybeDecrypt($rows->get('client_secret')?->value ?? '');
            $mode         = $rows->get('mode')?->value ?? 'test';

            if (!$clientId || !$clientSecret) {
                return response()->json(['success' => false, 'message' => 'API credentials not configured. Save your keys first.']);
            }

            $endpoint = $mode === 'live' ? 'https://api.qikink.com/api/token' : 'https://sandbox.qikink.com/api/token';

            $response = \Illuminate\Support\Facades\Http::asForm()->post($endpoint, [
                'ClientId' => $clientId,
                'client_secret' => $clientSecret,
            ]);

            if ($response->successful() && $response->json('Accesstoken')) {
                return response()->json(['success' => true, 'message' => 'Connection successful! Qikink credentials are valid.']);
            }

            $errorDetail = $response->body();
            return response()->json(['success' => false, 'message' => 'Authentication failed. Check your Client ID and Secret. Details: ' . $errorDetail]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

        public function testAlgolia(Request $request)
    {
        $group = 'integration.algolia';
        $rows  = ThemeSetting::where('group', $group)->get()->keyBy('key');

        try {
            $appId  = $this->maybeDecrypt($rows->get('app_id')?->value ?? '');
            $apiKey = $this->maybeDecrypt($rows->get('admin_api_key')?->value ?? '');

            if (!$appId || !$apiKey) {
                return response()->json(['success' => false, 'message' => 'API credentials not configured. Save your keys first.']);
            }

            // Using Algolia Search Client
            $client = AlgoliaAlgoliaSearchSearchClient::create($appId, $apiKey);
            // Verify by fetching indices
            $client->listIndices();

            return response()->json(['success' => true, 'message' => 'Connection successful! Algolia credentials are valid.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Authentication failed. Check your App ID and Admin API Key.']);
        }
    }

    private function updateAlgolia(Request $request)
    {
        $request->validate([
            'app_id'        => 'required|string',
            'admin_api_key' => 'required|string|min:4',
        ]);

        $group = 'integration.algolia';

        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'enabled'],  ['value' => $request->boolean('enabled') ? '1' : '0']);
        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'app_id'],   ['value' => Crypt::encryptString($request->app_id)]);

        if (!str_contains($request->admin_api_key, '****')) {
            ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'admin_api_key'], ['value' => Crypt::encryptString($request->admin_api_key)]);
        }

        return redirect()->back()->with('success', 'Algolia settings saved successfully.');
    }

    private function updateQikink(Request $request)
    {
        $request->validate([
            'mode'          => 'required|in:test,live',
            'client_id'     => 'required|string',
            'client_secret' => 'required|string|min:4',
        ]);

        $group = 'integration.qikink';

        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'enabled'],  ['value' => $request->boolean('enabled') ? '1' : '0']);
        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'mode'],     ['value' => $request->mode]);
        ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'client_id'],   ['value' => Crypt::encryptString($request->client_id)]);

        if (!str_contains($request->client_secret, '****')) {
            ThemeSetting::updateOrCreate(['group' => $group, 'key' => 'client_secret'], ['value' => Crypt::encryptString($request->client_secret)]);
        }

        return redirect()->back()->with('success', 'Qikink settings saved successfully.');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function maybeDecrypt(?string $value): string
    {
        if (!$value) return '';
        try {
            return Crypt::decryptString($value);
        } catch (\Exception) {
            return $value; // Return as-is if not encrypted
        }
    }

    private function maskedSecret(?string $encryptedValue): string
    {
        if (!$encryptedValue) return '';
        try {
            $plain = Crypt::decryptString($encryptedValue);
            return substr($plain, 0, 4) . str_repeat('*', max(0, strlen($plain) - 8)) . substr($plain, -4);
        } catch (\Exception) {
            return '****';
        }
    }
}
