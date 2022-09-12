<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\PayoutInstructionTransaction;
use PHPUnit\Framework\TestCase;

class PayoutInstructionTransactionTest extends TestCase
{
  public function testInstanceOf()
  {
    $payoutInstructionTransaction = $this->createClassObject();
    $this->assertInstanceOf(PayoutInstructionTransaction::class, $payoutInstructionTransaction);
  }

  public function testGetTxid()
  {
    $expectedTxid = 'db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057';
    
    $payoutInstructionTransaction = $this->createClassObject();
    $payoutInstructionTransaction->setTxId($expectedTxid);

    $this->assertEquals($expectedTxid, $payoutInstructionTransaction->getTxid());
  }

  public function testGetAmount()
  {
    $expectedAmount = 0.000254;

    $payoutInstructionTransaction = $this->createClassObject();
    $payoutInstructionTransaction->setAmount($expectedAmount);

    $this->assertEquals($expectedAmount, $payoutInstructionTransaction->getAmount());
  }

  public function testGetDate()
  {
    $expectedDate = '2021-05-27T11:04:23.155Z';

    $payoutInstructionTransaction = $this->createClassObject();
    $payoutInstructionTransaction->setDate($expectedDate);

    $this->assertEquals($expectedDate, $payoutInstructionTransaction->getDate());
  }

  public function testToArray()
  {
    $payoutInstructionTransaction = $this->createClassObject();
    $payoutInstructionTransaction->setTxid('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
    $payoutInstructionTransaction->setAmount(0.000254);
    $payoutInstructionTransaction->setDate('2021-05-27T11:04:23.155Z');
    $payoutInstructionTransactionArray = $payoutInstructionTransaction->toArray();

    $this->assertNotNull($payoutInstructionTransactionArray);
    $this->assertIsArray($payoutInstructionTransactionArray);

    $this->assertArrayHasKey('txid', $payoutInstructionTransactionArray);
    $this->assertArrayHasKey('amount', $payoutInstructionTransactionArray);
    $this->assertArrayHasKey('date', $payoutInstructionTransactionArray);

    $this->assertEquals($payoutInstructionTransactionArray['txid'], 'db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
    $this->assertEquals($payoutInstructionTransactionArray['amount'], 0.000254);
    $this->assertEquals($payoutInstructionTransactionArray['date'], '2021-05-27T11:04:23.155Z');
  }

  private function createClassObject()
  {
    return new PayoutInstructionTransaction();
  }
}