<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Wallet;

/**
 * Details of what currencies support payments for this wallet
 */
class Currencies
{
    protected $code;
    protected $p2p;
    protected $dappBrowser;
    protected $image;
    protected $payPro;
    protected $qr;
    protected $withdrawalFee;
    protected $walletConnect;
    protected $currencies;

    public function __construct()
    {
        $this->currencies = new CurrencyQr();
    }

    /**
     * Gets code
     *
     * Identifying code for the currency
     *
     * @return string the code
     */
    public function getCode()
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
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * Gets p2p
     *
     * Indicates that this is a peer to peer (p2p) payment method (as opposed to payment protocol)
     *
     * @return bool the p2p
     */
    public function getP2p()
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
    public function setP2p(bool $p2p)
    {
        $this->p2p = $p2p;
    }

    /**
     * Gets Dapp Browser
     *
     * Indicates that this payment method operates via a browser plugin interacting with the invoice
     *
     * @return bool the dapp browser
     */
    public function getDappBrowser()
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
    public function setDappBrowser(bool $dappBrowser)
    {
        $this->dappBrowser = $dappBrowser;
    }

    /**
     * Gets URL that displays currency image
     *
     * @return string the image url
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets URL that displays currency image
     *
     * @param string $image the image url
     */
    public function setImage(string $image)
    {
        $this->image = $image;
    }

    /**
     * Gets pay pro
     *
     * Whether or not BitPay Payment Protocol is supported on this particular currency option
     *
     * @return bool the pay pro
     */
    public function getPayPro()
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
    public function setPayPro(bool $payPro)
    {
        $this->payPro = $payPro;
    }

    /**
     * Gets CurrencyQr
     *
     * Object containing QR code related information to show for this payment method
     *
     * @return CurrencyQr the qr
     */
    public function getQr()
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
    public function setQr(CurrencyQr $qr)
    {
        $this->qr = $qr;
    }

    /**
     * Gets Custodial wallet withdrawal fee
     *
     * @return string the withdrawal fee
     */
    public function getWithdrawalFee()
    {
        return $this->withdrawalFee;
    }

    /**
     * Sets Custodial wallet withdrawal fee
     *
     * @param string $withdrawalFee the withdrawal fee
     */
    public function setWithdrawalFee(string $withdrawalFee)
    {
        $this->withdrawalFee = $withdrawalFee;
    }

    /**
     * Gets wallet connect
     *
     * Whether or not this wallet supports walletConnect
     *
     * @return bool the wallet connect
     */
    public function getWalletConnect()
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
    public function setWalletConnect(bool $walletConnect)
    {
        $this->walletConnect = $walletConnect;
    }

    /**
     * Gets Currencies as array
     *
     * @return array Currencies as array
     */
    public function toArray()
    {
        return [
            'code'            => $this->getCode(),
            'p2p'             => $this->getP2p(),
            'dappBrowser'     => $this->getDappBrowser(),
            'image'           => $this->getImage(),
            'paypro'          => $this->getPayPro(),
            'qr'              => $this->getQr()->toArray(),
            'withdrawalFee'   => $this->getWithdrawalFee(),
            'walletConnect'   => $this->getWalletConnect()
        ];
    }
}
