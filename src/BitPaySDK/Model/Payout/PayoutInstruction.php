<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutBatchCreationException;

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
    protected $_label = '';
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
     * @throws PayoutBatchCreationException BitPayException class
     */
    public function __construct(float $amount, int $method, string $methodValue)
    {
        $this->setAmount($amount);
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
                throw new PayoutBatchCreationException("\$method code must be a type of RecipientReferenceMethod");
                break;
        }
    }

    /**
     * Gets the amount of the payout in the indicated currency. The minimum amount per instruction is $5 USD equivalent
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets the amount of the payout in the indicated currency
     *
     * @param float $amount
     * @throws BitPayException
     */
    public function setAmount(float $amount)
    {
        if ($amount < 5) {
            throw new BitPayException("Instruction amount should be 5 or higher.");
        }

        $this->_amount = $amount;
    }


    /**
     * Gets email address of an active recipient
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets email address of an active recipient
     *
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }


    /**
     * Gets Bitpay recipient id of an active recipient, assigned by BitPay for
     * a given recipient email during the onboarding process
     * (see <a href="https://bitpay.com/api/#rest-api-resources-recipients">Recipients resource</a>)
     *
     * @return string
     */
    public function getRecipientId()
    {
        return $this->_recipientId;
    }

    /**
     * Sets recipient id
     *
     * @param string $recipientId
     */
    public function setRecipientId(string $recipientId)
    {
        $this->_recipientId = $recipientId;
    }

    /**
     * Gets unique id assigned by BitPay if the shopper used their personal BitPay account to authenticate
     * and pay an invoice.For customers signing up for a brand new BitPay personal account, this id will
     * only be created as part of the payout onboarding.The same field would also be available on paid invoices
     * if the customer signed in with their BitPay personal account before completing the payment.
     * This can allow merchants to monitor the activity of a customer (deposits & payouts)
     *
     * @return string
     */
    public function getShopperId()
    {
        return $this->_shopperId;
    }

    /**
     * Sets unique id assigned by BitPay if the shopper used their personal BitPay account to authenticate
     * and pay an invoice
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
     * For merchant use, pass through - can be the customer name or unique merchant reference assigned
     * by the merchant to to the recipient
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Sets label
     *
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    // Response fields
    //

    /**
     * Get payout id
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets payout id
     *
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Gets payout instruction BTC summary data as array
     *
     * @return array|null
     */
    public function getBtc()
    {
        return $this->_btc ? $this->_btc->toArray() : null;
    }

    /**
     * Sets payout instruction BTC summary
     *
     * @param PayoutInstructionBtcSummary $btc
     */
    public function setBtc(PayoutInstructionBtcSummary $btc)
    {
        $this->_btc = $btc;
    }

    /**
     * Gets cryptocurrency transaction details for the executed payout
     *
     * @return array
     */
    public function getTransactions()
    {
        return $this->_transactions;
    }

    /**
     * Sets cryptocurrency transaction details for the executed payout
     *
     * @param array $transactions
     */
    public function setTransactions(array $transactions)
    {
        $this->_transactions = $transactions;
    }

    /**
     * Gets payout status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Sets payout status
     *
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->_status = $status;
    }

    /**
     * Return PayoutInstruction values as array
     *
     * @return array
     */
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
