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
	 * ISO 4217 3-character currency code. This is the currency associated with the price field, supported currencies are available via the
	 * <a href="#rest-api-resources-currencies">Currencies resource</a>
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
	 * ISO 4217 3-character currency code. This is the currency associated with the price field, supported currencies are available via the
	 * <a href="#rest-api-resources-currencies">Currencies resource</a>
	 * @param string $currency
	 *
	 * @return void
	 * @throws BitPayException
	 */
	public function setCurrency( string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        $this->_currency = $currency;
    }
	
	/**
	 * Gets guid
	 * A passthru variable provided by the merchant and designed to be used by the merchant to correlate the invoice with an order ID in their system,
	 * which can be used as a lookup variable in Retrieve Invoice by GUID.
	 * @return string
	 */
	public function getGuid()
    {
        return $this->_guid;
    }
	
	/**
	 * Sets guid
	 * A passthru variable provided by the merchant and designed to be used by the merchant to correlate the invoice with an order ID in their system,
	 * which can be used as a lookup variable in Retrieve Invoice by GUID.
	 *
	 * @param string $guid
	 */
	public function setGuid( string $guid )
    {
        $this->_guid = $guid;
    }
	
	/**
	 * Gets token
	 * Invoice resource token. This token is derived from the API token initially used to create the invoice and is tied to the specific resource id created.
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
	 * Invoice resource token. This token is derived from the API token initially used to create the invoice and is tied to the specific resource id created.
	 *
	 * @param string $token
	 */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }
	
	
	/**
	 * Gets price
	 * Fixed price amount for the checkout, in the "currency" of the invoice object.
	 * @return float
	 */
	public function getPrice()
    {
        return $this->_price;
    }
	
	/**
	 * Sets price
	 * Fixed price amount for the checkout, in the "currency" of the invoice object.
	 * @param float $price
	 *
	 * @return void
	 */
	public function setPrice( float $price)
    {
        $this->_price = $price;
    }
	
	/**
	 * Gets posData
	 * A passthru variable provided by the merchant during invoice creation and designed to be used by the merchant to correlate the invoice with an order or other object in their system.
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
	 * A passthru variable provided by the merchant during invoice creation and designed to be used by the merchant to correlate the invoice with an order or other object in their system.
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
	 * @return string - URL to which BitPay sends webhook notifications. HTTPS is mandatory.
	 */
	public function getNotificationURL()
    {
        return $this->_notificationURL;
    }
	
	/**
	 * Sets notificationURL
	 * @param string $notificationURL - URL to which BitPay sends webhook notifications. HTTPS is mandatory.
	 *
	 * @return void
	 */
	public function setNotificationURL( string $notificationURL)
    {
        $this->_notificationURL = $notificationURL;
    }
	
	/**
	 * Gets transactionSpeed.
	 * This is a risk mitigation parameter for the merchant to configure how they want
	 * to fulfill orders depending on the number of block confirmations for the transaction made by the consumer on the selected cryptocurrency.
	 * If not set on the invoice, transactionSpeed will default to the account-level Order Settings.
	 * Note : orders are only credited to your BitPay Account Summary for settlement after the invoice reaches the status "complete" (regardless of this setting).
	 *
	 * @return string
	 */
	public function getTransactionSpeed()
    {
        return $this->_transactionSpeed;
    }
	
	/**
	 * Sets transactionSpeed.
	 * This is a risk mitigation parameter for the merchant to configure how they want
	 * to fulfill orders depending on the number of block confirmations for the transaction made by the consumer on the selected cryptocurrency.
	 * If not set on the invoice, transactionSpeed will default to the account-level Order Settings.
	 * Note : orders are only credited to your BitPay Account Summary for settlement after the invoice reaches the status "complete" (regardless of this setting).
	 *
	 * @param string $transactionSpeed
	 */
    public function setTransactionSpeed(string $transactionSpeed)
    {
        $this->_transactionSpeed = $transactionSpeed;
    }
	
	/**
	 * Gets fullNotifications
	 * This parameter is set to true by default, meaning all standard notifications are being sent for a payment made to an invoice.
	 * If you decide to set it to false instead, only 1 webhook will be sent for each invoice paid by the consumer.
	 * This webhook will be for the "confirmed" or "complete" invoice status, depending on the transactionSpeed selected.
	 *
	 * @return bool
	 */
	public function getFullNotifications()
    {
        return $this->_fullNotifications;
    }
	
	/**
	 * Sets fullNotifications
	 * This parameter is set to true by default, meaning all standard notifications are being sent for a payment made to an invoice.
	 * If you decide to set it to false instead, only 1 webhook will be sent for each invoice paid by the consumer.
	 * This webhook will be for the "confirmed" or "complete" invoice status, depending on the transactionSpeed selected.
	 *
	 * @param bool $fullNotifications
	 */
    public function setFullNotifications(bool $fullNotifications)
    {
        $this->_fullNotifications = $fullNotifications;
    }
	
	/**
	 * Gets NotificationEmail
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
	 * Merchant email address for notification of payout status change.
	 * @param string $notificationEmail
	 */
	public function setNotificationEmail( string $notificationEmail)
    {
        $this->_notificationEmail = $notificationEmail;
    }
	
	/**
	 * Gets RedirectURL
	 * The shopper will be redirected to this URL when clicking on the Return button after a successful payment or when clicking on the Close button if a separate closeURL is not specified.
	 *
	 * @return string
	 */
	public function getRedirectURL()
    {
        return $this->_redirectURL;
    }
	
	/**
	 * Sets RedirectURL
	 * The shopper will be redirected to this URL when clicking on the Return button after a successful payment or when clicking on the Close button if a separate closeURL is not specified.
	 * Be sure to include "http://" or "https://" in the url.
	 *
	 * @param string $redirectURL
	 */
	public function setRedirectURL( string $redirectURL)
    {
        $this->_redirectURL = $redirectURL;
    }
	
	/**
	 * Gets orderId
	 * Can be used by the merchant to assign their own internal Id to an invoice. If used, there should be a direct match between an orderId and an invoice id.
	 *
	 * @return string
	 */
	public function getOrderId()
    {
        return $this->_orderId;
    }
	
	/**
	 * Sets orderId
	 * Can be used by the merchant to assign their own internal Id to an invoice. If used, there should be a direct match between an orderId and an invoice id.
	 *
	 * @param string $orderId
	 */
	public function setOrderId( string $orderId)
    {
        $this->_orderId = $orderId;
    }
	
	
	/**
	 * Gets itemDesc
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
	 * Invoice description - will be added as a line item on the BitPay checkout page, under the merchant name.
	 *
	 * @param string $itemDesc
	 */
	public function setItemDesc( string $itemDesc)
    {
        $this->_itemDesc = $itemDesc;
    }
	
	/**
	 * Gets itemCode
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
	 * "bitcoindonation" for donations, otherwise do not include the field in the request.
	 *
	 * @param string $itemCode
	 */
	public function setItemCode( string $itemCode)
    {
        $this->_itemCode = $itemCode;
    }
	
	/**
	 * Gets physical.
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
	 * Indicates whether items are physical goods. Alternatives include digital goods and services.
	 *
	 * @param bool $physical
	 */
	public function setPhysical( bool $physical )
	{
		$this->_physical = $physical;
	}
	
	/**
	 * Gets paymentCurrencies
	 * Allow the merchant to select the cryptocurrencies available as payment option on the BitPay invoice.
	 * Possible values are currently "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
	 * For instance "paymentCurrencies": ["BTC"] will create an invoice with only XRP available as transaction currency, thus bypassing the currency selection step on the invoice.
	 *
	 * @return mixed
	 */
	public function getPaymentCurrencies()
    {
        return $this->_paymentCurrencies;
    }
	
	/**
	 * Sets paymentCurrencies
	 * Allow the merchant to select the cryptocurrencies available as payment option on the BitPay invoice.
	 * Possible values are currently "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
	 * For instance "paymentCurrencies": ["BTC"] will create an invoice with only XRP available as transaction currency, thus bypassing the currency selection step on the invoice.
	 *
	 * @param array $paymentCurrencies
	 */
    public function setPaymentCurrencies(array $paymentCurrencies)
    {
        $this->_paymentCurrencies = $paymentCurrencies;
    }
	
	/**
	 * Gets acceptanceWindow
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
	 * URL to redirect if the shopper does not pay the invoice and click on the Close button instead. Be sure to include "http://" or "https://" in the url.
	 *
	 * @param string $closeURL
	 */
    public function setCloseURL(string $closeURL)
    {
        $this->_closeURL = $closeURL;
    }
	
	/**
	 *
	 * @return bool
	 */
	public function getAutoRedirect()
    {
        return $this->_autoRedirect;
    }

    public function setAutoRedirect(bool $autoRedirect)
    {
        $this->_autoRedirect = $autoRedirect;
    }

    public function getJsonPayProRequired()
    {
        return $this->_jsonPayProRequired;
    }

    public function setJsonPayProRequired(bool $jsonPayProRequired)
    {
        $this->_jsonPayProRequired = $jsonPayProRequired;
    }

    public function getBitpayIdRequired()
    {
        return $this->_bitpayIdRequired;
    }

    public function setBitpayIdRequired(bool $bitpayIdRequired)
    {
        $this->_bitpayIdRequired = $bitpayIdRequired;
    }

    public function getMerchantName()
    {
        return $this->_merchantName;
    }

    public function setMerchantName(string $merchantName)
    {
        $this->_merchantName = $merchantName;
    }

    public function getSelectedTransactionCurrency()
    {
        return $this->_selectedTransactionCurrency;
    }

    public function setSelectedTransactionCurrency(string $selectedTransactionCurrency)
    {
        $this->_selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    public function getForcedBuyerSelectedWallet()
    {
        return $this->_forcedBuyerSelectedWallet;
    }

    public function setForcedBuyerSelectedWallet(string $forcedBuyerSelectedWallet)
    {
        $this->_forcedBuyerSelectedWallet = $forcedBuyerSelectedWallet;
    }

    public function getForcedBuyerSelectedTransactionCurrency()
    {
        return $this->_forcedBuyerSelectedTransactionCurrency;
    }

    public function setForcedBuyerSelectedTransactionCurrency(string $forcedBuyerSelectedTransactionCurrency)
    {
        $this->_forcedBuyerSelectedTransactionCurrency = $forcedBuyerSelectedTransactionCurrency;
    }

    public function getItemizedDetails()
    {
        return $this->_itemizedDetails;
    }

    public function getItemizedDetailsAsArray()
    {
        $items = [];

        foreach ($this->_items as $item) {
            if ($item instanceof ItemizedDetails) {
                array_push($items, $item->toArray());
            } else {
                array_push($items, $item);
            }
        }

        return $items;
    }

    public function setItemizedDetails(ItemizedDetails $itemizedDetails)
    {
        $itemsArray = [];

        foreach ($itemizedDetails as $item) {
            if ($item instanceof Item) {
                array_push($itemsArray, $item);
            } else {
                array_push($itemsArray, Item::createFromArray((array)$item));
            }
        }
        $this->_itemizedDetails = $itemsArray;
    }
    // Buyer data
    //

    public function setAcceptanceWindow(float $acceptanceWindow)
    {
        $this->_acceptanceWindow = $acceptanceWindow;
    }

    public function getBuyer()
    {
        return $this->_buyer;
    }

    public function setBuyer(Buyer $buyer)
    {
        $this->_buyer = $buyer;
    }

    public function getBuyerEmail()
    {
        return $this->_buyerEmail;
    }

    public function setBuyerEmail(string $buyerEmail)
    {
        $this->_buyerEmail = $buyerEmail;
    }

    public function getBuyerSms()
    {
        return $this->_buyerSms;
    }

    public function setBuyerSms(string $buyerSms)
    {
        $this->_buyerSms = $buyerSms;
    }

    // Response fields
    //

    public function getRefundAddresses()
    {
        return $this->_refundAddresses;
    }

    public function setRefundAddresses(array $refundAddresses)
    {
        $this->_refundAddresses = $refundAddresses;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    public function getLowFeeDetected()
    {
        return $this->_lowFeeDetected;
    }

    public function setLowFeeDetected($lowFeeDetected)
    {
        $this->_lowFeeDetected = $lowFeeDetected;
    }

    public function getInvoiceTime()
    {
        return $this->_invoiceTime;
    }

    public function setInvoiceTime($invoiceTime)
    {
        $this->_invoiceTime = $invoiceTime;
    }

    public function getExpirationTime()
    {
        return $this->_expirationTime;
    }

    public function setExpirationTime($expirationTime)
    {
        $this->_expirationTime = $expirationTime;
    }

    public function getCurrentTime()
    {
        return $this->_currentTime;
    }

    public function setCurrentTime($currentTime)
    {
        $this->_currentTime = $currentTime;
    }

    public function getTransactions()
    {
        return $this->_transactions;
    }

    public function setTransactions($transactions)
    {
        $this->_transactions = $transactions;
    }

    public function getExceptionStatus()
    {
        return $this->_exceptionStatus;
    }

    public function setExceptionStatus($exceptionStatus)
    {
        $this->_exceptionStatus = $exceptionStatus;
    }

    public function getTargetConfirmations()
    {
        return $this->_targetConfirmations;
    }

    public function setTargetConfirmations($targetConfirmations)
    {
        $this->_targetConfirmations = $targetConfirmations;
    }

    public function getRefundAddressRequestPending()
    {
        return $this->_refundAddressRequestPending;
    }

    public function setRefundAddressRequestPending($refundAddressRequestPending)
    {
        $this->_refundAddressRequestPending = $refundAddressRequestPending;
    }

    public function getBuyerProvidedEmail()
    {
        return $this->_buyerProvidedEmail;
    }

    public function setBuyerProvidedEmail($buyerProvidedEmail)
    {
        $this->_buyerProvidedEmail = $buyerProvidedEmail;
    }

    public function getBuyerProvidedInfo()
    {
        return $this->_buyerProvidedInfo;
    }

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

    public function getUniversalCodes()
    {
        return $this->_universalCodes;
    }

    public function setUniversalCodes(UniversalCodes $universalCodes)
    {
        $this->_universalCodes = $universalCodes;
    }

    public function getSupportedTransactionCurrencies()
    {
        return $this->_supportedTransactionCurrencies;
    }

    public function setSupportedTransactionCurrencies(SupportedTransactionCurrencies $supportedTransactionCurrencies)
    {
        $this->_supportedTransactionCurrencies = $supportedTransactionCurrencies;
    }

    public function getPaymentTotals()
    {
        return $this->_paymentTotals;
    }

    public function setPaymentTotals($paymentTotals)
    {
        $this->_paymentTotals = $paymentTotals;
    }

    public function getPaymentSubTotals()
    {
        return $this->_paymentSubtotals;
    }

    public function setPaymentSubTotals($paymentSubtotals)
    {
        $this->_paymentSubtotals = $paymentSubtotals;
    }


    public function getPaymentDisplaySubTotals()
    {
        return $this->_paymentDisplaySubtotals;
    }

    public function setPaymentDisplaySubTotals($paymentDisplaySubtotals)
    {
        $this->_paymentDisplaySubtotals = $paymentDisplaySubtotals;
    }

    public function getPaymentDisplayTotals()
    {
        return $this->_paymentDisplaytotals;
    }

    public function setPaymentDisplayTotals($paymentDisplaytotals)
    {
        $this->_paymentDisplaytotals = $paymentDisplaytotals;
    }

    public function getPaymentCodes()
    {
        return $this->_paymentCodes;
    }

    public function setPaymentCodes($paymentCodes)
    {
        $this->_paymentCodes = $paymentCodes;
    }

    public function getUnderpaidAmount()
    {
        return $this->_underpaidAmount;
    }

    public function setUnderpaidAmount($underpaidAmount)
    {
        $this->_underpaidAmount = $underpaidAmount;
    }

    public function getOverpaidAmount()
    {
        return $this->_overpaidAmount;
    }

    public function setOverpaidAmount($overpaidAmount)
    {
        $this->_overpaidAmount = $overpaidAmount;
    }

    public function getMinerFees()
    {
        return $this->_minerFees;
    }

    public function setMinerFees(MinerFees $minerFees)
    {
        $this->_minerFees = $minerFees;
    }

    public function getNonPayProPaymentReceived()
    {
        return $this->_nonPayProPaymentReceived;
    }

    public function setNonPayProPaymentReceived(bool $nonPayProPaymentReceived)
    {
        $this->_nonPayProPaymentReceived = $nonPayProPaymentReceived;
    }

    public function getShopper()
    {
        return $this->_shopper;
    }

    public function setShopper(Shopper $shopper)
    {
        $this->_shopper = $shopper;
    }

    public function getBillId()
    {
        return $this->_billId;
    }

    public function setBillId($billId)
    {
        $this->_billId = $billId;
    }

    public function getRefundInfo()
    {
        return $this->_refundInfo;
    }

    public function setRefundInfo(RefundInfo $refundInfo)
    {
        $this->_refundInfo = $refundInfo;
    }

    public function getExtendedNotifications()
    {
        return $this->_extendedNotifications;
    }

    public function setExtendedNotifications(bool $extendedNotifications)
    {
        $this->_extendedNotifications = $extendedNotifications;
    }

    public function getTransactionCurrency()
    {
        return $this->_transactionCurrency;
    }

    public function setTransactionCurrency($transactionCurrency)
    {
        $this->_transactionCurrency = $transactionCurrency;
    }

    public function getAmountPaid()
    {
        return $this->_amountPaid;
    }

    public function setAmountPaid($amountPaid)
    {
        $this->_amountPaid = $amountPaid;
    }

    public function getDisplayAmountPaid()
    {
        return $this->_displayAmountPaid;
    }

    public function setDisplayAmountPaid($displayAmountPaid)
    {
        $this->_displayAmountPaid = $displayAmountPaid;
    }

    public function getExchangeRates()
    {
        return $this->_exchangeRates;
    }

    public function setExchangeRates($exchangeRates)
    {
        $this->_exchangeRates = $exchangeRates;
    }

    public function getPaymentString()
    {
        return $this->_paymentString;
    }

    public function setPaymentString(string $paymentString)
    {
        $this->_paymentString = $paymentString;
    }

    public function getVerificationLink()
    {
        return $this->_verificationLink;
    }

    public function setVerificationLink(string $verificationLink)
    {
        $this->_verificationLink = $verificationLink;
    }

    public function getIsCancelled()
    {
        return $this->_isCancelled;
    }

    public function setIsCancelled(bool $isCancelled)
    {
        $this->_isCancelled = $isCancelled;
    }

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
            'itemizedDetails'                => $this->getItemizedDetails()->toArray(),
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
