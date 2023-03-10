<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\BuyerProvidedInfo;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\ItemizedDetails;
use BitPaySDK\Model\Invoice\MinerFees;
use BitPaySDK\Model\Invoice\RefundInfo;
use BitPaySDK\Model\Invoice\Shopper;
use BitPaySDK\Model\Invoice\SupportedTransactionCurrencies;
use BitPaySDK\Model\Invoice\TransactionDetails;
use BitPaySDK\Model\Invoice\UniversalCodes;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function testInstanceOf()
    {
        $invoice = $this->createClassObject();
        $this->assertInstanceOf(Invoice::class, $invoice);
    }

    public function testGetCurrencyException()
    {
        $expectedCurrency = 'ELO';

        $invoice = $this->createClassObject();
        $this->expectException(BitPayException::class);
        $this->expectExceptionMessage('currency code must be a type of Model.Currency');
        $invoice->setCurrency($expectedCurrency);
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrency()
    {
        $expectedCurrency = 'BTC';

        $invoice = $this->createClassObject();
        $invoice->setCurrency($expectedCurrency);
        $this->assertEquals($expectedCurrency, $invoice->getCurrency());
    }

    public function testGetGuid()
    {
        $expectedGuid = 'Test guid';

        $invoice = $this->createClassObject();
        $invoice->setGuid($expectedGuid);
        $this->assertEquals($expectedGuid, $invoice->getGuid());
    }

    public function testGetToken()
    {
        $expectedToken = 's7k3f9v2nnn3kb3';

        $invoice = $this->createClassObject();
        $invoice->setToken($expectedToken);
        $this->assertEquals($expectedToken, $invoice->getToken());
    }

    public function testGetPrice()
    {
        $expectedPrice = 150.25;

        $invoice = $this->createClassObject();
        $invoice->setPrice($expectedPrice);
        $this->assertEquals($expectedPrice, $invoice->getPrice());
    }

    public function testGetPosData()
    {
        $expectedPostData = 'Test post data';

        $invoice = $this->createClassObject();
        $invoice->setPosData($expectedPostData);
        $this->assertEquals($expectedPostData, $invoice->getPosData());
    }

    public function testGetNotificationURL()
    {
        $expectedNotificationURL = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setNotificationURL($expectedNotificationURL);
        $this->assertEquals($expectedNotificationURL, $invoice->getNotificationURL());
    }

    public function testGetTransactionSpeed()
    {
        $expectedTransactionSpeed = 'Test transaction speed';

        $invoice = $this->createClassObject();
        $invoice->setTransactionSpeed($expectedTransactionSpeed);
        $this->assertEquals($expectedTransactionSpeed, $invoice->getTransactionSpeed());
    }

    public function testGetFullNotifications()
    {
        $invoice = $this->createClassObject();
        $invoice->setFullNotifications(true);
        $this->assertTrue($invoice->getFullNotifications());
    }

    public function testGetNotificationEmail()
    {
        $expectedNotificationEmail = 'test@email.com';

        $invoice = $this->createClassObject();
        $invoice->setNotificationEmail($expectedNotificationEmail);
        $this->assertEquals($expectedNotificationEmail, $invoice->getNotificationEmail());
    }

    public function testGetRedirectURL()
    {
        $expectedRedirectURL = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setRedirectURL($expectedRedirectURL);
        $this->assertEquals($expectedRedirectURL, $invoice->getRedirectURL());
    }

    public function testGetOrderId()
    {
        $expectedOrderId = '15';

        $invoice = $this->createClassObject();
        $invoice->setOrderId($expectedOrderId);
        $this->assertEquals($expectedOrderId, $invoice->getOrderId());
    }

    public function testGetItemDesc()
    {
        $expectedItemDesc = 'Test item desc';

        $invoice = $this->createClassObject();
        $invoice->setItemDesc($expectedItemDesc);
        $this->assertEquals($expectedItemDesc, $invoice->getItemDesc());
    }

    public function testGetItemCode()
    {
        $expectedItemCode = 'X3NH';

        $invoice = $this->createClassObject();
        $invoice->setItemCode($expectedItemCode);
        $this->assertEquals($expectedItemCode, $invoice->getItemCode());
    }

    public function testGetPhysical()
    {
        $invoice = $this->createClassObject();
        $invoice->setPhysical(false);
        $this->assertFalse($invoice->getPhysical());
    }

    public function testGetPaymentCurrencies()
    {
        $expectedPaymentCurrencies = ['BTC'];

        $invoice = $this->createClassObject();
        $invoice->setPaymentCurrencies($expectedPaymentCurrencies);
        $this->assertEquals($expectedPaymentCurrencies, $invoice->getPaymentCurrencies());
    }

    public function testGetAcceptanceWindow()
    {
        $expectedAcceptanceWindow = 15.0;

        $invoice = $this->createClassObject();
        $invoice->setAcceptanceWindow($expectedAcceptanceWindow);
        $this->assertEquals($expectedAcceptanceWindow, $invoice->getAcceptanceWindow());
    }

    public function testGetCloseURL()
    {
        $expectedCloseURL = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setCloseURL($expectedCloseURL);
        $this->assertEquals($expectedCloseURL, $invoice->getCloseURL());
    }

    public function testGetAutoRedirect()
    {
        $invoice = $this->createClassObject();
        $invoice->setAutoRedirect(true);
        $this->assertTrue($invoice->getAutoRedirect());
    }

    public function testGetJsonPayProRequired()
    {
        $invoice = $this->createClassObject();
        $invoice->setJsonPayProRequired(false);
        $this->assertFalse($invoice->getJsonPayProRequired());
    }

    public function testGetBitpayIdRequired()
    {
        $invoice = $this->createClassObject();
        $invoice->setBitpayIdRequired(true);
        $this->assertTrue($invoice->getBitpayIdRequired());
    }

    public function testGetMerchantName()
    {
        $expectedMerchantName = 'Test merchant name';

        $invoice = $this->createClassObject();
        $invoice->setMerchantName($expectedMerchantName);
        $this->assertEquals($expectedMerchantName, $invoice->getMerchantName());
    }

    public function testGetSelectedTransactionCurrency()
    {
        $expectedSelectedTransactionCurrency = 'BTC';

        $invoice = $this->createClassObject();
        $invoice->setSelectedTransactionCurrency($expectedSelectedTransactionCurrency);
        $this->assertEquals($expectedSelectedTransactionCurrency, $invoice->getSelectedTransactionCurrency());
    }

    public function testGetForcedBuyerSelectedWallet()
    {
        $expectedForcedBuyerSelectedWallet = 'Test wallet';

        $invoice = $this->createClassObject();
        $invoice->setForcedBuyerSelectedWallet($expectedForcedBuyerSelectedWallet);
        $this->assertEquals($expectedForcedBuyerSelectedWallet, $invoice->getForcedBuyerSelectedWallet());
    }

    public function testGetForcedBuyerSelectedTransactionCurrency()
    {
        $expectedForcedBuyerSelectedTransactionCurrency = 'BTC';

        $invoice = $this->createClassObject();
        $invoice->setForcedBuyerSelectedTransactionCurrency($expectedForcedBuyerSelectedTransactionCurrency);
        $this->assertEquals($expectedForcedBuyerSelectedTransactionCurrency, $invoice->getForcedBuyerSelectedTransactionCurrency());
    }

    public function testGetItemizedDetailsAsArray()
    {
        $expectedArray = [
            'amount' => 1,
            'description' => 'testDescription',
            'isFee' => true
        ];
        $expectedItemizedDetails = $this->getMockBuilder(ItemizedDetails::class)->disableOriginalConstructor()->getMock();
        $expectedItemizedDetails->method('toArray')->willReturn($expectedArray);

        $invoice = $this->createClassObject();
        $invoice->setItemizedDetails($expectedArray);

        $this->assertIsArray($invoice->getItemizedDetails());
        $this->assertNotNull($invoice->getItemizedDetails());

        $this->assertInstanceOf(ItemizedDetails::class, $invoice->getItemizedDetails()[0]);
    }

    public function testGetBuyer()
    {
        $expectedBuyer = $this->getMockBuilder(Buyer::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setBuyer($expectedBuyer);
        $this->assertEquals($expectedBuyer, $invoice->getBuyer());
    }

    public function testGetBuyerEmail()
    {
        $expectedBuyerEmail = 'test@email.com';

        $invoice = $this->createClassObject();
        $invoice->setBuyerEmail($expectedBuyerEmail);
        $this->assertEquals($expectedBuyerEmail, $invoice->getBuyerEmail());
    }

    public function testGetBuyerSms()
    {
        $expectedBuyerSms = 'Test buyer sms';

        $invoice = $this->createClassObject();
        $invoice->setBuyerSms($expectedBuyerSms);
        $this->assertEquals($expectedBuyerSms, $invoice->getBuyerSms());
    }

    public function testGetRefundAddresses()
    {
        $expectedRefundAddresses = ['Test refund address'];

        $invoice = $this->createClassObject();
        $invoice->setRefundAddresses($expectedRefundAddresses);
        $this->assertEquals($expectedRefundAddresses, $invoice->getRefundAddresses());
    }

    public function testGetId()
    {
        $expectedId = '12';

        $invoice = $this->createClassObject();
        $invoice->setId($expectedId);
        $this->assertEquals($expectedId, $invoice->getId());
    }

    public function testGetUrl()
    {
        $expectedUrl = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setUrl($expectedUrl);
        $this->assertEquals($expectedUrl, $invoice->getUrl());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'pending';

        $invoice = $this->createClassObject();
        $invoice->setStatus($expectedStatus);
        $this->assertEquals($expectedStatus, $invoice->getStatus());
    }

    public function testGetFeeDetected()
    {
        $invoice = $this->createClassObject();
        $invoice->setLowFeeDetected(true);
        $this->assertTrue($invoice->getLowFeeDetected());
    }

    public function testGetInvoiceTime()
    {
        $expectedInvoiceTime = 1620669854224;

        $invoice = $this->createClassObject();
        $invoice->setInvoiceTime($expectedInvoiceTime);
        $this->assertEquals($expectedInvoiceTime, $invoice->getInvoiceTime());
    }

    public function testGetExpirationTime()
    {
        $expectedExpirationTime = '01:01:01';

        $invoice = $this->createClassObject();
        $invoice->setExpirationTime($expectedExpirationTime);
        $this->assertEquals($expectedExpirationTime, $invoice->getExpirationTime());
    }

    public function testGetCurrentTime()
    {
        $expectedCurrencyTime = '01:01:01';

        $invoice = $this->createClassObject();
        $invoice->setCurrentTime($expectedCurrencyTime);
        $this->assertEquals($expectedCurrencyTime, $invoice->getCurrentTime());
    }

    public function testGetTransactions()
    {
        $expectedTransaction = [];

        $invoice = $this->createClassObject();
        $invoice->setTransactions($expectedTransaction);
        $this->assertEquals($expectedTransaction, $invoice->getTransactions());
    }

    public function testGetExceptionStatus()
    {
        $expectedExceptionStatus = 'Test exception status';

        $invoice = $this->createClassObject();
        $invoice->setExceptionStatus($expectedExceptionStatus);
        $this->assertEquals($expectedExceptionStatus, $invoice->getExceptionStatus());
    }

    public function testGetTargetConfirmations()
    {
        $expectedTargetConfirmation = 6;

        $invoice = $this->createClassObject();
        $invoice->setTargetConfirmations($expectedTargetConfirmation);
        $this->assertEquals($expectedTargetConfirmation, $invoice->getTargetConfirmations());
    }

    public function testGetRefundAddressRequestPending()
    {
        $invoice = $this->createClassObject();
        $invoice->setRefundAddressRequestPending(false);
        $this->assertFalse($invoice->getRefundAddressRequestPending());
    }

    public function testGetBuyerProvidedEmail()
    {
        $expectedBuyerProvidedEmail = 'test@email.com';

        $invoice = $this->createClassObject();
        $invoice->setBuyerProvidedEmail($expectedBuyerProvidedEmail);
        $this->assertEquals($expectedBuyerProvidedEmail, $invoice->getBuyerProvidedEmail());
    }

    public function testGetBuyerProvidedInfo()
    {
        $expectedBuyerProvidedInfo = $this->getMockBuilder(BuyerProvidedInfo::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setBuyerProvidedInfo($expectedBuyerProvidedInfo);
        $this->assertEquals($expectedBuyerProvidedInfo, $invoice->getBuyerProvidedInfo());
    }

    public function testGetTransactionDetails()
    {
        $expectedTransactionDetails = $this->getMockBuilder(TransactionDetails::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setTransactionDetails($expectedTransactionDetails);
        $this->assertEquals($expectedTransactionDetails, $invoice->getTransactionDetails());
    }

    public function testGetUniversalCodes()
    {
        $expectedUniversalCodes = $this->getMockBuilder(UniversalCodes::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setUniversalCodes($expectedUniversalCodes);
        $this->assertEquals($expectedUniversalCodes, $invoice->getUniversalCodes());
    }

    public function testGetSupportedTransactionCurrencies()
    {
        $expectedSupportedTransactionCurrencies = $this->getMockBuilder(SupportedTransactionCurrencies::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setSupportedTransactionCurrencies($expectedSupportedTransactionCurrencies);
        $this->assertEquals($expectedSupportedTransactionCurrencies, $invoice->getSupportedTransactionCurrencies());
    }

    public function testGetPaymentTotals()
    {
        $expectedPaymentTotals = [
            "BTC" => 70200,
            "BCH" => 11495400,
            "ETH" => 9327000000000000,
            "GUSD" => 1200,
            "PAX" => 12000000000000000000,
            "BUSD" => 12000000000000000000,
            "USDC" => 12000000,
            "DOGE" => 13219659000,
            "LTC" => 20332100,
            "MATIC" => 12502605000000000000,
            "USDC_m" => 12000000
        ];

        $invoice = $this->createClassObject();
        $invoice->setPaymentTotals($expectedPaymentTotals);
        $this->assertEquals($expectedPaymentTotals, $invoice->getPaymentTotals());
    }

    public function testGetPaymentSubTotals()
    {
        $expectedPaymentSubTotals = [
            "BTC" => 70100,
            "BCH" => 11495400,
            "ETH" => 9327000000000000,
            "GUSD" => 1200,
            "PAX" => 12000000000000000000,
            "BUSD" => 12000000000000000000,
            "USDC" => 12000000,
            "DOGE" => 13219659000,
            "LTC" => 20332100,
            "MATIC" => 12502605000000000000,
            "USDC_m" => 12000000
        ];

        $invoice = $this->createClassObject();
        $invoice->setPaymentSubTotals($expectedPaymentSubTotals);
        $this->assertEquals($expectedPaymentSubTotals, $invoice->getPaymentSubTotals());
    }

    public function testGetPaymentDisplaySubTotals()
    {
        $expectedPaymentDisplaySubTotals = [
            "BTC" => "0.000701",
            "BCH" => "0.114954",
            "ETH" => "0.009327",
            "GUSD" => "12.00",
            "PAX" => "12.00",
            "BUSD" => "12.00",
            "USDC" => "12.00",
            "DOGE" => "132.196590",
            "LTC" => "0.203321",
            "MATIC" => "12.502605",
            "USDC_m" => "12.00"
        ];

        $invoice = $this->createClassObject();
        $invoice->setPaymentDisplaySubTotals($expectedPaymentDisplaySubTotals);
        $this->assertEquals($expectedPaymentDisplaySubTotals, $invoice->getPaymentDisplaySubTotals());
    }

    public function testGetPaymentDisplayTotals()
    {
        $expectedPaymentDisplayTotals = [
            "BTC" => "0.000702",
            "BCH" => "0.114954",
            "ETH" => "0.009327",
            "GUSD" => "12.00",
            "PAX" => "12.00",
            "BUSD" => "12.00",
            "USDC" => "12.00",
            "DOGE" => "132.196590",
            "LTC" => "0.203321",
            "MATIC" => "12.502605",
            "USDC_m" => "12.00"
        ];

        $invoice = $this->createClassObject();
        $invoice->setPaymentDisplayTotals($expectedPaymentDisplayTotals);
        $this->assertEquals($expectedPaymentDisplayTotals, $invoice->getPaymentDisplayTotals());
    }

    public function testGetPaymentCodes()
    {
        $expectedPaymentCodes = [
            'BTC' => [
                "BIP72b" => "bitcoin:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4",
                "BIP73"=> "https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "BCH" => [
                "BIP72b" => "bitcoincash:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4",
                "BIP73" => "https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "ETH" => [
                "EIP681" => "ethereum:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "GUSD" => [
                "EIP681b" => "ethereum:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "PAX" => [
                "EIP681b" => "ethereum:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "BUSD" => [
                "EIP681b" => "ethereum:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "USDC" => [
                "EIP681b" => "ethereum:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "DOGE" => [
                "BIP72b" => "dogecoin:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4",
                "BIP73" => "https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "LTC" => [
                "BIP72b" => "litecoin:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4",
                "BIP73" => "https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "MATIC" => [
                "EIP681" => "matic:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ],
            "USDC_m" => [
                "EIP681b" => "matic:?r=https://test.bitpay.com/i/UZjwcYkWAKfTMn9J1yyfs4"
            ]
        ];

        $invoice = $this->createClassObject();
        $invoice->setPaymentCodes($expectedPaymentCodes);
        $this->assertEquals($expectedPaymentCodes, $invoice->getPaymentCodes());
    }

    public function testGetUnderpaidAmount()
    {
        $expectedUnderpaidAmount = 10;

        $invoice = $this->createClassObject();
        $invoice->setUnderpaidAmount($expectedUnderpaidAmount);
        $this->assertEquals($expectedUnderpaidAmount, $invoice->getUnderpaidAmount());
    }

    public function testGetOverpaidAmount()
    {
        $expectedOverpaidAmount = 10;

        $invoice = $this->createClassObject();
        $invoice->setOverpaidAmount($expectedOverpaidAmount);
        $this->assertEquals($expectedOverpaidAmount, $invoice->getOverpaidAmount());
    }

    public function testGetMinerFees()
    {
        $expectedMinerFees = $this->getMockBuilder(MinerFees::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setMinerFees($expectedMinerFees);
        $this->assertEquals($expectedMinerFees, $invoice->getMinerFees());
    }

    public function testGetNonPayProPaymentReceived()
    {
        $invoice = $this->createClassObject();
        $invoice->setNonPayProPaymentReceived(true);
        $this->assertTrue($invoice->getNonPayProPaymentReceived());
    }

    public function testGetShopper()
    {
        $expectedShopper = $this->getMockBuilder(Shopper::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setShopper($expectedShopper);
        $this->assertEquals($expectedShopper, $invoice->getShopper());
    }

    public function testGetBillId()
    {
        $expectedBillId = '123';

        $invoice = $this->createClassObject();
        $invoice->setBillId($expectedBillId);
        $this->assertEquals($expectedBillId, $invoice->getBillId());
    }

    public function testGetRefundInfo()
    {
        $expectedRefundInfo = $this->getMockBuilder(RefundInfo::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setRefundInfo($expectedRefundInfo);
        $this->assertEquals($expectedRefundInfo, $invoice->getRefundInfo());
    }

    public function testGetExtendedNotifications()
    {
        $invoice = $this->createClassObject();
        $invoice->setExtendedNotifications(false);
        $this->assertFalse($invoice->getExtendedNotifications());
    }

    public function testgetTransactionCurrency()
    {
        $expectedTransactionCurrency = 'BTC';

        $invoice = $this->createClassObject();
        $invoice->setTransactionCurrency($expectedTransactionCurrency);
        $this->assertEquals($expectedTransactionCurrency, $invoice->getTransactionCurrency());
    }

    public function testGetAmountPaid()
    {
        $expectedAmountPaid = 11;

        $invoice = $this->createClassObject();
        $invoice->setAmountPaid($expectedAmountPaid);
        $this->assertEquals($expectedAmountPaid, $invoice->getAmountPaid());
    }

    public function testGetDisplayAmountPaid()
    {
        $expectedDisplayAmountPaid = 'Test display amount paid';

        $invoice = $this->createClassObject();
        $invoice->setDisplayAmountPaid($expectedDisplayAmountPaid);
        $this->assertEquals($expectedDisplayAmountPaid, $invoice->getDisplayAmountPaid());
    }

    public function testGetExchangeRates()
    {
        $expectedExchangeRates = $this->getExampleExchangeRates();

        $invoice = $this->createClassObject();
        $invoice->setExchangeRates($expectedExchangeRates);
        $this->assertEquals($expectedExchangeRates, $invoice->getExchangeRates());
    }

    public function testGetPaymentString()
    {
        $expectedPaymentString = 'Test payment string';

        $invoice = $this->createClassObject();
        $invoice->setPaymentString($expectedPaymentString);
        $this->assertEquals($expectedPaymentString, $invoice->getPaymentString());
    }

    public function testGetVerificationLink()
    {
        $expectedVerificationLink = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setVerificationLink($expectedVerificationLink);
        $this->assertEquals($expectedVerificationLink, $invoice->getVerificationLink());
    }

    public function testGetIsCancelled()
    {
        $invoice = $this->createClassObject();
        $invoice->setIsCancelled(false);
        $this->assertFalse($invoice->getIsCancelled());
    }

    /**
     * @throws BitPayException
     */
    public function testToArray()
    {
        $invoice = $this->createClassObject();
        $this->setObjectSetters($invoice);
        $invoiceArray = $invoice->toArray();

        $this->assertNotNull($invoiceArray);
        $this->assertIsArray($invoiceArray);

        $this->assertArrayHasKey('currency', $invoiceArray);
        $this->assertArrayHasKey('guid', $invoiceArray);
        $this->assertArrayHasKey('token', $invoiceArray);
        $this->assertArrayHasKey('price', $invoiceArray);
        $this->assertArrayHasKey('posData', $invoiceArray);
        $this->assertArrayHasKey('notificationURL', $invoiceArray);
        $this->assertArrayHasKey('transactionSpeed', $invoiceArray);
        $this->assertArrayHasKey('fullNotifications', $invoiceArray);
        $this->assertArrayHasKey('notificationEmail', $invoiceArray);
        $this->assertArrayHasKey('redirectURL', $invoiceArray);
        $this->assertArrayHasKey('orderId', $invoiceArray);
        $this->assertArrayHasKey('itemDesc', $invoiceArray);
        $this->assertArrayHasKey('itemCode', $invoiceArray);
        $this->assertArrayHasKey('physical', $invoiceArray);
        $this->assertArrayHasKey('paymentCurrencies', $invoiceArray);
        $this->assertArrayHasKey('acceptanceWindow', $invoiceArray);
        $this->assertArrayHasKey('closeURL', $invoiceArray);
        $this->assertArrayHasKey('autoRedirect', $invoiceArray);
        $this->assertArrayHasKey('refundAddresses', $invoiceArray);
        $this->assertArrayHasKey('id', $invoiceArray);
        $this->assertArrayHasKey('url', $invoiceArray);
        $this->assertArrayHasKey('status', $invoiceArray);
        $this->assertArrayHasKey('lowFeeDetected', $invoiceArray);
        $this->assertArrayHasKey('invoiceTime', $invoiceArray);
        $this->assertArrayHasKey('expirationTime', $invoiceArray);
        $this->assertArrayHasKey('currentTime', $invoiceArray);
        $this->assertArrayHasKey('exceptionStatus', $invoiceArray);
        $this->assertArrayHasKey('targetConfirmations', $invoiceArray);
//        $this->assertArrayHasKey('refundAddressRequestPending', $invoiceArray);
        $this->assertArrayHasKey('buyerProvidedEmail', $invoiceArray);
        $this->assertArrayHasKey('billId', $invoiceArray);
        $this->assertArrayHasKey('extendedNotifications', $invoiceArray);
        $this->assertArrayHasKey('transactionCurrency', $invoiceArray);
        $this->assertArrayHasKey('amountPaid', $invoiceArray);
        $this->assertArrayHasKey('exchangeRates', $invoiceArray);
        $this->assertArrayHasKey('merchantName', $invoiceArray);
        $this->assertArrayHasKey('selectedTransactionCurrency', $invoiceArray);
        $this->assertArrayHasKey('bitpayIdRequired', $invoiceArray);
        $this->assertArrayHasKey('forcedBuyerSelectedWallet', $invoiceArray);
        $this->assertArrayHasKey('paymentString', $invoiceArray);
        $this->assertArrayHasKey('verificationLink', $invoiceArray);
        $this->assertArrayHasKey('isCancelled', $invoiceArray);
        $this->assertArrayHasKey('buyerEmail', $invoiceArray);
        $this->assertArrayHasKey('buyerSms', $invoiceArray);
        $this->assertArrayHasKey('forcedBuyerSelectedTransactionCurrency', $invoiceArray);

        $this->assertEquals('BTC', $invoiceArray['currency']);
        $this->assertEquals('Test guid', $invoiceArray['guid']);
        $this->assertEquals('4h2h7kee5eh2hh4', $invoiceArray['token']);
        $this->assertEquals(355.3, $invoiceArray['price']);
        $this->assertEquals('Test pos data', $invoiceArray['posData']);
        $this->assertEquals('http://test.com', $invoiceArray['notificationURL']);
        $this->assertEquals('Test transaction speed', $invoiceArray['transactionSpeed']);
        $this->assertTrue($invoiceArray['fullNotifications']);
        $this->assertEquals('test@email.com', $invoiceArray['notificationEmail']);
        $this->assertEquals('http://test.com', $invoiceArray['redirectURL']);
        $this->assertEquals('34', $invoiceArray['orderId']);
        $this->assertEquals('Test item desc', $invoiceArray['itemDesc']);
        $this->assertEquals('Test item code', $invoiceArray['itemCode']);
        $this->assertTrue($invoiceArray['physical']);
        $this->assertEquals(['BTC'], $invoiceArray['paymentCurrencies']);
        $this->assertEquals(1.1, $invoiceArray['acceptanceWindow']);
        $this->assertEquals('http://test.com', $invoiceArray['closeURL']);
        $this->assertTrue($invoiceArray['autoRedirect']);
        $this->assertEquals(['Test refund address'], $invoiceArray['refundAddresses']);
        $this->assertEquals('12', $invoiceArray['id']);
        $this->assertEquals('http://test.com', $invoiceArray['url']);
        $this->assertEquals('pending', $invoiceArray['status']);
        $this->assertEquals('Low fee detected', $invoiceArray['lowFeeDetected']);
        $this->assertEquals(1620734545366, $invoiceArray['invoiceTime']);
        $this->assertEquals('01:01:01', $invoiceArray['expirationTime']);
        $this->assertEquals('01:01:01', $invoiceArray['currentTime']);
        $this->assertEquals('Exception status', $invoiceArray['exceptionStatus']);
        $this->assertEquals(6, $invoiceArray['targetConfirmations']);
        $this->assertEquals('test@email.com', $invoiceArray['buyerProvidedEmail']);
        $this->assertEquals('34', $invoiceArray['billId']);
        $this->assertTrue($invoiceArray['extendedNotifications']);
        $this->assertEquals('BTC', $invoiceArray['transactionCurrency']);
        $this->assertEquals(12, $invoiceArray['amountPaid']);
        $this->assertEquals($this->getExampleExchangeRates(), $invoiceArray['exchangeRates']);
        $this->assertEquals('Merchant name', $invoiceArray['merchantName']);
        $this->assertEquals('BTC', $invoiceArray['selectedTransactionCurrency']);
        $this->assertTrue($invoiceArray['bitpayIdRequired']);
        $this->assertEquals('Forced Buyer Selected Wallet', $invoiceArray['forcedBuyerSelectedWallet']);
        $this->assertEquals('Payment string', $invoiceArray['paymentString']);
        $this->assertEquals('http://test.com', $invoiceArray['verificationLink']);
        $this->assertTrue($invoiceArray['isCancelled']);
        $this->assertEquals('test@email.com', $invoiceArray['buyerEmail']);
        $this->assertEquals('Buyer sms', $invoiceArray['buyerSms']);
        $this->assertEquals('BTC', $invoiceArray['forcedBuyerSelectedTransactionCurrency']);
    }

    public function testToArrayEmptyKey()
    {
        $invoice = $this->createClassObject();
        $invoiceArray = $invoice->toArray();

        $this->assertNotNull($invoiceArray);
        $this->assertIsArray($invoiceArray);

        $this->assertArrayNotHasKey('transactions', $invoiceArray);
        $this->assertArrayNotHasKey('refundAddressRequestPending', $invoiceArray);
    }

    private function createClassObject(): Invoice
    {
        return new Invoice();
    }

    /**
     * @throws BitPayException
     */
    private function setObjectSetters(Invoice $invoice)
    {
        $invoice->setCurrency('BTC');
        $invoice->setGuid('Test guid');
        $invoice->setToken('4h2h7kee5eh2hh4');
        $invoice->setPrice(355.3);
        $invoice->setPosData('Test pos data');
        $invoice->setNotificationURL('http://test.com');
        $invoice->setTransactionSpeed('Test transaction speed');
        $invoice->setFullNotifications(true);
        $invoice->setNotificationEmail('test@email.com');
        $invoice->setRedirectURL('http://test.com');
        $invoice->setOrderId('34');
        $invoice->setItemDesc('Test item desc');
        $invoice->setItemCode('Test item code');
        $invoice->setPhysical(true);
        $invoice->setPaymentCurrencies(['BTC']);
        $invoice->setAcceptanceWindow(1.1);
        $invoice->setCloseURL('http://test.com');
        $invoice->setAutoRedirect(true);
        $invoice->setRefundAddresses(['Test refund address']);
        $invoice->setId('12');
        $invoice->setUrl('http://test.com');
        $invoice->setStatus('pending');
        $invoice->setLowFeeDetected('Low fee detected');
        $invoice->setInvoiceTime(1620734545366);
        $invoice->setExpirationTime('01:01:01');
        $invoice->setCurrentTime('01:01:01');
        $invoice->setTransactions([]);
        $invoice->setExceptionStatus('Exception status');
        $invoice->setTargetConfirmations(6);
        $invoice->setRefundAddressRequestPending(false);
        $invoice->setBuyerProvidedEmail('test@email.com');
        $invoice->setBillId('34');
        $invoice->setExtendedNotifications(true);
        $invoice->setTransactionCurrency('BTC');
        $invoice->setAmountPaid(12);
        $invoice->setExchangeRates($this->getExampleExchangeRates());
        $invoice->setMerchantName('Merchant name');
        $invoice->setSelectedTransactionCurrency('BTC');
        $invoice->setBitpayIdRequired(true);
        $invoice->setForcedBuyerSelectedWallet('Forced Buyer Selected Wallet');
        $invoice->setPaymentString('Payment string');
        $invoice->setVerificationLink('http://test.com');
        $invoice->setIsCancelled(true);
        $invoice->setBuyerEmail('test@email.com');
        $invoice->setBuyerSms('Buyer sms');
        $invoice->setForcedBuyerSelectedTransactionCurrency('BTC');
    }

    /**
     * @return array
     */
    private function getExampleExchangeRates(): array
    {
        return [
            "BTC" => [
                "USD" => 17120.09,
                "BCH" => 163.84429131974352,
                "ETH" => 13.299739755292292,
                "GUSD" => 17120.09,
                "PAX" => 17120.09,
                "BUSD" => 17120.09,
                "USDC" => 17120.09,
                "DOGE" => 188443.27083844703,
                "LTC" => 289.92531752751904,
                "MATIC" => 17878.1223893066,
                "USDC_m" => 17120.09
            ],
            "BCH" => [
                "USD" => 104.38999999999999,
                "BTC" => 0.006097902914889888,
                "ETH" => 0.08109535832200428,
                "GUSD" => 104.38999999999999,
                "PAX" => 104.38999999999999,
                "BUSD" => 104.38999999999999,
                "USDC" => 104.38999999999999,
                "DOGE" => 1149.0356092068141,
                "LTC" => 1.7678238780694326,
                "MATIC" => 109.01211361737676,
                "USDC_m" => 104.38999999999999
            ],
            "ETH" => [
                "USD" => 1286.54,
                "BTC" => 0.07515275424966411,
                "BCH" => 12.312565795769931,
                "GUSD" => 1286.54,
                "PAX" => 1286.54,
                "BUSD" => 1286.54,
                "USDC" => 1286.54,
                "DOGE" => 14161.129156709787,
                "LTC" => 21.787298899237936,
                "MATIC" => 1343.5045948203842,
                "USDC_m" => 1286.54
            ],
            "GUSD" => [
                "USD" => 1,
                "BTC" => 5.8414627022606464E-5,
                "BCH" => 0.009570293808019907,
                "ETH" => 7.768498737618955E-4,
                "PAX" => 1,
                "BUSD" => 1,
                "USDC" => 1,
                "DOGE" => 11.007142534790825,
                "LTC" => 0.01693480101608806,
                "MATIC" => 1.0442773600668336,
                "USDC_m" => 1
            ],
            "PAX" => [
                "USD" => 1,
                "BTC" => 5.8414627022606464E-5,
                "BCH" => 0.009570293808019907,
                "ETH" => 7.768498737618955E-4,
                "GUSD" => 1,
                "BUSD" => 1,
                "USDC" => 1,
                "DOGE" => 11.007142534790825,
                "LTC" => 0.01693480101608806,
                "MATIC" => 1.0442773600668336,
                "USDC_m" => 1
            ],
            "BUSD" => [
                "USD" => 1,
                "BTC" => 5.8414627022606464E-5,
                "BCH" => 0.009570293808019907,
                "ETH" => 7.768498737618955E-4,
                "GUSD" => 1,
                "PAX" => 1,
                "USDC" => 1,
                "DOGE" => 11.007142534790825,
                "LTC" => 0.01693480101608806,
                "MATIC" => 1.0442773600668336,
                "USDC_m" => 1
            ],
            "USDC" => [
                "USD" => 1,
                "BTC" => 5.8414627022606464E-5,
                "BCH" => 0.009570293808019907,
                "ETH" => 7.768498737618955E-4,
                "GUSD" => 1,
                "PAX" => 1,
                "BUSD" => 1,
                "DOGE" => 11.007142534790825,
                "LTC" => 0.01693480101608806,
                "MATIC" => 1.0442773600668336,
                "USDC_m" => 1
            ],
            "DOGE" => [
                "USD" => 0.09077389999999999,
                "BTC" => 5.302523511887377E-6,
                "BCH" => 8.687328930998182E-4,
                "ETH" => 7.051769275587492E-5,
                "GUSD" => 0.09077389999999999,
                "PAX" => 0.09077389999999999,
                "BUSD" => 0.09077389999999999,
                "USDC" => 0.09077389999999999,
                "LTC" => 0.0015372379339542762,
                "MATIC" => 0.09479312865497075,
                "USDC_m" => 0.09077389999999999
            ],
            "LTC" => [
                "USD" => 59.02,
                "BTC" => 0.0034476312868742336,
                "BCH" => 0.5648387405493349,
                "ETH" => 0.04584967954942708,
                "GUSD" => 59.02,
                "PAX" => 59.02,
                "BUSD" => 59.02,
                "USDC" => 59.02,
                "DOGE" => 649.6415524033546,
                "MATIC" => 61.63324979114453,
                "USDC_m" => 59.02
            ],
            "MATIC" => [
                "USD" => 0.9597999999999999,
                "BTC" => 5.6066359016297676E-5,
                "BCH" => 0.009185567996937507,
                "ETH" => 7.456205088366673E-4,
                "GUSD" => 0.9597999999999999,
                "PAX" => 0.9597999999999999,
                "BUSD" => 0.9597999999999999,
                "USDC" => 0.9597999999999999,
                "DOGE" => 10.564655404892232,
                "LTC" => 0.016254022015241322,
                "USDC_m" => 0.9597999999999999
            ],
            "USDC_m" => [
                "USD" => 1,
                "BTC" => 5.8414627022606464E-5,
                "BCH" => 0.009570293808019907,
                "ETH" => 7.768498737618955E-4,
                "GUSD" => 1,
                "PAX" => 1,
                "BUSD" => 1,
                "USDC" => 1,
                "DOGE" => 11.007142534790825,
                "LTC" => 0.01693480101608806,
                "MATIC" => 1.0442773600668336
            ]
        ];
    }
}
