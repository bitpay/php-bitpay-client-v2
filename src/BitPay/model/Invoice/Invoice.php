<?php

namespace Bitpay\Model\Invoice;

/**
 *
 * @package Bitpay
 */
class Invoice
{
    protected $_currency;

    protected $_guid = "";
    protected $_token = "";

    protected $_price;
    protected $_posData = "";
    protected $_notificationURL = "";
    protected $_transactionSpeed = "";
    protected $_fullNotifications = false;
    protected $_notificationEmail = "";
    protected $_redirectURL = "";
    protected $_orderId = "";
    protected $_itemDesc = "";
    protected $_itemCode = "";
    protected $_physical = false;
    protected $_paymentCurrencies;
    protected $_acceptanceWindow;
    protected $_buyer;

    protected $_id;
    protected $_url;
    protected $_status;
    protected $_lowFeeDetected;
    protected $_invoiceTime;
    protected $_expirationTime;
    protected $_currentTime;
    protected $_transactions;
    protected $_exceptionStatus;
    protected $_refundAddressRequestPending;
    protected $_invoiceBuyerProvidedInfo;
    protected $_supportedTransactionCurrencies;
    protected $_minerFees;
    protected $_paymentCodes;
    protected $_extendedNotifications = false;

    protected $_transactionCurrency;
    protected $_amountPaid;
    protected $_exchangeRates;
    protected $_paymentTotals;
    protected $_paymentSubtotals;
    protected $_paymentDisplayTotals;
    protected $_paymentDisplaySubTotals;

    /**
     * Constructor, create an empty Invoice object.
     */
    public function __construct() {
        $this->_buyer = new Buyer();
        $this->_invoiceBuyerProvidedInfo = new InvoiceBuyerProvidedInfo();
        $this->_supportedTransactionCurrencies = new SupportedTransactionCurrencies();
        $this->_minerFees = new MinerFees();
        $this->_paymentCodes = new PaymentCodes();
        $this->_paymentTotals = new PaymentTotal();
        $this->_paymentSubtotals = new PaymentTotal();
        $this->_paymentDisplayTotals = new PaymentTotal();
        $this->_paymentDisplaySubTotals = new PaymentTotal();
    }

    /**
     * Creator, create a minimal request Invoice object.
     *
     * @param $price    float The amount for which the invoice will be created.
     * @param $currency string three digit currency type used to compute the invoice bitcoin amount.
     */
    public static function create(float $price, string $currency) {
        $instance = new self();
        $instance->_price = $price;
        $instance->_currency = $currency;
    }

    // API fields
    //

    public function getGuid() {
        return $this->_guid;
    }

    public function setGuid(string $guid) {
        $this->_guid = $guid;
    }

    public function getToken() {
        return $this->_token;
    }

    public function setToken(string $token) {
        $this->_token = $token;
    }

    // Required fields
    //

    public function getPrice() {
        return $this->_price;
    }

    public function setPrice(float $price) {
        $this->_price = $price;
    }

    public function getCurrency() {
        return $this->_currency;
    }

    public function setCurrency(string $currency) {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("Error: currency code must be a type of Model.Currency");
        }

        $this->_currency = $currency;
    }

    // Optional fields
    //

    public function getOrderId() {
        return $this->_orderId;
    }

    public function setOrderId(string $orderId) {
        $this->_orderId = $orderId;
    }

    public function getItemDesc() {
        return $this->_itemDesc;
    }

    public function setItemDesc(string $itemDesc) {
        $this->_itemDesc = $itemDesc;
    }

    public function getItemCode() {
        return $this->_itemCode;
    }

    public function setItemCode(string $itemCode) {
        $this->_itemCode = $itemCode;
    }

    public function getPosData() {
        return $this->_posData;
    }

    public function setPosData(string $posData) {
        $this->_posData = $posData;
    }

    public function getNotificationURL() {
        return $this->_notificationURL;
    }

    public function setNotificationURL(string $notificationURL) {
        $this->_notificationURL = $notificationURL;
    }

    public function getTransactionSpeed() {
        return $this->_transactionSpeed;
    }

    public function setTransactionSpeed(string $transactionSpeed) {
        $this->_transactionSpeed = $transactionSpeed;
    }

    public function getFullNotifications() {
        return $this->_fullNotifications;
    }

    public function setFullNotifications(bool $fullNotifications) {
        $this->_fullNotifications = $fullNotifications;
    }

    public function getExtendedNotifications() {
        return $this->_extendedNotifications;
    }

    public function setExtendedNotifications(bool $extendedNotifications) {
        $this->_extendedNotifications = $extendedNotifications;
    }

    public function getNotificationEmail() {
        return $this->_notificationEmail;
    }

    public function setNotificationEmail(string $notificationEmail) {
        $this->_notificationEmail = $notificationEmail;
    }

    public function getRedirectURL() {
        return $this->_redirectURL;
    }

    public function setRedirectURL(string $redirectURL) {
        $this->_redirectURL = $redirectURL;
    }

    public function getPhysical() {
        return $this->_physical;
    }

    public function setPhysical(bool $physical) {
        $this->_physical = $physical;
    }

    public function getPaymentCurrencies() {
        return $this->_paymentCurrencies;
    }

    public function setPaymentCurrencies(array $paymentCurrencies) {
        $this->_paymentCurrencies = $paymentCurrencies;
    }

    public function getAcceptanceWindow() {
        return $this->_acceptanceWindow;
    }

    public function setAcceptanceWindow(float $acceptanceWindow) {
        $this->_acceptanceWindow = $acceptanceWindow;
    }

    // Buyer data
    //

    public function getBuyer() {
        return $this->_buyer;
    }

    public function setBuyer(Buyer $buyer) {
        $this->_buyer = $buyer;
    }

    // Response fields
    //

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getUrl() {
        return $this->_url;
    }

    public function setUrl($url) {
        $this->_url = $url;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function setStatus($status) {
        $this->_status = $status;
    }

    public function getLowFeeDetected() {
        return $this->_lowFeeDetected;
    }

    public function setLowFeeDetected($lowFeeDetected) {
        $this->_lowFeeDetected = $lowFeeDetected;
    }

    public function getInvoiceTime() {
        return $this->_invoiceTime;
    }

    public function setInvoiceTime($invoiceTime) {
        $this->_invoiceTime = $invoiceTime;
    }

    public function getExpirationTime() {
        return $this->_expirationTime;
    }

    public function setExpirationTime($expirationTime) {
        $this->_expirationTime = $expirationTime;
    }

    public function getCurrentTime() {
        return $this->_currentTime;
    }

    public function setCurrentTime($currentTime) {
        $this->_currentTime = $currentTime;
    }

    public function getTransactions() {
        return $this->_transactions;
    }

    public function setTransactions($transactions) {
        $this->_transactions = $transactions;
    }

    public function getExceptionStatus() {
        return $this->_exceptionStatus;
    }

    public function setExceptionStatus($exceptionStatus) {
        $this->_exceptionStatus = $exceptionStatus;
    }

    public function getRefundAddressRequestPending() {
        return $this->_refundAddressRequestPending;
    }

    public function setRefundAddressRequestPending($refundAddressRequestPending) {
        $this->_refundAddressRequestPending = $refundAddressRequestPending;
    }

    public function getInvoiceBuyerProvidedInfo() {
        return $this->_invoiceBuyerProvidedInfo;
    }

    public function setInvoiceBuyerProvidedInfo(InvoiceBuyerProvidedInfo $invoiceBuyerProvidedInfo) {
        $this->_invoiceBuyerProvidedInfo = $invoiceBuyerProvidedInfo;
    }

    public function getSupportedTransactionCurrencies() {
        return $this->_supportedTransactionCurrencies;
    }

    public function setSupportedTransactionCurrencies(SupportedTransactionCurrencies $supportedTransactionCurrencies) {
        $this->_supportedTransactionCurrencies = $supportedTransactionCurrencies;
    }

    public function getMinerFees() {
        return $this->_minerFees;
    }

    public function setMinerFees(MinerFees $minerFees) {
        $this->_minerFees = $minerFees;
    }

    public function getTransactionCurrency() {
        return $this->_transactionCurrency;
    }

    public function setTransactionCurrency($transactionCurrency) {
        $this->_transactionCurrency = $transactionCurrency;
    }

    public function getPaymentCodes() {
        return $this->_paymentCodes;
    }

    public function setPaymentCodes(PaymentCodes $paymentCodes) {
        $this->_paymentCodes = $paymentCodes;
    }

    public function getPaymentSubtotals() {
        return $this->_paymentSubtotals;
    }

    public function setPaymentSubtotals($paymentSubtotals) {
        $this->_paymentSubtotals = $paymentSubtotals;
    }

    public function getPaymentTotals() {
        return $this->_paymentTotals;
    }

    public function setPaymentTotals($paymentTotals) {
        $this->_paymentTotals = $paymentTotals;
    }

    public function getPaymentDisplayTotals() {
        return $this->_paymentDisplayTotals;
    }

    public function setPaymentDisplayTotals($paymentDisplayTotals) {
        $this->_paymentDisplayTotals = $paymentDisplayTotals;
    }

    public function getPaymentDisplaySubTotals() {
        return $this->_paymentDisplaySubTotals;
    }

    public function setPaymentDisplaySubTotals($paymentDisplaySubTotals) {
        $this->_paymentDisplaySubTotals = $paymentDisplaySubTotals;
    }

    public function getAmountPaid() {
        return $this->_amountPaid;
    }

    public function setAmountPaid($amountPaid) {
        $this->_amountPaid = $amountPaid;
    }

    public function getExchangeRates() {
        return $this->_exchangeRates;
    }

    public function setExchangeRates($exchangeRates) {
        $this->_exchangeRates = $exchangeRates;
    }
}
