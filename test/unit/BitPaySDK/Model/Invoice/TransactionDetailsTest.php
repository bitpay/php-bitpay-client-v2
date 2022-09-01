<?php

namespace BitPaySDK\Test;

use BitPaySDK\Model\Invoice\TransactionDetails;
use PHPUnit\Framework\TestCase;

class TransactionDetailsTest extends TestCase
{
  public function testInstanceOf()
  {
    $transactionDetails = $this->createClassObject();
    $this->assertInstanceOf(TransactionDetails::class, $transactionDetails);
  }

  public function testGetAmount()
  {
    $expectedAmount = 4.56;

    $transactionDetails = $this->createClassObject();
    $transactionDetails->setAmount($expectedAmount);
    $this->assertEquals($expectedAmount, $transactionDetails->getAmount());
  }

  public function testGetDescription()
  {
    $expectedDescription = 'My transaction';

    $transactionDetails = $this->createClassObject();
    $transactionDetails->setDescription($expectedDescription);
    $this->assertEquals($expectedDescription, $transactionDetails->getDescription());
  }

  public function testGetIsFee()
  {
    $expectedIsFee = true;

    $transactionDetails = $this->createClassObject();
    $transactionDetails->setIsFee($expectedIsFee);
    $this->assertEquals($expectedIsFee, $transactionDetails->getIsFee());
  }

  public function testToArray()
  {
    $transactionDetails = $this->createClassObject();
    $this->objectSetters($transactionDetails);

    $transactionDetailsArray = $transactionDetails->toArray();

    $this->assertNotNull($transactionDetailsArray);
    $this->assertIsArray($transactionDetailsArray);

    $this->assertArrayHasKey('amount', $transactionDetailsArray);
    $this->assertArrayHasKey('description', $transactionDetailsArray);
    $this->assertArrayHasKey('isFee', $transactionDetailsArray);

    $this->assertEquals($transactionDetailsArray['amount'], 1.23);
    $this->assertEquals($transactionDetailsArray['description'], 'My description');
    $this->assertEquals($transactionDetailsArray['isFee'], false);
  }

  private function createClassObject()
  {
    return new TransactionDetails();
  }

  private function objectSetters(TransactionDetails $transactionDetails): void
  {
    $transactionDetails->setAmount(1.23);
    $transactionDetails->setDescription("My description");
    $transactionDetails->setIsFee(false);
  }
}