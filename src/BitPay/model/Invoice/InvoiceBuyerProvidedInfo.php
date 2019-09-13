<?php


namespace BitPay\Model\Invoice;


class InvoiceBuyerProvidedInfo
{
    protected $_name;
    protected $_phoneNumber;
    protected $_emailAddress;

    public function __construct() {
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getPhoneNumber() {
        return $this->_phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->_phoneNumber = $phoneNumber;
    }

    public function getEmailAddress() {
        return $this->_emailAddress;
    }

    public function setEmailAddress($emailAddress) {
        $this->_emailAddress = $emailAddress;
    }
}