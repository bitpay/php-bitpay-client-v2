<?php


namespace BitPaySDK\Model\Settlement;


class WithHoldings
{
    protected $_amount;
    protected $_code;
    protected $_description;
    protected $_notes;
    protected $_label;
    protected $_bankCountry;

    public function __construct()
    {
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function setAmount(float $amount)
    {
        $this->_amount = $amount;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function setCode(string $code)
    {
        $this->_code = $code;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription(string $description)
    {
        $this->_description = $description;
    }

    public function getNotes()
    {
        return $this->_notes;
    }

    public function setNotes(string $notes)
    {
        $this->_notes = $notes;
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel(string $label)
    {
        $this->_label = $label;
    }

    public function getBankCountry()
    {
        return $this->_bankCountry;
    }

    public function setBankCountry(string $bankCountry)
    {
        $this->_bankCountry = $bankCountry;
    }

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