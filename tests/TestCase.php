<?php

namespace Psicologiaymente\CloudflareGeoIp\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Psicologiaymente\CloudflareGeoIp\CloudflareGeoIpServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [CloudflareGeoIpServiceProvider::class];
    }
}
