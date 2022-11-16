<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Wallet;

/**
 * Object containing QR code related information to show for this payment method
 */
class CurrencyQr
{
    protected $_type;
    protected $_collapsed;

    public function __construct()
    {
    }

    /**
     * Gets Type
     *
     * The type of QR code to use (ex. BIP21, ADDRESS, BIP72b, BIP681, BIP681b, etc)
     *
     * @return string The type of QR code to use
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Sets Type
     *
     * The type of QR code to use (ex. BIP21, ADDRESS, BIP72b, BIP681, BIP681b, etc)
     *
     * @param string $type The type of QR code to use
     */
    public function setType(string $type)
    {
        $this->_type = $type;
    }

    /**
     * Gets collapsed
     *
     * UI hint for BitPay invoice, generally not relevant to customer integrations
     *
     * @return bool the collapsed
     */
    public function getCollapsed()
    {
        return $this->_collapsed;
    }

    /**
     * Sets collapsed
     *
     * UI hint for BitPay invoice, generally not relevant to customer integrations
     *
     * @param bool $collapsed the collapsed
     */
    public function setCollapsed(bool $collapsed)
    {
        $this->_collapsed = $collapsed;
    }

    /**
     * Gets CurrencyQr as array
     *
     * @return array CurrencyQr as array
     */
    public function toArray()
    {
        $elements = [
            'type'          => $this->getType(),
            'collapsed'     => $this->getCollapsed(),
        ];

        return $elements;
    }
}
