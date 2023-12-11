<?php

declare(strict_types=1);

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\BuyerFields;
use BitPaySDK\Model\Invoice\InvoiceWebhook;
use PHPUnit\Framework\TestCase;

class InvoiceWebhookTest extends TestCase
{
    public function testManipulateAmountPaid(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 12.23;
        $testedClass->setAmountPaid($expected);
        self::assertEquals($expected, $testedClass->getamountPaid());
    }

    public function testManipulateBuyerFields(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = new BuyerFields();
        $testedClass->setBuyerFields($expected);
        self::assertEquals($expected, $testedClass->getbuyerFields());
    }

    public function testManipulateCurrency(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setCurrency($expected);
        self::assertEquals($expected, $testedClass->getCurrency());
    }

    public function testManipulateCurrencyTime(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setCurrencyTime($expected);
        self::assertEquals($expected, $testedClass->getCurrencyTime());
    }

    public function testManipulateExceptionStatus(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setExceptionStatus($expected);
        self::assertEquals($expected, $testedClass->getExceptionStatus());
    }

    public function testManipulateExchangeRates(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = [];
        $testedClass->setExchangeRates($expected);
        self::assertEquals($expected, $testedClass->getExchangeRates());
    }

    public function testManipulateId(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setid($expected);
        self::assertEquals($expected, $testedClass->getId());
    }

    public function testManipulateInvoiceTime(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setInvoiceTime($expected);
        self::assertEquals($expected, $testedClass->getInvoiceTime());
    }

    public function testManipulateOrderId(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setOrderId($expected);
        self::assertEquals($expected, $testedClass->getOrderId());
    }

    public function testManipulate_paymentSubtotals(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = [];
        $testedClass->setPaymentSubtotals($expected);
        self::assertEquals($expected, $testedClass->getPaymentSubtotals());
    }

    public function testManipulatePaymentTotals(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = [];
        $testedClass->setPaymentTotals($expected);
        self::assertEquals($expected, $testedClass->getPaymentTotals());
    }

    public function testManipulatePosData(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setPosData($expected);
        self::assertEquals($expected, $testedClass->getPosData());
    }

    public function testManipulatePrice(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 123.78;
        $testedClass->setPrice($expected);
        self::assertEquals($expected, $testedClass->getPrice());
    }

    public function testManipulateStatus(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setStatus($expected);
        self::assertEquals($expected, $testedClass->getStatus());
    }

    public function testManipulateTransactionCurrency(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setTransactionCurrency($expected);
        self::assertEquals($expected, $testedClass->getTransactionCurrency());
    }

    public function testManipulateUrl(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setUrl($expected);
        self::assertEquals($expected, $testedClass->getUrl());
    }

    private function getTestedClass(): InvoiceWebhook
    {
        return new InvoiceWebhook();
    }
}
