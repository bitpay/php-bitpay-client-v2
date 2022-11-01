<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * The total amount of fees that the purchaser will pay to cover BitPay's UTXO sweep cost for an invoice.
 * The key is the currency and the value is an object containing the satoshis per byte,
 * the total fee, and the fiat amount. This is referenced as "Network Cost" on an invoice,
 * see this support article for more information.
 *
 * @see <a href="https://bitpay.com/api/#rest-api-resources-invoices-resource">REST API Invoices</a>
 */
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

    /**
     * MinerFees constructor.
     */
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

    /**
     * Gets BTC.
     *
     * @return MinerFeesItem
     */
    public function getBTC()
    {
        return $this->_btc;
    }

    /**
     * Sets BTC.
     *
     * @param MinerFeesItem $btc
     */
    public function setBTC(MinerFeesItem $btc)
    {
        $this->_btc = $btc;
    }

    /**
     * Gets BCH.
     *
     * @return MinerFeesItem
     */
    public function getBCH()
    {
        return $this->_bch;
    }

    /**
     * Sets BCH.
     *
     * @param MinerFeesItem $bch
     */
    public function setBCH(MinerFeesItem $bch)
    {
        $this->_bch = $bch;
    }

    /**
     * Gets ETH.
     *
     * @return MinerFeesItem
     */
    public function getETH()
    {
        return $this->_eth;
    }

    /**
     * Sets ETH.
     *
     * @param MinerFeesItem $eth
     */
    public function setETH(MinerFeesItem $eth)
    {
        $this->_eth = $eth;
    }

    /**
     * Gets USDC.
     *
     * @return MinerFeesItem
     */
    public function getUSDC()
    {
        return $this->_usdc;
    }

    /**
     * Sets USDC.
     *
     * @param MinerFeesItem $usdc
     */
    public function setUSDC(MinerFeesItem $usdc)
    {
        $this->_usdc = $usdc;
    }

    /**
     * Gets GUSD.
     *
     * @return MinerFeesItem
     */
    public function getGUSD()
    {
        return $this->_gusd;
    }

    /**
     * Sets GUSD.
     *
     * @param MinerFeesItem $gusd
     */
    public function setGUSD(MinerFeesItem $gusd)
    {
        $this->_gusd = $gusd;
    }

    /**
     * Gets PAX.
     *
     * @return MinerFeesItem
     */
    public function getPAX()
    {
        return $this->_pax;
    }

    /**
     * Sets PAX.
     *
     * @param MinerFeesItem $pax
     */
    public function setPAX(MinerFeesItem $pax)
    {
        $this->_pax = $pax;
    }

    /**
     * Gets BUSD.
     *
     * @return MinerFeesItem
     */
    public function getBUSD()
    {
        return $this->_busd;
    }

    /**
     * Sets BUSD.
     *
     * @param MinerFeesItem $busd
     */
    public function setBUSD(MinerFeesItem $busd)
    {
        $this->_busd = $busd;
    }

    /**
     * Gets XRP.
     *
     * @return MinerFeesItem
     */
    public function getXRP()
    {
        return $this->_xrp;
    }

    /**
     * Sets XRP.
     *
     * @param MinerFeesItem $xrp
     */
    public function setXRP(MinerFeesItem $xrp)
    {
        $this->_xrp = $xrp;
    }

    /**
     * Gets DOGE.
     *
     * @return MinerFeesItem
     */
    public function getDOGE()
    {
        return $this->_doge;
    }

    /**
     * Sets DOGE.
     *
     * @param MinerFeesItem $doge
     */
    public function setDOGE(MinerFeesItem $doge)
    {
        $this->_doge = $doge;
    }

    /**
     * Gets LTC.
     *
     * @return MinerFeesItem
     */
    public function getLTC()
    {
        return $this->_ltc;
    }

    /**
     * Sets LTC.
     *
     * @param MinerFeesItem $ltc
     */
    public function setLTC(MinerFeesItem $ltc)
    {
        $this->_ltc = $ltc;
    }

    /**
     * Return array with details for currencies.
     *
     * @return array
     */
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
