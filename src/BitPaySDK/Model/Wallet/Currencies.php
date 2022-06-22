<?php

namespace BitPaySDK\Model\Wallet;

class Currencies
{
    protected $_code;
    protected $_p2p;
    protected $_image;
    protected $_dappBrowser;
    protected $_payPro;
    protected $_qr;
    protected $_withdrawalFee;
    protected $_walletConnect;

    public function __construct()
    {
        $this->_currencies = new CurrencyQr();
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function setCode(string $code)
    {
        $this->_code = $code;
    }

    public function getP2p()
    {
        return $this->_p2p;
    }

    public function setP2p(bool $p2p)
    {
        $this->_p2p = $p2p;
    }

    public function getImage()
    {
        return $this->_image;
    }

    public function setImage(string $image)
    {
        $this->_image = $image;
    }

    public function getDappBrowser()
    {
        return $this->_dappBrowser;
    }

    public function setDappBrowser(bool $dappBrowser)
    {
        $this->_dappBrowser = $dappBrowser;
    }

    public function getPayPro()
    {
        return $this->_payPro;
    }

    public function setPayPro(bool $payPro)
    {
        $this->_payPro = $payPro;
    }

    public function getQr()
    {
        return $this->_qr;
    }

    public function setQr(CurrencyQr $qr)
    {
        $this->_qr = $qr;
    }

    public function getWithdrawalFee()
    {
        return $this->_withdrawalFee;
    }

    public function setWithdrawalFee(string $withdrawalFee)
    {
        $this->_withdrawalFee = $withdrawalFee;
    }

    public function getWalletConnect()
    {
        return $this->_walletConnect;
    }

    public function setWalletConnect(bool $walletConnect)
    {
        $this->_walletConnect = $walletConnect;
    }    

    public function toArray()
    {
        $elements = [
            'code'            => $this->getCode(),
            'p2p'             => $this->getP2p(),
            'image'           => $this->getImage(),
            'dappBrowser'     => $this->getDappBrowser(),
            'paypro'          => $this->getPayPro(),
            'qr'              => $this->getQr()->toArray(),
            'withdrawalFee'   => $this->getWithdrawalFee(),
            'walletConnect'   => $this->getWalletConnect()
        ];

        return $elements;
    }
}
