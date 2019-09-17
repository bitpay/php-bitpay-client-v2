<?php


namespace BitPay\model\Invoice;


class SupportedTransactionCurrency
{
    protected $_enabled;

    public function __construct()
    {
    }

    public function setNotify(bool $enabled)
    {
        $this->_enabled = $enabled;
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

    public function getEnabled()
    {
        return $this->_enabled;
    }
}