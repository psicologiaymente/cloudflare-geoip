<?php

namespace Psicologiaymente\CloudflareGeoIp\Facades;

use Illuminate\Support\Facades\Facade;

class GeoIp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cloudflare-geoip';
    }
}
