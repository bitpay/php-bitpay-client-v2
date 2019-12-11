<?php


namespace BitPaySDK\Model\Invoice;


class PaymentTotal
{
    protected $_btc;
    protected $_bch;
    protected $_eth;
    protected $_usdc;
    protected $_gusd;
    protected $_pax;

    public function __construct()
    {
    }

    public function getBTC()
    {
        return $this->_btc;
    }

    public function setBTC(float $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(float $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_eth;
    }

    public function setETH(float $eth)
    {
        $this->_eth = $eth;
    }

    public function getUSDC()
    {
        return $this->_usdc;
    }

    public function setUSDC(float $usdc)
    {
        $this->_usdc = $usdc;
    }

    public function getGUSD()
    {
        return $this->_gusd;
    }

    public function setGUSD(float $gusd)
    {
        $this->_gusd = $gusd;
    }

    public function getPAX()
    {
        return $this->_pax;
    }

    public function setPAX(float $pax)
    {
        $this->_pax = $pax;
    }

    public function toArray()
    {
        $elements = [
            'BTC'  => $this->getBTC(),
            'BCH'  => $this->getBCH(),
            'ETH'  => $this->getETH(),
            'USDC' => $this->getUSDC(),
            'GUSD' => $this->getGUSD(),
            'PAX'  => $this->getPAX(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}