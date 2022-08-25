<?php

namespace BitPaySDK\Test;

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
    $expectedP2p = true;

    $currencies = $this->createClassObject();
    $currencies->setP2p($expectedP2p);
    $this->assertEquals($expectedP2p, $currencies->getP2p());
  }

  public function testGetDappBrowser()
  {
    $expectedDappBrowser = true;

    $currencies = $this->createClassObject();
    $currencies->setDappBrowser($expectedDappBrowser);
    $this->assertEquals($expectedDappBrowser, $currencies->getDappBrowser());
  }

  public function testGetImage()
  {
    $expectedImage = 'https://bitpay.com/api/images/logo-6fa5404d.svg';

    $currencies = $this->createClassObject();
    $currencies->setImage($expectedImage, $currencies->getImage());
    $this->assertEquals($expectedImage, $currencies->getImage());
  }

  public function testGetPayPro()
  {
    $expectedPayPro = true;

    $currencies = $this->createClassObject();
    $currencies->setPayPro($expectedPayPro);
    $this->assertEquals($expectedPayPro, $currencies->getPayPro());
  }

  public function testGetQr()
  {
    $expectedCurrencyQr = new CurrencyQr;
    $expectedCurrencyQr->setType = 'BIP21';
    $expectedCurrencyQr->setCollapsed = false;

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
    $expectedWalletConnect = true;

    $currencies = $this->createClassObject();
    $currencies->setWalletConnect($expectedWalletConnect);
    $this->assertEquals($expectedWalletConnect, $currencies->getWalletConnect());
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

    $this->assertEquals($currenciesArray['code'], 'BTH');
    $this->assertEquals($currenciesArray['p2p'], true);
    $this->assertEquals($currenciesArray['dappBrowser'], true);
    $this->assertEquals($currenciesArray['image'], 'https://bitpay.com/api/images/logo-6fa5404d.svg');
    $this->assertEquals($currenciesArray['paypro'], true);
    $this->assertEquals($currenciesArray['qr']['type'], 'BIP21');
    $this->assertEquals($currenciesArray['qr']['collapsed'], false);
    $this->assertEquals($currenciesArray['withdrawalFee'], '1.23');
    $this->assertEquals($currenciesArray['walletConnect'], true);
  }

  private function createClassObject()
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