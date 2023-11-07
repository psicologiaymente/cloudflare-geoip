<?php

namespace Psicologiaymente\CloudflareGeoIp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Psicologiaymente\CloudflareGeoIp\Location getLocation()
 *
 * @see \Psicologiaymente\CloudflareGeoIp\GeoIp
 */
class GeoIp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cloudflare-geoip';
    }
}
