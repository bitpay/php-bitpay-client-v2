<?php


namespace BitPaySDK\Model\Invoice;


class SupportedTransactionCurrency
{
    protected $_enabled;

    public function __construct()
    {
    }

    public function setEnabled(bool $enabled)
    {
        $this->_enabled = $enabled;
    }

    public function getEnabled()
    {
        return $this->_enabled;
    }

    public function toArray()
    {
        $elements = [
            'enabled' => $this->getEnabled(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}