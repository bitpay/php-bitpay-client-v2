<?php

namespace BitPaySDK\Test\Model\Invoice;

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
    $transactionDetails = $this->createClassObject();
    $transactionDetails->setIsFee(true);
    $this->assertTrue($transactionDetails->getIsFee());
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

    $this->assertEquals(1.23, $transactionDetailsArray['amount']);
    $this->assertEquals('My description', $transactionDetailsArray['description']);
    $this->assertEquals(false, $transactionDetailsArray['isFee']);
  }

  private function createClassObject(): TransactionDetails
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