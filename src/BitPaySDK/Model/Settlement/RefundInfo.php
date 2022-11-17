<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Object containing information about the refund
 */
class RefundInfo
{
    protected $_supportRequest;
    protected $_currency;
    protected $_amounts;
    protected $_reference;

    public function __construct()
    {
    }

    /**
     * Gets support request.
     *
     * BitPay support request ID associated to the refund
     *
     * @return string the support request
     */
    public function getSupportRequest()
    {
        return $this->_supportRequest;
    }

    /**
     * Sets support request.
     *
     * BitPay support request ID associated to the refund
     *
     * @param string $supportRequest the support request
     */
    public function setSupportRequest(string $supportRequest)
    {
        $this->_supportRequest = $supportRequest;
    }

    /**
     * Gets currency.
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on <a href="https://bitpay.com/docs/settlement">Settlement Docs</a>
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * Sets currency.
     *
     * ISO 4217 3-character currency code. This is the currency associated with the settlement.
     * Supported settlement currencies are listed on <a href="https://bitpay.com/docs/settlement">Settlement Docs</a>
     *
     * @param string $currency the currency
     */
    public function setCurrency(string $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Gets amounts.
     *
     * This object will contain the crypto currency amount refunded by BitPay to the consumer
     *
     * @return array
     */
    public function getAmounts()
    {
        return $this->_amounts;
    }

    /**
     * Sets amounts.
     *
     * @param array $amounts
     */
    public function setAmounts(array $amounts)
    {
        $this->_amounts = $amounts;
    }

    /**
     * Gets reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->_reference;
    }

    /**
     * Sets reference.
     *
     * @param string $reference
     */
    public function setReference(string $reference)
    {
        $this->_reference = $reference;
    }

    /**
     * Gets Refund info as array
     *
     * @return array refund info as array
     */
    public function toArray()
    {
        $elements = [
            'supportRequest' => $this->getSupportRequest(),
            'currency'       => $this->getCurrency(),
            'amounts'        => $this->getAmounts(),
            'reference'      => $this->getReference()
        ];

        return $elements;
    }
}
