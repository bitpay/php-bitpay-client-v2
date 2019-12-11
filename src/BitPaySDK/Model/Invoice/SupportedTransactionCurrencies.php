<?php


namespace BitPaySDK\Model\Invoice;


class SupportedTransactionCurrencies
{
    protected $_btc;
    protected $_bch;
    protected $_eth;
    protected $_usdc;
    protected $_gusd;
    protected $_pax;

    public function __construct()
    {
        $this->_btc = new SupportedTransactionCurrency();
        $this->_bch = new SupportedTransactionCurrency();
        $this->_eth = new SupportedTransactionCurrency();
        $this->_usdc = new SupportedTransactionCurrency();
        $this->_gusd = new SupportedTransactionCurrency();
        $this->_pax = new SupportedTransactionCurrency();
    }

    public function getBTC()
    {
        return $this->_btc;
    }

    public function setBTC(SupportedTransactionCurrency $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(SupportedTransactionCurrency $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_eth;
    }

    public function setETH(SupportedTransactionCurrency $eth)
    {
        $this->_eth = $eth;
    }

    public function getUSDC()
    {
        return $this->_usdc;
    }

    public function setUSDC(SupportedTransactionCurrency $usdc)
    {
        $this->_usdc = $usdc;
    }

    public function getGUSD()
    {
        return $this->_gusd;
    }

    public function setGUSD(SupportedTransactionCurrency $gusd)
    {
        $this->_gusd = $gusd;
    }

    public function getPAX()
    {
        return $this->_pax;
    }

    public function setPAX(SupportedTransactionCurrency $pax)
    {
        $this->_pax = $pax;
    }

    public function toArray()
    {
        $elements = [
            'btc'  => $this->getBTC()->toArray(),
            'bch'  => $this->getBCH()->toArray(),
            'eth'  => $this->getETH()->toArray(),
            'usdc' => $this->getUSDC()->toArray(),
            'gusd' => $this->getGUSD()->toArray(),
            'pax'  => $this->getPAX()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}