<?php

namespace Psicologiaymente\CloudflareGeoIp;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        if ($this->hasCloudflareHeaders()) {
            return $this->getCloudflareLocation();
        }

        return $this->getDefaultLocation();
    }

    protected function hasCloudflareHeaders(): bool
    {
        return $this->request->hasHeader('Cf-Connecting-Ip');
    }

    protected function getCloudflareLocation(): Location
    {
        return new Location(
            ip: $this->getHeader('Cf-Connecting-Ip'),
            country: $this->getHeader('Cf-Ipcountry'),
            city: $this->getHeader('Cf-Ipcity'),
            continent: $this->getHeader('Cf-Ipcontinent'),
            latitude: $this->getHeader('Cf-Iplatitude'),
            longitude: $this->getHeader('Cf-Iplongitude'),
            postalCode: $this->getHeader('Cf-Postal-Code'),
            region: $this->getHeader('Cf-Region'),
            regionCode: $this->getHeader('Cf-Region-Code'),
            timezone: $this->getHeader('Cf-Timezone'),
        );
    }

    protected function getDefaultLocation(): Location
    {
        return new Location(
            ip: $this->getConfig('ip'),
            country: $this->getConfig('country'),
            city: $this->getConfig('city'),
            continent: $this->getConfig('continent'),
            latitude: $this->getConfig('latitude'),
            longitude: $this->getConfig('longitude'),
            postalCode: $this->getConfig('postal_code'),
            region: $this->getConfig('region'),
            regionCode: $this->getConfig('region_code'),
            timezone: $this->getConfig('timezone'),
        );
    }

    protected function getHeader(string $headerKey, mixed $default = null): ?string
    {
        return $this->request->header($headerKey, $default);
    }

    protected function getConfig(string $configKey, mixed $default = null): mixed
    {
        return Arr::get($this->config['default_location'], $configKey, $default);
    }
}
