<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Wallet;

/**
 * @package BitPaySDK\Model\Currencies
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://bitpay.readme.io/reference/wallets Wallets
 */
class Wallet
{
    protected ?string $key = null;
    protected ?string $displayName = null;
    protected ?string $avatar = null;
    protected Currencies $currencies;
    protected ?string $image = null;
    protected ?bool $payPro = null;
    protected ?string $uniCode = null;
    protected ?bool $offChainMode = null;
    protected ?string $invoiceDefault = null;

    /**
     * Constructor, create a minimal request Wallet object.
     */
    public function __construct()
    {
        $this->currencies = new Currencies();
    }

    /**
     * Gets A unique identifier for the wallet
     *
     * @return string|null the key
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * Sets A unique identifier for the wallet
     *
     * @param string $key the key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * Gets display name
     *
     * Human readable display name for the wallet
     *
     * @return string|null the display name
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * Sets display name
     *
     * Human readable display name for the wallet
     *
     * @param string $displayName the display name
     */
    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * Gets avatar
     *
     * Filename of a wallet graphic (not fully qualified)
     *
     * @return string|null the avatar
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * Sets avatar
     *
     * Filename of a wallet graphic (not fully qualified)
     *
     * @param string $avatar the avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * Gets pay pro
     *
     * Whether or not the wallet supports ANY BitPay Payment Protocol options
     *
     * @return bool|null the pay pro
     */
    public function getPayPro(): ?bool
    {
        return $this->payPro;
    }

    /**
     * Sets pay pro
     *
     * Whether or not the wallet supports ANY BitPay Payment Protocol options
     *
     * @param bool $payPro the pay pro
     */
    public function setPayPro(bool $payPro): void
    {
        $this->payPro = $payPro;
    }

    /**
     * Gets currencies
     *
     * Details of what currencies support payments for this wallet
     *
     * @return Currencies the currencies
     */
    public function getCurrencies(): Currencies
    {
        return $this->currencies;
    }

    /**
     * Sets currencies
     *
     * Details of what currencies support payments for this wallet
     *
     * @param Currencies $currencies the currencies
     */
    public function setCurrencies(Currencies $currencies): void
    {
        $this->currencies = $currencies;
    }

    /**
     * Gets image
     *
     * URL that displays wallet avatar image
     *
     * @return string|null the image url
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Sets image
     *
     * URL that displays wallet avatar image
     *
     * @param string $image the image url
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getUniCode(): ?string
    {
        return $this->uniCode;
    }

    /**
     * @param string|null $uniCode
     */
    public function setUniCode(?string $uniCode): void
    {
        $this->uniCode = $uniCode;
    }

    /**
     * @return bool|null
     */
    public function getOffChainMode(): ?bool
    {
        return $this->offChainMode;
    }

    /**
     * @param bool|null $offChainMode
     */
    public function setOffChainMode(?bool $offChainMode): void
    {
        $this->offChainMode = $offChainMode;
    }

    /**
     * @return string|null
     */
    public function getInvoiceDefault(): ?string
    {
        return $this->invoiceDefault;
    }

    /**
     * @param string|null $invoiceDefault
     */
    public function setInvoiceDefault(?string $invoiceDefault): void
    {
        $this->invoiceDefault = $invoiceDefault;
    }

    /**
     * Gets Wallet as array
     *
     * @return array Wallet as array
     */
    public function toArray(): array
    {
        return [
            'key' => $this->getKey(),
            'displayName' => $this->getDisplayName(),
            'avatar' => $this->getAvatar(),
            'paypro' => $this->getPayPro(),
            'currencies' => $this->getCurrencies()->toArray(),
            'image' => $this->getImage(),
            'uniCode' => $this->getUniCode(),
            'offChainMode' => $this->getOffChainMode(),
            'invoiceDefault' => $this->getInvoiceDefault()
        ];
    }
}
