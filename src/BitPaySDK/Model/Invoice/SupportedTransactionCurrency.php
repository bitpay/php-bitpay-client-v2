<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Class SupportedTransactionCurrency
 * The currency that may be used to pay this invoice. The values are objects with an "enabled" boolean and option.
 * An extra "reason" parameter is added in the object if a cryptocurrency is disabled on a specific invoice.
 *
 * @package BitPaySDK\Model\Invoice
 * @see <a href="https://bitpay.readme.io/reference/invoices">REST API Invoices</a>
 */
class SupportedTransactionCurrency
{
    protected ?bool $enabled = null;
    protected ?string $reason = null;

    /**
     * SupportedTransactionCurrency constructor.
     */
    public function __construct()
    {
    }

    /**
     * Gets enabled.
     *
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * Sets enabled.
     *
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * Gets reason.
     *
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * Sets reason.
     *
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * Return array with enabled and reason value.
     *
     * @return array
     */
    public function toArray(): array
    {
        $elements = [
            'enabled' => $this->getEnabled(),
            'reason' => $this->getReason()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
