<?php

/**
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Rate;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;

/**
 * Class Rates
 * @package BitPaySDK\Model\Rate
 */
class Rates
{
    protected $_bp;
    protected $_rates;

    /**
     * Rates constructor.
     *
     * @param array $rates
     * @param Client $bp
     */
    public function __construct(array $rates, Client $bp)
    {
        $this->_bp = $bp;
        $this->_rates = $rates;
    }

    /**
     * Gets rates.
     *
     * @return array
     */
    public function getRates()
    {
        $rates = [];

        foreach ($this->_rates as $rate) {
            if ($rate instanceof Rate) {
                array_push($rates, $rate->toArray());
            } else {
                array_push($rates, $rate);
            }
        }

        return $rates;
    }

    /**
     * Update rates.
     *
     * @throws BitPayException
     */
    public function update()
    {
        $this->_rates = $this->_bp->getRates()->getRates();
    }

    /**
     * Gets rate for the requested currency code.
     *
     * @param string $currencyCode
     * @return float|null
     * @throws BitPayException
     */
    public function getRate(string $currencyCode)
    {
        $val = null;

        if (!Currency::isValid($currencyCode)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        foreach ($this->_rates as $rateObj) {
            if ($rateObj->getCode() == $currencyCode) {
                $val = $rateObj->getRate();
                break;
            }
        }

        return $val;
    }

    /**
     * Return an array with rates value.
     *
     * @return array[]
     */
    public function toArray()
    {
        $elements = [
            'rates' => $this->getRates(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
