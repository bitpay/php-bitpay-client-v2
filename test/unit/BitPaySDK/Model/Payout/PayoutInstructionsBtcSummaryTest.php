<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutInstructionBtcSummary;
use PHPUnit\Framework\TestCase;

class PayoutInstructionsBtcSummaryTest extends TestCase
{
  public function testInstanceOf()
  {
    $payout = $this->createClassObject();
    $this->assertInstanceOf(PayoutInstructionBtcSummary::class, $payout);
  }

  public function testGetPaid()
  {
    $expectedPaid = 1.23;

    $payoutInstructionBtcSummary = $this->createClassObject();
    $this->assertEquals($expectedPaid, $payoutInstructionBtcSummary->getPaid());
  }

  public function testGetUnPaid()
  {
    $expectedUnpaid = 4.56;

    $payoutInstructionBtcSummary = $this->createClassObject();
    $this->assertEquals($expectedUnpaid, $payoutInstructionBtcSummary->getUnpaid());
  }

  public function testToArray()
  {
    $payoutInstructionBtcSummary = $this->createClassObject();
    $payoutInstructionBtcSummaryArray = $payoutInstructionBtcSummary->toArray();

    $this->assertNotNull($payoutInstructionBtcSummaryArray);
    $this->assertIsArray($payoutInstructionBtcSummaryArray);

    $this->assertArrayHasKey('paid', $payoutInstructionBtcSummaryArray);
    $this->assertArrayHasKey('unpaid', $payoutInstructionBtcSummaryArray);

    $this->assertEquals($payoutInstructionBtcSummaryArray['paid'], 1.23);
    $this->assertEquals($payoutInstructionBtcSummaryArray['unpaid'], 4.56);
  }

  private function createClassObject()
  {
    $paid = 1.23;
    $unpaid = 4.56;
    return new PayoutInstructionBtcSummary($paid, $unpaid);
  }
}