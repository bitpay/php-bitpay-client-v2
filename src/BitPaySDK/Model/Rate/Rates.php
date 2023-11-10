<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Rate;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayExceptionProvider;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Exceptions\BitPayValidationException;
use BitPaySDK\Model\Currency;

/**
 * @package BitPaySDK\Model\Rate
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://bitpay.readme.io/reference/rates REST API Rates
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
     * @throws BitPayGenericException
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
     * @throws BitPayApiException
     * @throws BitPayGenericException
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
     * @throws BitPayValidationException
     */
    public function getRate(string $currencyCode): ?float
    {
        $val = null;

        if (!Currency::isValid($currencyCode)) {
            BitPayExceptionProvider::throwInvalidCurrencyException($currencyCode);
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
     * @throws BitPayGenericException
     */
    private function validateRates(array $rates): void
    {
        foreach ($rates as $rate) {
            if (!$rate instanceof Rate) {
                BitPayExceptionProvider::throwGenericExceptionWithMessage('Array should contains only Rate objects');
            }
        }
    }
}
