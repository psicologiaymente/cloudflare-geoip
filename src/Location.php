<?php

namespace Psicologiaymente\CloudflareGeoIp;

/**
 * @property string    $iso_code
 * @property string    $isoCode
 * @property string    $state
 * @property string    $state_name
 * @property string    $stateName
 * @property float|int $lat
 * @property float|int $lon
 */
class Location
{
    public function __construct(
        public readonly string $ip,
        public readonly string $city,
        public readonly string $country,
        public readonly string $continent,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $postalCode,
        public readonly string $region,
        public readonly string $regionCode,
        public readonly string $timezone,
    ) {
        //
    }

    public function __get($name)
    {
        $replications = [
            'iso_code'   => 'country',
            'isoCode'    => 'country',
            'state'      => 'regionCode',
            'state_name' => 'region',
            'stateName'  => 'region',
            'lat'        => 'latitude',
            'lon'        => 'longitude',
        ];

        if (! array_key_exists($name, $replications)) {
            throw new \InvalidArgumentException("Property {$name} does not exist on this object.");
        }

        return $this->{$replications[$name]};
    }
}
