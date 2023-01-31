<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Class SupportedTransactionCurrencies. The currencies that may be used to pay this invoice.
 *
 * @see <a href="https://bitpay.com/api/#rest-api-resources-invoices-resource">REST API Invoices</a>
 *
 * @package BitPaySDK\Model\Invoice
 */
class SupportedTransactionCurrencies
{
    protected $btc;
    protected $bch;
    protected $eth;
    protected $usdc;
    protected $gusd;
    protected $pax;
    protected $xrp;

    /**
     * SupportedTransactionCurrencies constructor.
     */
    public function __construct()
    {
        $this->btc = new SupportedTransactionCurrency();
        $this->bch = new SupportedTransactionCurrency();
        $this->eth = new SupportedTransactionCurrency();
        $this->usdc = new SupportedTransactionCurrency();
        $this->gusd = new SupportedTransactionCurrency();
        $this->pax = new SupportedTransactionCurrency();
        $this->xrp = new SupportedTransactionCurrency();
    }

    /**
     * Gets BTC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBTC()
    {
        return $this->btc;
    }

    /**
     * Sets BTC.
     *
     * @param SupportedTransactionCurrency $btc
     */
    public function setBTC(SupportedTransactionCurrency $btc)
    {
        $this->btc = $btc;
    }

    /**
     * Gets BCH.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBCH()
    {
        return $this->bch;
    }

    /**
     * Sets BCH.
     *
     * @param SupportedTransactionCurrency $bch
     */
    public function setBCH(SupportedTransactionCurrency $bch)
    {
        $this->bch = $bch;
    }

    /**
     * Gets ETH.
     *
     * @return SupportedTransactionCurrency
     */
    public function getETH()
    {
        return $this->eth;
    }

    /**
     * Sets ETH.
     *
     * @param SupportedTransactionCurrency $eth
     */
    public function setETH(SupportedTransactionCurrency $eth)
    {
        $this->eth = $eth;
    }

    /**
     * Gets USDC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getUSDC()
    {
        return $this->usdc;
    }

    /**
     * Sets USDC.
     *
     * @param SupportedTransactionCurrency $usdc
     */
    public function setUSDC(SupportedTransactionCurrency $usdc)
    {
        $this->usdc = $usdc;
    }

    /**
     * Gets GUSD.
     *
     * @return SupportedTransactionCurrency
     */
    public function getGUSD()
    {
        return $this->gusd;
    }

    /**
     * Sets GUSD.
     *
     * @param SupportedTransactionCurrency $gusd
     */
    public function setGUSD(SupportedTransactionCurrency $gusd)
    {
        $this->gusd = $gusd;
    }

    /**
     * Gets PAX.
     *
     * @return SupportedTransactionCurrency
     */
    public function getPAX()
    {
        return $this->pax;
    }

    /**
     * Sets PAX.
     *
     * @param SupportedTransactionCurrency $pax
     */
    public function setPAX(SupportedTransactionCurrency $pax)
    {
        $this->pax = $pax;
    }

    /**
     * Gets XRP.
     *
     * @return SupportedTransactionCurrency
     */
    public function getXRP()
    {
        return $this->xrp;
    }

    /**
     * Sets XRP.
     *
     * @param SupportedTransactionCurrency $xrp
     */
    public function setXRP(SupportedTransactionCurrency $xrp)
    {
        $this->xrp = $xrp;
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
            'xrp'  => $this->getXRP()->toArray()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
