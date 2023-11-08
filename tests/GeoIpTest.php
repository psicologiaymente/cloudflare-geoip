<?php

namespace PsicologiaYMente\CloudflareGeoIp\Tests;

use PsicologiaYMente\CloudflareGeoIp\Facades\GeoIp;

class GeoIpTest extends TestCase
{
    /** @test */
    public function it_returns_default_location_if_not_cloudflare_headers(): void
    {
        $location = GeoIp::getLocation();

        $this->assertEquals('US', $location->country);
        $this->assertEquals('America/New_York', $location->timezone);
        $this->assertEquals('CT', $location->regionCode);
        $this->assertEquals('Connecticut', $location->region);
        $this->assertEquals('New Haven', $location->city);
        $this->assertEquals('06510', $location->postalCode);
        $this->assertEquals(41.31, $location->latitude);
        $this->assertEquals(-72.92, $location->longitude);
        $this->assertEquals('127.0.0.0', $location->ip);
    }

    /**
     * @test
     *
     * @dataProvider cloudflareHeadersProvider
     */
    public function it_returns_location_from_cloudflare_headers($header, $headerValue, $property): void
    {
        $this->app['request']->headers->set($header, $headerValue);
        $this->app['request']->headers->set('Cf-Connecting-Ip', '172.0.23.2');
        $this->app['request']->headers->set('Cf-Ipcountry', 'ES');

        $location = GeoIp::getLocation();

        $this->assertEquals($headerValue, $location->{$property});
        $this->assertEquals('ES', $location->country);
        $this->assertEquals('172.0.23.2', $location->ip);
        $this->assertEquals([
            'ip'         => '172.0.23.2',
            'country'    => 'ES',
            $property    => $headerValue,
        ], $location->toArray());
    }

    /** @test */
    public function it_returns_pseudo_fields_from_location(): void
    {
        $location = GeoIp::getLocation();

        $this->assertEquals('US', $location->iso_code);
        $this->assertEquals('US', $location->isoCode);
        $this->assertEquals('CT', $location->state);
        $this->assertEquals('Connecticut', $location->state_name);
        $this->assertEquals('Connecticut', $location->stateName);
        $this->assertEquals(41.31, $location->lat);
        $this->assertEquals(-72.92, $location->lon);
        $this->assertEquals('06510', $location->postal_code);
    }

    /** @test */
    public function throws_error_if_property_does_not_exist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Property foo does not exist on this object.');

        $location = GeoIp::getLocation();

        $location->foo;
    }

    public static function cloudflareHeadersProvider(): array
    {
        return [
            ['Cf-Ipcity', 'Madrid', 'city'],
            ['Cf-Ipcontinent', 'EU', 'continent'],
            ['Cf-Iplatitude', 02.4165, 'latitude'],
            ['Cf-Iplongitude', -3.70256, 'longitude'],
            ['Cf-Postal-Code', '28001', 'postalCode'],
            ['Cf-Region', 'Comunidad de Madrid', 'region'],
            ['Cf-Region-Code', 'MD', 'regionCode'],
            ['Cf-Timezone', 'Europe/Madrid', 'timezone'],
        ];
    }
}
