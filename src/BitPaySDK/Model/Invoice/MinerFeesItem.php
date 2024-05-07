<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

/**
 * Class MinerFeesItem
 *
 * @package BitPaySDK\Model\Invoice
 * @author BitPay Integrations <integrations@bitpay.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see https://bitpay.readme.io/reference/invoices REST API Invoices
 */
class MinerFeesItem
{
    protected ?float $satoshisPerByte = null;
    protected ?int $totalFee = null;
    protected ?float $fiatAmount = null;

    public function __construct()
    {
    }

    public function getSatoshisPerByte(): ?float
    {
        return $this->satoshisPerByte;
    }

    public function setSatoshisPerByte(float $satoshisPerByte): void
    {
        $this->satoshisPerByte = $satoshisPerByte;
    }

    public function getTotalFee(): ?int
    {
        return $this->totalFee;
    }

    public function setTotalFee(int $totalFee): void
    {
        $this->totalFee = $totalFee;
    }

    public function getFiatAmount(): ?float
    {
        return $this->fiatAmount;
    }

    public function setFiatAmount(?float $fiatAmount): void
    {
        $this->fiatAmount = $fiatAmount;
    }

    public function toArray(): array
    {
        $elements = [
            'satoshisPerByte' => $this->getSatoshisPerByte(),
            'totalFee'        => $this->getTotalFee(),
            'fiatAmount'      => $this->getFiatAmount()
        ];

        foreach ($elements as $key => $value) {
            if (empty($value)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }
}
