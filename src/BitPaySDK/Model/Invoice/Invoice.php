<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 *
 * @package Bitpay
 */
class Invoice
{
    protected $_currency;

    protected $_guid  = "";
    protected $_token = "";

    protected $_price;
    protected $_posData;
    protected $_notificationURL   = "";
    protected $_transactionSpeed  = "";
    protected $_fullNotifications = false;
    protected $_notificationEmail = "";
    protected $_redirectURL       = "";
    protected $_orderId           = "";
    protected $_itemDesc          = "";
    protected $_itemCode          = "";
    protected $_physical          = false;
    protected $_paymentCurrencies;
    protected $_paymentSubtotals;
    protected $_paymentTotals;
    protected $_paymentDisplayTotals;
    protected $_paymentDisplaySubTotals;
    protected $_paymentCodes;
    protected $_paymentString;
    protected $_verificationLink;
    protected $_acceptanceWindow;
    protected $_buyer;
    protected $_refundAddresses;
    protected $_closeURL   = "";
    protected $_autoRedirect  = false;
    protected $_jsonPayProRequired;
    protected $_buyerEmail;
    protected $_buyerSms;

    protected $_merchantName;
    protected $_selectedTransactionCurrency;
    protected $_forcedBuyerSelectedWallet;
    protected $_forcedBuyerSelectedTransactionCurrency;
    protected $_itemizedDetails;

    protected $_id;
    protected $_url;
    protected $_status;
    protected $_lowFeeDetected;
    protected $_invoiceTime;
    protected $_expirationTime;
    protected $_currentTime;
    protected $_transactions;
    protected $_exceptionStatus;
    protected $_targetConfirmations;
    protected $_refundAddressRequestPending;
    protected $_buyerProvidedEmail;
    protected $_buyerProvidedInfo;
    protected $_transactionDetails;
    protected $_universalCodes;
    protected $_supportedTransactionCurrencies;
    protected $_minerFees;
    protected $_nonPayProPaymentReceived;
    protected $_shopper;
    protected $_billId;
    protected $_refundInfo;
    protected $_extendedNotifications = false;
    protected $_isCancelled;

    protected $_transactionCurrency;
    protected $_underpaidAmount;
    protected $_overpaidAmount;
    protected $_amountPaid;
    protected $_displayAmountPaid;
    protected $_exchangeRates;
    protected $_bitpayIdRequired;

    /**
     * Constructor, create a minimal request Invoice object.
     *
     * @param $price    float The amount for which the invoice will be created.
     * @param $currency string three digit currency type used to compute the invoice bitcoin amount.
     */
    public function __construct(float $price = null, string $currency = null)
    {
        $this->_price = $price;
        $this->_currency = $currency;
        $this->_buyer = new Buyer();
        $this->_buyerProvidedInfo = new BuyerProvidedInfo();
        $this->_universalCodes = new UniversalCodes();
        $this->_supportedTransactionCurrencies = new SupportedTransactionCurrencies();
        $this->_minerFees = new MinerFees();
        $this->_shopper = new Shopper();
        $this->_refundInfo = new RefundInfo();
        $this->_itemizedDetails = new ItemizedDetails();
        $this->_transactionDetails = new TransactionDetails();
    }

    // API fields
    //

    /**
     * Gets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field,
     * supported currencies are available via the
     * <a href="#rest-api-resources-currencies">Currencies resource</a>
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    // Required fields
    //

    /**
     * Sets currency
     *
     * ISO 4217 3-character currency code. This is the currency associated with the price field,
     * supported currencies are available via the
     * <a href="#rest-api-resources-currencies">Currencies resource</a>
     *
     * @param string $currency
     *
     * @throws BitPayException
     */
    public function setCurrency(string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        $this->_currency = $currency;
    }

    /**
     * Gets guid
     *
     * A passthru variable provided by the merchant and designed to be used by the merchant
     * to correlate the invoice with an order ID in their system,
     * which can be used as a lookup variable in Retrieve Invoice by GUID.
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->_guid;
    }

    /**
     * Sets guid
     *
     * A passthru variable provided by the merchant and designed to be used by the merchant
     * to correlate the invoice with an order ID in their system,
     * which can be used as a lookup variable in Retrieve Invoice by GUID.
     *
     * @param string $guid
     */
    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

    /**
     * Gets token
     *
     * Invoice resource token. This token is derived from the API token initially used
     * to create the invoice and is tied to the specific resource id created.
     *
     * @return string - Invoice resource token.
     */
    public function getToken()
    {
        return $this->_token;
    }

    // Optional fields
    //
    /**
     * Sets token
     *
     * Invoice resource token.
     * This token is derived from the API token initially used to create the
     * invoice and is tied to the specific resource id created.
     *
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    /**
     * Gets price
     *
     * Fixed price amount for the checkout, in the "currency" of the invoice object.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * Sets price
     *
     * Fixed price amount for the checkout, in the "currency" of the invoice object.
     *
     * @param float $price
     *
     */
    public function setPrice(float $price)
    {
        $this->_price = $price;
    }

    /**
     * Gets posData
     *
     * A passthru variable provided by the merchant during invoice creation and designed to be
     * used by the merchant to correlate the invoice with an order or other object in their system.
     * This passthru variable can be a serialized object.
     *
     * @return string
     */
    public function getPosData()
    {
        return $this->_posData;
    }

    /**
     * Sets posData
     *
     * A passthru variable provided by the merchant during invoice creation and designed to be
     * used by the merchant to correlate the invoice with an order or other object in their system.
     * This passthru variable can be a serialized object.
     *
     * @param string $posData
     */
    public function setPosData(string $posData)
    {
        $this->_posData = $posData;
    }

    /**
     * Gets notificationURL
     *
     * @return string - URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     */
    public function getNotificationURL()
    {
        return $this->_notificationURL;
    }

    /**
     * Sets notificationURL
     *
     * @param string $notificationURL - URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     */
    public function setNotificationURL(string $notificationURL)
    {
        $this->_notificationURL = $notificationURL;
    }

    /**
     * Gets transactionSpeed.
     *
     * This is a risk mitigation parameter for the merchant to configure how they want
     * to fulfill orders depending on the number of block confirmations for the transaction
     * made by the consumer on the selected cryptocurrency.
     * If not set on the invoice, transactionSpeed will default to the account-level Order Settings.
     * Note : orders are only credited to your BitPay Account Summary for settlement after
     * the invoice reaches the status "complete" (regardless of this setting).
     *
     * @return string
     */
    public function getTransactionSpeed()
    {
        return $this->_transactionSpeed;
    }

    /**
     * Sets transactionSpeed.
     *
     * This is a risk mitigation parameter for the merchant to configure how they want
     * to fulfill orders depending on the number of block confirmations for the transaction
     * made by the consumer on the selected cryptocurrency.
     * If not set on the invoice, transactionSpeed will default to the account-level Order Settings.
     * Note : orders are only credited to your BitPay Account Summary for settlement after
     * the invoice reaches the status "complete" (regardless of this setting).
     *
     * @param string $transactionSpeed
     */
    public function setTransactionSpeed(string $transactionSpeed)
    {
        $this->_transactionSpeed = $transactionSpeed;
    }

    /**
     * Gets fullNotifications
     *
     * This parameter is set to true by default, meaning all standard notifications
     * are being sent for a payment made to an invoice.
     * If you decide to set it to false instead, only 1 webhook will be sent for each
     * invoice paid by the consumer.
     * This webhook will be for the "confirmed" or "complete" invoice status,
     * depending on the transactionSpeed selected.
     *
     * @return bool
     */
    public function getFullNotifications()
    {
        return $this->_fullNotifications;
    }

    /**
     * Sets fullNotifications
     *
     * This parameter is set to true by default, meaning all standard notifications
     * are being sent for a payment made to an invoice.
     * If you decide to set it to false instead, only 1 webhook will be sent for each
     * invoice paid by the consumer.
     * This webhook will be for the "confirmed" or "complete" invoice status,
     * depending on the transactionSpeed selected.
     *
     * @param bool $fullNotifications
     */
    public function setFullNotifications(bool $fullNotifications)
    {
        $this->_fullNotifications = $fullNotifications;
    }

    /**
     * Gets NotificationEmail
     *
     * Merchant email address for notification of payout status change.
     *
     * @return string
     */
    public function getNotificationEmail()
    {
        return $this->_notificationEmail;
    }

    /**
     * Sets NotificationEmail
     *
     * Merchant email address for notification of payout status change.
     *
     * @param string $notificationEmail
     */
    public function setNotificationEmail(string $notificationEmail)
    {
        $this->_notificationEmail = $notificationEmail;
    }

    /**
     * Gets RedirectURL
     *
     * The shopper will be redirected to this URL when clicking on the Return button
     * after a successful payment or when clicking on the Close button if a separate closeURL is not specified.
     *
     * @return string
     */
    public function getRedirectURL()
    {
        return $this->_redirectURL;
    }

    /**
     * Sets RedirectURL
     *
     * The shopper will be redirected to this URL when clicking on the Return button
     * after a successful payment or when clicking on the Close button if a separate closeURL is not specified.
     * Be sure to include "http://" or "https://" in the url.
     *
     * @param string $redirectURL
     */
    public function setRedirectURL(string $redirectURL)
    {
        $this->_redirectURL = $redirectURL;
    }

    /**
     * Gets orderId
     *
     * Can be used by the merchant to assign their own internal Id to an invoice.
     * If used, there should be a direct match between an orderId and an invoice id.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->_orderId;
    }

    /**
     * Sets orderId
     *
     * Can be used by the merchant to assign their own internal Id to an invoice.
     * If used, there should be a direct match between an orderId and an invoice id.
     *
     * @param string $orderId
     */
    public function setOrderId(string $orderId)
    {
        $this->_orderId = $orderId;
    }


    /**
     * Gets itemDesc
     *
     * Invoice description - will be added as a line item on the BitPay checkout page, under the merchant name.
     *
     * @return string
     */
    public function getItemDesc()
    {
        return $this->_itemDesc;
    }


    /**
     * Sets itemDesc
     *
     * Invoice description - will be added as a line item on the BitPay checkout page, under the merchant name.
     *
     * @param string $itemDesc
     */
    public function setItemDesc(string $itemDesc)
    {
        $this->_itemDesc = $itemDesc;
    }

    /**
     * Gets itemCode
     *
     * "bitcoindonation" for donations, otherwise do not include the field in the request.
     *
     * @return string
     */
    public function getItemCode()
    {
        return $this->_itemCode;
    }

    /**
     * Sets itemCode
     *
     * "bitcoindonation" for donations, otherwise do not include the field in the request.
     *
     * @param string $itemCode
     */
    public function setItemCode(string $itemCode)
    {
        $this->_itemCode = $itemCode;
    }

    /**
     * Gets physical.
     *
     * Indicates whether items are physical goods. Alternatives include digital goods and services.
     *
     * @return bool
     */
    public function getPhysical()
    {
        return $this->_physical;
    }

    /**
     * Sets physical.
     *
     * Indicates whether items are physical goods. Alternatives include digital goods and services.
     *
     * @param bool $physical
     */
    public function setPhysical(bool $physical)
    {
        $this->_physical = $physical;
    }

    /**
     * Gets paymentCurrencies
     *
     * Allow the merchant to select the cryptocurrencies available as payment option on the BitPay invoice.
     * Possible values are currently "BTC", "BCH", "ETH", "GUSD",
     * "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * For instance "paymentCurrencies": ["BTC"] will create an invoice with only XRP available as transaction currency,
     * thus bypassing the currency selection step on the invoice.
     *
     * @return mixed
     */
    public function getPaymentCurrencies()
    {
        return $this->_paymentCurrencies;
    }

    /**
     * Sets paymentCurrencies
     *
     * Allow the merchant to select the cryptocurrencies available as payment option on the BitPay invoice.
     * Possible values are currently "BTC", "BCH", "ETH", "GUSD",
     * "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * For instance "paymentCurrencies": ["BTC"] will create an invoice with only XRP available as transaction currency,
     * thus bypassing the currency selection step on the invoice.
     *
     * @param array $paymentCurrencies
     */
    public function setPaymentCurrencies(array $paymentCurrencies)
    {
        $this->_paymentCurrencies = $paymentCurrencies;
    }

    /**
     * Gets acceptanceWindow
     *
     * Number of milliseconds that a user has to pay an invoice before it expires (0-900000).
     * If not set, invoice will default to the account acceptanceWindow.
     * If account acceptanceWindow is not set, invoice will default to 15 minutes (900,000 milliseconds).
     *
     * @return mixed
     */
    public function getAcceptanceWindow()
    {
        return $this->_acceptanceWindow;
    }


    /**
     * Gets closeURL
     *
     * URL to redirect if the shopper does not pay the invoice and click on the Close button instead.
     *
     * @return string
     */
    public function getCloseURL()
    {
        return $this->_closeURL;
    }

    /**
     * Gets closeURL
     *
     * URL to redirect if the shopper does not pay the invoice and click on the Close button instead.
     * Be sure to include "http://" or "https://" in the url.
     *
     * @param string $closeURL
     */
    public function setCloseURL(string $closeURL)
    {
        $this->_closeURL = $closeURL;
    }

    /**
     * Gets autoRedirect
     *
     * Set to false by default,
     * merchant can setup automatic redirect to their website by setting this parameter to true.
     *
     * @return bool
     */
    public function getAutoRedirect()
    {
        return $this->_autoRedirect;
    }

    /**
     * Sets autoRedirect
     *
     * Set to false by default,
     * merchant can setup automatic redirect to their website by setting this parameter to true.
     *
     * @param bool $autoRedirect
     */
    public function setAutoRedirect(bool $autoRedirect)
    {
        $this->_autoRedirect = $autoRedirect;
    }

    /**
     * Gets jsonPayProRequired
     *
     * Boolean set to false by default.
     * If set to true, this means that the invoice will only accept payments
     * from wallets which have implemented the
     * <a href="https://bitpay.com/docs/payment-protocol">BitPay JSON Payment Protocol</a>
     *
     * @return mixed
     */
    public function getJsonPayProRequired()
    {
        return $this->_jsonPayProRequired;
    }

    /**
     * Sets jsonPayProRequired
     *
     * Boolean set to false by default.
     * If set to true, this means that the invoice will only accept payments
     * from wallets which have implemented the
     * <a href="https://bitpay.com/docs/payment-protocol">BitPay JSON Payment Protocol</a>
     *
     * @param bool $jsonPayProRequired
     */
    public function setJsonPayProRequired(bool $jsonPayProRequired)
    {
        $this->_jsonPayProRequired = $jsonPayProRequired;
    }

    /**
     * Gets bitpayIdRequired
     *
     * BitPay ID is a verification process that is required when a user is making payments
     * or receiving a refund over a given threshold, which may vary by region.
     * This Boolean forces the invoice to require BitPay ID regardless of the price.
     *
     * @return mixed
     */
    public function getBitpayIdRequired()
    {
        return $this->_bitpayIdRequired;
    }

    /**
     * Sets bitpayIdRequired
     *
     * BitPay ID is a verification process that is required when a user is making payments
     * or receiving a refund over a given threshold, which may vary by region.
     * This Boolean forces the invoice to require BitPay ID regardless of the price.
     *
     * @param bool $bitpayIdRequired
     */
    public function setBitpayIdRequired(bool $bitpayIdRequired)
    {
        $this->_bitpayIdRequired = $bitpayIdRequired;
    }

    /**
     * Gets merchantName
     *
     * A display string for merchant identification (ex. Wal-Mart Store #1452, Bowling Green, KY).
     *
     * @return mixed
     */
    public function getMerchantName()
    {
        return $this->_merchantName;
    }

    /**
     * Sets merchantName
     *
     * A display string for merchant identification (ex. Wal-Mart Store #1452, Bowling Green, KY).
     *
     * @param string $merchantName
     */
    public function setMerchantName(string $merchantName)
    {
        $this->_merchantName = $merchantName;
    }

    /**
     * Gets selectedTransactionCurrency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @return mixed
     */
    public function getSelectedTransactionCurrency()
    {
        return $this->_selectedTransactionCurrency;
    }

    /**
     * Sets selectedTransactionCurrency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @param string $selectedTransactionCurrency
     */
    public function setSelectedTransactionCurrency(string $selectedTransactionCurrency)
    {
        $this->_selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    /**
     * Gets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @return mixed
     */
    public function getForcedBuyerSelectedWallet()
    {
        return $this->_forcedBuyerSelectedWallet;
    }

    /**
     * Sets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @param string $forcedBuyerSelectedWallet
     */
    public function setForcedBuyerSelectedWallet(string $forcedBuyerSelectedWallet)
    {
        $this->_forcedBuyerSelectedWallet = $forcedBuyerSelectedWallet;
    }

    /**
     * Gets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @return string
     */
    public function getForcedBuyerSelectedTransactionCurrency()
    {
        return $this->_forcedBuyerSelectedTransactionCurrency;
    }

    /**
     * Sets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @param string $forcedBuyerSelectedTransactionCurrency
     */
    public function setForcedBuyerSelectedTransactionCurrency(string $forcedBuyerSelectedTransactionCurrency)
    {
        $this->_forcedBuyerSelectedTransactionCurrency = $forcedBuyerSelectedTransactionCurrency;
    }

    /**
     * Gets itemizedDetails
     *
     * Object containing line item details for display.
     *
     * @return ItemizedDetails
     */
    public function getItemizedDetails()
    {
        return $this->_itemizedDetails;
    }

    /**
     * Sets itemizedDetails
     *
     * Object containing line item details for display.
     *
     * @param array $itemizedDetails
     */
    public function setItemizedDetails(array $itemizedDetails)
    {
        $itemsArray = [];

        foreach ($itemizedDetails as $item) {
            if ($item instanceof ItemizedDetails) {
                array_push($itemsArray, $item->toArray());
            } else {
                array_push($itemsArray, $item);
            }
        }

        $this->_itemizedDetails = $itemsArray;
    }

    /**
     * Sets acceptanceWindow
     *
     * Number of milliseconds that a user has to pay an invoice before it expires (0-900000).
     * If not set, invoice will default to the account acceptanceWindow.
     * If account acceptanceWindow is not set, invoice will default to 15 minutes (900,000 milliseconds).
     *
     * @param float $acceptanceWindow
     */
    public function setAcceptanceWindow(float $acceptanceWindow)
    {
        $this->_acceptanceWindow = $acceptanceWindow;
    }

    /**
     * Gets buyer
     *
     * Allows merchant to pass buyer related information in the invoice object
     *
     * @return Buyer
     */
    public function getBuyer()
    {
        return $this->_buyer;
    }

    /**
     * Sets buyer
     *
     * Allows merchant to pass buyer related information in the invoice object
     *
     * @param Buyer $buyer
     */
    public function setBuyer(Buyer $buyer)
    {
        $this->_buyer = $buyer;
    }

    /**
     * Gets buyerEmail
     *
     * Buyer's email address.
     * If provided during invoice creation, this will bypass the email prompt for the consumer when opening the invoice.
     *
     * @return string
     */
    public function getBuyerEmail()
    {
        return $this->_buyerEmail;
    }

    /**
     * Sets buyerEmail
     *
     * Buyer's email address.
     * If provided during invoice creation, this will bypass the email prompt for the consumer when opening the invoice.
     *
     * @param string $buyerEmail
     */
    public function setBuyerEmail(string $buyerEmail)
    {
        $this->_buyerEmail = $buyerEmail;
    }

    /**
     * Gets buyerSms
     *
     * SMS provided by user for communications.
     * This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @return mixed
     */
    public function getBuyerSms()
    {
        return $this->_buyerSms;
    }

    /**
     * Sets buyerSms
     *
     * SMS provided by user for communications.
     * This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @param string $buyerSms
     */
    public function setBuyerSms(string $buyerSms)
    {
        $this->_buyerSms = $buyerSms;
    }

    // Response fields
    //

    /**
     * Gets refundAddresses
     *
     * Initially empty when the invoice is created.
     * This field will be populated with the refund address
     * provided by the customer if you request a refund of the specific invoice.
     *
     * @return array
     */
    public function getRefundAddresses()
    {
        return $this->_refundAddresses;
    }

    /**
     * Sets refundAddresses
     *
     * Initially empty when the invoice is created.
     * This field will be populated with the refund address
     * provided by the customer if you request a refund of the specific invoice.
     *
     * @param array $refundAddresses
     */
    public function setRefundAddresses(array $refundAddresses)
    {
        $this->_refundAddresses = $refundAddresses;
    }

    /**
     * Gets invoice resource id
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets invoice resource id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Gets url
     *
     * Web address of invoice, expires at expirationTime
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Sets url
     *
     * Web address of invoice, expires at expirationTime
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * Gets status
     *
     * Detailed information about invoice status notifications can be found under the
     * <a href="https://bitpay.com/api/#notifications-webhooks-instant-payment-notifications-handling">
     * Instant Payment Notification (IPN) section.
     * </a>
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets status
     *
     * Detailed information about invoice status notifications can be found under the
     * <a href="https://bitpay.com/api/#notifications-webhooks-instant-payment-notifications-handling">
     * Instant Payment Notification (IPN) section.
     * </a>
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    /**
     * Gets lowFeeDetected
     *
     * Flag to indicate if the miner fee used by the buyer is too low.
     * Initially set to false when the invoice is created.
     *
     * @return boolean
     */
    public function getLowFeeDetected()
    {
        return $this->_lowFeeDetected;
    }

    /**
     * Sets lowFeeDetected
     *
     * Flag to indicate if the miner fee used by the buyer is too low.
     * Initially set to false when the invoice is created.
     *
     * @param boolean $lowFeeDetected
     */
    public function setLowFeeDetected($lowFeeDetected)
    {
        $this->_lowFeeDetected = $lowFeeDetected;
    }

    /**
     * Gets invoiceTime - UNIX time of invoice creation, in milliseconds
     *
     * @return int
     */
    public function getInvoiceTime()
    {
        return $this->_invoiceTime;
    }

    /**
     * Sets invoiceTime - UNIX time of invoice creation, in milliseconds
     *
     * @param int $invoiceTime
     */
    public function setInvoiceTime($invoiceTime)
    {
        $this->_invoiceTime = $invoiceTime;
    }

    /**
     * Gets expirationTime - UNIX time when invoice is last available to be paid, in milliseconds
     *
     * @return mixed
     */
    public function getExpirationTime()
    {
        return $this->_expirationTime;
    }

    /**
     * Sets expirationTime - UNIX time when invoice is last available to be paid, in milliseconds
     *
     * @param string $expirationTime
     */
    public function setExpirationTime($expirationTime)
    {
        $this->_expirationTime = $expirationTime;
    }

    /**
     * Gets currentTime - UNIX time of API call, in milliseconds
     *
     * @return string
     */
    public function getCurrentTime()
    {
        return $this->_currentTime;
    }

    /**
     * Sets currentTime - UNIX time of API call, in milliseconds
     *
     * @param string $currentTime
     */
    public function setCurrentTime($currentTime)
    {
        $this->_currentTime = $currentTime;
    }

    /**
     * Gets transactions
     *
     * Contains the cryptocurrency transaction details for the executed payout.
     *
     * @return array
     */
    public function getTransactions()
    {
        return $this->_transactions;
    }

    /**
     * Sets transactions
     *
     * Contains the cryptocurrency transaction details for the executed payout.
     *
     * @param array $transactions
     */
    public function setTransactions($transactions)
    {
        $this->_transactions = $transactions;
    }

    /**
     * Gets exceptionStatus
     *
     * Initially a boolean false, this parameter will indicate if the purchaser sent too much ("paidOver")
     * or not enough funds ("paidPartial") in the transaction to pay the BitPay invoice. Possible values are:
     * false: default value (boolean) unless an exception is triggered.
     * "paidPartial": (string) if the consumer did not send enough funds when paying the invoice.
     * "paidOver": (string) if the consumer sent to much funds when paying the invoice.
     *
     * @return boolean
     */
    public function getExceptionStatus()
    {
        return $this->_exceptionStatus;
    }

    /**
     * Sets exceptionStatus
     *
     * Initially a boolean false, this parameter will indicate if the purchaser sent too much ("paidOver")
     * or not enough funds ("paidPartial") in the transaction to pay the BitPay invoice. Possible values are:
     * false: default value (boolean) unless an exception is triggered.
     * "paidPartial": (string) if the consumer did not send enough funds when paying the invoice.
     * "paidOver": (string) if the consumer sent to much funds when paying the invoice.
     *
     * @param boolean $exceptionStatus
     */
    public function setExceptionStatus($exceptionStatus)
    {
        $this->_exceptionStatus = $exceptionStatus;
    }

    /**
     * Gets targetConfirmations
     *
     * Indicates the number of block confirmation of the crypto currency
     * transaction which are required to credit a paid invoice to the merchant account.
     * Currently, the value set is set to 6 by default for BTC/BCH/XRP,
     * 40 for DOGE and 50 for ETH/GUSD/PAX/USDC/BUSD/DAI/WBTC
     *
     * @return int
     */
    public function getTargetConfirmations()
    {
        return $this->_targetConfirmations;
    }

    /**
     * Sets targetConfirmations
     *
     * Indicates the number of block confirmation of the crypto currency
     * transaction which are required to credit a paid invoice to the merchant account.
     * Currently, the value set is set to 6 by default for BTC/BCH/XRP,
     * 40 for DOGE and 50 for ETH/GUSD/PAX/USDC/BUSD/DAI/WBTC
     *c
     * @param int $targetConfirmations
     */
    public function setTargetConfirmations($targetConfirmations)
    {
        $this->_targetConfirmations = $targetConfirmations;
    }

    /**
     * Gets refundAddressRequestPending
     *
     * Initially set to false when the invoice is created,
     * this field will be set to true once a refund request has been issued by the merchant.
     * This flag is here to indicate that the refund request is pending action
     * from the buyer to provide an address for the refund,
     * via the secure link which has been automatically emailed to him.
     *
     * @return boolean
     */
    public function getRefundAddressRequestPending()
    {
        return $this->_refundAddressRequestPending;
    }

    /**
     * Sets refundAddressRequestPending
     *
     * Initially set to false when the invoice is created,
     * this field will be set to true once a refund request has been issued by the merchant.
     * This flag is here to indicate that the refund request is pending action
     * from the buyer to provide an address for the refund,
     * via the secure link which has been automatically emailed to him.
     *
     * @param boolean $refundAddressRequestPending
     */
    public function setRefundAddressRequestPending($refundAddressRequestPending)
    {
        $this->_refundAddressRequestPending = $refundAddressRequestPending;
    }

    /**
     * Gets buyerProvidedEmail
     *
     * Populated with the buyer's email address if passed in the buyer object by the merchant,
     * otherwise this field is not returned for newly created invoices.
     * If the merchant does not pass the buyer email in the invoice request,
     * the bitpay invoice UI will prompt the user to enter his
     * email address and this field will be populated with the email submitted.
     *
     * @return string
     */
    public function getBuyerProvidedEmail()
    {
        return $this->_buyerProvidedEmail;
    }

    /**
     * Sets buyerProvidedEmail
     *
     * Populated with the buyer's email address if passed in the buyer object by the merchant,
     * otherwise this field is not returned for newly created invoices.
     * If the merchant does not pass the buyer email in the invoice request,
     * the bitpay invoice UI will prompt the user to enter his
     * email address and this field will be populated with the email submitted.
     *
     * @param string $buyerProvidedEmail
     */
    public function setBuyerProvidedEmail($buyerProvidedEmail)
    {
        $this->_buyerProvidedEmail = $buyerProvidedEmail;
    }

    /**
     * Gets buyerProvidedEmail
     *
     * Information collected from the buyer during the process of paying an invoice.
     * Initially this object is empty.
     *
     * @return object
     */
    public function getBuyerProvidedInfo()
    {
        return $this->_buyerProvidedInfo;
    }

    /**
     * Sets buyerProvidedEmail
     *
     * Information collected from the buyer during the process of paying an invoice.
     * Initially this object is empty.
     *
     * @param BuyerProvidedInfo $buyerProvidedInfo
     */
    public function setBuyerProvidedInfo(BuyerProvidedInfo $buyerProvidedInfo)
    {
        $this->_buyerProvidedInfo = $buyerProvidedInfo;
    }

    public function getTransactionDetails()
    {
        return $this->_transactionDetails;
    }

    public function setTransactionDetails(TransactionDetails $transactionDetails)
    {
        $this->_transactionDetails = $transactionDetails;
    }

    /**
     * Gets universalCodes
     *
     * Object containing wallet-specific URLs for payment protocol.
     *
     * @return object UniversalCodes
     */
    public function getUniversalCodes()
    {
        return $this->_universalCodes;
    }

    /**
     * Sets universalCodes
     *
     * @param UniversalCodes $universalCodes
     */
    public function setUniversalCodes(UniversalCodes $universalCodes)
    {
        $this->_universalCodes = $universalCodes;
    }

    /**
     * Gets supportedTransactionCurrencies
     *
     * The currencies that may be used to pay this invoice.
     * The object is keyed by currency code.
     * The values are objects with an "enabled" boolean and option.
     * An extra "reason" parameter is added in the object if a cryptocurrency is disabled on a specific invoice.
     * If you disable a currency via the invoice parameter "paymentCurrencies",
     * this parameter will be set to "merchantDisabledByParam"
     *
     * @return object
     */
    public function getSupportedTransactionCurrencies()
    {
        return $this->_supportedTransactionCurrencies;
    }

    /**
     * Sets supportedTransactionCurrencies
     *
     * The currencies that may be used to pay this invoice.
     * The object is keyed by currency code.
     * The values are objects with an "enabled" boolean and option.
     * An extra "reason" parameter is added in the object if a cryptocurrency is disabled on a specific invoice.
     * If you disable a currency via the invoice parameter "paymentCurrencies",
     * this parameter will be set to "merchantDisabledByParam"
     *
     * @param SupportedTransactionCurrencies $supportedTransactionCurrencies
     */
    public function setSupportedTransactionCurrencies(SupportedTransactionCurrencies $supportedTransactionCurrencies)
    {
        $this->_supportedTransactionCurrencies = $supportedTransactionCurrencies;
    }

    /**
     * Gets paymentTotals
     *
     * For internal use - This field can be ignored in merchant implementations.
     *
     * @return object
     */
    public function getPaymentTotals()
    {
        return $this->_paymentTotals;
    }

    /**
     * Sets paymentTotals
     *
     * For internal use - This field can be ignored in merchant implementations.
     *
     * @param object $paymentTotals
     */
    public function setPaymentTotals($paymentTotals)
    {
        $this->_paymentTotals = $paymentTotals;
    }

    /**
     * Gets paymentSubtotals
     *
     * For internal use. This field can be ignored in merchant implementations.
     *
     * @return object
     */
    public function getPaymentSubTotals()
    {
        return $this->_paymentSubtotals;
    }

    /**
     * Sets paymentSubtotals
     *
     * For internal use. This field can be ignored in merchant implementations.
     *
     * @param object $paymentSubtotals
     */
    public function setPaymentSubTotals($paymentSubtotals)
    {
        $this->_paymentSubtotals = $paymentSubtotals;
    }

    /**
     * Gets paymentDisplaySubtotals
     *
     * Equivalent to price for each supported transactionCurrency, excluding minerFees.
     * The key is the currency and the value is an amount indicated in the base unit
     * for each supported transactionCurrency.
     *
     * @return object
     */
    public function getPaymentDisplaySubTotals()
    {
        return $this->_paymentDisplaySubtotals;
    }

    /**
     * Sets paymentDisplaySubtotals
     *
     * Equivalent to price for each supported transactionCurrency, excluding minerFees.
     * The key is the currency and the value is an amount indicated in the base unit
     * for each supported transactionCurrency.
     *
     * @param object $paymentDisplaySubtotals
     */
    public function setPaymentDisplaySubTotals($paymentDisplaySubtotals)
    {
        $this->_paymentDisplaySubtotals = $paymentDisplaySubtotals;
    }

    /**
     * Gets paymentDisplayTotals
     *
     * The total amount that the purchaser should pay as displayed on the invoice UI.
     * This is like paymentDisplaySubTotals but with the minerFees included.
     * The key is the currency and the value is an amount
     * indicated in the base unit for each supported transactionCurrency.
     *
     * @return object
     */
    public function getPaymentDisplayTotals()
    {
        return $this->_paymentDisplaytotals;
    }

    /**
     * Sets paymentDisplayTotals
     *
     * The total amount that the purchaser should pay as displayed on the invoice UI.
     * This is like paymentDisplaySubTotals but with the minerFees included.
     * The key is the currency and the value is an amount
     * indicated in the base unit for each supported transactionCurrency.
     *
     * @param object $paymentDisplaytotals
     */
    public function setPaymentDisplayTotals($paymentDisplaytotals)
    {
        $this->_paymentDisplaytotals = $paymentDisplaytotals;
    }

    /**
     * Gets paymentCodes
     *
     * The URIs for sending a transaction to the invoice. The first key is the transaction currency.
     * The transaction currency maps to an object containing the payment URIs.
     * The key of this object is the BIP number and the value is the payment URI.
     * For "BTC", "BCH" and "DOGE" - BIP72b and BIP73 are supported.
     * For "ETH", "GUSD", "PAX", "BUSD", "USDC", "DAI" and "WBTC"- EIP681 is supported
     * For "XRP" - RIP681, BIP72b and BIP73 is supported
     *
     * @return object
     */
    public function getPaymentCodes()
    {
        return $this->_paymentCodes;
    }

    /**
     * Sets paymentCodes
     *
     * The URIs for sending a transaction to the invoice. The first key is the transaction currency.
     * The transaction currency maps to an object containing the payment URIs.
     * The key of this object is the BIP number and the value is the payment URI.
     * For "BTC", "BCH" and "DOGE" - BIP72b and BIP73 are supported.
     * For "ETH", "GUSD", "PAX", "BUSD", "USDC", "DAI" and "WBTC"- EIP681 is supported
     * For "XRP" - RIP681, BIP72b and BIP73 is supported
     *
     * @param object
     */
    public function setPaymentCodes($paymentCodes)
    {
        $this->_paymentCodes = $paymentCodes;
    }

    /**
     * Gets underpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was underpaid ("exceptionStatus": "paidPartial").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @return numeric
     */
    public function getUnderpaidAmount()
    {
        return $this->_underpaidAmount;
    }

    /**
     * Sets underpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was underpaid ("exceptionStatus": "paidPartial").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @param $underpaidAmount
     */
    public function setUnderpaidAmount($underpaidAmount)
    {
        $this->_underpaidAmount = $underpaidAmount;
    }

    /**
     * Gets overpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was overpaid ("exceptionStatus": "paidOver").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @return numeric
     */
    public function getOverpaidAmount()
    {
        return $this->_overpaidAmount;
    }

    /**
     * Sets overpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was overpaid ("exceptionStatus": "paidOver").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @param $overpaidAmount
     */
    public function setOverpaidAmount($overpaidAmount)
    {
        $this->_overpaidAmount = $overpaidAmount;
    }

    /**
     * Gets minerFees
     *
     * The total amount of fees that the purchaser will pay to cover BitPay's UTXO sweep cost for an invoice.
     * The key is the currency and the value is an object containing
     * the satoshis per byte, the total fee, and the fiat amount.
     * This is referenced as "Network Cost" on an invoice, see
     * <a href="https://support.bitpay.com/hc/en-us/articles/115002990803-What-is-the-Network-Cost-fee-on-BitPay-invoices-and-why-is-BitPay-charging-it-">
     * this support article
     * </a> for more information
     *
     * @return MinerFees
     */
    public function getMinerFees()
    {
        return $this->_minerFees;
    }

    /**
     * Sets minerFees
     *
     * The total amount of fees that the purchaser will pay to cover BitPay's UTXO sweep cost for an invoice.
     * The key is the currency and the value is an object containing
     * the satoshis per byte, the total fee, and the fiat amount.
     * This is referenced as "Network Cost" on an invoice, see
     * <a href="https://support.bitpay.com/hc/en-us/articles/115002990803-What-is-the-Network-Cost-fee-on-BitPay-invoices-and-why-is-BitPay-charging-it-">
     * this support article
     * </a> for more information
     *
     * @param MinerFees $minerFees
     */
    public function setMinerFees(MinerFees $minerFees)
    {
        $this->_minerFees = $minerFees;
    }

    /**
     * Gets nonPayProPaymentReceived
     *
     * This boolean will be available on an invoice object once an invoice is paid
     * and indicate if the transaction was made with a wallet using the payment protocol (true) or peer to peer (false).
     *
     * @return boolean
     */
    public function getNonPayProPaymentReceived()
    {
        return $this->_nonPayProPaymentReceived;
    }

    /**
     * Sets nonPayProPaymentReceived
     *
     * This boolean will be available on an invoice object once an invoice is paid
     * and indicate if the transaction was made with a wallet using the payment protocol (true) or peer to peer (false).
     *
     * @param boolean $nonPayProPaymentReceived
     */
    public function setNonPayProPaymentReceived(bool $nonPayProPaymentReceived)
    {
        $this->_nonPayProPaymentReceived = $nonPayProPaymentReceived;
    }

    /**
     * Gets shopper
     *
     * This object will be available on the invoice if a shopper signs in on an invoice using his BitPay ID.
     * See the following <a href="https://blog.bitpay.com/bitpay-dashboard-id/">blogpost</a> for more information.
     *
     * @return Shopper
     */
    public function getShopper()
    {
        return $this->_shopper;
    }

    /**
     * Sets shopper
     *
     * This object will be available on the invoice if a shopper signs in on an invoice using his BitPay ID.
     * See the following <a href="https://blog.bitpay.com/bitpay-dashboard-id/">blogpost</a> for more information.
     *
     * @param Shopper $shopper
     */
    public function setShopper(Shopper $shopper)
    {
        $this->_shopper = $shopper;
    }

    /**
     * Gets billId
     *
     * This field will be in the invoice object only if the invoice was generated from a bill, see the
     * <a href="https://bitpay.com/api/#rest-api-resources-bills">Bills</a> resource for more information
     *
     * @return string
     */
    public function getBillId()
    {
        return $this->_billId;
    }

    /**
     * Sets billId
     *
     * This field will be in the invoice object only if the invoice was generated from a bill, see the
     * <a href="https://bitpay.com/api/#rest-api-resources-bills">Bills</a> resource for more information
     *
     * @param $billId
     */
    public function setBillId($billId)
    {
        $this->_billId = $billId;
    }

    /**
     * Gets refundInfo
     *
     * For a refunded invoice, this object will contain the details of executed refunds for the corresponding invoice.
     *
     * @return RefundInfo
     */
    public function getRefundInfo()
    {
        return $this->_refundInfo;
    }

    /**
     * Sets refundInfo
     *
     * For a refunded invoice, this object will contain the details of executed refunds for the corresponding invoice.
     *
     * @param RefundInfo
     */
    public function setRefundInfo(RefundInfo $refundInfo)
    {
        $this->_refundInfo = $refundInfo;
    }

    /**
     * Gets extendedNotifications
     *
     * Allows merchants to get access to additional webhooks.
     * For instance when an invoice expires without receiving a payment or when it is refunded.
     * If set to true, then fullNotifications is automatically set to true.
     * When using the extendedNotifications parameter,
     * the webhook also have a payload slightly different from the standard webhooks.
     *
     * @return bool
     */
    public function getExtendedNotifications()
    {
        return $this->_extendedNotifications;
    }

    /**
     * Sets extendedNotifications
     *
     * Allows merchants to get access to additional webhooks.
     * For instance when an invoice expires without receiving a payment or when it is refunded.
     * If set to true, then fullNotifications is automatically set to true.
     * When using the extendedNotifications parameter,
     * the webhook also have a payload slightly different from the standard webhooks.
     *
     * @param bool $extendedNotifications
     */
    public function setExtendedNotifications(bool $extendedNotifications)
    {
        $this->_extendedNotifications = $extendedNotifications;
    }

    /**
     * Gets transactionCurrency
     *
     * The cryptocurrency used to pay the invoice.
     * This field will only be available after a transaction is applied to the invoice.
     * Possible values are currently "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     *
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->_transactionCurrency;
    }

    /**
     * Sets transactionCurrency
     *
     * The cryptocurrency used to pay the invoice.
     * This field will only be available after a transaction is applied to the invoice.
     * Possible values are currently "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     *
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->_transactionCurrency = $transactionCurrency;
    }

    /**
     * Gets amountPaid
     *
     * The total amount paid to the invoice in terms of the invoice transactionCurrency indicated
     * in the smallest possible unit for the corresponding transactionCurrency (e.g satoshis for BTC and BCH)
     *
     * @return number
     */
    public function getAmountPaid()
    {
        return $this->_amountPaid;
    }

    /**
     * Sets amountPaid
     *
     * The total amount paid to the invoice in terms of the invoice transactionCurrency indicated
     * in the smallest possible unit for the corresponding transactionCurrency (e.g satoshis for BTC and BCH)
     *
     * @param int $amountPaid
     */
    public function setAmountPaid($amountPaid)
    {
        $this->_amountPaid = $amountPaid;
    }

    /**
     * Gets displayAmountPaid
     *
     * Initially set to "0" when creating the invoice.
     * It will be updated with the total amount paid to the invoice
     * indicated in the base unit for the corresponding transactionCurrency
     *
     * @return string
     */
    public function getDisplayAmountPaid()
    {
        return $this->_displayAmountPaid;
    }

    /**
     * Sets displayAmountPaid
     *
     * Initially set to "0" when creating the invoice.
     * It will be updated with the total amount paid to the invoice
     * indicated in the base unit for the corresponding transactionCurrency
     *
     * @param string $displayAmountPaid
     */
    public function setDisplayAmountPaid($displayAmountPaid)
    {
        $this->_displayAmountPaid = $displayAmountPaid;
    }

    /**
     * Gets exchangeRates
     *
     * Exchange rates keyed by source and target currencies.
     *
     * @return object
     */
    public function getExchangeRates()
    {
        return $this->_exchangeRates;
    }

    /**
     * Sets exchangeRates
     *
     * Exchange rates keyed by source and target currencies.
     *
     * @param object $exchangeRates
     */
    public function setExchangeRates($exchangeRates)
    {
        $this->_exchangeRates = $exchangeRates;
    }

    /**
     * Gets paymentString
     *
     * Payment protocol URL for selected wallet, defaults to BitPay URL if no wallet selected.
     *
     * @return string
     */
    public function getPaymentString()
    {
        return $this->_paymentString;
    }

    /**
     * Sets paymentString
     *
     * Payment protocol URL for selected wallet, defaults to BitPay URL if no wallet selected.
     *
     * @param string $paymentString
     */
    public function setPaymentString(string $paymentString)
    {
        $this->_paymentString = $paymentString;
    }

    /**
     * Gets verificationLink
     *
     * Link to bring user to BitPay ID flow, only present when bitpayIdRequired is true.
     *
     * @return string
     */
    public function getVerificationLink()
    {
        return $this->_verificationLink;
    }

    /**
     * Sets verificationLink
     *
     * Link to bring user to BitPay ID flow, only present when bitpayIdRequired is true.
     *
     * @param string $verificationLink
     */
    public function setVerificationLink(string $verificationLink)
    {
        $this->_verificationLink = $verificationLink;
    }

    /**
     * Gets isCancelled
     *
     * Indicates whether or not the invoice was cancelled.
     *
     * @return boolean
     */
    public function getIsCancelled()
    {
        return $this->_isCancelled;
    }

    /**
     * Sets isCancelled
     *
     * Indicates whether or not the invoice was cancelled.
     *
     * @param boolean $isCancelled
     */
    public function setIsCancelled(bool $isCancelled)
    {
        $this->_isCancelled = $isCancelled;
    }

    /**
     * Returns the Invoice object as array
     *
     * @return array
     */
    public function toArray()
    {
        $elements = [
            'currency'                       => $this->getCurrency(),
            'guid'                           => $this->getGuid(),
            'token'                          => $this->getToken(),
            'price'                          => $this->getPrice(),
            'posData'                        => $this->getPosData(),
            'notificationURL'                => $this->getNotificationURL(),
            'transactionSpeed'               => $this->getTransactionSpeed(),
            'fullNotifications'              => $this->getFullNotifications(),
            'notificationEmail'              => $this->getNotificationEmail(),
            'redirectURL'                    => $this->getRedirectURL(),
            'orderId'                        => $this->getOrderId(),
            'itemDesc'                       => $this->getItemDesc(),
            'itemCode'                       => $this->getItemCode(),
            'physical'                       => $this->getPhysical(),
            'paymentCurrencies'              => $this->getPaymentCurrencies(),
            'acceptanceWindow'               => $this->getAcceptanceWindow(),
            'closeURL'                       => $this->getCloseURL(),
            'autoRedirect'                   => $this->getAutoRedirect(),
            'buyer'                          => $this->getBuyer()->toArray(),
            'refundAddresses'                => $this->getRefundAddresses(),
            'id'                             => $this->getId(),
            'url'                            => $this->getUrl(),
            'status'                         => $this->getStatus(),
            'lowFeeDetected'                 => $this->getLowFeeDetected(),
            'invoiceTime'                    => $this->getInvoiceTime(),
            'expirationTime'                 => $this->getExpirationTime(),
            'currentTime'                    => $this->getCurrentTime(),
            'transactions'                   => $this->getTransactions(),
            'exceptionStatus'                => $this->getExceptionStatus(),
            'targetConfirmations'            => $this->getTargetConfirmations(),
            'refundAddressRequestPending'    => $this->getRefundAddressRequestPending(),
            'buyerProvidedEmail'             => $this->getBuyerProvidedEmail(),
            'buyerProvidedInfo'              => $this->getBuyerProvidedInfo()->toArray(),
            'transactionDetails'             => $this->getTransactionDetails()->toArray(),
            'universalCodes'                 => $this->getUniversalCodes()->toArray(),
            'supportedTransactionCurrencies' => $this->getSupportedTransactionCurrencies()->toArray(),
            'minerFees'                      => $this->getMinerFees()->toArray(),
            'shopper'                        => $this->getShopper()->toArray(),
            'billId'                         => $this->getBillId(),
            'refundInfo'                     => $this->getRefundInfo()->toArray(),
            'extendedNotifications'          => $this->getExtendedNotifications(),
            'transactionCurrency'            => $this->getTransactionCurrency(),
            'amountPaid'                     => $this->getAmountPaid(),
            'exchangeRates'                  => $this->getExchangeRates(),
            'merchantName'                   => $this->getMerchantName(),
            'selectedTransactionCurrency'    => $this->getSelectedTransactionCurrency(),
            'bitpayIdRequired'               => $this->getBitpayIdRequired(),
            'forcedBuyerSelectedWallet'      => $this->getForcedBuyerSelectedWallet(),
            'paymentString'                  => $this->getPaymentString(),
            'verificationLink'               => $this->getVerificationLink(),
            'isCancelled'                    => $this->getIsCancelled(),
            'buyerEmail'                     => $this->getBuyerEmail(),
            'buyerSms'                       => $this->getBuyerSms(),
            'itemizedDetails'                => $this->getItemizedDetails(),
            'forcedBuyerSelectedTransactionCurrency' => $this->getForcedBuyerSelectedTransactionCurrency()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
