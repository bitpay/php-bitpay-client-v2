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
    protected $_btc;
    protected $_bch;
    protected $_eth;
    protected $_usdc;
    protected $_gusd;
    protected $_pax;
    protected $_xrp;

    /**
     * SupportedTransactionCurrencies constructor.
     */
    public function __construct()
    {
        $this->_btc = new SupportedTransactionCurrency();
        $this->_bch = new SupportedTransactionCurrency();
        $this->_eth = new SupportedTransactionCurrency();
        $this->_usdc = new SupportedTransactionCurrency();
        $this->_gusd = new SupportedTransactionCurrency();
        $this->_pax = new SupportedTransactionCurrency();
        $this->_xrp = new SupportedTransactionCurrency();
    }

    /**
     * Gets BTC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBTC()
    {
        return $this->_btc;
    }

    /**
     * Sets BTC.
     *
     * @param SupportedTransactionCurrency $btc
     */
    public function setBTC(SupportedTransactionCurrency $btc)
    {
        $this->_btc = $btc;
    }

    /**
     * Gets BCH.
     *
     * @return SupportedTransactionCurrency
     */
    public function getBCH()
    {
        return $this->_bch;
    }

    /**
     * Sets BCH.
     *
     * @param SupportedTransactionCurrency $bch
     */
    public function setBCH(SupportedTransactionCurrency $bch)
    {
        $this->_bch = $bch;
    }

    /**
     * Gets ETH.
     *
     * @return SupportedTransactionCurrency
     */
    public function getETH()
    {
        return $this->_eth;
    }

    /**
     * Sets ETH.
     *
     * @param SupportedTransactionCurrency $eth
     */
    public function setETH(SupportedTransactionCurrency $eth)
    {
        $this->_eth = $eth;
    }

    /**
     * Gets USDC.
     *
     * @return SupportedTransactionCurrency
     */
    public function getUSDC()
    {
        return $this->_usdc;
    }

    /**
     * Sets USDC.
     *
     * @param SupportedTransactionCurrency $usdc
     */
    public function setUSDC(SupportedTransactionCurrency $usdc)
    {
        $this->_usdc = $usdc;
    }

    /**
     * Gets GUSD.
     *
     * @return SupportedTransactionCurrency
     */
    public function getGUSD()
    {
        return $this->_gusd;
    }

    /**
     * Sets GUSD.
     *
     * @param SupportedTransactionCurrency $gusd
     */
    public function setGUSD(SupportedTransactionCurrency $gusd)
    {
        $this->_gusd = $gusd;
    }

    /**
     * Gets PAX.
     *
     * @return SupportedTransactionCurrency
     */
    public function getPAX()
    {
        return $this->_pax;
    }

    /**
     * Sets PAX.
     *
     * @param SupportedTransactionCurrency $pax
     */
    public function setPAX(SupportedTransactionCurrency $pax)
    {
        $this->_pax = $pax;
    }

    /**
     * Gets XRP.
     *
     * @return SupportedTransactionCurrency
     */
    public function getXRP()
    {
        return $this->_xrp;
    }

    /**
     * Sets XRP.
     *
     * @param SupportedTransactionCurrency $xrp
     */
    public function setXRP(SupportedTransactionCurrency $xrp)
    {
        $this->_xrp = $xrp;
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
