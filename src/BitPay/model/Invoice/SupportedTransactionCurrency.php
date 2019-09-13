<?php


namespace BitPay\model\Invoice;


class SupportedTransactionCurrency
{
    protected $_enabled;

    public function __construct() {
    }

    public function getEnabled() {
        return $this->_enabled;
    }

    public function setNotify(bool $enabled) {
        $this->_enabled = $enabled;
    }
}