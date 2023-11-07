<?php

namespace Psicologiaymente\CloudflareGeoIp\Tests;

use Psicologiaymente\CloudflareGeoIp\Facades\GeoIp;

class GeoIpTest extends TestCase
{
    /** @test */
    public function it_returns_default_location_if_not_cloudflare_headers(): void
    {
        $location = GeoIp::getLocation();

        $this->assertEquals('US', $location->iso_code);
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

        $location = GeoIp::getLocation();

        $this->assertEquals($headerValue, $location->{$property});
    }

    public static function cloudflareHeadersProvider(): array
    {
        return [
            ['Cf-Connecting-Ip', '192.182.88.29', 'ip'],
            ['Cf-Ipcity', 'Madrid', 'city'],
            ['Cf-Ipcountry', 'ES', 'country'],
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