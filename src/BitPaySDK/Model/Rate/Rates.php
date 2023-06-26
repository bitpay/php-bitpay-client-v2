<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

/*
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace BitPaySDK\Model\Rate;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\RateException;
use BitPaySDK\Model\Currency;

/**
 * Class Rates
 * @package BitPaySDK\Model\Rate
 * @see <a href="https://bitpay.readme.io/reference/rates">REST API Rates</a>
 */
class Rates
{
    /**
     * @var array Rate[]
     */
    protected array $rates;

    /**
     * Rates constructor.
     *
     * @param array $rates Rate[]
     * @throws BitPayException
     */
    public function __construct(array $rates)
    {
        $this->validateRates($rates);
        $this->rates = $rates;
    }

    /**
     * Gets rates.
     *
     * @return array Rate[]
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    /**
     * Update rates.
     *
     * @throws BitPayException
     */
    public function update(Client $bp): void
    {
        $rates = $bp->getRates()->getRates();
        $this->validateRates($rates);

        $this->rates = $rates;
    }

    /**
     * Gets rate for the requested currency code.
     *
     * @param string $currencyCode 3-character currency code
     * @return float|null
     * @throws BitPayException
     */
    public function getRate(string $currencyCode): ?float
    {
        $val = null;

        if (!Currency::isValid($currencyCode)) {
            throw new BitPayException("currency code must be a type of Model.Currency");
        }

        foreach ($this->rates as $rateObj) {
            if ($rateObj->getCode() === $currencyCode) {
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
    public function toArray(): array
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

    /**
     * @param array $rates
     * @throws BitPayException
     */
    private function validateRates(array $rates): void
    {
        foreach ($rates as $rate) {
            if (!$rate instanceof Rate) {
                throw new RateException('Array should contains only Rate objects');
            }
        }
    }
}
