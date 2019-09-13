<?php

namespace Bitpay\Model\Invoice;

/**
 *
 * @package Bitpay
 */
class Buyer
{
    protected $_name;
    protected $_address1;
    protected $_address2;
    protected $_locality;
    protected $_region;
    protected $_postalCode;
    protected $_country;
    protected $_email;
    protected $_phone;
    protected $_notify;

    public function __construct() {
    }

    public function getName() {
        return $this->_name;
    }

    public function setName(string $name) {
        $this->_name = $name;
    }

    public function getAddress1() {
        return $this->_address1;
    }

    public function setAddress1(string $address1) {
        $this->_address1 = $address1;
    }

    public function getAddress2() {
        return $this->_address2;
    }

    public function setAddress2(string $address2) {
        $this->_address2 = $address2;
    }

    public function getLocality() {
        return $this->_locality;
    }

    public function setLocality(string $locality) {
        $this->_locality = $locality;
    }

    public function getRegion() {
        return $this->_region;
    }

    public function setRegion(string $region) {
        $this->_region = $region;
    }

    public function getPostalCode() {
        return $this->_postalCode;
    }

    public function setPostalCode(string $postalCode) {
        $this->_postalCode = $postalCode;
    }

    public function getCountry() {
        return $this->_country;
    }

    public function setCountry(string $country) {
        $this->_country = $country;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail(string $email) {
        $this->_email = $email;
    }

    public function getPhone() {
        return $this->_phone;
    }

    public function setPhone(string $phone) {
        $this->_phone = $phone;
    }

    public function getNotify() {
        return $this->_notify;
    }

    public function setNotify(boolean $notify) {
        $this->_notify = $notify;
    }
}
