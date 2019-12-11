<?php


namespace BitPaySDK\Model\Invoice;


class PaymentCode
{
    protected $_bip72b;
    protected $_bip73;
    protected $_eip681;
    protected $_eip681b;

    public function __construct()
    {
    }

    public function toArray()
    {
        $elements = [
            'bip72b'  => $this->getBip72b(),
            'bip73'   => $this->getBip73(),
            'eip681'  => $this->getEip681(),
            'eip681b' => $this->getEip681b(),
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

    public function getEip681()
    {
        return $this->_eip681;
    }

    public function setEip681(string $eip681)
    {
        $this->_eip681 = $eip681;
    }

    public function getEip681b()
    {
        return $this->_eip681b;
    }

    public function setEip681b(string $eip681b)
    {
        $this->_eip681b = $eip681b;
    }
}