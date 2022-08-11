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
    protected $_environment;
    /**
     * @var
     */
    protected $_envConfig;

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }

    /**
     * @param $environment
     */
    public function setEnvironment($environment)
    {
        $this->_environment = $environment;
    }

    /**
     * @return mixed
     */
    public function getEnvConfig()
    {
        return $this->_envConfig;
    }

    /**
     * @param $envConfig
     */
    public function setEnvConfig($envConfig)
    {
        $this->_envConfig = $envConfig;
    }
}
