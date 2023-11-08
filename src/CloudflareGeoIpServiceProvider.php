<?php

namespace PsicologiaYMente\CloudflareGeoIp;

use Illuminate\Support\ServiceProvider;

class CloudflareGeoIpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cloudflare-geoip.php', 'cloudflare-geoip');

        $this->app->singleton('cloudflare-geoip', fn ($app) => new GeoIP(
            $app->make('request'),
            $app->config->get('cloudflare-geoip'))
        );

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/cloudflare-geoip.php' => config_path('cloudflare-geoip.php'),
            ], 'cloudflare-geoip-config');
        }
    }
}
