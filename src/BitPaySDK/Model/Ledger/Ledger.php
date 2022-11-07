<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

use BitPaySDK\Model\Ledger\LedgerEntry;

class Ledger
{
    protected $_entries;
    protected $_currency;
    protected $_balance;

    public function __construct()
    {
    }

    /**
     * Gets Array of ledger entries listing the various debits and credits which are settled in the report
     *
     * @return array the ledger entries
     */
    public function getEntries()
    {
        $entries = [];

        foreach ($this->_entries as $entry) {
            if ($entry instanceof LedgerEntry) {
                array_push($entries, $entry->toArray());
            } else {
                array_push($entries, $entry);
            }
        }

        return $entries;
    }

    /**
     * Sets Array of ledger entries listing the various debits and credits which are settled in the report
     *
     * @param array $entries the ledgers entries
     */
    public function setEntries(array $entries)
    {
        $this->_entries = $entries;
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
            'entries'  => $this->getEntries(),
            'currency' => $this->getCurrency(),
            'balance'  => $this->getBalance(),
        ];

        return $elements;
    }
}
