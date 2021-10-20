<?php

namespace BitPaySDK\Model\Wallet;

/**
 *
 * @package Bitpay
 */
class Wallet
{
    protected $_key;
    protected $_displayName;
    protected $_avatar;
    protected $_paypro;
    protected $_currencies;

    /**
     * Constructor, create a minimal request Wallet object.
     *
     * @param $currencies details of what currencies support payments for this wallet 
    */
    public function __construct()
    {
        $this->_currencies = new Currencies();
    }

    public function getKey()
    {
        return $this->_key;
    }

    public function setKey(string $key)
    {
        $this->_key = $key;
    }

    public function getDisplayName()
    {
        return $this->_displayName;
    }

    public function setDisplayName(string $displayName)
    {
        $this->_displayName = $displayName;
    }

    public function getAvatar()
    {
        return $this->_avatar;
    }

    public function setAvatar(string $avatar)
    {
        $this->_avatar = $avatar;
    }

    public function getPayPro()
    {
        return $this->_payPro;
    }

    public function setPayPro(bool $payPro)
    {
        $this->_payPro = $payPro;
    }

    public function getCurrencies()
    {
        return $this->_currencies;
    }

    public function setCurrencies(Currencies $currencies)
    {
        $this->_currencies = $currencies;
    }

    public function toArray()
    {
        $elements = [
            'key'          => $this->getKey(),
            'displayName'  => $this->getDisplayName(),
            'avatar'       => $this->getAvatar(),
            'paypro'       => $this->getPayPro(),
            'currencies'   => $this->getCurrencies()->toArray()
        ];

        return $elements;
    }
}
