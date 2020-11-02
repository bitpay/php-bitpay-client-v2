<?php


namespace BitPaySDK\Model\Payout;


use BitPaySDK\Exceptions\PayoutCreationException;

/**
 *
 * @package Bitpay
 */
class PayoutInstruction
{
    protected $_amount;
    protected $_email;
    protected $_recipientId;
    protected $_shopperId;
    protected $_label = "";
    protected $_walletProvider;
    protected $_id;

    /**
     * @var PayoutInstructionBtcSummary
     */
    protected $_btc;
    protected $_transactions;
    protected $_status;

    /**
     * Constructor, create a PayoutInstruction object.
     *
     * @param $amount      float BTC amount.
     * @param $method      int Method used to target the recipient.
     * @param $methodValue string value for the choosen target method.
     *
     * @throws PayoutCreationException BitPayException class
     */
    public function __construct(float $amount, int $method, string $methodValue)
    {
        $this->_amount = $amount;
        switch ($method) {
            case RecipientReferenceMethod::EMAIL:
                $this->_email = $methodValue;
                break;
            case RecipientReferenceMethod::RECIPIENT_ID:
                $this->_recipientId = $methodValue;
                break;
            case RecipientReferenceMethod::SHOPPER_ID:
                $this->_shopperId = $methodValue;
                break;
            default:
                throw new PayoutCreationException("\$method code must be a type of RecipientReferenceMethod");
                break;
        }
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
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

    public function getWalletProvider()
    {
        return $this->_walletProvider;
    }

    public function setWalletProvider(string $walletProvider)
    {
        $this->_walletProvider = $walletProvider;
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

    public function getBtc()
    {
        return $this->_btc ? $this->_btc->toArray() : null;
    }

    public function setBtc(PayoutInstructionBtcSummary $btc)
    {
        $this->_btc = $btc;
    }

    public function getTransactions()
    {
        return $this->_transactions;
    }

    public function setTransactions(array $transactions)
    {
        $this->_transactions = $transactions;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    public function toArray()
    {
        $elements = [
            'amount'       => $this->getAmount(),
            'email'        => $this->getEmail(),
            'recipientId'  => $this->getRecipientId(),
            'shopperId'    => $this->getShopperId(),
            'label'        => $this->getLabel(),
            'id'           => $this->getId(),
            'btc'          => $this->getBtc(),
            'transactions' => $this->getTransactions(),
            'status'       => $this->getStatus(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
