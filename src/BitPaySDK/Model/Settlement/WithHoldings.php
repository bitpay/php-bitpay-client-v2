<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Settlement;

/**
 * Class WithHoldings
 *
 * @see <a href="https://bitpay.com/api/#rest-api-resources-settlements">Settlements</a>
 * @package BitPaySDK\Model\Settlement
 */
class WithHoldings
{
    protected $_amount;
    protected $_code;
    protected $_description;
    protected $_notes;
    protected $_label;
    protected $_bankCountry;

    /**
     * WithHoldings constructor.
     */
    public function __construct()
    {
    }

    /**
     * Gets amount.
     *
     * @return float|null
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * Sets amount.
     *
     * @param float $amount
     */
    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    /**
     * Gets code.
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Sets code.
     *
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->_code = $code;
    }

    /**
     * Gets description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Sets description.
     *
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    /**
     * Gets notes.
     *
     * @return string|null
     */
    public function getNotes()
    {
        return $this->_notes;
    }

    /**
     * Sets notes.
     *
     * @param string $notes
     */
    public function setNotes(string $notes)
    {
        $this->_notes = $notes;
    }

    /**
     * Gets label.
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Sets label.
     *
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    /**
     * Gets bank country.
     *
     * @return string|null
     */
    public function getBankCountry()
    {
        return $this->_bankCountry;
    }

    /**
     * Sets bank country.
     *
     * @param string $bankCountry
     */
    public function setBankCountry(string $bankCountry)
    {
        $this->_bankCountry = $bankCountry;
    }

    /**
     * Return an array with class values.
     *
     * @return array
     */
    public function toArray()
    {
        $elements =
            [
                'amount'      => $this->getAmount(),
                'code'        => $this->getCode(),
                'description' => $this->getDescription(),
                'notes'       => $this->getNotes(),
                'label'       => $this->getLabel(),
                'bankCountry' => $this->getBankCountry(),
            ];

        return $elements;
    }
}
