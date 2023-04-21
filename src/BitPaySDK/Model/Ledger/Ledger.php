<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Ledger;

/**
 * Class Ledger
 * @package BitPaySDK\Model\Ledger
 * @see <a href="https://bitpay.readme.io/reference/ledgers">REST API Ledgers</a>
 */
class Ledger
{
    protected ?string $currency = null;
    protected ?float $balance = null;

    public function __construct()
    {
    }

    /**
     * Gets Ledger currency
     *
     * @return string|null the Ledger currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets Ledger currency
     *
     * @param string $currency the Ledger currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Gets Ledger balance in the corresponding currency
     *
     * @return float|null the Ledger balance
     */
    public function getBalance(): ?float
    {
        return $this->balance;
    }

    /**
     * Sets Ledger balance in the corresponding currency
     *
     * @param float $balance the Ledger balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * Gets Ledger as array
     *
     * @return array Ledger as array
     */
    public function toArray(): array
    {
        return [
            'currency' => $this->getCurrency(),
            'balance'  => $this->getBalance(),
        ];
    }
}
