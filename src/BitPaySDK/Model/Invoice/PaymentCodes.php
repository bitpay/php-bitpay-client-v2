<?php


namespace BitPaySDK\Model\Invoice;


/**
 * PaymentCode will be deprecated TODO on version 4.0
 *
 * @deprecated
 */
class PaymentCodes
{
    protected $_btc;
    protected $_bch;
    protected $_eth;
    protected $_usdc;
    protected $_gusd;
    protected $_pax;

    public function __construct()
    {
        $this->_btc = new PaymentCode();
        $this->_bch = new PaymentCode();
        $this->_eth = new PaymentCode();
        $this->_usdc = new PaymentCode();
        $this->_gusd = new PaymentCode();
        $this->_pax = new PaymentCode();
    }

    public function getBTC()
    {
        return $this->_btc;
    }

    public function setBTC(PaymentCode $btc)
    {
        $this->_btc = $btc;
    }

    public function getBCH()
    {
        return $this->_bch;
    }

    public function setBCH(PaymentCode $bch)
    {
        $this->_bch = $bch;
    }

    public function getETH()
    {
        return $this->_eth;
    }

    public function setETH(PaymentCode $eth)
    {
        $this->_eth = $eth;
    }

    public function getUSDC()
    {
        return $this->_usdc;
    }

    public function setUSDC(PaymentCode $usdc)
    {
        $this->_usdc = $usdc;
    }

    public function getGUSD()
    {
        return $this->_gusd;
    }

    public function setGUSD(PaymentCode $gusd)
    {
        $this->_gusd = $gusd;
    }

    public function getPAX()
    {
        return $this->_pax;
    }

    public function setPAX(PaymentCode $pax)
    {
        $this->_pax = $pax;
    }

    public function toArray()
    {
        $elements = [
            'BTC'  => $this->getBTC()->toArray(),
            'BCH'  => $this->getBCH()->toArray(),
            'ETH'  => $this->getETH()->toArray(),
            'USDC' => $this->getUSDC()->toArray(),
            'GUSD' => $this->getGUSD()->toArray(),
            'PAX'  => $this->getPAX()->toArray(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}