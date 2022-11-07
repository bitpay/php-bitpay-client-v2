<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 * Contains the cryptocurrency transaction details for the executed payout.
 */
class PayoutTransaction
{
    protected $_txid;
    protected $_amount;
    protected $_date;

    public function __construct()
    {
    }

    /**
     * Gets Cryptocurrency transaction hash for the executed payout.
     *
     * @return string the tax id
     */
    public function getTxid()
    {
        return $this->_txid;
    }

    /**
     * Sets Cryptocurrency transaction hash for the executed payout.
     *
     * @param string $txid the tax id
     */
    public function setTxid(string $txid)
    {
        $this->_txid = $txid;
    }

    /**
     * Gets Amount of cryptocurrency sent to the requested address.
     *
     * @return float the amount
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets Amount of cryptocurrency sent to the requested address.
     *
     * @param float $amount the amount
     */
    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Gets Date and time (UTC) when the cryptocurrency transaction is broadcasted.
     * ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @return string the date
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * Sets Date and time (UTC) when the cryptocurrency transaction is broadcasted.
     * ISO-8601 format yyyy-mm-ddThh:mm:ssZ.
     *
     * @param string $date the date
     */
    public function setDate(string $date)
    {
        $this->_date = $date;
    }

    /**
     * Gets PayoutTransaction as array
     *
     * @return array PayoutTransaction as array
     */
    public function toArray()
    {
        $elements = [
            'txid'   => $this->getTxid(),
            'amount' => $this->getAmount(),
            'date'   => $this->getDate(),
        ];

        return $elements;
    }
}
