<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 * @package Bitpay
 * @see <a href="https://bitpay.readme.io/reference/invoices">REST API Invoices</a>
 */
class Invoice
{
    protected ?string $currency = null;
    protected ?string $guid = null;
    protected ?string $token = null;
    protected ?float $price = null;
    protected ?string $posData = null;
    protected ?string $notificationURL = null;
    protected ?string $transactionSpeed = null;
    protected bool $fullNotifications = false;
    protected ?string $notificationEmail = null;
    protected ?string $redirectURL = null;
    protected ?string $orderId = null;
    protected ?string $itemDesc = null;
    protected ?string $itemCode = null;
    protected bool $physical = false;
    protected ?array $paymentCurrencies = null;
    protected ?array $paymentSubtotals = null;
    protected ?array $paymentTotals = null;
    protected ?array $paymentCodes = null;
    protected ?float $acceptanceWindow = null;
    protected ?Buyer $buyer = null;
    protected ?array $refundAddresses = null;
    protected ?string $closeURL = null;
    protected bool $autoRedirect = false;
    protected ?bool $jsonPayProRequired = null;
    protected ?string $buyerEmail = null;
    protected ?string $buyerSms = null;
    protected ?string $merchantName = null;
    protected ?string $selectedTransactionCurrency = null;
    protected ?string $forcedBuyerSelectedWallet = null;
    protected ?string $forcedBuyerSelectedTransactionCurrency = null;
    /**
     * @var ItemizedDetails[]
     */
    protected array $itemizedDetails = [];
    protected ?string $id = null;
    protected ?string $url = null;
    protected ?string $status = null;
    protected ?bool $lowFeeDetected = null;
    protected ?int $invoiceTime = null;
    protected ?string $expirationTime = null;
    protected ?string $currentTime = null;
    protected ?array $transactions = null;
    protected ?bool $exceptionStatus = null;
    protected ?int $targetConfirmations = null;
    protected ?bool $refundAddressRequestPending = null;
    protected ?string $buyerProvidedEmail = null;
    protected ?BuyerProvidedInfo $buyerProvidedInfo = null;
    protected ?UniversalCodes $universalCodes = null;
    protected ?SupportedTransactionCurrencies $supportedTransactionCurrencies = null;
    protected ?MinerFees $minerFees = null;
    protected ?bool $nonPayProPaymentReceived = null;
    protected ?Shopper $shopper = null;
    protected ?string $billId = null;
    protected ?RefundInfo $refundInfo = null;
    protected bool $extendedNotifications = false;
    protected ?bool $isCancelled = null;
    protected ?string $transactionCurrency = null;
    protected ?int $underpaidAmount = null;
    protected ?int $overpaidAmount = null;
    protected ?int $amountPaid = null;
    protected ?string $displayAmountPaid = null;
    protected ?array $exchangeRates = null;
    protected ?bool $bitpayIdRequired = null;
    protected ?array $paymentDisplayTotals = null;
    protected ?array $paymentDisplaySubTotals = null;

    /**
     * Constructor, create a minimal request Invoice object.
     *
     * @param float|null $price float The amount for which the invoice will be created.
     * @param string|null $currency string three digit currency type used to compute the invoice bitcoin amount.
     */
    public function __construct(float $price = null, string $currency = null)
    {
        $this->price = $price;
        $this->currency = $currency;
        $this->buyer = new Buyer();
        $this->buyerProvidedInfo = new BuyerProvidedInfo();
        $this->universalCodes = new UniversalCodes();
        $this->supportedTransactionCurrencies = new SupportedTransactionCurrencies();
        $this->minerFees = new MinerFees();
        $this->shopper = new Shopper();
        $this->refundInfo = new RefundInfo();
        $this->itemizedDetails = [];
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
     * @return string|null The currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
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
     * @param string $currency 3-character currency code
     *
     * @throws BitPayException
     */
    public function setCurrency(string $currency): void
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        $this->currency = $currency;
    }

    /**
     * Gets guid
     *
     * A passthru variable provided by the merchant and designed to be used by the merchant
     * to correlate the invoice with an order ID in their system,
     * which can be used as a lookup variable in Retrieve Invoice by GUID.
     *
     * @return string|null The guid
     */
    public function getGuid(): ?string
    {
        return $this->guid;
    }

    /**
     * Sets guid
     *
     * A passthru variable provided by the merchant and designed to be used by the merchant
     * to correlate the invoice with an order ID in their system,
     * which can be used as a lookup variable in Retrieve Invoice by GUID.
     *
     * @param string $guid The guid of the refund request being retrieved
     */
    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    /**
     * Gets token
     *
     * Invoice resource token. This token is derived from the API token initially used
     * to create the invoice and is tied to the specific resource id created.
     *
     * @return string|null - Invoice resource token.
     */
    public function getToken(): ?string
    {
        return $this->token;
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
     * @param string $token Invoice resource token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Gets price
     *
     * Fixed price amount for the checkout, in the "currency" of the invoice object.
     *
     * @return float|null The price
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Sets price
     *
     * Fixed price amount for the checkout, in the "currency" of the invoice object.
     *
     * @param float $price Fixed price amount for the checkout, in the "currency" of the invoice object.
     *
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * Gets posData
     *
     * A passthru variable provided by the merchant during invoice creation and designed to be
     * used by the merchant to correlate the invoice with an order or other object in their system.
     * This passthru variable can be a serialized object.
     *
     * @return string|null The pos data
     */
    public function getPosData(): ?string
    {
        return $this->posData;
    }

    /**
     * Sets posData
     *
     * A passthru variable provided by the merchant during invoice creation and designed to be
     * used by the merchant to correlate the invoice with an order or other object in their system.
     * This passthru variable can be a serialized object.
     *
     * @param string $posData the pos data
     */
    public function setPosData(string $posData): void
    {
        $this->posData = $posData;
    }

    /**
     * Gets notificationURL
     *
     * @return string|null - URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     */
    public function getNotificationURL(): ?string
    {
        return $this->notificationURL;
    }

    /**
     * Sets notificationURL
     *
     * @param string $notificationURL - URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     */
    public function setNotificationURL(string $notificationURL): void
    {
        $this->notificationURL = $notificationURL;
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
     * @return string|null the transaction speed
     */
    public function getTransactionSpeed(): ?string
    {
        return $this->transactionSpeed;
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
     * @param string $transactionSpeed the transaction speed
     */
    public function setTransactionSpeed(string $transactionSpeed): void
    {
        $this->transactionSpeed = $transactionSpeed;
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
     * @return bool|null the full notification
     */
    public function getFullNotifications(): ?bool
    {
        return $this->fullNotifications;
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
     * @param bool $fullNotifications the full notification
     */
    public function setFullNotifications(bool $fullNotifications): void
    {
        $this->fullNotifications = $fullNotifications;
    }

    /**
     * Gets NotificationEmail
     *
     * Merchant email address for notification of payout status change.
     *
     * @return string|null the notification email
     */
    public function getNotificationEmail(): ?string
    {
        return $this->notificationEmail;
    }

    /**
     * Sets NotificationEmail
     *
     * Merchant email address for notification of payout status change.
     *
     * @param string $notificationEmail Merchant email address for notification of payout status change
     */
    public function setNotificationEmail(string $notificationEmail): void
    {
        $this->notificationEmail = $notificationEmail;
    }

    /**
     * Gets RedirectURL
     *
     * The shopper will be redirected to this URL when clicking on the Return button
     * after a successful payment or when clicking on the Close button if a separate closeURL is not specified.
     *
     * @return string|null the redirect url
     */
    public function getRedirectURL(): ?string
    {
        return $this->redirectURL;
    }

    /**
     * Sets RedirectURL
     *
     * The shopper will be redirected to this URL when clicking on the Return button
     * after a successful payment or when clicking on the Close button if a separate closeURL is not specified.
     * Be sure to include "http://" or "https://" in the url.
     *
     * @param string $redirectURL The shopper will be redirected to this URL
     */
    public function setRedirectURL(string $redirectURL): void
    {
        $this->redirectURL = $redirectURL;
    }

    /**
     * Gets orderId
     *
     * Can be used by the merchant to assign their own internal Id to an invoice.
     * If used, there should be a direct match between an orderId and an invoice id.
     *
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets orderId
     *
     * Can be used by the merchant to assign their own internal Id to an invoice.
     * If used, there should be a direct match between an orderId and an invoice id.
     *
     * @param string $orderId Invoice order id
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }


    /**
     * Gets itemDesc
     *
     * Invoice description - will be added as a line item on the BitPay checkout page, under the merchant name.
     *
     * @return string|null the item desc
     */
    public function getItemDesc(): ?string
    {
        return $this->itemDesc;
    }


    /**
     * Sets itemDesc
     *
     * Invoice description - will be added as a line item on the BitPay checkout page, under the merchant name.
     *
     * @param string $itemDesc Invoice description
     */
    public function setItemDesc(string $itemDesc): void
    {
        $this->itemDesc = $itemDesc;
    }

    /**
     * Gets itemCode
     *
     * "bitcoindonation" for donations, otherwise do not include the field in the request.
     *
     * @return string|null the item code
     */
    public function getItemCode(): ?string
    {
        return $this->itemCode;
    }

    /**
     * Sets itemCode
     *
     * "bitcoindonation" for donations, otherwise do not include the field in the request.
     *
     * @param string $itemCode "bitcoindonation" for donations, otherwise do not include the field in the request.
     */
    public function setItemCode(string $itemCode): void
    {
        $this->itemCode = $itemCode;
    }

    /**
     * Gets physical.
     *
     * Indicates whether items are physical goods. Alternatives include digital goods and services.
     *
     * @return bool|null the physical
     */
    public function getPhysical(): ?bool
    {
        return $this->physical;
    }

    /**
     * Sets physical.
     *
     * Indicates whether items are physical goods. Alternatives include digital goods and services.
     *
     * @param bool $physical the physical
     */
    public function setPhysical(bool $physical): void
    {
        $this->physical = $physical;
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
     * @return array|null the payment currencies
     */
    public function getPaymentCurrencies(): ?array
    {
        return $this->paymentCurrencies;
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
     * @param array $paymentCurrencies the payment currencies
     */
    public function setPaymentCurrencies(array $paymentCurrencies): void
    {
        $this->paymentCurrencies = $paymentCurrencies;
    }

    /**
     * Gets closeURL
     *
     * URL to redirect if the shopper does not pay the invoice and click on the Close button instead.
     *
     * @return string|null the close url
     */
    public function getCloseURL(): ?string
    {
        return $this->closeURL;
    }

    /**
     * Gets closeURL
     *
     * URL to redirect if the shopper does not pay the invoice and click on the Close button instead.
     * Be sure to include "http://" or "https://" in the url.
     *
     * @param string $closeURL URL to redirect if the shopper does not pay the invoice
     */
    public function setCloseURL(string $closeURL): void
    {
        $this->closeURL = $closeURL;
    }

    /**
     * Gets autoRedirect
     *
     * Set to false by default,
     * merchant can setup automatic redirect to their website by setting this parameter to true.
     *
     * @return bool|null the auto redirect
     */
    public function getAutoRedirect(): ?bool
    {
        return $this->autoRedirect;
    }

    /**
     * Sets autoRedirect
     *
     * Set to false by default,
     * merchant can setup automatic redirect to their website by setting this parameter to true.
     *
     * @param bool $autoRedirect the auto redirect
     */
    public function setAutoRedirect(bool $autoRedirect): void
    {
        $this->autoRedirect = $autoRedirect;
    }

    /**
     * Gets jsonPayProRequired
     *
     * Boolean set to false by default.
     * If set to true, this means that the invoice will only accept payments
     * from wallets which have implemented the
     * <a href="https://bitpay.com/docs/payment-protocol">BitPay JSON Payment Protocol</a>
     *
     * @return bool|null the json pay pro required
     */
    public function getJsonPayProRequired(): ?bool
    {
        return $this->jsonPayProRequired;
    }

    /**
     * Sets jsonPayProRequired
     *
     * Boolean set to false by default.
     * If set to true, this means that the invoice will only accept payments
     * from wallets which have implemented the
     * <a href="https://bitpay.com/docs/payment-protocol">BitPay JSON Payment Protocol</a>
     *
     * @param bool $jsonPayProRequired the json pay pro required
     */
    public function setJsonPayProRequired(bool $jsonPayProRequired): void
    {
        $this->jsonPayProRequired = $jsonPayProRequired;
    }

    /**
     * Gets bitpayIdRequired
     *
     * BitPay ID is a verification process that is required when a user is making payments
     * or receiving a refund over a given threshold, which may vary by region.
     * This Boolean forces the invoice to require BitPay ID regardless of the price.
     *
     * @return bool|null the Bitpay id required
     */
    public function getBitpayIdRequired(): ?bool
    {
        return $this->bitpayIdRequired;
    }

    /**
     * Sets bitpayIdRequired
     *
     * BitPay ID is a verification process that is required when a user is making payments
     * or receiving a refund over a given threshold, which may vary by region.
     * This Boolean forces the invoice to require BitPay ID regardless of the price.
     *
     * @param bool $bitpayIdRequired the bitpay id required
     */
    public function setBitpayIdRequired(bool $bitpayIdRequired): void
    {
        $this->bitpayIdRequired = $bitpayIdRequired;
    }

    /**
     * Gets merchantName
     *
     * A display string for merchant identification (ex. Wal-Mart Store #1452, Bowling Green, KY).
     *
     * @return string|null the merchant name
     */
    public function getMerchantName(): ?string
    {
        return $this->merchantName;
    }

    /**
     * Sets merchantName
     *
     * A display string for merchant identification (ex. Wal-Mart Store #1452, Bowling Green, KY).
     *
     * @param string $merchantName A display string for merchant identification
     */
    public function setMerchantName(string $merchantName): void
    {
        $this->merchantName = $merchantName;
    }

    /**
     * Gets selectedTransactionCurrency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @return string|null the selected transaction currency
     */
    public function getSelectedTransactionCurrency(): ?string
    {
        return $this->selectedTransactionCurrency;
    }

    /**
     * Sets selectedTransactionCurrency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @param string $selectedTransactionCurrency This field will be populated with the cryptocurrency selected
     * to pay the BitPay invoice
     */
    public function setSelectedTransactionCurrency(string $selectedTransactionCurrency): void
    {
        $this->selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    /**
     * Gets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @return string|null the forced buyer selected wallet
     */
    public function getForcedBuyerSelectedWallet(): ?string
    {
        return $this->forcedBuyerSelectedWallet;
    }

    /**
     * Sets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @param string $forcedBuyerSelectedWallet Merchant pre-selects wallet on behalf of buyer
     */
    public function setForcedBuyerSelectedWallet(string $forcedBuyerSelectedWallet)
    {
        $this->forcedBuyerSelectedWallet = $forcedBuyerSelectedWallet;
    }

    /**
     * Gets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @return string|null Merchant pre-selects transaction currency
     */
    public function getForcedBuyerSelectedTransactionCurrency(): ?string
    {
        return $this->forcedBuyerSelectedTransactionCurrency;
    }

    /**
     * Sets forcedBuyerSelectedWallet
     *
     * Merchant pre-selects transaction currency on behalf of buyer.
     *
     * @param string $forcedBuyerSelectedTransactionCurrency Merchant pre-selects transaction currency
     */
    public function setForcedBuyerSelectedTransactionCurrency(string $forcedBuyerSelectedTransactionCurrency)
    {
        $this->forcedBuyerSelectedTransactionCurrency = $forcedBuyerSelectedTransactionCurrency;
    }

    /**
     * Gets itemizedDetails
     *
     * Object containing line item details for display.
     *
     * @return ItemizedDetails[]
     */
    public function getItemizedDetails(): array
    {
        return $this->itemizedDetails;
    }

    /**
     * Sets itemizedDetails
     *
     * Object containing line item details for display.
     *
     * @param ItemizedDetails[] $itemizedDetails
     * @throws BitPayException
     */
    public function setItemizedDetails(array $itemizedDetails): void
    {
        foreach ($itemizedDetails as $item) {
            if (!$item instanceof ItemizedDetails) {
                throw new BitPayException('Wrong format for itemized details');
            }
        }

        $this->itemizedDetails = $itemizedDetails;
    }

    /**
     * Gets acceptanceWindow
     *
     * Number of milliseconds that a user has to pay an invoice before it expires (0-900000).
     * If not set, invoice will default to the account acceptanceWindow.
     * If account acceptanceWindow is not set, invoice will default to 15 minutes (900,000 milliseconds).
     *
     * @return float|null the acceptance window
     */
    public function getAcceptanceWindow(): ?float
    {
        return $this->acceptanceWindow;
    }

    /**
     * Sets acceptanceWindow
     *
     * Number of milliseconds that a user has to pay an invoice before it expires (0-900000).
     * If not set, invoice will default to the account acceptanceWindow.
     * If account acceptanceWindow is not set, invoice will default to 15 minutes (900,000 milliseconds).
     *
     * @param float $acceptanceWindow Number of milliseconds that a user has to pay an invoice before it expire
     */
    public function setAcceptanceWindow(float $acceptanceWindow): void
    {
        $this->acceptanceWindow = $acceptanceWindow;
    }

    /**
     * Gets buyer
     *
     * Allows merchant to pass buyer related information in the invoice object
     *
     * @return Buyer|null the buyer
     */
    public function getBuyer(): ?Buyer
    {
        return $this->buyer;
    }

    /**
     * Sets buyer
     *
     * Allows merchant to pass buyer related information in the invoice object
     *
     * @param Buyer $buyer the buyer
     */
    public function setBuyer(Buyer $buyer): void
    {
        $this->buyer = $buyer;
    }

    /**
     * Gets buyerEmail
     *
     * Buyer's email address.
     * If provided during invoice creation, this will bypass the email prompt for the consumer when opening the invoice.
     *
     * @return string|null the buyer email
     */
    public function getBuyerEmail(): ?string
    {
        return $this->buyerEmail;
    }

    /**
     * Sets buyerEmail
     *
     * Buyer's email address.
     * If provided during invoice creation, this will bypass the email prompt for the consumer when opening the invoice.
     *
     * @param string $buyerEmail Buyer's email address
     */
    public function setBuyerEmail(string $buyerEmail): void
    {
        $this->buyerEmail = $buyerEmail;
    }

    /**
     * Gets buyerSms
     *
     * SMS provided by user for communications.
     * This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @return string|null the buyer sms
     */
    public function getBuyerSms(): ?string
    {
        return $this->buyerSms;
    }

    /**
     * Sets buyerSms
     *
     * SMS provided by user for communications.
     * This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @param string $buyerSms SMS provided by user for communication
     */
    public function setBuyerSms(string $buyerSms): void
    {
        $this->buyerSms = $buyerSms;
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
     * @return array|null Refund address provided by the customer
     */
    public function getRefundAddresses(): ?array
    {
        return $this->refundAddresses;
    }

    /**
     * Sets refundAddresses
     *
     * Initially empty when the invoice is created.
     * This field will be populated with the refund address
     * provided by the customer if you request a refund of the specific invoice.
     *
     * @param array $refundAddresses Refund address provided by the customer
     */
    public function setRefundAddresses(array $refundAddresses): void
    {
        $this->refundAddresses = $refundAddresses;
    }

    /**
     * Gets invoice resource id
     *
     * @return string|null Invoice resource id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets invoice resource id
     *
     * @param string $id Invoice resource id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets url
     *
     * Web address of invoice, expires at expirationTime
     *
     * @return string|null Web address of invoice
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Sets url
     *
     * Web address of invoice, expires at expirationTime
     *
     * @param string $url Web address of invoice
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Gets status
     *
     * Detailed information about invoice status notifications can be found under the
     * <a href="https://bitpay.com/api/#notifications-webhooks-instant-payment-notifications-handling">
     * Instant Payment Notification (IPN) section.
     * </a>
     *
     * @return string|null Invoice status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets status
     *
     * Detailed information about invoice status notifications can be found under the
     * <a href="https://bitpay.com/api/#notifications-webhooks-instant-payment-notifications-handling">
     * Instant Payment Notification (IPN) section.
     * </a>
     *
     * @param string $status Invoice status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets lowFeeDetected
     *
     * Flag to indicate if the miner fee used by the buyer is too low.
     * Initially set to false when the invoice is created.
     *
     * @return bool|null Flag to indicate if the miner fee used by the buyer is too low
     */
    public function getLowFeeDetected(): ?bool
    {
        return $this->lowFeeDetected;
    }

    /**
     * Sets lowFeeDetected
     *
     * Flag to indicate if the miner fee used by the buyer is too low.
     * Initially set to false when the invoice is created.
     *
     * @param boolean $lowFeeDetected Flag to indicate if the miner fee used by the buyer is too low
     */
    public function setLowFeeDetected(bool $lowFeeDetected)
    {
        $this->lowFeeDetected = $lowFeeDetected;
    }

    /**
     * Gets invoiceTime - UNIX time of invoice creation, in milliseconds
     *
     * @return int|null UNIX time of invoice creation, in milliseconds
     */
    public function getInvoiceTime(): ?int
    {
        return $this->invoiceTime;
    }

    /**
     * Sets invoiceTime - UNIX time of invoice creation, in milliseconds
     *
     * @param int $invoiceTime UNIX time of invoice creation, in milliseconds
     */
    public function setInvoiceTime(int $invoiceTime)
    {
        $this->invoiceTime = $invoiceTime;
    }

    /**
     * Gets expirationTime - UNIX time when invoice is last available to be paid, in milliseconds
     *
     * @return string|null the UNIX time
     */
    public function getExpirationTime(): ?string
    {
        return $this->expirationTime;
    }

    /**
     * Sets expirationTime - UNIX time when invoice is last available to be paid, in milliseconds
     *
     * @param string $expirationTime UNIX time when invoice is last available to be paid, in milliseconds
     */
    public function setExpirationTime(string $expirationTime): void
    {
        $this->expirationTime = $expirationTime;
    }

    /**
     * Gets currentTime - UNIX time of API call, in milliseconds
     *
     * @return string|null UNIX time
     */
    public function getCurrentTime(): ?string
    {
        return $this->currentTime;
    }

    /**
     * Sets currentTime - UNIX time of API call, in milliseconds
     *
     * @param string $currentTime UNIX time of API call, in milliseconds
     */
    public function setCurrentTime(string $currentTime): void
    {
        $this->currentTime = $currentTime;
    }

    /**
     * Gets transactions
     *
     * Contains the cryptocurrency transaction details for the executed payout.
     *
     * @return array|null the transactions
     */
    public function getTransactions(): ?array
    {
        return $this->transactions;
    }

    /**
     * Sets transactions
     *
     * Contains the cryptocurrency transaction details for the executed payout.
     *
     * @param array $transactions array with the crypto currency transaction hashes linked to the invoice
     */
    public function setTransactions(array $transactions): void
    {
        $this->transactions = $transactions;
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
     * @return bool|null the exception status
     */
    public function getExceptionStatus(): ?bool
    {
        return $this->exceptionStatus;
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
     * @param boolean $exceptionStatus this parameter will indicate if the purchaser sent too much or not enough funds
     */
    public function setExceptionStatus(bool $exceptionStatus): void
    {
        $this->exceptionStatus = $exceptionStatus;
    }

    /**
     * Gets targetConfirmations
     *
     * Indicates the number of block confirmation of the crypto currency
     * transaction which are required to credit a paid invoice to the merchant account.
     * Currently, the value set is set to 6 by default for BTC/BCH/XRP,
     * 40 for DOGE and 50 for ETH/GUSD/PAX/USDC/BUSD/DAI/WBTC
     *
     * @return int|null the target confirmations
     */
    public function getTargetConfirmations(): ?int
    {
        return $this->targetConfirmations;
    }

    /**
     * Sets targetConfirmations
     *
     * Indicates the number of block confirmation of the crypto currency
     * transaction which are required to credit a paid invoice to the merchant account.
     * Currently, the value set is set to 6 by default for BTC/BCH/XRP,
     * 40 for DOGE and 50 for ETH/GUSD/PAX/USDC/BUSD/DAI/WBTC
     *c
     * @param int $targetConfirmations Indicates the number of block confirmation of the crypto currency transaction
     * which are required to credit a paid invoice to the merchant account
     */
    public function setTargetConfirmations(int $targetConfirmations): void
    {
        $this->targetConfirmations = $targetConfirmations;
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
     * @return bool|null the refund address request pending
     */
    public function getRefundAddressRequestPending(): ?bool
    {
        return $this->refundAddressRequestPending;
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
     * @param boolean $refundAddressRequestPending This flag is here to indicate that the refund
     * request is pending action
     */
    public function setRefundAddressRequestPending(bool $refundAddressRequestPending): void
    {
        $this->refundAddressRequestPending = $refundAddressRequestPending;
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
     * @return string|null the buyer provided email
     */
    public function getBuyerProvidedEmail(): ?string
    {
        return $this->buyerProvidedEmail;
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
     * @param string $buyerProvidedEmail Populated with the buyer's email address if passed in the buyer object
     * by the merchant
     */
    public function setBuyerProvidedEmail(string $buyerProvidedEmail): void
    {
        $this->buyerProvidedEmail = $buyerProvidedEmail;
    }

    /**
     * Gets buyerProvidedEmail
     *
     * Information collected from the buyer during the process of paying an invoice.
     * Initially this object is empty.
     *
     * @return BuyerProvidedInfo|null Information collected from the buyer
     */
    public function getBuyerProvidedInfo(): ?BuyerProvidedInfo
    {
        return $this->buyerProvidedInfo;
    }

    /**
     * Sets buyerProvidedEmail
     *
     * Information collected from the buyer during the process of paying an invoice.
     * Initially this object is empty.
     *
     * @param BuyerProvidedInfo $buyerProvidedInfo Information collected from the buyer
     * during the process of paying an invoice
     */
    public function setBuyerProvidedInfo(BuyerProvidedInfo $buyerProvidedInfo)
    {
        $this->buyerProvidedInfo = $buyerProvidedInfo;
    }

    /**
     * Gets universalCodes
     *
     * Object containing wallet-specific URLs for payment protocol.
     *
     * @return UniversalCodes|null UniversalCodes
     */
    public function getUniversalCodes(): ?UniversalCodes
    {
        return $this->universalCodes;
    }

    /**
     * Sets universalCodes
     *
     * @param UniversalCodes $universalCodes Object containing wallet-specific URLs for payment protocol.
     */
    public function setUniversalCodes(UniversalCodes $universalCodes)
    {
        $this->universalCodes = $universalCodes;
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
     * @return SupportedTransactionCurrencies|null The currencies that may be used to pay this invoice
     */
    public function getSupportedTransactionCurrencies(): ?SupportedTransactionCurrencies
    {
        return $this->supportedTransactionCurrencies;
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
     * @param SupportedTransactionCurrencies $supportedTransactionCurrencies The currencies that may be used
     * to pay this invoice
     */
    public function setSupportedTransactionCurrencies(
        SupportedTransactionCurrencies $supportedTransactionCurrencies
    ): void {
        $this->supportedTransactionCurrencies = $supportedTransactionCurrencies;
    }

    /**
     * Gets paymentTotals
     *
     * For internal use - This field can be ignored in merchant implementations.
     *
     * @return array|null the payment totals
     */
    public function getPaymentTotals(): ?array
    {
        return $this->paymentTotals;
    }

    /**
     * Sets paymentTotals
     *
     * For internal use - This field can be ignored in merchant implementations.
     *
     * @param array|null $paymentTotals the payment totals
     */
    public function setPaymentTotals(?array $paymentTotals)
    {
        $this->paymentTotals = $paymentTotals;
    }

    /**
     * Gets paymentSubtotals
     *
     * For internal use. This field can be ignored in merchant implementations.
     *
     * @return array|null the payment subtotals
     */
    public function getPaymentSubtotals(): ?array
    {
        return $this->paymentSubtotals;
    }

    /**
     * Sets paymentSubtotals
     *
     * For internal use. This field can be ignored in merchant implementations.
     *
     * @param array|null $paymentSubtotals the payment subtotals
     */
    public function setPaymentSubtotals(?array $paymentSubtotals)
    {
        $this->paymentSubtotals = $paymentSubtotals;
    }

    /**
     * Gets paymentDisplaySubtotals
     *
     * Equivalent to price for each supported transactionCurrency, excluding minerFees.
     * The key is the currency and the value is an amount indicated in the base unit
     * for each supported transactionCurrency.
     *
     * @return array|null Equivalent to price for each supported transactionCurrency
     */
    public function getPaymentDisplaySubTotals(): ?array
    {
        return $this->paymentDisplaySubTotals;
    }

    /**
     * Sets paymentDisplaySubtotals
     *
     * Equivalent to price for each supported transactionCurrency, excluding minerFees.
     * The key is the currency and the value is an amount indicated in the base unit
     * for each supported transactionCurrency.
     *
     * @param array|null $paymentDisplaySubTotals Equivalent to price for each supported transactionCurrency
     */
    public function setPaymentDisplaySubTotals(?array $paymentDisplaySubTotals)
    {
        $this->paymentDisplaySubTotals = $paymentDisplaySubTotals;
    }

    /**
     * Gets paymentDisplayTotals
     *
     * The total amount that the purchaser should pay as displayed on the invoice UI.
     * This is like paymentDisplaySubTotals but with the minerFees included.
     * The key is the currency and the value is an amount
     * indicated in the base unit for each supported transactionCurrency.
     *
     * @return array|null The total amount that the purchaser should pay
     */
    public function getPaymentDisplayTotals(): ?array
    {
        return $this->paymentDisplayTotals;
    }

    /**
     * Sets paymentDisplayTotals
     *
     * The total amount that the purchaser should pay as displayed on the invoice UI.
     * This is like paymentDisplaySubTotals but with the minerFees included.
     * The key is the currency and the value is an amount
     * indicated in the base unit for each supported transactionCurrency.
     *
     * @param array|null $paymentDisplayTotals The total amount that the purchaser should pay
     */
    public function setPaymentDisplayTotals(?array $paymentDisplayTotals)
    {
        $this->paymentDisplayTotals = $paymentDisplayTotals;
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
     * @return array|null
     */
    public function getPaymentCodes(): ?array
    {
        return $this->paymentCodes;
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
     * @param array|null $paymentCodes
     */
    public function setPaymentCodes(?array $paymentCodes)
    {
        $this->paymentCodes = $paymentCodes;
    }

    /**
     * Gets underpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was underpaid ("exceptionStatus": "paidPartial").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @return int|null
     */
    public function getUnderpaidAmount(): ?int
    {
        return $this->underpaidAmount;
    }

    /**
     * Sets underpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was underpaid ("exceptionStatus": "paidPartial").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @param int $underpaidAmount the underpaid amount
     */
    public function setUnderpaidAmount(int $underpaidAmount): void
    {
        $this->underpaidAmount = $underpaidAmount;
    }

    /**
     * Gets overpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was overpaid ("exceptionStatus": "paidOver").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @return int|null
     */
    public function getOverpaidAmount(): ?int
    {
        return $this->overpaidAmount;
    }

    /**
     * Sets overpaidAmount
     *
     * This parameter will be returned on the invoice object
     * if the invoice was overpaid ("exceptionStatus": "paidOver").
     * It equals to the absolute difference between amountPaid
     * and paymentTotals for the corresponding transactionCurrency used.
     *
     * @param int $overpaidAmount the overpaid amount
     */
    public function setOverpaidAmount(int $overpaidAmount): void
    {
        $this->overpaidAmount = $overpaidAmount;
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
     * @return MinerFees|null
     */
    public function getMinerFees(): ?MinerFees
    {
        return $this->minerFees;
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
     * @param MinerFees $minerFees The total amount of fees that the purchaser will pay
     * to cover BitPay's UTXO sweep cost for an invoice
     */
    public function setMinerFees(MinerFees $minerFees): void
    {
        $this->minerFees = $minerFees;
    }

    /**
     * Gets nonPayProPaymentReceived
     *
     * This boolean will be available on an invoice object once an invoice is paid
     * and indicate if the transaction was made with a wallet using the payment protocol (true) or peer to peer (false).
     *
     * @return bool|null
     */
    public function getNonPayProPaymentReceived(): ?bool
    {
        return $this->nonPayProPaymentReceived;
    }

    /**
     * Sets nonPayProPaymentReceived
     *
     * This boolean will be available on an invoice object once an invoice is paid
     * and indicate if the transaction was made with a wallet using the payment protocol (true) or peer to peer (false).
     *
     * @param boolean $nonPayProPaymentReceived transaction was made with a wallet using the payment protocol
     */
    public function setNonPayProPaymentReceived(bool $nonPayProPaymentReceived): void
    {
        $this->nonPayProPaymentReceived = $nonPayProPaymentReceived;
    }

    /**
     * Gets shopper
     *
     * This object will be available on the invoice if a shopper signs in on an invoice using his BitPay ID.
     * See the following <a href="https://blog.bitpay.com/bitpay-dashboard-id/">blogpost</a> for more information.
     *
     * @return Shopper|null the shopper
     */
    public function getShopper(): ?Shopper
    {
        return $this->shopper;
    }

    /**
     * Sets shopper
     *
     * This object will be available on the invoice if a shopper signs in on an invoice using his BitPay ID.
     * See the following <a href="https://blog.bitpay.com/bitpay-dashboard-id/">blogpost</a> for more information.
     *
     * @param Shopper $shopper the shopper
     */
    public function setShopper(Shopper $shopper)
    {
        $this->shopper = $shopper;
    }

    /**
     * Gets billId
     *
     * This field will be in the invoice object only if the invoice was generated from a bill, see the
     * <a href="https://bitpay.com/api/#rest-api-resources-bills">Bills</a> resource for more information
     *
     * @return string|null
     */
    public function getBillId(): ?string
    {
        return $this->billId;
    }

    /**
     * Sets billId
     *
     * This field will be in the invoice object only if the invoice was generated from a bill, see the
     * <a href="https://bitpay.com/api/#rest-api-resources-bills">Bills</a> resource for more information
     *
     * @param string $billId the bill id
     */
    public function setBillId(string $billId): void
    {
        $this->billId = $billId;
    }

    /**
     * Gets refundInfo
     *
     * For a refunded invoice, this object will contain the details of executed refunds for the corresponding invoice.
     *
     * @return RefundInfo|null
     */
    public function getRefundInfo(): ?RefundInfo
    {
        return $this->refundInfo;
    }

    /**
     * Sets refundInfo
     *
     * For a refunded invoice, this object will contain the details of executed refunds for the corresponding invoice.
     *
     * @param RefundInfo object which contain the details of executed refunds for the corresponding invoice.
     */
    public function setRefundInfo(RefundInfo $refundInfo): void
    {
        $this->refundInfo = $refundInfo;
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
     * @return bool|null
     */
    public function getExtendedNotifications(): ?bool
    {
        return $this->extendedNotifications;
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
     * @param bool $extendedNotifications Allows merchants to get access to additional webhooks
     */
    public function setExtendedNotifications(bool $extendedNotifications): void
    {
        $this->extendedNotifications = $extendedNotifications;
    }

    /**
     * Gets transactionCurrency
     *
     * The cryptocurrency used to pay the invoice.
     * This field will only be available after a transaction is applied to the invoice.
     * Possible values are currently "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     *
     * @return string|null
     */
    public function getTransactionCurrency(): ?string
    {
        return $this->transactionCurrency;
    }

    /**
     * Sets transactionCurrency
     *
     * The cryptocurrency used to pay the invoice.
     * This field will only be available after a transaction is applied to the invoice.
     * Possible values are currently "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD",
     * "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     *
     * @param string $transactionCurrency The currency used for the invoice transaction.
     */
    public function setTransactionCurrency(string $transactionCurrency): void
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * Gets amountPaid
     *
     * The total amount paid to the invoice in terms of the invoice transactionCurrency indicated
     * in the smallest possible unit for the corresponding transactionCurrency (e.g satoshis for BTC and BCH)
     *
     * @return int|null
     */
    public function getAmountPaid(): ?int
    {
        return $this->amountPaid;
    }

    /**
     * Sets amountPaid
     *
     * The total amount paid to the invoice in terms of the invoice transactionCurrency indicated
     * in the smallest possible unit for the corresponding transactionCurrency (e.g satoshis for BTC and BCH)
     *
     * @param int $amountPaid The total amount paid to the invoice
     */
    public function setAmountPaid(int $amountPaid): void
    {
        $this->amountPaid = $amountPaid;
    }

    /**
     * Gets displayAmountPaid
     *
     * Initially set to "0" when creating the invoice.
     * It will be updated with the total amount paid to the invoice
     * indicated in the base unit for the corresponding transactionCurrency
     *
     * @return string|null
     */
    public function getDisplayAmountPaid(): ?string
    {
        return $this->displayAmountPaid;
    }

    /**
     * Sets displayAmountPaid
     *
     * Initially set to "0" when creating the invoice.
     * It will be updated with the total amount paid to the invoice
     * indicated in the base unit for the corresponding transactionCurrency
     *
     * @param string $displayAmountPaid display amount paid
     */
    public function setDisplayAmountPaid(string $displayAmountPaid): void
    {
        $this->displayAmountPaid = $displayAmountPaid;
    }

    /**
     * Gets exchangeRates
     *
     * Exchange rates keyed by source and target currencies.
     *
     * @return array|null
     */
    public function getExchangeRates(): ?array
    {
        return $this->exchangeRates;
    }

    /**
     * Sets exchangeRates
     *
     * Exchange rates keyed by source and target currencies.
     *
     * @param array|null $exchangeRates Exchange rates keyed by source and target currencies.
     */
    public function setExchangeRates(?array $exchangeRates): void
    {
        $this->exchangeRates = $exchangeRates;
    }

    /**
     * Gets isCancelled
     *
     * Indicates whether or not the invoice was cancelled.
     *
     * @return bool|null
     */
    public function getIsCancelled(): ?bool
    {
        return $this->isCancelled;
    }

    /**
     * Sets isCancelled
     *
     * Indicates whether or not the invoice was cancelled.
     *
     * @param boolean $isCancelled Indicates whether or not the invoice was cancelled.
     */
    public function setIsCancelled(bool $isCancelled): void
    {
        $this->isCancelled = $isCancelled;
    }

    /**
     * Returns the Invoice object as array
     *
     * @return array
     */
    public function toArray(): array
    {
        $elements = [
            'currency' => $this->getCurrency(),
            'guid' => $this->getGuid(),
            'token' => $this->getToken(),
            'price' => $this->getPrice(),
            'posData' => $this->getPosData(),
            'notificationURL' => $this->getNotificationURL(),
            'transactionSpeed' => $this->getTransactionSpeed(),
            'fullNotifications' => $this->getFullNotifications(),
            'notificationEmail' => $this->getNotificationEmail(),
            'redirectURL' => $this->getRedirectURL(),
            'orderId' => $this->getOrderId(),
            'itemDesc' => $this->getItemDesc(),
            'itemCode' => $this->getItemCode(),
            'physical' => $this->getPhysical(),
            'paymentCurrencies' => $this->getPaymentCurrencies(),
            'acceptanceWindow' => $this->getAcceptanceWindow(),
            'closeURL' => $this->getCloseURL(),
            'autoRedirect' => $this->getAutoRedirect(),
            'buyer' => $this->getBuyer() ? $this->getBuyer()->toArray() : null,
            'refundAddresses' => $this->getRefundAddresses(),
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'status' => $this->getStatus(),
            'lowFeeDetected' => $this->getLowFeeDetected(),
            'invoiceTime' => $this->getInvoiceTime(),
            'expirationTime' => $this->getExpirationTime(),
            'currentTime' => $this->getCurrentTime(),
            'transactions' => $this->getTransactions(),
            'exceptionStatus' => $this->getExceptionStatus(),
            'targetConfirmations' => $this->getTargetConfirmations(),
            'refundAddressRequestPending' => $this->getRefundAddressRequestPending(),
            'buyerProvidedEmail' => $this->getBuyerProvidedEmail(),
            'buyerProvidedInfo' => $this->getBuyerProvidedInfo() ? $this->getBuyerProvidedInfo()->toArray() : null,
            'universalCodes' => $this->getUniversalCodes() ? $this->getUniversalCodes()->toArray() : null,
            'supportedTransactionCurrencies' => $this->getSupportedTransactionCurrencies()
                ? $this->getSupportedTransactionCurrencies()->toArray() : null,
            'minerFees' => $this->getMinerFees() ? $this->getMinerFees()->toArray() : null,
            'shopper' => $this->getShopper() ? $this->getShopper()->toArray() : null,
            'billId' => $this->getBillId(),
            'refundInfo' => $this->getRefundInfo() ? $this->getRefundInfo()->toArray() : null,
            'extendedNotifications' => $this->getExtendedNotifications(),
            'transactionCurrency' => $this->getTransactionCurrency(),
            'amountPaid' => $this->getAmountPaid(),
            'exchangeRates' => $this->getExchangeRates(),
            'merchantName' => $this->getMerchantName(),
            'selectedTransactionCurrency' => $this->getSelectedTransactionCurrency(),
            'bitpayIdRequired' => $this->getBitpayIdRequired(),
            'forcedBuyerSelectedWallet' => $this->getForcedBuyerSelectedWallet(),
            'isCancelled' => $this->getIsCancelled(),
            'buyerEmail' => $this->getBuyerEmail(),
            'buyerSms' => $this->getBuyerSms(),
            'itemizedDetails' => $this->getItemizedDetails(),
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
