<?php


namespace Bitpay;


use Bitpay\Model\Facade;

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
    protected $payroll;

    /**
     * Tokens constructor.
     * @param string|null $merchant
     * @param string|null $payroll
     */
    public function __construct($merchant = null, $payroll = null)
    {
        $this->merchant = $merchant;
        $this->payroll = $payroll;
    }

    public function loadFromArray(array $tokens) {
        foreach($tokens as $facade => $token){
            $this->{$facade} = $token;
        }
    }

    /**
     * @param $facade
     * @return string
     * @throws \Exception
     */
    public function getTokenByFacade($facade)
    {
        $token = null;
        switch ($facade) {
            case Facade::Merchant:
                $token = $this->merchant;
            case Facade::Payroll:
                $token = $this->payroll;
        }

        if ($token) {
            return $token;
        }

        throw new \Exception("given facade does not exist or no token defined for the given facade");
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
    public function getPayrollToken()
    {
        return $this->payroll;
    }

    /**
     * @param $payroll
     */
    public function setPayrollToken($payroll)
    {
        $this->payroll = $payroll;
    }
}