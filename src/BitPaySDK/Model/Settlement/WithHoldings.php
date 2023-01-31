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
    protected $amount;
    protected $code;
    protected $description;
    protected $notes;
    protected $label;
    protected $bankCountry;

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
        return $this->amount;
    }

    /**
     * Sets amount.
     *
     * @param float $amount
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Gets code.
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets code.
     *
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * Gets description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets description.
     *
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Gets notes.
     *
     * @return string|null
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Sets notes.
     *
     * @param string $notes
     */
    public function setNotes(string $notes)
    {
        $this->notes = $notes;
    }

    /**
     * Gets label.
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets label.
     *
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * Gets bank country.
     *
     * @return string|null
     */
    public function getBankCountry()
    {
        return $this->bankCountry;
    }

    /**
     * Sets bank country.
     *
     * @param string $bankCountry
     */
    public function setBankCountry(string $bankCountry)
    {
        $this->bankCountry = $bankCountry;
    }

    /**
     * Return an array with class values.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'amount'      => $this->getAmount(),
            'code'        => $this->getCode(),
            'description' => $this->getDescription(),
            'notes'       => $this->getNotes(),
            'label'       => $this->getLabel(),
            'bankCountry' => $this->getBankCountry(),
        ];
    }
}
