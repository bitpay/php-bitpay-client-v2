<?php

namespace BitPaySDK\Model\Payout;

use BitPaySDK;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 *
 * @package Bitpay
 */
class Payout
{
    protected $_token = '';

    protected $_amount       = 0.0;
    protected $_currency     = '';
    protected $_effectiveDate;
    protected $_ledgerCurrency = '';

    protected $_reference         = '';
    protected $_notificationUrl   = '';
    protected $_notificationEmail = '';
    protected $_redirectUrl = '';
    protected $_account = '';
    protected $_email = '';
    protected $_recipientId = '';
    protected $_shopperId = '';
    protected $_label = '';
    protected $_supportPhone = '';
    protected $_message = '';
    protected $_percentFee = 0.0;
    protected $_fee = 0.0;
    protected $_depositTotal = 0.0;
    protected $_rate = 0.0;
    protected $_btc = 0.0;
    protected $_dateExecuted;

    protected $_id;
    protected $_status;
    protected $_requestDate;
    protected $_exchangeRates;
    protected $_transactions;

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
        $this->_amount = $amount;
        $this->_currency = $currency;
        $this->_ledgerCurrency = $ledgerCurrency;
        $this->_transactions = new PayoutTransaction();
    }

    // API fields
    //

    public function getToken()
    {
        return $this->_token;
    }

    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    // Required fields
    //

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function formatAmount(int $precision)
    {
        $this->_amount = round($this->_amount, $precision);
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency(string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException('currency code must be a type of Model.Currency');
        }

        $this->_currency = $currency;
    }

    public function getEffectiveDate()
    {
        return $this->_effectiveDate;
    }

    public function setEffectiveDate(string $effectiveDate)
    {
        $this->_effectiveDate = $effectiveDate;
    }

    public function getLedgerCurrency()
    {
        return $this->_ledgerCurrency;
    }

    public function setLedgerCurrency(string $ledgerCurrency)
    {
        if (!Currency::isValid($ledgerCurrency)) {
            throw new BitPayException('currency code must be a type of Model.Currency');
        }

        $this->_ledgerCurrency = $ledgerCurrency;
    }

    // Optional fields
    //

    public function getReference()
    {
        return $this->_reference;
    }

    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    public function getNotificationURL()
    {
        return $this->_notificationUrl;
    }

    public function setNotificationURL(string $notificationUrl)
    {
        $this->_notificationUrl = $notificationUrl;
    }

    public function getNotificationEmail()
    {
        return $this->_notificationEmail;
    }

    public function setNotificationEmail(string $notificationEmail)
    {
        $this->_notificationEmail = $notificationEmail;
    }

    public function getRedirectUrl()
    {
        return $this->_redirectUrl;
    }

    public function setRedirectUrl(string $redirectUrl)
    {
        $this->_redirectUrl = $redirectUrl;
    }

    public function getAccount()
    {
        return $this->_account;
    }

    public function setAccount(string $account)
    {
        $this->_account = $account;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    public function getRecipientId()
    {
        return $this->_recipientId;
    }

    public function setRecipientId(string $recipientId)
    {
        $this->_recipientId = $recipientId;
    }

    public function getShopperId()
    {
        return $this->_shopperId;
    }

    public function setShopperId(string $shopperId)
    {
        $this->_shopperId = $shopperId;
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    public function getSupportPhone()
    {
        return $this->_supportPhone;
    }

    public function setSupportPhone(string $supportPhone)
    {
        $this->_supportPhone = $supportPhone;
    }

    public function getMessage()
    {
        return $this->_message;
    }

    public function setMessage(string $message)
    {
        $this->_message = $message;
    }

    public function getPercentFee()
    {
        return $this->_percentFee;
    }

    public function setPercentFee(float $percentFee)
    {
        $this->_percentFee = $percentFee;
    }

    public function getFee()
    {
        return $this->_fee;
    }

    public function setFee(float $fee)
    {
        $this->_fee = $fee;
    }

    public function getDepositTotal()
    {
        return $this->_depositTotal;
    }

    public function setDepositTotal(float $depositTotal)
    {
        $this->_depositTotal = $depositTotal;
    }

    public function getRate()
    {
        return $this->_rate;
    }

    public function setRate(float $rate)
    {
        $this->_rate = $rate;
    }

    public function getBtc()
    {
        return $this->_btc;
    }

    public function setBtc(float $btc)
    {
        $this->_btc = $btc;
    }

    public function getDateExecuted()
    {
        return $this->_dateExecuted;
    }

    public function setDateExecuted(string $dateExecuted)
    {
        $this->_dateExecuted = $dateExecuted;
    }

    // Response fields
    //

    public function getId()
    {
        return $this->_id;
    }

    public function setId(string $id)
    {
        $this->_id = $id;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    public function getRequestDate()
    {
        return $this->_requestDate;
    }

    public function setRequestDate(string $requestDate)
    {
        $this->_requestDate = $requestDate;
    }

    public function getExchangeRates()
    {
        return $this->_exchangeRates;
    }

    public function setExchangeRates($exchangeRates)
    {
        $this->_exchangeRates = $exchangeRates;
    }

    public function getTransactions()
    {
        return $this->_transactions;
    }

    public function setTransactions(array $transactions)
    {
        $this->_transactions = $transactions;
    }

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
            'transactions'      => $this->getTransactions()->toArray()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
