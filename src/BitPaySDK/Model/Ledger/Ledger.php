<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

class Ledger
{
    protected $currency;
    protected $balance;

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
        return $this->currency;
    }

    /**
     * Sets Ledger currency
     *
     * @param string $currency the Ledger currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * Gets Ledger balance in the corresponding currency
     *
     * @return float the Ledger balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Sets Ledger balance in the corresponding currency
     *
     * @param float $balance the Ledger balance
     */
    public function setBalance(float $balance)
    {
        $this->balance = $balance;
    }

    /**
     * Gets Ledger as array
     *
     * @return array Ledger as array
     */
    public function toArray()
    {
        return [
            'currency' => $this->getCurrency(),
            'balance'  => $this->getBalance(),
        ];
    }
}
