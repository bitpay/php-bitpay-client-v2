<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 *
 * @package Bitpay
 */
class Payout
{
    protected $token = '';

    protected $amount       = 0.0;
    protected $currency     = '';
    protected $effectiveDate;
    protected $ledgerCurrency = '';

    protected $reference         = '';
    protected $notificationUrl   = '';
    protected $notificationEmail = '';
    protected $redirectUrl = '';
    protected $account = '';
    protected $email = '';
    protected $recipientId = '';
    protected $shopperId = '';
    protected $label = '';
    protected $supportPhone = '';
    protected $message = '';
    protected $percentFee = 0.0;
    protected $fee = 0.0;
    protected $depositTotal = 0.0;
    protected $rate = 0.0;
    protected $btc = 0.0;
    protected $dateExecuted;

    protected $id;
    protected $status;
    protected $requestDate;
    protected $exchangeRates;
    protected $transactions;

    /**
     * Constructor, create a request Payout object.
     *
     * @param $amount            float The amount for which the payout will be created.
     * @param $currency          string The three digit currency string for the PayoutBatch to use.
     * @param $ledgerCurrency    string Ledger currency code set for the payout request (ISO 4217 3-character
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
        $this->transactions = new PayoutTransaction();
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
    public function getToken()
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
    public function setToken(string $token)
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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets amount of cryptocurrency sent to the requested address.
     *
     * @param float $amount
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Change amount value based on precision rounding.
     *
     * @param int $precision
     */
    public function formatAmount(int $precision)
    {
        $this->amount = round($this->amount, $precision);
    }

    /**
     * Gets currency code set for the batch amount (ISO 4217 3-character currency code).
     *
     * @return string|null
     */
    public function getCurrency()
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
     * @see <a href="https://bitpay.com/api/#rest-api-resources-payouts">Supported ledger currency codes</a>
     * @return string|null
     *
     */
    public function getEffectiveDate()
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
    public function setEffectiveDate(string $effectiveDate)
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
     * @see <a href="https://bitpay.com/api/#rest-api-resources-payouts">Supported ledger currency codes</a>
     *
     * @return string|null
     */
    public function getLedgerCurrency()
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
    public function setLedgerCurrency(string $ledgerCurrency)
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
    public function getReference()
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
    public function setReference(string $reference)
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
    public function getNotificationURL()
    {
        return $this->notificationUrl;
    }

    /**
     * Sets notification url.
     *
     * URL to which BitPay sends webhook notifications. HTTPS is mandatory.
     *
     * @param string $notificationUrl
     */
    public function setNotificationURL(string $notificationUrl)
    {
        $this->notificationUrl = $notificationUrl;
    }

    /**
     * Gets notification email.
     *
     * Merchant email address for notification of payout status change.
     *
     * @return string
     */
    public function getNotificationEmail()
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
    public function setNotificationEmail(string $notificationEmail)
    {
        $this->notificationEmail = $notificationEmail;
    }

    /**
     * Gets redirect url.
     *
     * The shopper will be redirected to this URL when clicking on the Return button after a successful payment or
     * when clicking on the Close button if a separate closeURL is not specified.
     * Be sure to include "http://" or "https://" in the url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Sets redirect url.
     *
     * The shopper will be redirected to this URL when clicking on the Return button after a successful payment or
     * when clicking on the Close button if a separate closeURL is not specified.
     * Be sure to include "http://" or "https://" in the url.
     *
     * @param string $redirectUrl
     */
    public function setRedirectUrl(string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Gets account.
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Sets account.
     *
     * @param string $account
     */
    public function setAccount(string $account)
    {
        $this->account = $account;
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
    public function getEmail()
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
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Gets BitPay recipient id. Assigned by BitPay for a given recipient email during the onboarding process.
     *
     * @return string
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * Sets BitPay recipient id. Assigned by BitPay for a given recipient email during the onboarding process.
     *
     * @param string $recipientId
     */
    public function setRecipientId(string $recipientId)
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
    public function getShopperId()
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
    public function setShopperId(string $shopperId)
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
    public function getLabel()
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
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * Gets support phone.
     *
     * @return string
     */
    public function getSupportPhone()
    {
        return $this->supportPhone;
    }

    /**
     * Sets support phone.
     *
     * @param string $supportPhone
     */
    public function setSupportPhone(string $supportPhone)
    {
        $this->supportPhone = $supportPhone;
    }

    /**
     * Gets message.
     *
     * In case of error, this field will contain a description message. Set to `null` if the request is successful.
     *
     * @return string
     */
    public function getMessage()
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
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * Gets percent fee.
     *
     * @return float
     */
    public function getPercentFee()
    {
        return $this->percentFee;
    }

    /**
     * Sets percent fee.
     *
     * @param float $percentFee
     */
    public function setPercentFee(float $percentFee)
    {
        $this->percentFee = $percentFee;
    }

    /**
     * Gets fee.
     *
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Sets fee.
     *
     * @param float $fee
     */
    public function setFee(float $fee)
    {
        $this->fee = $fee;
    }

    /**
     * Gets deposit total.
     *
     * @return float
     */
    public function getDepositTotal()
    {
        return $this->depositTotal;
    }

    /**
     * Sets deposit total.
     *
     * @param float $depositTotal
     */
    public function setDepositTotal(float $depositTotal)
    {
        $this->depositTotal = $depositTotal;
    }

    /**
     * Gets rate.
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Sets rate.
     *
     * @param float $rate
     */
    public function setRate(float $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Gets btc.
     *
     * @return float
     */
    public function getBtc()
    {
        return $this->btc;
    }

    /**
     * Sets btc.
     *
     * @param float $btc
     */
    public function setBtc(float $btc)
    {
        $this->btc = $btc;
    }

    /**
     * Gets date and time (UTC) when BitPay executed the payout. ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @return string|null
     */
    public function getDateExecuted()
    {
        return $this->dateExecuted;
    }

    /**
     * Sets date and time (UTC) when BitPay executed the payout. ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @param string $dateExecuted
     */
    public function setDateExecuted(string $dateExecuted)
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Payout request id.
     *
     * @param string $id
     */
    public function setId(string $id)
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
    public function getStatus()
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
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * Gets date and time (UTC) when BitPay received the batch. ISO-8601 format `yyyy-mm-ddThh:mm:ssZ`.
     *
     * @return string|null
     */
    public function getRequestDate()
    {
        return $this->requestDate;
    }

    /**
     * Sets date and time (UTC) when BitPay received the batch. ISO-8601 format `yyyy-mm-ddThh:mm:ssZ`.
     *
     * @param string $requestDate
     */
    public function setRequestDate(string $requestDate)
    {
        $this->requestDate = $requestDate;
    }

    /**
     * Gets exchange rates keyed by source and target currencies.
     *
     * @return array|null
     */
    public function getExchangeRates()
    {
        return $this->exchangeRates;
    }

    /**
     * Sets exchange rates keyed by source and target currencies.
     *
     * @param array $exchangeRates
     */
    public function setExchangeRates(array $exchangeRates)
    {
        $this->exchangeRates = $exchangeRates;
    }

    /**
     * Gets transactions. Contains the cryptocurrency transaction details for the executed payout request.
     *
     * @return array
     */
    public function getTransactions()
    {
        $transactions = [];

        foreach ($this->transactions as $transaction) {
            if ($transaction instanceof PayoutTransaction) {
                array_push($transactions, $transaction->toArray());
            } else {
                array_push($transactions, $transaction);
            }
        }

        return $transactions;
    }

    /**
     * Sets transactions. Contains the cryptocurrency transaction details for the executed payout request.
     *
     * @param array $transactions
     */
    public function setTransactions(array $transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Return Payout values as array.
     *
     * @return array
     */
    public function toArray()
    {
        $elements = [
            'token'             => $this->getToken(),
            'amount'            => $this->getAmount(),
            'currency'          => $this->getCurrency(),
            'effectiveDate'     => $this->getEffectiveDate(),
            'ledgerCurrency'    => $this->getLedgerCurrency(),
            'reference'         => $this->getReference(),
            'notificationURL'   => $this->getNotificationURL(),
            'notificationEmail' => $this->getNotificationEmail(),
            'redirectUrl'       => $this->getRedirectUrl(),
            'account'           => $this->getAccount(),
            'email'             => $this->getEmail(),
            'recipientId'       => $this->getRecipientId(),
            'shopperId'         => $this->getShopperId(),
            'label'             => $this->getLabel(),
            'supportPhone'      => $this->getSupportPhone(),
            'message'           => $this->getMessage(),
            'percentFee'        => $this->getPercentFee(),
            'fee'               => $this->getFee(),
            'depositTotal'      => $this->getDepositTotal(),
            'rate'              => $this->getRate(),
            'btc'               => $this->getBtc(),
            'dateExecuted'      => $this->getDateExecuted(),
            'id'                => $this->getId(),
            'status'            => $this->getStatus(),
            'requestDate'       => $this->getRequestDate(),
            'exchangeRates'     => $this->getExchangeRates(),
            'transactions'      => $this->getTransactions()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
