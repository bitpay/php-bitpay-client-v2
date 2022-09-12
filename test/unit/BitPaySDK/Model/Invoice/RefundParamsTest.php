<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\RefundParams;
use PHPUnit\Framework\TestCase;

class RefundParamsTest extends TestCase
{
    public function testInstanceOf()
    {
        $refundParams = $this->createClassObject();
        $this->assertInstanceOf(RefundParams::class, $refundParams);
    }

    public function testGetRequesterType()
    {
        $expectedRequesterType = 'Test requester type';

        $refundParams = $this->createClassObject();
        $refundParams->setRequesterType($expectedRequesterType);
        $this->assertEquals($expectedRequesterType, $refundParams->getRequesterType());
    }

    public function testGetRequesterEmail()
    {
        $expectedRequesterEmail = 'test@email.com';

        $refundParams = $this->createClassObject();
        $refundParams->setRequesterEmail($expectedRequesterEmail);
        $this->assertEquals($expectedRequesterEmail, $refundParams->getRequesterEmail());
    }

    public function testGetAmount()
    {
        $expectedAmount = 15.0;

        $refundParams = $this->createClassObject();
        $refundParams->setAmount($expectedAmount);
        $this->assertEquals($expectedAmount, $refundParams->getAmount());
    }

    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $refundParams = $this->createClassObject();
        $refundParams->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $refundParams->getCurrency());
    }

    public function testGetEmail()
    {
        $expectedEmail = 'test@email.com';

        $refundParams = $this->createClassObject();
        $refundParams->setEmail($expectedEmail);
        $this->assertEquals($expectedEmail, $refundParams->getEmail());
    }

    public function testGetPurchaserNotifyEmail()
    {
        $expectedPurchaserNotifyEmail = 'test@email.com';

        $refundParams = $this->createClassObject();
        $refundParams->setPurchaserNotifyEmail($expectedPurchaserNotifyEmail);
        $this->assertEquals($expectedPurchaserNotifyEmail, $refundParams->getPurchaserNotifyEmail());
    }

    public function testGetRefundAddress()
    {
        $expectedRefundAddress = 'Test refund address';

        $refundParams = $this->createClassObject();
        $refundParams->setRefundAddress($expectedRefundAddress);
        $this->assertEquals($expectedRefundAddress, $refundParams->getRefundAddress());
    }

    public function testGetSupportRequestEid()
    {
        $expectedSupportRequestEid = 'Test support request eid';

        $refundParams = $this->createClassObject();
        $refundParams->setSupportRequestEid($expectedSupportRequestEid);
        $this->assertEquals($expectedSupportRequestEid, $refundParams->getSupportRequestEid());
    }

    public function testToArray()
    {
        $refundParams = $this->createClassObject();
        $this->setSetters($refundParams);
        $refundParamsArray = $refundParams->toArray();

        $this->assertNotNull($refundParamsArray);
        $this->assertIsArray($refundParamsArray);

        $this->assertArrayHasKey('requesterType', $refundParamsArray);
        $this->assertArrayHasKey('requesterEmail', $refundParamsArray);
        $this->assertArrayHasKey('amount', $refundParamsArray);
        $this->assertArrayHasKey('currency', $refundParamsArray);
        $this->assertArrayHasKey('email', $refundParamsArray);
        $this->assertArrayHasKey('purchaserNotifyEmail', $refundParamsArray);
        $this->assertArrayHasKey('refundAddress', $refundParamsArray);

        $this->assertEquals($refundParamsArray['requesterType'], 'Requester type');
        $this->assertEquals($refundParamsArray['requesterEmail'], 'test@email.com');
        $this->assertEquals($refundParamsArray['amount'], 15);
        $this->assertEquals($refundParamsArray['currency'], 'BTC');
        $this->assertEquals($refundParamsArray['email'], 'test@email.com');
        $this->assertEquals($refundParamsArray['purchaserNotifyEmail'], 'test@email.com');
        $this->assertEquals($refundParamsArray['refundAddress'], 'Refund address');
    }

    private function createClassObject()
    {
        return new RefundParams();
    }

    private function setSetters(RefundParams $refundParams)
    {
        $refundParams->setRequesterType('Requester type');
        $refundParams->setRequesterEmail('test@email.com');
        $refundParams->setAmount(15);
        $refundParams->setCurrency('BTC');
        $refundParams->setEmail('test@email.com');
        $refundParams->setPurchaserNotifyEmail('test@email.com');
        $refundParams->setRefundAddress('Refund address');
    }
}
