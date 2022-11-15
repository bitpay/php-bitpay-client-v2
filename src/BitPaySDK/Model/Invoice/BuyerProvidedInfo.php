<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Invoice;

/**
 * Information collected from the buyer during the process of paying an invoice. Initially this object is empty.
 */
class BuyerProvidedInfo
{
    protected $_name;
    protected $_phoneNumber;
    protected $_selectedWallet;
    protected $_emailAddress;
    protected $_selectedTransactionCurrency;
    protected $_sms;
    protected $_smsVerified;

    public function __construct()
    {
    }

    /**
     * Gets name
     *
     * Populated with the buyer's name address if passed in the buyer object by the merchant
     *
     * @return string the name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets name
     *
     * Populated with the buyer's name address if passed in the buyer object by the merchant
     *
     * @param string $name the name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Gets phone number
     *
     * Populated with the buyer's phone number if passed in the buyer object by the merchant
     *
     * @return string the phone number
     */
    public function getPhoneNumber()
    {
        return $this->_phoneNumber;
    }

    /**
     * Sets phone number
     *
     * Populated with the buyer's phone number if passed in the buyer object by the merchant
     *
     * @param string $phoneNumber the phone number
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->_phoneNumber = $phoneNumber;
    }

    /**
     * Gets selected wallet
     *
     * This field contains the name of the cryptocurrency wallet selected by the shopper to complete the payment.
     *
     * @return string the selected wallet
     */
    public function getSelectedWallet()
    {
        return $this->_selectedWallet;
    }

    /**
     * Sets selected wallet
     *
     * This field contains the name of the cryptocurrency wallet selected by the shopper to complete the payment.
     *
     * @param string $selectedWallet the selected wallet
     */
    public function setSelectedWallet(string $selectedWallet)
    {
        $this->_selectedWallet = $selectedWallet;
    }

    /**
     * Gets email address
     *
     * Populated with the buyer's email address if passed in the buyer object,
     * otherwise this field is not returned in the response.
     *
     * @return string the email address
     */
    public function getEmailAddress()
    {
        return $this->_emailAddress;
    }

    /**
     * Sets email address
     *
     * Populated with the buyer's email address if passed in the buyer object,
     * otherwise this field is not returned in the response.
     *
     * @param string $emailAddress the email address
     */
    public function setEmailAddress($emailAddress)
    {
        $this->_emailAddress = $emailAddress;
    }

    /**
     * Gets selected transaction currency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @return string the selected transaction currency
     */
    public function getSelectedTransactionCurrency()
    {
        return $this->_selectedTransactionCurrency;
    }

    /**
     * Sets selected transaction currency
     *
     * This field will be populated with the cryptocurrency selected to pay the BitPay invoice,
     * current supported values are "BTC", "BCH", "ETH", "GUSD", "PAX", "BUSD", "USDC", "XRP", "DOGE", "DAI" and "WBTC".
     * If not yet selected, this field will not be returned.
     *
     * @param string $selectedTransactionCurrency the selected transaction currency
     */
    public function setSelectedTransactionCurrency(string $selectedTransactionCurrency)
    {
        $this->_selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    /**
     * Gets sms
     *
     * SMS provided by user for communications. This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @return string the sms
     */
    public function getSms()
    {
        return $this->_sms;
    }

    /**
     * Sets sms
     *
     * SMS provided by user for communications. This is only used for instances where a buyers email
     * (primary form of buyer communication) is can not be gathered.
     *
     * @param string $sms the sms
     */
    public function setSms(string $sms)
    {
        $this->_sms = $sms;
    }

    /**
     * Gets verification status of SMS (ie. have they passed the challenge).
     *
     * @return bool the sms verified
     */
    public function getSmsVerified()
    {
        return $this->_smsVerified;
    }

    /**
     * Sets verification status of SMS (ie. have they passed the challenge).
     *
     * @param bool $smsVerfied the sms verified
     */
    public function setSmsVerified(bool $smsVerfied)
    {
        $this->_smsVerified = $smsVerfied;
    }

    /**
     * Gets BuyerProvidedInfo as array
     *
     * @return array BuyerProvidedInfo as array
     */
    public function toArray()
    {
        $elements = [
            'name'                        => $this->getName(),
            'phoneNumber'                 => $this->getPhoneNumber(),
            'selectedWallet'              => $this->getSelectedWallet(),
            'emailAddress'                => $this->getEmailAddress(),
            'selectedTransactionCurrency' => $this->getSelectedTransactionCurrency(),
            'sms'                         => $this->getSms(),
            'smsVerified'                 => $this->getSmsVerified(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
