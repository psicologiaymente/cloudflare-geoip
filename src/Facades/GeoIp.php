<?php

namespace PsicologiaYMente\CloudflareGeoIp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \PsicologiaYMente\CloudflareGeoIp\Location getLocation()
 *
 * @see \PsicologiaYMente\CloudflareGeoIp\GeoIp
 */
class GeoIp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cloudflare-geoip';
    }
}
