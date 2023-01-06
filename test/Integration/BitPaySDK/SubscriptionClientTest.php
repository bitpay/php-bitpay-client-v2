<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Model\Subscription\BillData;
use BitPaySDK\Model\Subscription\Item;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Model\Subscription\SubscriptionStatus;
use PHPUnit\Framework\TestCase;

class SubscriptionClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile('src/BitPaySDK/config.yml');
    }

    public function testCreateSubscription(): void
    {
        $subscription = $this->getSubscriptionExample();
        $basicSubscription = $this->client->createSubscription($subscription);

        $this->assertEquals(30.0, $basicSubscription->getBillData()->getItems()[0]->getPrice());
        $this->assertEquals(9, $basicSubscription->getBillData()->getItems()[0]->getQuantity());
        $this->assertEquals('product-a', $basicSubscription->getBillData()->getItems()[0]->getDescription());

        $this->assertEquals(14.0, $basicSubscription->getBillData()->getItems()[1]->getPrice());
        $this->assertEquals(16, $basicSubscription->getBillData()->getItems()[1]->getQuantity());
        $this->assertEquals('product-b', $basicSubscription->getBillData()->getItems()[1]->getDescription());

        $this->assertEquals('john@doe.com', $basicSubscription->getBillData()->getEmail());
        $this->assertEquals('USD', $basicSubscription->getBillData()->getCurrency());
    }

    public function testGetSubscription(): void
    {
        $subscriptions = $this->client->getSubscriptions(SubscriptionStatus::Draft);
        $subscription = $subscriptions[0];

        $basicSubscription = $this->client->getSubscription($subscription->getId());
        $this->assertEquals('john@doe.com', $basicSubscription->getBillData()->getEmail());
        $this->assertEquals('draft', $basicSubscription->getStatus());
        $this->assertEquals('USD', $basicSubscription->getBillData()->getCurrency());
        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertNotNull($subscription);
    }

    public function testGetSubscriptions(): void
    {
        $subscriptions = $this->client->getSubscriptions(SubscriptionStatus::Draft);

        $this->assertTrue(is_array($subscriptions));
        $this->assertNotNull($subscriptions);
        $this->assertTrue(count($subscriptions) > 0);
        $this->assertNotEmpty($subscriptions);
    }

    public function testUpdateSubscription(): void
    {
        $subscription = $this->getSubscriptionExample();
        $basicSubscription = $this->client->createSubscription($subscription);
        $items = $basicSubscription->getBillData()->getItems();
        $item = new Item();
        $item->setPrice(60);
        $item->setQuantity(7);
        $item->setDescription("product-added");
        array_push($items, $item);
        $basicSubscription->getBillData()->setItems($items);;

        $updateSubscription = $this->client->updateSubscription($basicSubscription, $basicSubscription->getId());

        $this->assertCount(3, $updateSubscription->getBillData()->getItems());
        $this->assertEquals('product-added', $updateSubscription->getBillData()->getItems()[2]->getDescription());
        $this->assertEquals(60, $updateSubscription->getBillData()->getItems()[2]->getPrice());
        $this->assertEquals(7, $updateSubscription->getBillData()->getItems()[2]->getQuantity());
    }

    private function getSubscriptionExample(): Subscription
    {
        $items = [];

        $item = new Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $date = new \DateTime();
        $date->modify('+1 month');
        $dueDate = $date->format("Y-m-d");

        $billData = new BillData(
            \BitPaySDK\Model\Currency::USD,
            "john@doe.com",
            $dueDate,
            $items
        );

        $subscription = new Subscription();
        $subscription->setBillData($billData);
        $subscription->setSchedule("weekly");

        return $subscription;
    }
}