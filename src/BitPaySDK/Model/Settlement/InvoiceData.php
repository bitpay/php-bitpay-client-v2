<?php


namespace BitPaySDK\Model\Settlement;


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

    public function getOrderId()
    {
        return $this->_orderId;
    }

    public function setOrderId(string $orderId)
    {
        $this->_orderId = $orderId;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function setDate(string $date)
    {
        $this->_date = $date;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function setPrice(float $price)
    {
        $this->_price = $price;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    public function getTransactionCurrency()
    {
        return $this->_transactionCurrency;
    }

    public function setTransactionCurrency(string $transactionCurrency)
    {
        $this->_transactionCurrency = $transactionCurrency;
    }

    public function getOverPaidAmount()
    {
        return $this->_overPaidAmount;
    }

    public function setOverPaidAmount(float $overPaidAmount)
    {
        $this->_overPaidAmount = $overPaidAmount;
    }

    public function getPayoutPercentage()
    {
        return $this->_payoutPercentage;
    }

    public function setPayoutPercentage(float $payoutPercentage)
    {
        $this->_payoutPercentage = $payoutPercentage;
    }

    public function getBtcPrice()
    {
        return $this->_btcPrice;
    }

    public function setBtcPrice(float $btcPrice)
    {
        $this->_btcPrice = $btcPrice;
    }

    public function getRefundInfo()
    {
        return $this->_refundInfo;
    }

    public function setRefundInfo(RefundInfo $refundInfo)
    {
        $this->_refundInfo = $refundInfo;
    }

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