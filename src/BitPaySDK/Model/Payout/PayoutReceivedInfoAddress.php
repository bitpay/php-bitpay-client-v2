<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Payout;

/**
 *
 * @package Bitpay
 */
class PayoutReceivedInfoAddress
{
    protected $address1;
    protected $address2;
    protected $locality;
    protected $region;
    protected $postalCode;
    protected $country;

    /**
     * PayoutReceivedInfoAddress constructor.
     */
    public function __construct()
    {
    }

    /**
     * Gets recipient's address
     *
     * @return string|null
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Sets recipient's address
     *
     * @param string $address1
     */
    public function setAddress1(string $address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Gets recipient's address
     *
     * @return string|null
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Sets recipient's address
     *
     * @param string $address2
     */
    public function setAddress2(string $address2)
    {
        $this->address2 = $address2;
    }

    /**
     * gets city or locality.
     *
     * @return string|null
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Sets city or locality.
     *
     * @param string $locality
     */
    public function setLocality(string $locality)
    {
        $this->locality = $locality;
    }

    /**
     * Gets state or province.
     *
     * @return string|null
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Sets state or province.
     *
     * @param string $region
     */
    public function setRegion(string $region)
    {
        $this->region = $region;
    }

    /**
     * Gets Zip or Postal Code.
     *
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Sets Zip or Postal Code.
     *
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Gets Country code. Format ISO 3166-1 alpha-2.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets Country code. Format ISO 3166-1 alpha-2.
     *
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * Return an array with values of all fields.
     *
     * @return array
     */
    public function toArray()
    {
        $elements = [
            'address1'   => $this->getAddress1(),
            'address2'   => $this->getAddress2(),
            'locality'   => $this->getLocality(),
            'region'     => $this->getRegion(),
            'postalCode' => $this->getPostalCode(),
            'country'    => $this->getCountry(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
