<?php

declare(strict_types=1);

/*
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
    protected array $rates;

    /**
     * Rates constructor.
     *
     * @param array $rates
     */
    public function __construct(array $rates)
    {
        $this->rates = $rates;
    }

    /**
     * Gets rates.
     *
     * @return array
     */
    public function getRates(): array
    {
        $rates = [];

        foreach ($this->rates as $rate) {
            if ($rate instanceof Rate) {
                $rates[] = $rate->toArray();
            } else {
                $rates[] = $rate;
            }
        }

        return $rates;
    }

    /**
     * Update rates.
     *
     * @throws BitPayException
     */
    public function update(Client $bp): void
    {
        $this->rates = $bp->getRates()->getRates();
    }

    /**
     * Gets rate for the requested currency code.
     *
     * @param string $currencyCode
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
}
