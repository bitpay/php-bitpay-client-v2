<?php

namespace BitPaySDK\Test\Model\Wallet;

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
    $wallet = $this->createClassObject();
    $wallet->setPayPro(true);
    $this->assertTrue($wallet->getPayPro());
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

    $this->assertEquals('abcd123', $walletArray['key']);
    $this->assertEquals('My Wallet', $walletArray['displayName']);
    $this->assertEquals('image.png', $walletArray['avatar']);
    $this->assertTrue($walletArray['paypro']);
    $this->assertEquals('BTH', $walletArray['currencies']['code']);
    $this->assertTrue($walletArray['currencies']['p2p']);
    $this->assertTrue($walletArray['currencies']['dappBrowser']);
    $this->assertEquals('https://bitpay.com/api/images/logo-6fa5404d.svg', $walletArray['currencies']['image']);
    $this->assertTrue($walletArray['currencies']['paypro']);
    $this->assertEquals('BIP21', $walletArray['currencies']['qr']['type']);
    $this->assertFalse($walletArray['currencies']['qr']['collapsed']);
    $this->assertEquals('1.23', $walletArray['currencies']['withdrawalFee']);
    $this->assertTrue($walletArray['currencies']['walletConnect']);
    $this->assertEquals('https://bitpay.com/api/images/logo-6fa5404d.svg', $walletArray['image']);
  }

  private function createClassObject(): Wallet
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