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
    self::assertInstanceOf(Currencies::class, $currencies);
  }

  public function testGetCode()
  {
    $expectedCode = 'BTH';

    $currencies = $this->createClassObject();
    $currencies->setCode($expectedCode);
    self::assertEquals($expectedCode, $currencies->getCode());
  }

  public function testGetP2p()
  {
    $currencies = $this->createClassObject();
    $currencies->setP2p(true);
    self::assertTrue($currencies->getP2p());
  }

  public function testGetDappBrowser()
  {
     $currencies = $this->createClassObject();
    $currencies->setDappBrowser(true);
    self::assertTrue($currencies->getDappBrowser());
  }

  public function testGetImage()
  {
    $expectedImage = 'https://bitpay.com/api/images/logo-6fa5404d.svg';

    $currencies = $this->createClassObject();
    $currencies->setImage($expectedImage);
    self::assertEquals($expectedImage, $currencies->getImage());
  }

  public function testGetPayPro()
  {
    $currencies = $this->createClassObject();
    $currencies->setPayPro(true);
    self::assertTrue($currencies->getPayPro());
  }

  public function testGetQr()
  {
    $expectedCurrencyQr = new CurrencyQr;
    $expectedCurrencyQr->setType('BIP21');
    $expectedCurrencyQr->setCollapsed(false);

    $currencies = $this->createClassObject();
    $currencies->setQr($expectedCurrencyQr);

    self::assertEquals($expectedCurrencyQr, $currencies->getQr());
  }

  public function testGetWithdrawalFee()
  {
    $expectedWithdrawalFee = '1.23';

    $currencies = $this->createClassObject();
    $currencies->setWithdrawalFee($expectedWithdrawalFee);
    self::assertEquals($expectedWithdrawalFee, $currencies->getWithdrawalFee());
  }

  public function testGetWalletConnect()
  {
    $currencies = $this->createClassObject();
    $currencies->setWalletConnect(true);
    self::assertTrue($currencies->getWalletConnect());
  }

  public function testToArray()
  {
    $currencies = $this->createClassObject();
    $this->objectSetters($currencies);
    $currenciesArray = $currencies->toArray();

    self::assertNotNull($currenciesArray);
    self::assertIsArray($currenciesArray);

    self::assertArrayHasKey('code', $currenciesArray);
    self::assertArrayHasKey('p2p', $currenciesArray);
    self::assertArrayHasKey('dappBrowser', $currenciesArray);
    self::assertArrayHasKey('image', $currenciesArray);
    self::assertArrayHasKey('paypro', $currenciesArray);
    self::assertArrayHasKey('qr', $currenciesArray);
    self::assertArrayHasKey('withdrawalFee', $currenciesArray);
    self::assertArrayHasKey('walletConnect', $currenciesArray);

    self::assertEquals('BTH', $currenciesArray['code']);
    self::assertEquals(true, $currenciesArray['p2p']);
    self::assertEquals(true, $currenciesArray['dappBrowser']);
    self::assertEquals('https://bitpay.com/api/images/logo-6fa5404d.svg', $currenciesArray['image']);
    self::assertEquals(true, $currenciesArray['paypro']);
    self::assertEquals('BIP21', $currenciesArray['qr']['type']);
    self::assertEquals(false, $currenciesArray['qr']['collapsed']);
    self::assertEquals('1.23', $currenciesArray['withdrawalFee']);
    self::assertEquals(true, $currenciesArray['walletConnect']);
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