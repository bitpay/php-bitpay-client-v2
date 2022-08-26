<?php

namespace BitPaySDK\Test;

use BitPaySDK\Model\Wallet\CurrencyQr;
use PHPUnit\Framework\TestCase;

class CurrencyQrTest extends TestCase
{
  public function testInstanceOf()
  {
    $currencyQr = $this->createClassObject();
    $this->assertInstanceOf(CurrencyQr::class, $currencyQr);
  }

  public function testGetType()
  {
    $expectedType = 'BIP21';

    $currencyQr = $this->createClassObject();
    $currencyQr->setType($expectedType);
    $this->assertEquals($expectedType, $currencyQr->getType());
  }

  public function testGetCollapsed()
  {
    $expectedCollapsed = false;

    $currencyQr = $this->createClassObject();
    $currencyQr->setCollapsed($expectedCollapsed);
    $this->assertEquals($expectedCollapsed, $currencyQr->getCollapsed());
  }

  public function testToArray()
  {
    $currencyQr = $this->createClassObject();
    $this->objectSetters($currencyQr);
    $currencyQrArray = $currencyQr->toArray();

    $this->assertNotNull($currencyQrArray);
    $this->assertIsArray($currencyQrArray);

    $this->assertArrayHasKey('type', $currencyQrArray);
    $this->assertArrayHasKey('collapsed', $currencyQrArray);

    $this->AssertEquals($currencyQrArray['type'], 'BIP21');
    $this->AssertEquals($currencyQrArray['collapsed'], false);
  }

  private function createClassObject()
  {
    return new CurrencyQr();
  }

  private function objectSetters(CurrencyQr $currencyQr): void
  {
    $currencyQr->setType('BIP21');
    $currencyQr->setCollapsed(false);
  }
}