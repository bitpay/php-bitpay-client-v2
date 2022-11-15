<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

class ItemizedDetails
{
    protected $_amount;
    protected $_description;
    protected $_isFee;

    public function __construct()
    {
    }

    /**
     * Gets The amount of currency.
     *
     * @return float the amount
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets The amount of currency.
     *
     * @param float $amount the amount
     */
    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Gets description
     *
     * Display string for the item.
     *
     * @return string the description
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Sets string for the item.
     *
     * @param string $description the description
     */
    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    /**
     * Gets is fee
     *
     * Indicates whether or not the item is considered a fee/tax or part of the main purchase.
     *
     * @return bool is fee
     */
    public function getIsFee()
    {
        return $this->_isFee;
    }

    /**
     * Sets is fee
     *
     * Gets Indicates whether or not the item is considered a fee/tax or part of the main purchase.
     *
     * @param bool $isFee is fee
     */
    public function setIsFee(bool $isFee)
    {
        $this->_isFee = $isFee;
    }

    /**
     * Gets Item details data as array
     *
     * @return array item details data as array
     */
    public function toArray()
    {
        $elements = [
            'amount'        => $this->getAmount(),
            'description'   => $this->getDescription(),
            'isFee'         => $this->getIsFee()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
