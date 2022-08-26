<?php

namespace BitPaySDK\Test;

use BitPaySDK\Model\Wallet\Currencies;
use BitPaySDK\Model\Wallet\CurrencyQr;
use BitPaySDK\Model\Wallet\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
  public function testInstanceOf()
  {
    $wallet = $this->createClassObject();
    $this->assertInstanceOf(Wallet::class, $wallet);
  }

  public function testGetKey()
  {
    $expectedKey = 'abcd123';

    $wallet = $this->createClassObject();
    $wallet->setKey($expectedKey);
    $this->assertEquals($expectedKey, $wallet->getKey());
  }

  public function testGetDisplayName()
  {
    $expectedDisplayName = 'My Wallet';

    $wallet = $this->createClassObject();
    $wallet->setDisplayName($expectedDisplayName);
    $this->assertEquals($expectedDisplayName, $wallet->getDisplayName());
  }

  public function testGetAvatar()
  {
    $expectedAvatar = 'image.png';

    $wallet = $this->createClassObject();
    $wallet->setAvatar($expectedAvatar);
    $this->assertEquals($expectedAvatar, $wallet->getAvatar());
  }

  public function testGetPayPro()
  {
    $expectedPayPro = true;
    
    $wallet = $this->createClassObject();
    $wallet->setPayPro($expectedPayPro);
    $this->assertEquals($expectedPayPro, $wallet->getPayPro());
  }

  public function testGetCurrencies()
  {
    $currencyQr = new CurrencyQr;
    $currencyQr->setType('BIP21');
    $currencyQr->setCollapsed(false);

    $expectedCurrencies = new Currencies();
    $expectedCurrencies->setCode('BTH');
    $expectedCurrencies->setP2p(true);
    $expectedCurrencies->setDappBrowser(true);
    $expectedCurrencies->setImage('https://bitpay.com/api/images/logo-6fa5404d.svg');
    $expectedCurrencies->setPayPro(true);
    $expectedCurrencies->setQr($currencyQr);
    $expectedCurrencies->setWithdrawalFee('1.23');
    $expectedCurrencies->setWalletConnect(true);
    
    $wallet = $this->createClassObject();
    $wallet->setCurrencies($expectedCurrencies);
    $this->assertEquals($expectedCurrencies, $wallet->getCurrencies());
  }

  public function testGetImage()
  {
    $expectedImage = 'https://bitpay.com/api/images/logo-6fa5404d.svg';

    $wallet = $this->createClassObject();
    $wallet->setImage($expectedImage);
    $this->assertEquals($expectedImage, $wallet->getImage());
  }

  public function testToArray()
  {
    $wallet = $this->createClassObject();
    $this->objectSetters($wallet);
    $walletArray = $wallet->toArray();

    $this->assertNotNull($walletArray);
    $this->assertIsArray($walletArray);

    $this->assertArrayHasKey('key', $walletArray);
    $this->assertArrayHasKey('displayName', $walletArray);
    $this->assertArrayHasKey('avatar', $walletArray);
    $this->assertArrayHasKey('paypro', $walletArray);
    $this->assertArrayHasKey('currencies', $walletArray);
    $this->assertArrayHasKey('image', $walletArray);

    $this->assertEquals($walletArray['key'], 'abcd123');
    $this->assertEquals($walletArray['displayName'], 'My Wallet');
    $this->assertEquals($walletArray['avatar'], 'image.png');
    $this->assertEquals($walletArray['paypro'], true);
    $this->assertEquals($walletArray['currencies']['code'], 'BTH');
    $this->assertEquals($walletArray['currencies']['p2p'], true);
    $this->assertEquals($walletArray['currencies']['dappBrowser'], true);
    $this->assertEquals($walletArray['currencies']['image'], 'https://bitpay.com/api/images/logo-6fa5404d.svg');
    $this->assertEquals($walletArray['currencies']['paypro'], true);
    $this->assertEquals($walletArray['currencies']['qr']['type'], 'BIP21');
    $this->assertEquals($walletArray['currencies']['qr']['collapsed'], false);
    $this->assertEquals($walletArray['currencies']['withdrawalFee'], '1.23');
    $this->assertEquals($walletArray['currencies']['walletConnect'], true);
    $this->assertEquals($walletArray['image'], 'https://bitpay.com/api/images/logo-6fa5404d.svg');
  }

  private function createClassObject()
  {
    return new Wallet();
  }

  private function objectSetters(Wallet $wallet): void
  {
    $currencyQr = new CurrencyQr;
    $currencyQr->setType('BIP21');
    $currencyQr->setCollapsed(false);

    $currencies = new Currencies();
    $currencies->setCode('BTH');
    $currencies->setP2p(true);
    $currencies->setDappBrowser(true);
    $currencies->setImage('https://bitpay.com/api/images/logo-6fa5404d.svg');
    $currencies->setPayPro(true);
    $currencies->setQr($currencyQr);
    $currencies->setWithdrawalFee('1.23');
    $currencies->setWalletConnect(true);

    $wallet->setKey('abcd123');
    $wallet->setDisplayName('My Wallet');
    $wallet->setAvatar('image.png');
    $wallet->setPayPro(true);
    $wallet->setCurrencies($currencies);
    $wallet->setImage('https://bitpay.com/api/images/logo-6fa5404d.svg');
  }
}