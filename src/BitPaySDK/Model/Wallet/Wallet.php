<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Wallet;

/**
 *
 * @package Bitpay
 */
class Wallet
{
    protected $_key;
    protected $_displayName;
    protected $_avatar;
    protected $_paypro;
    protected $_currencies;
    protected $_image;

    /**
     * Constructor, create a minimal request Wallet object.
     *
     * @param $currencies details of what currencies support payments for this wallet
    */
    public function __construct()
    {
        $this->_currencies = new Currencies();
    }

    /**
     * Gets A unique identifier for the wallet
     *
     * @return string the key
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * Sets A unique identifier for the wallet
     *
     * @param string $key the key
     */
    public function setKey(string $key)
    {
        $this->_key = $key;
    }

    /**
     * Gets display name
     *
     * Human readable display name for the wallet
     *
     * @return string the display name
     */
    public function getDisplayName()
    {
        return $this->_displayName;
    }

    /**
     * Sets display name
     *
     * Human readable display name for the wallet
     *
     * @param string $displayName the display name
     */
    public function setDisplayName(string $displayName)
    {
        $this->_displayName = $displayName;
    }

    /**
     * Gets avatar
     *
     * Filename of a wallet graphic (not fully qualified)
     *
     * @return string the avatar
     */
    public function getAvatar()
    {
        return $this->_avatar;
    }

    /**
     * Sets avatar
     *
     * Filename of a wallet graphic (not fully qualified)
     *
     * @param string $avatar the avatar
     */
    public function setAvatar(string $avatar)
    {
        $this->_avatar = $avatar;
    }

    /**
     * Gets pay pro
     *
     * Whether or not the wallet supports ANY BitPay Payment Protocol options
     *
     * @return bool the pay pro
     */
    public function getPayPro()
    {
        return $this->_payPro;
    }

    /**
     * Sets pay pro
     *
     * Whether or not the wallet supports ANY BitPay Payment Protocol options
     *
     * @param bool $payPro the pay pro
     */
    public function setPayPro(bool $payPro)
    {
        $this->_payPro = $payPro;
    }

    /**
     * Gets currencies
     *
     * Details of what currencies support payments for this wallet
     *
     * @return Currencies the currencies
     */
    public function getCurrencies()
    {
        return $this->_currencies;
    }

    /**
     * Sets currencies
     *
     * Details of what currencies support payments for this wallet
     *
     * @param Currencies $currencies the currencies
     */
    public function setCurrencies(Currencies $currencies)
    {
        $this->_currencies = $currencies;
    }

    /**
     * Gets image
     *
     * URL that displays wallet avatar image
     *
     * @return string the image url
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * Sets image
     *
     * URL that displays wallet avatar image
     *
     * @param string $image the image url
     */
    public function setImage(string $image)
    {
        $this->_image = $image;
    }

    /**
     * Gets Wallet as array
     *
     * @return array Wallet as array
     */
    public function toArray()
    {
        $elements = [
            'key'         => $this->getKey(),
            'displayName' => $this->getDisplayName(),
            'avatar'      => $this->getAvatar(),
            'paypro'      => $this->getPayPro(),
            'currencies'  => $this->getCurrencies()->toArray(),
            'image'       => $this->getImage()
        ];

        return $elements;
    }
}
