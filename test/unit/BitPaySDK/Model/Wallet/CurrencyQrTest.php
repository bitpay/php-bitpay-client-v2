<?php

namespace BitPaySDK\Test\Model\Wallet;

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
    $currencyQr = $this->createClassObject();
    $currencyQr->setCollapsed(false);
    $this->assertFalse($currencyQr->getCollapsed());
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

    $this->assertEquals('BIP21', $currencyQrArray['type']);
    $this->assertEquals(false, $currencyQrArray['collapsed']);
  }

  private function createClassObject(): CurrencyQr
  {
    return new CurrencyQr();
  }

  private function objectSetters(CurrencyQr $currencyQr): void
  {
    $currencyQr->setType('BIP21');
    $currencyQr->setCollapsed(false);
  }
}