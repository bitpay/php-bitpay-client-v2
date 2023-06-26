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
    self::assertInstanceOf(Wallet::class, $wallet);
  }

  public function testGetKey()
  {
    $expectedKey = 'abcd123';

    $wallet = $this->createClassObject();
    $wallet->setKey($expectedKey);
    self::assertEquals($expectedKey, $wallet->getKey());
  }

  public function testGetDisplayName()
  {
    $expectedDisplayName = 'My Wallet';

    $wallet = $this->createClassObject();
    $wallet->setDisplayName($expectedDisplayName);
    self::assertEquals($expectedDisplayName, $wallet->getDisplayName());
  }

  public function testGetAvatar()
  {
    $expectedAvatar = 'image.png';

    $wallet = $this->createClassObject();
    $wallet->setAvatar($expectedAvatar);
    self::assertEquals($expectedAvatar, $wallet->getAvatar());
  }

  public function testGetPayPro()
  {
    $wallet = $this->createClassObject();
    $wallet->setPayPro(true);
    self::assertTrue($wallet->getPayPro());
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
    self::assertEquals($expectedCurrencies, $wallet->getCurrencies());
  }

  public function testGetImage()
  {
    $expectedImage = 'https://bitpay.com/api/images/logo-6fa5404d.svg';

    $wallet = $this->createClassObject();
    $wallet->setImage($expectedImage);
    self::assertEquals($expectedImage, $wallet->getImage());
  }

  public function testToArray()
  {
    $wallet = $this->createClassObject();
    $this->objectSetters($wallet);
    $walletArray = $wallet->toArray();

    self::assertNotNull($walletArray);
    self::assertIsArray($walletArray);

    self::assertArrayHasKey('key', $walletArray);
    self::assertArrayHasKey('displayName', $walletArray);
    self::assertArrayHasKey('avatar', $walletArray);
    self::assertArrayHasKey('paypro', $walletArray);
    self::assertArrayHasKey('currencies', $walletArray);
    self::assertArrayHasKey('image', $walletArray);

    self::assertEquals('abcd123', $walletArray['key']);
    self::assertEquals('My Wallet', $walletArray['displayName']);
    self::assertEquals('image.png', $walletArray['avatar']);
    self::assertTrue($walletArray['paypro']);
    self::assertEquals('BTH', $walletArray['currencies']['code']);
    self::assertTrue($walletArray['currencies']['p2p']);
    self::assertTrue($walletArray['currencies']['dappBrowser']);
    self::assertEquals('https://bitpay.com/api/images/logo-6fa5404d.svg', $walletArray['currencies']['image']);
    self::assertTrue($walletArray['currencies']['paypro']);
    self::assertEquals('BIP21', $walletArray['currencies']['qr']['type']);
    self::assertFalse($walletArray['currencies']['qr']['collapsed']);
    self::assertEquals('1.23', $walletArray['currencies']['withdrawalFee']);
    self::assertTrue($walletArray['currencies']['walletConnect']);
    self::assertEquals('https://bitpay.com/api/images/logo-6fa5404d.svg', $walletArray['image']);
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