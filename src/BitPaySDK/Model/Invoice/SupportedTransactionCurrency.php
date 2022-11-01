<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Class SupportedTransactionCurrency
 * The currency that may be used to pay this invoice. The values are objects with an "enabled" boolean and option.
 * An extra "reason" parameter is added in the object if a cryptocurrency is disabled on a specific invoice.
 *
 * @see <a href="https://bitpay.com/api/#rest-api-resources-invoices-resource">REST API Invoices</a>
 *
 * @package BitPaySDK\Model\Invoice
 */
class SupportedTransactionCurrency
{
    protected $_enabled;
    protected $_reason;

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
    public function setEnabled(bool $enabled)
    {
        $this->_enabled = $enabled;
    }

    /**
     * Sets enabled.
     *
     * @return bool|null
     */
    public function getEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Gets reason.
     *
     * @param string $reason
     */
    public function setReason(string $reason)
    {
        $this->_reason = $reason;
    }

    /**
     * Sets reason.
     *
     * @return string|null
     */
    public function getReason()
    {
        return $this->_reason;
    }

    /**
     * Return array with enabled and reason value.
     *
     * @return array
     */
    public function toArray()
    {
        $elements = [
            'enabled' => $this->getEnabled(),
            'reason'  => $this->getReason()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
