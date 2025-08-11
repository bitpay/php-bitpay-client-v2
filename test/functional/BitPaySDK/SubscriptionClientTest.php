<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Model\Subscription\SubscriptionSchedule;
use BitPaySDK\Model\Subscription\SubscriptionStatus;

class SubscriptionClientTest extends AbstractClientTestCase
{
    public function testCreateSubscription(): void
    {
        $subscription = $this->getSubscriptionExample();
        $subscription = $this->client->createSubscription($subscription);

        self::assertEquals(SubscriptionStatus::DRAFT, $subscription->getStatus());

        $this->assertValidMonthlySchedule($subscription->getSchedule());

        self::assertEquals(3.0, $subscription->getBillData()->getItems()[0]->getPrice());
        self::assertEquals(2, $subscription->getBillData()->getItems()[0]->getQuantity());
        self::assertEquals(1, $subscription->getBillData()->getItems()[1]->getQuantity());
        self::assertEquals(7.0, $subscription->getBillData()->getItems()[1]->getPrice());
        self::assertEquals("Test Item 1", $subscription->getBillData()->getItems()[0]->getDescription());
        self::assertEquals("Test Item 2", $subscription->getBillData()->getItems()[1]->getDescription());
        self::assertEquals(Currency::USD, $subscription->getBillData()->getCurrency());
    }

    public function testGetSubscription(): void
    {
        $subscription = $this->getSubscriptionExample();
        $subscription = $this->client->createSubscription($subscription);
        $subscription = $this->client->getSubscription($subscription->getId());

        self::assertEquals(SubscriptionStatus::DRAFT, $subscription->getStatus());

        $this->assertValidMonthlySchedule($subscription->getSchedule());

        self::assertCount(2, $subscription->getBillData()->getItems());
        self::assertEquals(Currency::USD, $subscription->getBillData()->getCurrency());
        self::assertEquals('billData1234-ABCD', $subscription->getBillData()->getNumber());
        self::assertEquals('john.doe@example.com', $subscription->getBillData()->getEmail());
    }

    public function testGetSubscriptions(): void
    {
        $subscriptions = $this->client->getSubscriptions();

        self::assertNotNull($subscriptions);
        self::assertIsArray($subscriptions);
        $isCount = count($subscriptions) > 0;
        self::assertTrue($isCount);
    }

    public function testUpdateSubscription(): void
    {
        $subscription = $this->getSubscriptionExample();
        $subscription = $this->client->createSubscription($subscription);

        // Store original values for comparison after update
        $originalId = $subscription->getId();
        $originalStatus = $subscription->getStatus();
        $originalCurrency = $subscription->getBillData()->getCurrency();
        $originalNumber = $subscription->getBillData()->getNumber();

        $subscription = $this->client->getSubscription($subscription->getId());

        // Update multiple fields
        $bill = $subscription->getBillData();
        $bill->setEmail("jane.doe@example.com");
        $bill->setName("Updated Company Name");
        $bill->setCC(["jane.doe@example.com"]);
        $bill->setPhone("555-0100");

        // Update an item price
        $items = $bill->getItems();
        $items[0]->setPrice(5.0); // Change first item price from 3.0 to 5.0
        $bill->setItems($items);

        $subscription->setBillData($bill);

        $subscription = $this->client->updateSubscription($subscription, $subscription->getId());

        // Assert updated fields
        self::assertEquals("jane.doe@example.com", $subscription->getBillData()->getEmail());
        self::assertEquals("Updated Company Name", $subscription->getBillData()->getName());
        self::assertEquals(["jane.doe@example.com"], $subscription->getBillData()->getCc());
        self::assertEquals("555-0100", $subscription->getBillData()->getPhone());
        self::assertEquals(5.0, $subscription->getBillData()->getItems()[0]->getPrice());

        // Assert that other important fields weren't changed
        self::assertEquals($originalId, $subscription->getId(), "Subscription ID should not change after update");
        self::assertEquals($originalStatus, $subscription->getStatus(), "Subscription status should not change");
        self::assertEquals($originalCurrency, $subscription->getBillData()->getCurrency(), "Currency should not change");
        self::assertEquals($originalNumber, $subscription->getBillData()->getNumber(), "Bill number should be preserved");
        self::assertEquals(2, count($subscription->getBillData()->getItems()), "Item count should be preserved");
        self::assertEquals(2, $subscription->getBillData()->getItems()[0]->getQuantity(), "Item quantity should be preserved");
    }

    private function getSubscriptionExample(): Subscription
    {
        return new Subscription($this->getBillDataExample());
    }

    private function getBillDataExample(): Bill
    {
        $items = [];
        $item = new Item();
        $item->setPrice(3.0);
        $item->setQuantity(2);
        $item->setDescription("Test Item 1");
        $items[] = $item;

        $item = new Item();
        $item->setPrice(7.0);
        $item->setQuantity(1);
        $item->setDescription("Test Item 2");
        $items[] = $item;

        $bill = new Bill("billData1234-ABCD", Currency::USD, "john.doe@example.com", $items);

        $dueDate = (new \DateTime('first day of next month'));
        $bill->setDueDate($dueDate->format('Y-m-d\TH:i:s\Z'));

        return $bill;
    }

    /**
     * Helper method to validate if a schedule is a valid monthly schedule (either 'monthly' or a cron expression)
     *
     * @param string $schedule The schedule to validate
     */
    private function assertValidMonthlySchedule(string $schedule): void
    {
        if ($schedule === SubscriptionSchedule::MONTHLY) {
            return; // Standard monthly string is valid
        }

        $parts = explode(' ', $schedule);

        // A proper cron expression should have 6 parts: second minute hour dayOfMonth month dayOfWeek
        if (count($parts) !== 6) {
            self::fail("Invalid cron expression format: " . $schedule);
        }

        [$second, $minute, $hour, $dayOfMonth, $month, $dayOfWeek] = $parts;

        // Validate time parts are within range
        self::assertGreaterThanOrEqual(0, (int)$second, "Second must be ≥ 0: " . $schedule);
        self::assertLessThanOrEqual(59, (int)$second, "Second must be ≤ 59: " . $schedule);

        self::assertGreaterThanOrEqual(0, (int)$minute, "Minute must be ≥ 0: " . $schedule);
        self::assertLessThanOrEqual(59, (int)$minute, "Minute must be ≤ 59: " . $schedule);

        self::assertGreaterThanOrEqual(0, (int)$hour, "Hour must be ≥ 0: " . $schedule);
        self::assertLessThanOrEqual(23, (int)$hour, "Hour must be ≤ 23: " . $schedule);

        self::assertGreaterThanOrEqual(1, (int)$dayOfMonth, "Day of month must be ≥ 1: " . $schedule);
        self::assertLessThanOrEqual(28, (int)$dayOfMonth, "Day of month must be ≤ 28: " . $schedule);

        self::assertEquals('*', $month, "Month must be * for monthly schedule: " . $schedule);
        self::assertEquals('*', $dayOfWeek, "Day of week must be * for monthly schedule: " . $schedule);
    }
}
