<?php

namespace BitPaySDK\Test\Model\Subscription;

use BitPaySDK\Model\Subscription\BillData;
use BitPaySDK\Model\Subscription\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testInstanceOf()
    {
        $subscription = $this->createClassObject();
        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    public function testGetId()
    {
        $expectedId = '11';

        $subscription = $this->createClassObject();
        $subscription->setId($expectedId);
        $this->assertEquals($expectedId, $subscription->getId());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'pending';

        $subscription = $this->createClassObject();
        $subscription->setStatus($expectedStatus);
        $this->assertEquals($expectedStatus, $subscription->getStatus());
    }

    public function testGetBillData()
    {
        $expectedBillData = $this->getMockBuilder(BillData::class)
            ->disableOriginalConstructor()
            ->getMock();

        $subscription = $this->createClassObject();
        $subscription->setBillData($expectedBillData);
        $this->assertEquals($expectedBillData, $subscription->getBillData());
    }

    public function testGetSchedule()
    {
        $expectedSchedule = 'Test schedule';

        $subscription = $this->createClassObject();
        $subscription->setSchedule($expectedSchedule);
        $this->assertEquals($expectedSchedule, $subscription->getSchedule());
    }

    public function testGetNextDelivery()
    {
        $expectedNextDelivery = '2022-01-01';

        $subscription = $this->createClassObject();
        $subscription->setNextDelivery($expectedNextDelivery);
        $this->assertEquals($expectedNextDelivery, $subscription->getNextDelivery());
    }

    public function testGetCreatedDate()
    {
        $expectedCreatedDate = '2022-01-01';

        $subscription = $this->createClassObject();
        $subscription->setCreatedDate($expectedCreatedDate);
        $this->assertEquals($expectedCreatedDate, $subscription->getCreatedDate());
    }

    public function testGetToken()
    {
        $expectedToken = 'g73mv29b2b4njg23';

        $subscription = $this->createClassObject();
        $subscription->setToken($expectedToken);
        $this->assertEquals($expectedToken, $subscription->getToken());
    }

    public function testToArray()
    {
        $subscription = $this->createClassObject();
        $this->setSetters($subscription);
        $subscriptionArray = $subscription->toArray();

        $this->assertNotNull($subscriptionArray);
        $this->assertIsArray($subscriptionArray);

        $this->assertArrayHasKey('id', $subscriptionArray);
        $this->assertArrayHasKey('status', $subscriptionArray);
        $this->assertArrayNotHasKey('billData', $subscriptionArray);
        $this->assertArrayNotHasKey('schedule', $subscriptionArray);
        $this->assertArrayHasKey('nextDelivery', $subscriptionArray);
        $this->assertArrayHasKey('createdDate', $subscriptionArray);
        $this->assertArrayHasKey('token', $subscriptionArray);

        $this->assertEquals('1', $subscriptionArray['id']);
        $this->assertEquals('pending', $subscriptionArray['status']);
        $this->assertEquals('2022-01-01', $subscriptionArray['nextDelivery']);
        $this->assertEquals('2022-01-01', $subscriptionArray['createdDate']);
        $this->assertEquals('g73mv29b2b4njg23', $subscriptionArray['token']);
    }

    private function createClassObject(): Subscription
    {
        return new Subscription();
    }

    private function setSetters(Subscription $subscription)
    {
        $subscription->setId('1');
        $subscription->setStatus('pending');
        $subscription->setSchedule('');
        $subscription->setNextDelivery('2022-01-01');
        $subscription->setCreatedDate('2022-01-01');
        $subscription->setToken('g73mv29b2b4njg23');
    }
}
