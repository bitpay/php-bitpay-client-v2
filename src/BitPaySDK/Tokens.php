<?php

namespace BitPaySDK;

use BitPaySDK\Model\Facade;
use Exception;

/**
 * Class Tokens
 * @package Bitpay
 */
class Tokens
{
    /**
     * @var
     */
    protected $merchant;
    /**
     * @var
     */
    protected $payout;

    /**
     * Tokens constructor.
     * @param string|null $merchant
     * @param string|null $payout
     */
    public function __construct($merchant = null, $payout = null)
    {
        $this->merchant = $merchant;
        $this->payout = $payout;
    }

    public static function loadFromArray(array $tokens)
    {
        $instance = new self();

        foreach ($tokens as $facade => $token) {
            $instance->{$facade} = $token;
        }

        return $instance;
    }

    /**
     * @param $facade
     * @return string
     * @throws Exception
     */
    public function getTokenByFacade($facade)
    {
        $token = null;
        switch ($facade) {
            case Facade::Merchant:
                $token = $this->merchant;
                break;
            case Facade::Payout:
                $token = $this->payout;
                break;
        }

        if ($token) {
            return $token;
        }

        throw new Exception("given facade does not exist or no token defined for the given facade");
    }

    /**
     * @param $merchant
     */
    public function setMerchantToken($merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * @return mixed
     */
    public function getPayoutToken()
    {
        return $this->payout;
    }

    /**
     * @param $payout
     */
    public function setPayoutToken($payout)
    {
        $this->payout = $payout;
    }
}
