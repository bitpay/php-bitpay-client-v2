<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Object containing relevant information from the paid invoice
 */
class InvoiceData
{
    protected $_orderId;
    protected $_date;
    protected $_price;
    protected $_currency;
    protected $_transactionCurrency;
    protected $_overPaidAmount;
    protected $_payoutPercentage;
    protected $_btcPrice;
    /**
     * @var RefundInfo
     */
    protected $_refundInfo;

    public function __construct()
    {
    }

    /**
     * Gets Invoice orderId provided during invoice creation.
     *
     * @return string the order id
     */
    public function getOrderId()
    {
        return $this->_orderId;
    }

    /**
     * Sets Invoice orderId provided during invoice creation.
     *
     * @param string $orderId the order id
     */
    public function setOrderId(string $orderId)
    {
        $this->_orderId = $orderId;
    }

    /**
     * Gets Date at which the invoice was created (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @return string the date
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * Sets Date at which the invoice was created (UTC). ISO-8601 format yyyy-mm-ddThh:mm:ssZ
     *
     * @param string $date the date
     */
    public function setDate(string $date)
    {
        $this->_date = $date;
    }

    /**
     * Gets Invoice price in the invoice original currency
     *
     * @return float the price
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * Sets Invoice price in the invoice original currency
     *
     * @param float $price the price
     */
    public function setPrice(float $price)
    {
        $this->_price = $price;
    }

    /**
     * Gets Invoice currency
     *
     * @return string the Invoice currency
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets Invoice currency
     *
     * @param string $currency the Invoice currency
     */
    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Gets Cryptocurrency selected by the consumer when paying the invoice.
     *
     * @return string the transaction currency
     */
    public function getTransactionCurrency()
    {
        return $this->_transactionCurrency;
    }

    /**
     * Sets Cryptocurrency selected by the consumer when paying the invoice.
     *
     * @param string $transactionCurrency the transaction currency
     */
    public function setTransactionCurrency(string $transactionCurrency)
    {
        $this->_transactionCurrency = $transactionCurrency;
    }

    /**
     * Gets over paid amount
     *
     * @return float the over paid amount
     */
    public function getOverPaidAmount()
    {
        return $this->_overPaidAmount;
    }

    /**
     * Sets over paid amount
     *
     * @param float $overPaidAmount the over paid amount
     */
    public function setOverPaidAmount(float $overPaidAmount)
    {
        $this->_overPaidAmount = $overPaidAmount;
    }

    /**
     * Gets The payout percentage defined by the merchant on his BitPay account settings
     *
     * @return float the payout percentage
     */
    public function getPayoutPercentage()
    {
        return $this->_payoutPercentage;
    }

    /**
     * Sets The payout percentage defined by the merchant on his BitPay account settings
     *
     * @param float $payoutPercentage the payout percentage
     */
    public function setPayoutPercentage(float $payoutPercentage)
    {
        $this->_payoutPercentage = $payoutPercentage;
    }

    /**
     * Gets BTC price
     *
     * @return float the btc price
     */
    public function getBtcPrice()
    {
        return $this->_btcPrice;
    }

    /**
     * Sets BTC price
     *
     * @param float $btcPrice the btc price
     */
    public function setBtcPrice(float $btcPrice)
    {
        $this->_btcPrice = $btcPrice;
    }

    /**
     * Gets Object containing information about the refund executed for the invoice
     *
     * @return RefundInfo
     */
    public function getRefundInfo()
    {
        return $this->_refundInfo;
    }

    /**
     * Sets Object containing information about the refund executed for the invoice
     *
     * @param RefundInfo $refundInfo
     */
    public function setRefundInfo(RefundInfo $refundInfo)
    {
        $this->_refundInfo = $refundInfo;
    }

    /**
     * Gets InvoiceData as array
     *
     * @return array InvoiceData as array
     */
    public function toArray()
    {
        $elements = [
            'orderId'             => $this->getOrderId(),
            'date'                => $this->getDate(),
            'price'               => $this->getPrice(),
            'currency'            => $this->getCurrency(),
            'transactionCurrency' => $this->getTransactionCurrency(),
            'payoutPercentage'    => $this->getPayoutPercentage(),
            'refundInfo'          => $this->getRefundInfo()->toArray(),
        ];

        return $elements;
    }
}
