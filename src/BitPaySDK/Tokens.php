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
    protected $payroll;//TODO DEPRECATED delete in version 6.0
    /**
     * @var
     */
    protected $payout;

    /**
     * Tokens constructor.
     * @param string|null $merchant
     * @param string|null $payroll
     */
    public function __construct($merchant = null, $payroll = null, $payout = null)
    {
        $this->merchant = $merchant;
        $this->payroll = $payroll;//TODO DEPRECATED delete in version 6.0
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
            case Facade::Payroll://TODO DEPRECATED delete in version 6.0
                $token = $this->payroll;
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
    public function getPayrollToken()//TODO DEPRECATED delete in version 6.0
    {
        return $this->payroll;
    }

    /**
     * @param $payroll
     */
    public function setPayrollToken($payroll)//TODO DEPRECATED delete in version 6.0
    {
        $this->payroll = $payroll;
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