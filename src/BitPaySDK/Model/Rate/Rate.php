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

/**
 * Class Rate
 * @package BitPaySDK\Model\Rate
 * @see <a href="https://bitpay.readme.io/reference/rates">REST API Rates</a>
 */
class Rate
{
    protected ?string $name = null;
    protected ?string $code = null;
    protected ?float $rate = null;

    public function __construct()
    {
    }

    /**
     * Gets detailed currency name
     *
     * @return string|null the name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets detailed currency name
     *
     * @param string $name the name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets ISO 4217 3-character currency code
     *
     * @return string|null the code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Sets ISO 4217 3-character currency code
     *
     * @param string $code the code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Gets rate for the requested baseCurrency /currency pair
     *
     * @return float|null the rate
     */
    public function getRate(): ?float
    {
        return $this->rate;
    }

    /**
     * Sets rate for the requested baseCurrency /currency pair
     *
     * @param float $rate the rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * Gets Rate as array
     *
     * @return array Rate as array
     */
    public function toArray(): array
    {
        $elements = [
            'name' => $this->getName(),
            'code' => $this->getCode(),
            'rate' => $this->getRate(),
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
