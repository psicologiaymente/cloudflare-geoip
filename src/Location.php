<?php

namespace Psicologiaymente\CloudflareGeoIp;

/**
 * @property string         $iso_code
 * @property string         $isoCode
 * @property null|string    $state
 * @property null|string    $state_name
 * @property null|string    $stateName
 * @property null|string    $postal_code
 * @property null|float|int $lat
 * @property null|float|int $lon
 */
class Location
{
    public function __construct(
        public readonly string $ip,
        public readonly string $country,
        public readonly ?string $city,
        public readonly ?string $continent = null,
        public readonly ?float $latitude = null,
        public readonly ?float $longitude = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $region = null,
        public readonly ?string $regionCode = null,
        public readonly ?string $timezone = null,
    ) {
        //
    }

    public function __get($name)
    {
        $replications = [
            'iso_code'    => 'country',
            'isoCode'     => 'country',
            'state'       => 'regionCode',
            'state_name'  => 'region',
            'stateName'   => 'region',
            'postal_code' => 'postalCode',
            'lat'         => 'latitude',
            'lon'         => 'longitude',
        ];

        if (! array_key_exists($name, $replications)) {
            throw new \InvalidArgumentException("Property {$name} does not exist on this object.");
        }

        return $this->{$replications[$name]};
    }
}
