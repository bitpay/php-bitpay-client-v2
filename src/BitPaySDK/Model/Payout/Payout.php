<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutException;
use BitPaySDK\Model\Currency;

/**
 * @package Bitpay
 * @see <a href="https://bitpay.readme.io/reference/payouts">REST API Payouts</a>
 */
class Payout
{
    protected string $token = '';
    protected ?float $amount = null;
    protected ?string $currency = null;
    protected ?string $effectiveDate = null;
    protected ?string $ledgerCurrency = null;
    protected string $reference = '';
    protected string $notificationURL = '';
    protected string $notificationEmail = '';
    protected string $accountId = '';
    protected string $email = '';
    protected string $recipientId = '';
    protected string $shopperId = '';
    protected string $label = '';
    protected string $message = '';
    protected bool $ignoreEmails = false;
    protected ?string $groupId = null;
    protected ?int $code = null;
    protected ?string $dateExecuted = null;
    protected ?string $id = null;
    protected ?string $status = null;
    protected ?string $requestDate = null;
    protected ?array $exchangeRates = null;
    /**
     * @var PayoutTransaction[]
     */
    protected array $transactions = [];

    /**
     * Constructor, create a request Payout object.
     *
     * @param float|null $amount float The amount for which the payout will be created.
     * @param string|null $currency string The three digit currency string for the PayoutBatch to use.
     * @param string|null $ledgerCurrency string Ledger currency code set for the payout request (ISO 4217 3-character
     *                           currency code), it indicates on which ledger the payout request will be
     *                           recorded. If not provided in the request, this parameter will be set by
     *                           default to the active ledger currency on your account, e.g. your settlement
     *                           currency.
     */
    public function __construct(float $amount = null, string $currency = null, string $ledgerCurrency = null)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->ledgerCurrency = $ledgerCurrency;
    }

    // API fields
    //

    /**
     * Gets resource token.
     *
     * <p>
     *  This token is actually derived from the API token -
     *  used to submit the payout and is tied to the specific payout resource id created.
     * </p>
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Sets resource token.
     *
     * This token is actually derived from the API token -
     * used to submit the payout and is tied to the specific payout resource id created.
     *
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    // Required fields
    //

    /**
     * Gets amount of cryptocurrency sent to the requested address.
     *
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Sets amount of cryptocurrency sent to the requested address.
     *
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Change amount value based on precision rounding.
     *
     * @param int $precision
     */
    public function formatAmount(int $precision): void
    {
        $this->amount = round($this->amount, $precision);
    }

    /**
     * Gets currency code set for the batch amount (ISO 4217 3-character currency code).
     *
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets currency code set for the batch amount (ISO 4217 3-character currency code).
     *
     * @param string $currency
     * @throws BitPayException
     */
    public function setCurrency(string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException('currency code must be a type of Model.Currency');
        }

        $this->currency = $currency;
    }

    /**
     * Gets Ledger currency code (ISO 4217 3-character currency code)
     *
     * it indicates on which ledger the payout request will be recorded. If not provided in the request,
     * this parameter will be set by default to the active ledger currency on your account,
     * e.g. your settlement currency.
     *
     * @return string|null
     *
     * @see <a href="https://bitpay.com/api/#rest-api-resources-payouts">Supported ledger currency codes</a>
     */
    public function getEffectiveDate(): ?string
    {
        return $this->effectiveDate;
    }

    /**
     * Sets effective date and time (UTC) for the payout.
     *
     * ISO-8601 format yyyy-mm-ddThh:mm:ssZ. If not provided, defaults to date and time of creation.
     *
     * @param string $effectiveDate
     */
    public function setEffectiveDate(string $effectiveDate): void
    {
        $this->effectiveDate = $effectiveDate;
    }

    /**
     * Gets Ledger currency code (ISO 4217 3-character currency code
     *
     * it indicates on which ledger the payout request will be recorded. If not provided in the request,
     * this parameter will be set by default to the active ledger currency on your account,
     * e.g. your settlement currency.
     *
     * @return string|null
     * @see <a href="https://bitpay.com/api/#rest-api-resources-payouts">Supported ledger currency codes</a>
     *
     */
    public function getLedgerCurrency(): ?string
    {
        return $this->ledgerCurrency;
    }

    /**
     * Sets Ledger currency code (ISO 4217 3-character currency code)
     *
     * it indicates on which ledger the payout request will be recorded. If not provided in the request,
     * this parameter will be set by default to the active ledger currency on your account,
     * e.g. your settlement currency.
     *
     * @param string $ledgerCurrency
     * @throws BitPayException
     */
    public function setLedgerCurrency(string $ledgerCurrency): void
    {
        if (!Currency::isValid($ledgerCurrency)) {
            throw new BitPayException('currency code must be a type of Model.Currency');
        }

        $this->ledgerCurrency = $ledgerCurrency;
    }

    // Optional fields
    //

    /**
     * Gets reference.
     *
     * Present only if specified by the merchant in the request.
     * Merchants can pass their own unique identifier in this field for reconciliation purpose.
     * Maximum string length is 100 characters.
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Sets reference.
     *
     * Present only if specified by the merchant in the request.
     * Merchants can pass their own unique identifier in this field for reconciliation purpose.
     * Maximum string length is 100 characters.
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Gets notification url.
     *
     * URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     *
     * @return string
     */
    public function getNotificationURL(): string
    {
        return $this->notificationURL;
    }

    /**
     * Sets notification url.
     *
     * URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     *
     * @param string $notificationURL
     */
    public function setNotificationURL(string $notificationURL): void
    {
        $this->notificationURL = $notificationURL;
    }

    /**
     * Gets notification email.
     *
     * Merchant email address for notification of payout status change.
     *
     * @return string
     */
    public function getNotificationEmail(): string
    {
        return $this->notificationEmail;
    }

    /**
     * Sets notification email.
     *
     * Merchant email address for notification of payout status change.
     *
     * @param string $notificationEmail
     */
    public function setNotificationEmail(string $notificationEmail): void
    {
        $this->notificationEmail = $notificationEmail;
    }

    /**
     * Gets BitPay account id that is associated to the payout,
     * assigned by BitPay for a given account during the onboarding process.
     *
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * Sets BitPay account id that is associated to the payout,
     * assigned by BitPay for a given account during the onboarding process.
     *
     * @param string $accountId
     */
    public function setAccountId(string $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * Gets email.
     *
     * Email address of an active recipient.
     * Note: In the future, BitPay may allow recipients to update the email address tied to their personal account.
     * BitPay encourages the use of `recipientId` or `shopperId` when programatically creating payouts requests.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets email.
     *
     * Email address of an active recipient.
     * Note: In the future, BitPay may allow recipients to update the email address tied to their personal account.
     * BitPay encourages the use of `recipientId` or `shopperId` when programatically creating payouts requests.
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Gets BitPay recipient id. Assigned by BitPay for a given recipient email during the onboarding process.
     *
     * @return string
     */
    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    /**
     * Sets BitPay recipient id. Assigned by BitPay for a given recipient email during the onboarding process.
     *
     * @param string $recipientId
     */
    public function setRecipientId(string $recipientId): void
    {
        $this->recipientId = $recipientId;
    }

    /**
     * Gets shopper id.
     *
     * This is the unique id assigned by BitPay if the shopper used his personal BitPay account to authenticate and
     * pay an invoice. For customers signing up for a brand new BitPay personal account,
     * this id will only be created as part of the payout onboarding.
     * The same field would also be available on paid invoices for customers who signed in with their
     * BitPay personal accounts before completing the payment.
     * This can allow merchants to monitor the activity of a customer (deposits and payouts).
     *
     * @return string
     */
    public function getShopperId(): string
    {
        return $this->shopperId;
    }

    /**
     * Sets shopper id.
     *
     * This is the unique id assigned by BitPay if the shopper used his personal BitPay account to authenticate and
     * pay an invoice. For customers signing up for a brand new BitPay personal account,
     * this id will only be created as part of the payout onboarding.
     * The same field would also be available on paid invoices for customers who signed in with their
     * BitPay personal accounts before completing the payment.
     * This can allow merchants to monitor the activity of a customer (deposits and payouts).
     *
     * @param string $shopperId
     */
    public function setShopperId(string $shopperId): void
    {
        $this->shopperId = $shopperId;
    }

    /**
     * Gets label.
     *
     * For merchant use, pass through - can be the customer name or unique merchant reference assigned by
     * the merchant to the recipient.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Sets label.
     *
     * For merchant use, pass through - can be the customer name or unique merchant reference assigned by
     * the merchant to the recipient.
     *
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * Gets message.
     *
     * In case of error, this field will contain a description message. Set to `null` if the request is successful.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets message.
     *
     * In case of error, this field will contain a description message. Set to `null` if the request is successful.
     *
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Gets group id.
     *
     * @return string|null
     */
    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    /**
     * Sets group id.
     *
     * @param string|null $groupId
     */
    public function setGroupId(?string $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * This field will be returned in case of error and contain an error code.
     *
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * Sets error code.
     *
     * @param int|null $code
     */
    public function setCode(?int $code): void
    {
        $this->code = $code;
    }

    /**
     * Gets date and time (UTC) when BitPay executed the payout. ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @return string|null
     */
    public function getDateExecuted(): ?string
    {
        return $this->dateExecuted;
    }

    /**
     * Sets date and time (UTC) when BitPay executed the payout. ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @param string $dateExecuted
     */
    public function setDateExecuted(string $dateExecuted): void
    {
        $this->dateExecuted = $dateExecuted;
    }

    // Response fields
    //

    /**
     * Gets Payout request id.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Payout request id.
     *
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets payout request status.
     *
     * The possible values are:
     * <ul>
     *     <li>new - initial status when the payout batch is created</li>
     *     <li>funded - if there are enough funds available on the merchant account,
     *      the payout batches are set to funded. This happens at the daily cutoff time for payout processing,
     *      e.g. 2pm and 9pm UTC
     *     </li>
     *     <li>processing - the payout batches switch to this status whenever the corresponding cryptocurrency
     *      transactions are broadcasted by BitPay
     *     </li>
     *     <li>complete - the payout batches are marked as complete when the cryptocurrency transaction has reached
     *      the typical target confirmation for the corresponding asset. For instance,
     *      6 confirmations for a bitcoin transaction.
     *     </li>
     *     <li>cancelled - when the merchant cancels a payout batch (only possible for requests in the status new</li>
     * </ul>
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets payout request status.
     *
     * The possible values are:
     * <ul>
     *     <li>new - initial status when the payout batch is created</li>
     *     <li>funded - if there are enough funds available on the merchant account,
     *      the payout batches are set to funded. This happens at the daily cutoff time for payout processing,
     *      e.g. 2pm and 9pm UTC
     *     </li>
     *     <li>processing - the payout batches switch to this status whenever the corresponding cryptocurrency
     *      transactions are broadcasted by BitPay
     *     </li>
     *     <li>complete - the payout batches are marked as complete when the cryptocurrency transaction has reached
     *      the typical target confirmation for the corresponding asset. For instance,
     *      6 confirmations for a bitcoin transaction.
     *     </li>
     *     <li>cancelled - when the merchant cancels a payout batch (only possible for requests in the status new</li>
     * </ul>
     *
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Gets date and time (UTC) when BitPay received the batch. ISO-8601 format `yyyy-mm-ddThh:mm:ssZ`.
     *
     * @return string|null
     */
    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    /**
     * Sets date and time (UTC) when BitPay received the batch. ISO-8601 format `yyyy-mm-ddThh:mm:ssZ`.
     *
     * @param string $requestDate
     */
    public function setRequestDate(string $requestDate): void
    {
        $this->requestDate = $requestDate;
    }

    /**
     * Gets exchange rates keyed by source and target currencies.
     *
     * @return array|null
     */
    public function getExchangeRates(): ?array
    {
        return $this->exchangeRates;
    }

    /**
     * Sets exchange rates keyed by source and target currencies.
     *
     * @param array $exchangeRates
     */
    public function setExchangeRates(array $exchangeRates): void
    {
        $this->exchangeRates = $exchangeRates;
    }

    /**
     * Gets transactions. Contains the cryptocurrency transaction details for the executed payout request.
     *
     * @return PayoutTransaction[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * Sets transactions. Contains the cryptocurrency transaction details for the executed payout request.
     *
     * @param PayoutTransaction[] $transactions
     * @throws PayoutException
     */
    public function setTransactions(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            if (!$transaction instanceof PayoutTransaction) {
                throw new PayoutException(
                    'Wrong type of transactions array. They should contains only PayoutTransaction objects'
                );
            }
        }

        $this->transactions = $transactions;
    }

    /**
     * Gets boolean to prevent email updates on a specific payout.
     * Defaults to false if not provided - you will receive emails unless specified to true.
     *
     * @return bool
     */
    public function isIgnoreEmails(): bool
    {
        return $this->ignoreEmails;
    }

    /**
     * Sets boolean to prevent email updates on a specific payout.
     * Defaults to false if not provided - you will receive emails unless specified to true.
     *
     * @param bool $ignoreEmails
     */
    public function setIgnoreEmails(bool $ignoreEmails): void
    {
        $this->ignoreEmails = $ignoreEmails;
    }

    /**
     * Return Payout values as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        $fields = get_object_vars($this);

        foreach ($fields as $name => $value) {
            if (!empty($value)) {
                $result[$name] = $value;
            }
        }

        return $result;
    }
}
