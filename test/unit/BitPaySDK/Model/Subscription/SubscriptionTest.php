<?php

/**
 * Copyright (c) 2025 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Test\Unit\Model\Subscription;

use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Model\Subscription\SubscriptionStatus;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testInstanceOf(): void
    {
        $subscription = new Subscription();

        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    public function testConstructorWithBill(): void
    {
        $items = [];
        $item = new Item();
        $item->setPrice(10.0);
        $item->setQuantity(1);
        $items[] = $item;

        $bill = new Bill('testNumber', 'USD', 'test@example.com', $items);
        $dueDate = (new \DateTime('now'))->format('Y-m-d\TH:i:s\Z');
        $bill->setDueDate($dueDate);

        $subscription = new Subscription($bill);

        $this->assertEquals($bill, $subscription->getBillData());
    }

    public function testBillDataGetterSetter(): void
    {
        $subscription = new Subscription();

        $items = [];
        $item = new Item();
        $item->setPrice(10.0);
        $item->setQuantity(1);
        $items[] = $item;

        $bill = new Bill('testNumber', 'USD', 'test@example.com', $items);
        $dueDate = (new \DateTime('now'))->format('Y-m-d\TH:i:s\Z');
        $bill->setDueDate($dueDate);

        $subscription->setBillData($bill);

        $this->assertEquals($bill, $subscription->getBillData());
        $this->assertEquals('testNumber', $subscription->getBillData()->getNumber());
        $this->assertEquals('USD', $subscription->getBillData()->getCurrency());
    }

    public function testStatusGetterSetter(): void
    {
        $subscription = new Subscription();
        $subscription->setStatus(SubscriptionStatus::ACTIVE);

        $this->assertEquals(SubscriptionStatus::ACTIVE, $subscription->getStatus());
    }

    public function testToArray(): void
    {
        $items = [];
        $item = new Item();
        $item->setPrice(10.0);
        $item->setQuantity(1);
        $items[] = $item;

        $bill = new Bill('testNumber', 'USD', 'test@example.com', $items);

        $subscription = new Subscription($bill);
        $subscription->setId('testId');
        $subscription->setStatus(SubscriptionStatus::ACTIVE);

        $result = $subscription->toArray();

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('billData', $result);
        $this->assertEquals('testId', $result['id']);
        $this->assertEquals(SubscriptionStatus::ACTIVE, $result['status']);
    }
}
