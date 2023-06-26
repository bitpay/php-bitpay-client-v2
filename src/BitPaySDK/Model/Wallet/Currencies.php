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
 * Details of what currencies support payments for this wallet
 * @see <a href="https://bitpay.readme.io/reference/wallets">Wallets</a>
 */
class Currencies
{
    protected ?string $code = null;
    protected ?bool $p2p = null;
    protected ?bool $dappBrowser = null;
    protected ?string $image = null;
    protected ?bool $payPro = null;
    protected ?CurrencyQr $qr = null;
    protected ?string $withdrawalFee = null;
    protected ?bool $walletConnect = null;

    public function __construct()
    {
    }

    /**
     * Gets code
     *
     * Identifying code for the currency
     *
     * @return string|null the code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Sets code
     *
     * Identifying code for the currency
     *
     * @param string $code the code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Gets p2p
     *
     * Indicates that this is a peer to peer (p2p) payment method (as opposed to payment protocol)
     *
     * @return bool|null the p2p
     */
    public function getP2p(): ?bool
    {
        return $this->p2p;
    }

    /**
     * Sets p2p
     *
     * Indicates that this is a peer to peer (p2p) payment method (as opposed to payment protocol)
     *
     * @param bool $p2p the p2p
     */
    public function setP2p(bool $p2p): void
    {
        $this->p2p = $p2p;
    }

    /**
     * Gets Dapp Browser
     *
     * Indicates that this payment method operates via a browser plugin interacting with the invoice
     *
     * @return bool|null the dapp browser
     */
    public function getDappBrowser(): ?bool
    {
        return $this->dappBrowser;
    }

    /**
     * Sets Dapp Browser
     *
     * Indicates that this payment method operates via a browser plugin interacting with the invoice
     *
     * @param bool $dappBrowser the dapp browser
     */
    public function setDappBrowser(bool $dappBrowser): void
    {
        $this->dappBrowser = $dappBrowser;
    }

    /**
     * Gets URL that displays currency image
     *
     * @return string|null the image url
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Sets URL that displays currency image
     *
     * @param string $image the image url
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * Gets pay pro
     *
     * Whether or not BitPay Payment Protocol is supported on this particular currency option
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
     * Whether or not BitPay Payment Protocol is supported on this particular currency option
     *
     * @param bool $payPro the pay pro
     */
    public function setPayPro(bool $payPro): void
    {
        $this->payPro = $payPro;
    }

    /**
     * Gets CurrencyQr
     *
     * Object containing QR code related information to show for this payment method
     *
     * @return CurrencyQr|null the qr
     */
    public function getQr(): ?CurrencyQr
    {
        return $this->qr;
    }

    /**
     * Sets CurrencyQr
     *
     * Object containing QR code related information to show for this payment method
     *
     * @param CurrencyQr $qr the currency qr
     */
    public function setQr(CurrencyQr $qr): void
    {
        $this->qr = $qr;
    }

    /**
     * Gets Custodial wallet withdrawal fee
     *
     * @return string|null the withdrawal fee
     */
    public function getWithdrawalFee(): ?string
    {
        return $this->withdrawalFee;
    }

    /**
     * Sets Custodial wallet withdrawal fee
     *
     * @param string $withdrawalFee the withdrawal fee
     */
    public function setWithdrawalFee(string $withdrawalFee): void
    {
        $this->withdrawalFee = $withdrawalFee;
    }

    /**
     * Gets wallet connect
     *
     * Whether or not this wallet supports walletConnect
     *
     * @return bool|null the wallet connect
     */
    public function getWalletConnect(): ?bool
    {
        return $this->walletConnect;
    }

    /**
     * Sets wallet connect
     *
     * Whether or not this wallet supports walletConnect
     *
     * @param bool $walletConnect the wallet connect
     */
    public function setWalletConnect(bool $walletConnect): void
    {
        $this->walletConnect = $walletConnect;
    }

    /**
     * Gets Currencies as array
     *
     * @return array Currencies as array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'p2p' => $this->getP2p(),
            'dappBrowser' => $this->getDappBrowser(),
            'image' => $this->getImage(),
            'paypro' => $this->getPayPro(),
            'qr' => $this->getQr()->toArray(),
            'withdrawalFee' => $this->getWithdrawalFee(),
            'walletConnect' => $this->getWalletConnect()
        ];
    }
}
