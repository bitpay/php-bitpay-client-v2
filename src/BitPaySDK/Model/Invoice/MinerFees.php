<?php


namespace BitPaySDK\Model\Invoice;


class MinerFees
{
    protected $_btc;
    protected $_bch;
    protected $_eth;
    protected $_usdc;
    protected $_gusd;
    protected $_pax;

    public function __construct()
    {
        $this->_btc = new MinerFeesItem();
        $this->_bch = new MinerFeesItem();
        $this->_eth = new MinerFeesItem();
        $this->_usdc = new MinerFeesItem();
        $this->_gusd = new MinerFeesItem();
        $this->_pax = new MinerFeesItem();
    }

    public function getBTH()
    {
        return $this->_btc;
    }

    public function setBTH(MinerFeesItem $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(MinerFeesItem $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_bch;
    }

    public function setETH(MinerFeesItem $eth)
    {
        $this->_eth = $eth;
    }

    public function getUSDC()
    {
        return $this->_usdc;
    }

    public function setUSDC(MinerFeesItem $usdc)
    {
        $this->_usdc = $usdc;
    }

    public function getGUSD()
    {
        return $this->_gusd;
    }

    public function setGUSD(MinerFeesItem $gusd)
    {
        $this->_gusd = $gusd;
    }

    public function getPAX()
    {
        return $this->_pax;
    }

    public function setPAX(MinerFeesItem $pax)
    {
        $this->_pax = $pax;
    }

    public function toArray()
    {
        $elements = [
            'btc'  => $this->getBTH()->toArray(),
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