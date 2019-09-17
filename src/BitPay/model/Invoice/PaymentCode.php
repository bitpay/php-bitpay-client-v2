<?php


namespace BitPay\Model\Invoice;


class PaymentCode
{
    protected $_bip72b;
    protected $_bip73;

    public function __construct()
    {
    }

    public function toArray()
    {
        $elements = [
            'bip72b' => $this->getBip72b(),
            'bip73'  => $this->getBip73(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }

    public function getBip72b()
    {
        return $this->_bip72b;
    }

    public function setBip72b(string $bip72b)
    {
        $this->_bip72b = $bip72b;
    }

    public function getBip73()
    {
        return $this->_bip73;
    }

    public function setBip73(string $bip73)
    {
        $this->_bip73 = $bip73;
    }
}