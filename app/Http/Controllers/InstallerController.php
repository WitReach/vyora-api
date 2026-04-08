<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InstallerController extends Controller
{
    public function welcome()
    {
        // Check PHP requirements
        $requirements = [
            'PHP Version >= 8.2' => version_compare(phpversion(), '8.2.0', '>='),
            'BCMath' => extension_loaded('bcmath'),
            'Ctype' => extension_loaded('ctype'),
            'JSON' => extension_loaded('json'),
            'Mbstring' => extension_loaded('mbstring'),
            'OpenSSL' => extension_loaded('openssl'),
            'PDO' => extension_loaded('pdo'),
            'Tokenizer' => extension_loaded('tokenizer'),
            'XML' => extension_loaded('xml'),
        ];
        
        $allMet = !in_array(false, $requirements);

        return view('install.welcome', compact('requirements', 'allMet'));
    }

    public function database()
    {
        return view('install.database');
    }

    public function processDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
        ]);

        // Try connection
        try {
            $pdo = new \PDO(
                "mysql:host={$request->db_host};port={$request->db_port};dbname={$request->db_database}",
                $request->db_username,
                $request->db_password
            );
        } catch (\Exception $e) {
            return back()->withErrors(['connection' => 'Could not connect to database: ' . $e->getMessage()])->withInput();
        }

        // Write to .env
        $this->updateEnv([
            'DB_HOST' => $request->db_host,
            'DB_PORT' => $request->db_port,
            'DB_DATABASE' => $request->db_database,
            'DB_USERNAME' => $request->db_username,
            'DB_PASSWORD' => $request->db_password,
        ]);

        // Run Migrations
        Artisan::call('migrate:fresh --force');

        return redirect()->route('install.admin');
    }

    public function admin()
    {
        return view('install.admin');
    }

    public function processAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        // Mark installed
        File::put(storage_path('installed'), 'installed');

        return redirect()->route('dashboard');
    }

    private function updateEnv($data)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $env = file_get_contents($path);
            foreach ($data as $key => $value) {
                // If key exists, replace it
                if (strpos($env, $key . '=') !== false) {
                    $env = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $env);
                } else {
                    // Append if not exists
                    $env .= "\n{$key}=\"{$value}\"";
                }
            }
            file_put_contents($path, $env);
        }
    }
}
