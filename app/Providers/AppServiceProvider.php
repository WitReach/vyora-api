<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('theme_settings')) {
                $enabled = \App\Models\ThemeSetting::where('group', 'integration.algolia')->where('key', 'enabled')->value('value');
                if ($enabled === '1') {
                    $appId = \App\Models\ThemeSetting::where('group', 'integration.algolia')->where('key', 'app_id')->value('value');
                    $apiKey = \App\Models\ThemeSetting::where('group', 'integration.algolia')->where('key', 'admin_api_key')->value('value');
                    
                    if ($appId && $apiKey) {
                        try {
                            $appId = \Illuminate\Support\Facades\Crypt::decryptString($appId);
                            $apiKey = \Illuminate\Support\Facades\Crypt::decryptString($apiKey);
                            
                            config([
                                'scout.driver' => 'algolia',
                                'scout.algolia.id' => $appId,
                                'scout.algolia.secret' => $apiKey,
                            ]);
                        } catch (\Exception $e) {
                            config(['scout.driver' => 'database']);
                        }
                    } else {
                        config(['scout.driver' => 'database']);
                    }
                } else {
                    config(['scout.driver' => 'database']);
                }
            } else {
                config(['scout.driver' => 'database']);
            }
        } catch (\Exception $e) {
            config(['scout.driver' => 'database']);
        }
    }
}
