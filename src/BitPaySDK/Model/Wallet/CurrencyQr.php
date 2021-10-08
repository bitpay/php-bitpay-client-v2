<?php

namespace BitPaySDK\Model\Wallet;

class CurrencyQr{

    protected $_type;
    protected $_collapsed;

    public function __construct()
    {
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setType(string $type)
    {
        $this->_type = $type;
    }

    public function getCollapsed()
    {
        return $this->_collapsed;
    }

    public function setCollapsed(bool $collapsed)
    {
        $this->_collapsed = $collapsed;
    }

    public function toArray()
    {
        $elements = [
            'type'          => $this->getType(),
            'collapsed'     => $this->getCollapsed(),
        ];

        return $elements;
    }

}
