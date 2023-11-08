<?php

namespace PsicologiaYMente\CloudflareGeoIp\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PsicologiaYMente\CloudflareGeoIp\CloudflareGeoIpServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [CloudflareGeoIpServiceProvider::class];
    }
}
