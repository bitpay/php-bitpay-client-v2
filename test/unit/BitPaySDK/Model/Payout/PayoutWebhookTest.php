<?php

declare(strict_types=1);

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutWebhook;
use PHPUnit\Framework\TestCase;

class PayoutWebhookTest extends TestCase
{
    public function testModifyCurrency(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setCurrency($expected);
        
        self::assertEquals($expected, $testedClass->getCurrency());
    }
    
    public function testModifyEffectiveDate(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setEffectiveDate($expected);
        
        self::assertEquals($expected, $testedClass->getEffectiveDate());
    }
    
    public function testModifyEmail(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setEmail($expected);
        
        self::assertEquals($expected, $testedClass->getEmail());
    }
    
    public function testModifyExchangeRates(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = [];
        $testedClass->setExchangeRates($expected);
        
        self::assertEquals($expected, $testedClass->getExchangeRates());
    }
    
    public function testModifyId(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setId($expected);
        
        self::assertEquals($expected, $testedClass->getId());
    }
    
    public function testModifyLabel(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setLabel($expected);
        
        self::assertEquals($expected, $testedClass->getLabel());
    }
    
    public function testModifyLedgerCurrency(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setLedgerCurrency($expected);
        
        self::assertEquals($expected, $testedClass->getLedgerCurrency());
    }
    
    public function testModifyNotificationEmail(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setNotificationEmail($expected);
        
        self::assertEquals($expected, $testedClass->getNotificationEmail());
    }
    
    public function testModifyNotificationURL(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setNotificationURL($expected);
        
        self::assertEquals($expected, $testedClass->getNotificationURL());
    }
    
    public function testModifyPrice(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 12.67;
        $testedClass->setprice($expected);
        
        self::assertEquals($expected, $testedClass->getPrice());
    }
    
    public function testModifyRecipientId(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setRecipientId($expected);
        
        self::assertEquals($expected, $testedClass->getRecipientId());
    }
    
    public function testModifyReference(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setReference($expected);
        
        self::assertEquals($expected, $testedClass->getReference());
    }
    
    public function testModifyRequestDate(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setRequestDate($expected);
        
        self::assertEquals($expected, $testedClass->getRequestDate());
    }
    
    public function testModifyShopperId(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setShopperId($expected);
        
        self::assertEquals($expected, $testedClass->getShopperId());
    }
    
    public function testModifyStatus(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setStatus($expected);
        
        self::assertEquals($expected, $testedClass->getStatus());
    }
    
    public function testModifyTransactions(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = [];
        $testedClass->setTransactions($expected);
        
        self::assertEquals($expected, $testedClass->getTransactions());
    }

    private function getTestedClass(): PayoutWebhook
    {
        return new PayoutWebhook();
    }
}
