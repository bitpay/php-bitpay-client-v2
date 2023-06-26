<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Wallet;

/**
 * Object containing QR code related information to show for this payment method
 * @see <a href="https://bitpay.readme.io/reference/wallets">Wallets</a>
 */
class CurrencyQr
{
    protected ?string $type = null;
    protected ?bool $collapsed = null;

    public function __construct()
    {
    }

    /**
     * Gets Type
     *
     * The type of QR code to use (ex. BIP21, ADDRESS, BIP72b, BIP681, BIP681b, etc)
     *
     * @return string|null The type of QR code to use
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type
     *
     * The type of QR code to use (ex. BIP21, ADDRESS, BIP72b, BIP681, BIP681b, etc)
     *
     * @param string $type The type of QR code to use
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets collapsed
     *
     * UI hint for BitPay invoice, generally not relevant to customer integrations
     *
     * @return bool|null the collapsed
     */
    public function getCollapsed(): ?bool
    {
        return $this->collapsed;
    }

    /**
     * Sets collapsed
     *
     * UI hint for BitPay invoice, generally not relevant to customer integrations
     *
     * @param bool $collapsed the collapsed
     */
    public function setCollapsed(bool $collapsed): void
    {
        $this->collapsed = $collapsed;
    }

    /**
     * Gets CurrencyQr as array
     *
     * @return array CurrencyQr as array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'collapsed' => $this->getCollapsed(),
        ];
    }
}
