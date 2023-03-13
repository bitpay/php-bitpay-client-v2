<?php

namespace BitPaySDK;

/**
 * Class Config
 * @package Bitpay
 */
class Config
{
    /**
     * @var
     */
    protected $environment;
    /**
     * @var
     */
    protected $envConfig;

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return mixed
     */
    public function getEnvConfig()
    {
        return $this->envConfig;
    }

    /**
     * @param $envConfig
     */
    public function setEnvConfig($envConfig)
    {
        $this->envConfig = $envConfig;
    }
}
