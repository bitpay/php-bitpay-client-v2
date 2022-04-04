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
    protected $_busd;
    protected $_xrp;
    protected $_doge;
    protected $_ltc;

    public function __construct()
    {
        $this->_btc = new MinerFeesItem();
        $this->_bch = new MinerFeesItem();
        $this->_eth = new MinerFeesItem();
        $this->_usdc = new MinerFeesItem();
        $this->_gusd = new MinerFeesItem();
        $this->_pax = new MinerFeesItem();
        $this->_busd = new MinerFeesItem();
        $this->_xrp = new MinerFeesItem();
        $this->_doge = new MinerFeesItem();
        $this->_ltc = new MinerFeesItem();
    }

    public function getBTC()
    {
        return $this->_btc;
    }

    public function setBTC(MinerFeesItem $btc)
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
        return $this->_eth;
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

    public function getBUSD()
    {
        return $this->_busd;
    }

    public function setBUSD(MinerFeesItem $busd)
    {
        $this->_busd = $busd;
    }

    public function getXRP()
    {
        return $this->_xrp;
    }

    public function setXRP(MinerFeesItem $xrp)
    {
        $this->_xrp = $xrp;
    }

    public function getDOGE()
    {
        return $this->_doge;
    }

    public function setDOGE(MinerFeesItem $doge)
    {
        $this->_doge = $doge;
    }

    public function getLTC()
    {
        return $this->_ltc;
    }

    public function setLTC(MinerFeesItem $ltc)
    {
        $this->_ltc = $ltc;
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
            'busd' => $this->getBUSD()->toArray(),
            'xrp'  => $this->getXRP()->toArray(),
            'doge' => $this->getDOGE()->toArray(),
            'ltc'  => $this->getLTC()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}