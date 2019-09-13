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

    /**
     * @param $facade
     * @return string|null
     * @throws \Exception
     */
    public function getTokenByFacade($facade)
    {
        switch ($facade) {
            case Facade::Merchant:
                return $this->merchant;
            case Facade::Payroll:
                return $this->payroll;
        }

        throw new \Exception("given facade does not exist");
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