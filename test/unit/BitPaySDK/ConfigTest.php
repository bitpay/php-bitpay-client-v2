<?php

namespace BitPaySDK\Test;

use BitPaySDK\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testInstanceOf()
    {
        $config = new Config();
        $this->assertInstanceOf(Config::class, $config);
    }

    public function testGetEnvironment()
    {
        $config = new Config();
        $environment = 'test';
        $config->setEnvironment($environment);
        $this->assertEquals($environment, $config->getEnvironment());
    }

    public function testGetEnvConfig()
    {
        $config = new Config();
        $envConfig = 'test';
        $config->setEnvConfig($envConfig);
        $this->assertEquals($envConfig, $config->getEnvConfig());
    }
}
