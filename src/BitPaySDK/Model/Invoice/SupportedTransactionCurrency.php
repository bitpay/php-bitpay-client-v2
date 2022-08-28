<?php

namespace BitPaySDK\Model\Invoice;

class SupportedTransactionCurrency
{
    protected $_enabled;
    protected $_reason;

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

    public function setReason(string $reason)
    {
        $this->_reason = $reason;
    }

    public function getReason()
    {
        return $this->_reason;
    }

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
