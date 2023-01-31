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
    protected $btc;
    protected $bch;
    protected $eth;
    protected $usdc;
    protected $gusd;
    protected $pax;
    protected $busd;
    protected $xrp;
    protected $doge;
    protected $ltc;

    /**
     * MinerFees constructor.
     */
    public function __construct()
    {
        $this->btc = new MinerFeesItem();
        $this->bch = new MinerFeesItem();
        $this->eth = new MinerFeesItem();
        $this->usdc = new MinerFeesItem();
        $this->gusd = new MinerFeesItem();
        $this->pax = new MinerFeesItem();
        $this->busd = new MinerFeesItem();
        $this->xrp = new MinerFeesItem();
        $this->doge = new MinerFeesItem();
        $this->ltc = new MinerFeesItem();
    }

    /**
     * Gets BTC.
     *
     * @return MinerFeesItem
     */
    public function getBTC()
    {
        return $this->btc;
    }

    /**
     * Sets BTC.
     *
     * @param MinerFeesItem $btc
     */
    public function setBTC(MinerFeesItem $btc)
    {
        $this->btc = $btc;
    }

    /**
     * Gets BCH.
     *
     * @return MinerFeesItem
     */
    public function getBCH()
    {
        return $this->bch;
    }

    /**
     * Sets BCH.
     *
     * @param MinerFeesItem $bch
     */
    public function setBCH(MinerFeesItem $bch)
    {
        $this->bch = $bch;
    }

    /**
     * Gets ETH.
     *
     * @return MinerFeesItem
     */
    public function getETH()
    {
        return $this->eth;
    }

    /**
     * Sets ETH.
     *
     * @param MinerFeesItem $eth
     */
    public function setETH(MinerFeesItem $eth)
    {
        $this->eth = $eth;
    }

    /**
     * Gets USDC.
     *
     * @return MinerFeesItem
     */
    public function getUSDC()
    {
        return $this->usdc;
    }

    /**
     * Sets USDC.
     *
     * @param MinerFeesItem $usdc
     */
    public function setUSDC(MinerFeesItem $usdc)
    {
        $this->usdc = $usdc;
    }

    /**
     * Gets GUSD.
     *
     * @return MinerFeesItem
     */
    public function getGUSD()
    {
        return $this->gusd;
    }

    /**
     * Sets GUSD.
     *
     * @param MinerFeesItem $gusd
     */
    public function setGUSD(MinerFeesItem $gusd)
    {
        $this->gusd = $gusd;
    }

    /**
     * Gets PAX.
     *
     * @return MinerFeesItem
     */
    public function getPAX()
    {
        return $this->pax;
    }

    /**
     * Sets PAX.
     *
     * @param MinerFeesItem $pax
     */
    public function setPAX(MinerFeesItem $pax)
    {
        $this->pax = $pax;
    }

    /**
     * Gets BUSD.
     *
     * @return MinerFeesItem
     */
    public function getBUSD()
    {
        return $this->busd;
    }

    /**
     * Sets BUSD.
     *
     * @param MinerFeesItem $busd
     */
    public function setBUSD(MinerFeesItem $busd)
    {
        $this->busd = $busd;
    }

    /**
     * Gets XRP.
     *
     * @return MinerFeesItem
     */
    public function getXRP()
    {
        return $this->xrp;
    }

    /**
     * Sets XRP.
     *
     * @param MinerFeesItem $xrp
     */
    public function setXRP(MinerFeesItem $xrp)
    {
        $this->xrp = $xrp;
    }

    /**
     * Gets DOGE.
     *
     * @return MinerFeesItem
     */
    public function getDOGE()
    {
        return $this->doge;
    }

    /**
     * Sets DOGE.
     *
     * @param MinerFeesItem $doge
     */
    public function setDOGE(MinerFeesItem $doge)
    {
        $this->doge = $doge;
    }

    /**
     * Gets LTC.
     *
     * @return MinerFeesItem
     */
    public function getLTC()
    {
        return $this->ltc;
    }

    /**
     * Sets LTC.
     *
     * @param MinerFeesItem $ltc
     */
    public function setLTC(MinerFeesItem $ltc)
    {
        $this->ltc = $ltc;
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
