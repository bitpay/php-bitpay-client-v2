<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

class Ledger
{
    protected $_currency;
    protected $_balance;

    public function __construct()
    {
    }

    /**
     * Gets Ledger currency
     *
     * @return string the Ledger currency
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets Ledger currency
     *
     * @param string $currency the Ledger currency
     */
    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Gets Ledger balance in the corresponding currency
     *
     * @return float the Ledger balance
     */
    public function getBalance()
    {
        return $this->_balance;
    }

    /**
     * Sets Ledger balance in the corresponding currency
     *
     * @param float $balance the Ledger balance
     */
    public function setBalance(float $balance)
    {
        $this->_balance = $balance;
    }

    /**
     * Gets Ledger as array
     *
     * @return array Ledger as array
     */
    public function toArray()
    {
        $elements = [
            'currency' => $this->getCurrency(),
            'balance'  => $this->getBalance(),
        ];

        return $elements;
    }
}
