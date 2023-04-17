<?php

namespace BitPaySDK\Test\Model\Wallet;

use BitPaySDK\Model\Wallet\Currencies;
use BitPaySDK\Model\Wallet\CurrencyQr;
use PHPUnit\Framework\TestCase;

class CurrenciesTest extends TestCase
{
  public function testInstanceOf()
  {
    $currencies = $this->createClassObject();
    $this->assertInstanceOf(Currencies::class, $currencies);
  }

  public function testGetCode()
  {
    $expectedCode = 'BTH';

    $currencies = $this->createClassObject();
    $currencies->setCode($expectedCode);
    $this->assertEquals($expectedCode, $currencies->getCode());
  }

  public function testGetP2p()
  {
    $currencies = $this->createClassObject();
    $currencies->setP2p(true);
    $this->assertTrue($currencies->getP2p());
  }

  public function testGetDappBrowser()
  {
     $currencies = $this->createClassObject();
    $currencies->setDappBrowser(true);
    $this->assertTrue($currencies->getDappBrowser());
  }

  public function testGetImage()
  {
    $expectedImage = 'https://bitpay.com/api/images/logo-6fa5404d.svg';

    $currencies = $this->createClassObject();
    $currencies->setImage($expectedImage);
    $this->assertEquals($expectedImage, $currencies->getImage());
  }

  public function testGetPayPro()
  {
    $currencies = $this->createClassObject();
    $currencies->setPayPro(true);
    $this->assertTrue($currencies->getPayPro());
  }

  public function testGetQr()
  {
    $expectedCurrencyQr = new CurrencyQr;
    $expectedCurrencyQr->setType('BIP21');
    $expectedCurrencyQr->setCollapsed(false);

    $currencies = $this->createClassObject();
    $currencies->setQr($expectedCurrencyQr);

    $this->assertEquals($expectedCurrencyQr, $currencies->getQr());
  }

  public function testGetWithdrawalFee()
  {
    $expectedWithdrawalFee = '1.23';

    $currencies = $this->createClassObject();
    $currencies->setWithdrawalFee($expectedWithdrawalFee);
    $this->assertEquals($expectedWithdrawalFee, $currencies->getWithdrawalFee());
  }

  public function testGetWalletConnect()
  {
    $currencies = $this->createClassObject();
    $currencies->setWalletConnect(true);
    $this->assertTrue($currencies->getWalletConnect());
  }

  public function testToArray()
  {
    $currencies = $this->createClassObject();
    $this->objectSetters($currencies);
    $currenciesArray = $currencies->toArray();

    $this->assertNotNull($currenciesArray);
    $this->assertIsArray($currenciesArray);

    $this->assertArrayHasKey('code', $currenciesArray);
    $this->assertArrayHasKey('p2p', $currenciesArray);
    $this->assertArrayHasKey('dappBrowser', $currenciesArray);
    $this->assertArrayHasKey('image', $currenciesArray);
    $this->assertArrayHasKey('paypro', $currenciesArray);
    $this->assertArrayHasKey('qr', $currenciesArray);
    $this->assertArrayHasKey('withdrawalFee', $currenciesArray);
    $this->assertArrayHasKey('walletConnect', $currenciesArray);

    $this->assertEquals('BTH', $currenciesArray['code']);
    $this->assertEquals(true, $currenciesArray['p2p']);
    $this->assertEquals(true, $currenciesArray['dappBrowser']);
    $this->assertEquals('https://bitpay.com/api/images/logo-6fa5404d.svg', $currenciesArray['image']);
    $this->assertEquals(true, $currenciesArray['paypro']);
    $this->assertEquals('BIP21', $currenciesArray['qr']['type']);
    $this->assertEquals(false, $currenciesArray['qr']['collapsed']);
    $this->assertEquals('1.23', $currenciesArray['withdrawalFee']);
    $this->assertEquals(true, $currenciesArray['walletConnect']);
  }

  private function createClassObject(): Currencies
  {
    return new Currencies();
  }

  private function objectSetters(Currencies $currencies): void
  {
    $currencyQr = new CurrencyQr;
    $currencyQr->setType('BIP21');
    $currencyQr->setCollapsed(false);

    $currencies->setCode('BTH');
    $currencies->setP2p(true);
    $currencies->setDappBrowser(true);
    $currencies->setImage('https://bitpay.com/api/images/logo-6fa5404d.svg');
    $currencies->setPayPro(true);
    $currencies->setQr($currencyQr);
    $currencies->setWithdrawalFee('1.23');
    $currencies->setWalletConnect(true);
  }
}