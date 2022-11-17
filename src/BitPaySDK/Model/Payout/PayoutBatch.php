<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 * Class PayoutBatch
 *
 * @see <a href="https://bitpay.com/api/#rest-api-resources-payouts">REST API Payouts</a>
 * @package BitPaySDK\Model\Payout
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

    /**
     * Compute and set amount based on PayoutInstruction.
     */
    private function _computeAndSetAmount()
    {
        $amount = 0.0;
        if ($this->_instructions) {
            foreach ($this->_instructions as $instruction) {
                if ($instruction instanceof PayoutInstruction) {
                    $amount += $instruction->getAmount();
                } else {
                    $amount += $instruction['amount'];
                }
            }
        }
        $this->_amount = $amount;
    }

    // API fields
    //

    /**
     *  Gets guid.
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->_guid;
    }

    /**
     * Sets guid.
     *
     * @param string $guid
     */
    public function setGuid(string $guid)
    {
        $this->_guid = $guid;
    }

    /**
     * Gets token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Sets token.
     *
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->_token = $token;
    }

    // Required fields
    //

    /**
     * Gets amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets amount.
     *
     * @param float $amount
     */
    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Gets amount based on precision.
     *
     * @param int $precision
     */
    public function formatAmount(int $precision)
    {
        $this->_amount = round($this->_amount, $precision);
    }

    /**
     * Gets currency.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets currency.
     *
     * @param string $currency
     * @throws BitPayException
     */
    public function setCurrency(string $currency)
    {
        if (!Currency::isValid($currency)) {
            throw new BitPayException('currency code must be a type of Model.Currency');
        }

        $this->_currency = $currency;
    }

    /**
     * Gets effective date.
     *
     * @return string|null
     */
    public function getEffectiveDate()
    {
        return $this->_effectiveDate;
    }

    /**
     * Sets effective date.
     *
     * @param string $effectiveDate
     */
    public function setEffectiveDate(string $effectiveDate)
    {
        $this->_effectiveDate = $effectiveDate;
    }

    /**
     * Gets instructions.
     *
     * @return array
     */
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

    /**
     * Sets instructions.
     *
     * @param array $instructions
     */
    public function setInstructions(array $instructions)
    {
        $this->_instructions = $instructions;
        $this->_computeAndSetAmount();
    }

    /**
     * Gets ledger currency.
     *
     * @return string|null
     */
    public function getLedgerCurrency()
    {
        return $this->_ledgerCurrency;
    }

    /**
     * Sets ledger currency.
     *
     * @param string $ledgerCurrency
     * @throws BitPayException
     */
    public function setLedgerCurrency(string $ledgerCurrency)
    {
        if (!Currency::isValid($ledgerCurrency)) {
            throw new BitPayException('currency code must be a type of Model.Currency');
        }

        $this->_ledgerCurrency = $ledgerCurrency;
    }

    // Optional fields
    //

    /**
     * Gets reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->_reference;
    }

    /**
     * Sets reference.
     *
     * @param string $reference
     */
    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    /**
     * Gets notification url.
     *
     * @return string
     */
    public function getNotificationURL()
    {
        return $this->_notificationUrl;
    }

    /**
     * Sets notification url.
     *
     * @param string $notificationUrl
     */
    public function setNotificationURL(string $notificationUrl)
    {
        $this->_notificationUrl = $notificationUrl;
    }

    /**
     * Gets notification email.
     *
     * @return string
     */
    public function getNotificationEmail()
    {
        return $this->_notificationEmail;
    }

    /**
     * Sets notification email.
     *
     * @param string $notificationEmail
     */
    public function setNotificationEmail(string $notificationEmail)
    {
        $this->_notificationEmail = $notificationEmail;
    }

    /**
     * Gets email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets email.
     *
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    /**
     * Gets Recipient ID.
     *
     * @return string
     */
    public function getRecipientId()
    {
        return $this->_recipientId;
    }

    /**
     * Sets Recipient ID.
     *
     * @param string $recipientId
     */
    public function setRecipientId(string $recipientId)
    {
        $this->_recipientId = $recipientId;
    }

    /**
     * Gets Shopper ID.
     *
     * @return string
     */
    public function getShopperId()
    {
        return $this->_shopperId;
    }

    /**
     * Sets Shopper ID.
     *
     * @param string $shopperId
     */
    public function setShopperId(string $shopperId)
    {
        $this->_shopperId = $shopperId;
    }

    /**
     * Gets label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Sets label.
     *
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    /**
     * Gets message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Sets message.
     *
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->_message = $message;
    }

    /**
     * Gets redirect url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->_redirectUrl;
    }

    /**
     * Sets redirect url.
     *
     * @param string $redirectUrl
     */
    public function setRedirectUrl(string $redirectUrl)
    {
        $this->_redurectUrl = $redirectUrl;
    }

    /**
     * Gets pricing method.
     *
     * @return string
     */
    public function getPricingMethod()
    {
        return $this->_pricingMethod;
    }

    /**
     * Sets pricing method.
     *
     * @param string $pricingMethod
     */
    public function setPricingMethod(string $pricingMethod)
    {
        $this->_pricingMethod = $pricingMethod;
    }

    // Response fields
    //

    /**
     * Gets ID.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets ID.
     *
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets account.
     *
     * @return string|null
     */
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * Sets account.
     *
     * @param string $account
     */
    public function setAccount(string $account)
    {
        $this->_account = $account;
    }

    /**
     * Gets support phone.
     *
     * @return string|null
     */
    public function getSupportPhone()
    {
        return $this->_supportPhone;
    }

    /**
     * Sets support phone.
     *
     * @param string $supportPhone
     */
    public function setSupportPhone(string $supportPhone)
    {
        $this->_supportPhone = $supportPhone;
    }

    /**
     * Gets status.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets status.
     *
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    /**
     * Gets percent fee.
     *
     * @return float|null
     */
    public function getPercentFee()
    {
        return $this->_percentFee;
    }

    /**
     * Sets percent fee
     *
     * @param float $percentFee
     */
    public function setPercentFee(float $percentFee)
    {
        $this->_percentFee = $percentFee;
    }

    /**
     * Gets fee.
     *
     * @return float|null
     */
    public function getFee()
    {
        return $this->_fee;
    }

    /**
     * Sets fee.
     *
     * @param float $fee
     */
    public function setFee(float $fee)
    {
        $this->_fee = $fee;
    }

    /**
     * Gets deposit total.
     *
     * @return float|null
     */
    public function getDepositTotal()
    {
        return $this->_depositTotal;
    }

    /**
     * Sets deposit total.
     *
     * @param float $depositTotal
     */
    public function setDepositTotal(float $depositTotal)
    {
        $this->_depositTotal = $depositTotal;
    }

    /**
     * Gets BTC.
     *
     * @return float|null
     */
    public function getBtc()
    {
        return $this->_btc;
    }

    /**
     * Sets BTC.
     *
     * @param float|null $btc
     */
    public function setBtc(?float $btc)
    {
        $this->_btc = $btc;
    }

    /**
     * Gets rate.
     *
     * @return float|null
     */
    public function getRate()
    {
        return $this->_rate;
    }

    /**
     * Sets rate.
     *
     * @param float $rate
     */
    public function setRate(float $rate)
    {
        $this->_rate = $rate;
    }

    /**
     * Get request date.
     *
     * @return string|null
     */
    public function getRequestDate()
    {
        return $this->_requestDate;
    }

    /**
     * Sets request date.
     *
     * @param string $requestDate
     */
    public function setRequestDate(string $requestDate)
    {
        $this->_requestDate = $requestDate;
    }

    /**
     * Gets date executed.
     *
     * @return string|null
     */
    public function getDateExecuted()
    {
        return $this->_dateExecuted;
    }

    /**
     * Sets date executed.
     *
     * @param string $dateExecuted
     */
    public function setDateExecuted(string $dateExecuted)
    {
        $this->_dateExecuted = $dateExecuted;
    }

    /**
     * Gets exchange rates.
     *
     * @return mixed
     */
    public function getExchangeRates()
    {
        return $this->_exchangeRates;
    }

    /**
     * Sets exchange rates.
     *
     * @param $exchangeRates
     */
    public function setExchangeRates($exchangeRates)
    {
        $this->_exchangeRates = $exchangeRates;
    }

    /**
     * Return an array with class values.
     *
     * @return array
     */
    public function toArray()
    {
        $elements = [
            'guid'              => $this->getGuid(),
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
            'redirectUrl'       => $this->getRedirectUrl(),
            'pricingMethod'     => $this->getPricingMethod(),
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
