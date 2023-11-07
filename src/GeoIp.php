<?php

namespace Psicologiaymente\CloudflareGeoIp;

use Illuminate\Http\Request;

class GeoIp
{
    public function __construct(
        public Request $request,
        public array $config,
    ) {
        //
    }

    public function getLocation(): Location
    {
        return new Location(
            ip: $this->getHeader('Cf-Connecting-Ip', 'ip'),
            city: $this->getHeader('Cf-Ipcity', 'city'),
            country: $this->getHeader('Cf-Ipcountry', 'country'),
            continent: $this->getHeader('Cf-Ipcontinent', 'continent'),
            latitude: $this->getHeader('Cf-Iplatitude', 'latitude'),
            longitude: $this->getHeader('Cf-Iplongitude', 'longitude'),
            postalCode: $this->getHeader('Cf-Postal-Code', 'postal_code'),
            region: $this->getHeader('Cf-Region', 'region'),
            regionCode: $this->getHeader('Cf-Region-Code', 'region_code'),
            timezone: $this->getHeader('Cf-Timezone', 'timezone'),
        );
    }

    protected function getHeader(string $headerKey, string $defaultKey): ?string
    {
        return $this->request->header($headerKey, $this->config['default_location'][$defaultKey] ?? null);
    }
}
