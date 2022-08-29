<?php

namespace BitPaySDK\Model\Payout;

use BitPaySDK;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 *
 * @package Bitpay
 */
class PayoutBatch
{
    protected $_guid = '';
    protected $_token = '';

    protected $_amount       = 0.0;
    protected $_currency     = '';
    protected $_effectiveDate;
    protected $_instructions = [];
    protected $_ledgerCurrency = '';

    protected $_reference         = '';
    protected $_notificationUrl   = '';
    protected $_notificationEmail = '';
    protected $_email = '';
    protected $_recipientId = '';
    protected $_shopperId = '';
    protected $_label = '';
    protected $_message = '';
    protected $_redirectUrl = '';
    protected $_pricingMethod = 'vwap_24hr';

    protected $_id;
    protected $_account;
    protected $_supportPhone;
    protected $_status;
    protected $_percentFee;
    protected $_fee;
    protected $_depositTotal;
    protected $_rate;
    protected $_btc;
    protected $_requestDate;
    protected $_dateExecuted;
    protected $_exchangeRates;

    /**
     * Constructor, create an instruction-full request PayoutBatch object.
     *
     * @param $currency          string The three digit currency string for the PayoutBatch to use.
     * @param $ledgerCurrency    string Ledger currency code set for the payout request (ISO 4217 3-character
     *                           currency code), it indicates on which ledger the payout request will be
     *                           recorded. If not provided in the request, this parameter will be set by
     *                           default to the active ledger currency on your account, e.g. your settlement
     *                           currency.
     * @param array|null $instructions
     */
    public function __construct(string $currency = null, array $instructions = null, string $ledgerCurrency = null)
    {
        $this->_currency = $currency;
        $this->_instructions = $instructions;
        $this->_ledgerCurrency = $ledgerCurrency;
        $this->_computeAndSetAmount();
    }

    // Private methods
    //

    private function _computeAndSetAmount()
    {
        $amount = 0.0;
        if ($this->_instructions) {
            foreach ($this->_instructions as $instruction) {
                if ($instruction instanceof PayoutInstruction) {
                    $amount += $instruction->getAmount();
                } else {
                    $amount += $instruction->amount;
                }
            }
        }
        $this->_amount = $amount;
    }

    // API fields
    //

    public function getGuid()
    {
        return $this->_guid;
    }

    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

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

    public function getInstructions()
    {
        $instructions = [];

        foreach ($this->_instructions as $instruction) {
            if ($instruction instanceof PayoutInstruction) {
                array_push($instructions, $instruction->toArray());
            } else {
                array_push($instructions, $instruction);
            }
        }

        return $instructions;
    }

    public function setInstructions(array $instructions)
    {
        $this->_instructions = $instructions;
        $this->_computeAndSetAmount();
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

    public function getMessage()
    {
        return $this->_message;
    }

    public function setMessage(string $message)
    {
        $this->_message = $message;
    }

    public function getRedirectUrl()
    {
        return $this->_redirectUrl;
    }

    public function setRedirectUrl(string $redirectUrl)
    {
        $this->_redurectUrl = $redirectUrl;
    }

    public function getPricingMethod()
    {
        return $this->_pricingMethod;
    }

    public function setPricingMethod(string $pricingMethod)
    {
        $this->_pricingMethod = $pricingMethod;
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

    public function getAccount()
    {
        return $this->_account;
    }

    public function setAccount(string $account)
    {
        $this->_account = $account;
    }

    public function getSupportPhone()
    {
        return $this->_supportPhone;
    }

    public function setSupportPhone(string $supportPhone)
    {
        $this->_supportPhone = $supportPhone;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
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

    public function getBtc()
    {
        return $this->_btc;
    }

    public function setBtc(?float $btc)
    {
        $this->_btc = $btc;
    }

    public function getRate()
    {
        return $this->_rate;
    }

    public function setRate(float $rate)
    {
        $this->_rate = $rate;
    }

    public function getRequestDate()
    {
        return $this->_requestDate;
    }

    public function setRequestDate(string $requestDate)
    {
        $this->_requestDate = $requestDate;
    }

    public function getDateExecuted()
    {
        return $this->_dateExecuted;
    }

    public function setDateExecuted(string $dateExecuted)
    {
        $this->_dateExecuted = $dateExecuted;
    }

    public function getExchangeRates()
    {
        return $this->_exchangeRates;
    }

    public function setExchangeRates($exchangeRates)
    {
        $this->_exchangeRates = $exchangeRates;
    }

    public function toArray()
    {
        $elements = [
            'token'             => $this->getToken(),
            'amount'            => $this->getAmount(),
            'currency'          => $this->getCurrency(),
            'effectiveDate'     => $this->getEffectiveDate(),
            'instructions'      => $this->getInstructions(),
            'ledgerCurrency'    => $this->getLedgerCurrency(),
            'reference'         => $this->getReference(),
            'notificationURL'   => $this->getNotificationURL(),
            'notificationEmail' => $this->getNotificationEmail(),
            'email'             => $this->getEmail(),
            'recipientId'       => $this->getRecipientId(),
            'shopperId'         => $this->getShopperId(),
            'label'             => $this->getLabel(),
            'message'           => $this->getMessage(),
            'id'                => $this->getId(),
            'account'           => $this->getAccount(),
            'supportPhone'      => $this->getSupportPhone(),
            'status'            => $this->getStatus(),
            'percentFee'        => $this->getPercentFee(),
            'fee'               => $this->getFee(),
            'depositTotal'      => $this->getDepositTotal(),
            'rate'              => $this->getRate(),
            'btc'               => $this->getBtc(),
            'requestDate'       => $this->getRequestDate(),
            'dateExecuted'      => $this->getDateExecuted(),
            'exchangeRates'     => $this->getExchangeRates(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
