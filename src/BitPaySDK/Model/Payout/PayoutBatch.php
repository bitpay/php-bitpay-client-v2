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
    const MethodManual2 = "manual_2";
    const MethodVwap24  = "vwap_24hr";

    protected $_guid  = "";
    protected $_token = "";

    protected $_amount       = 0.0;
    protected $_currency     = "";
    protected $_effectiveDate;
    protected $_instructions = [];

    protected $_reference         = "";
    protected $_notificationEmail = "";
    protected $_notificationUrl   = "";
    protected $_pricingMethod     = self::MethodVwap24;

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

    /**
     * Constructor, create an instruction-full request PayoutBatch object.
     *
     * @param $currency      string The three digit currency string for the PayoutBatch to use.
     * @param $effectiveDate string Date when request is effective. Note that the time of day will automatically be set
     *                       to 09:00:00.000 UTC time for the given day. Only requests submitted before 09:00:00.000
     *                       UTC are guaranteed to be processed on the same day.
     */
    public function __construct(string $currency = "USD", string $effectiveDate = null, array $instructions = null)
    {
        $this->_currency = $currency;
        $this->_effectiveDate = $effectiveDate;
        $this->_instructions = $instructions;
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
            throw new BitPayException("currency code must be a type of Model.Currency");
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

    public function getNotificationEmail()
    {
        return $this->_notificationEmail;
    }

    public function setNotificationEmail(string $notificationEmail)
    {
        $this->_notificationEmail = $notificationEmail;
    }

    public function getNotificationURL()
    {
        return $this->_notificationUrl;
    }

    public function setNotificationURL(string $notificationUrl)
    {
        $this->_notificationUrl = $notificationUrl;
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

    public function setCurrencyInfo(array $currencyInfo)
    {
        $this->_currnecyinfo = $currencyInfo;
    }

    public function getCurrencyInfo()
    {
        return $this->_currencyInfo;
    }

    public function toArray()
    {
        $elements = [
            'guid'              => $this->getGuid(),
            'token'             => $this->getToken(),
            'amount'            => $this->getAmount(),
            'currency'          => $this->getCurrency(),
            'effectiveDate'     => $this->getEffectiveDate(),
            'instructions'      => $this->getInstructions(),
            'reference'         => $this->getReference(),
            'notificationEmail' => $this->getNotificationEmail(),
            'notificationURL'   => $this->getNotificationURL(),
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
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
