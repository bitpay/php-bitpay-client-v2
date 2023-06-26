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
use BitPaySDK\Model\Invoice\UniversalCodes;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function testInstanceOf()
    {
        $invoice = $this->createClassObject();
        self::assertInstanceOf(Invoice::class, $invoice);
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
        self::assertEquals($expectedCurrency, $invoice->getCurrency());
    }

    public function testGetGuid()
    {
        $expectedGuid = 'Test guid';

        $invoice = $this->createClassObject();
        $invoice->setGuid($expectedGuid);
        self::assertEquals($expectedGuid, $invoice->getGuid());
    }

    public function testGetToken()
    {
        $expectedToken = 's7k3f9v2nnn3kb3';

        $invoice = $this->createClassObject();
        $invoice->setToken($expectedToken);
        self::assertEquals($expectedToken, $invoice->getToken());
    }

    public function testGetPrice()
    {
        $expectedPrice = 150.25;

        $invoice = $this->createClassObject();
        $invoice->setPrice($expectedPrice);
        self::assertEquals($expectedPrice, $invoice->getPrice());
    }

    public function testGetPosData()
    {
        $expectedPostData = 'Test post data';

        $invoice = $this->createClassObject();
        $invoice->setPosData($expectedPostData);
        self::assertEquals($expectedPostData, $invoice->getPosData());
    }

    public function testGetNotificationURL()
    {
        $expectedNotificationURL = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setNotificationURL($expectedNotificationURL);
        self::assertEquals($expectedNotificationURL, $invoice->getNotificationURL());
    }

    public function testGetTransactionSpeed()
    {
        $expectedTransactionSpeed = 'Test transaction speed';

        $invoice = $this->createClassObject();
        $invoice->setTransactionSpeed($expectedTransactionSpeed);
        self::assertEquals($expectedTransactionSpeed, $invoice->getTransactionSpeed());
    }

    public function testGetFullNotifications()
    {
        $invoice = $this->createClassObject();
        $invoice->setFullNotifications(true);
        self::assertTrue($invoice->getFullNotifications());
    }

    public function testGetNotificationEmail()
    {
        $expectedNotificationEmail = 'test@email.com';

        $invoice = $this->createClassObject();
        $invoice->setNotificationEmail($expectedNotificationEmail);
        self::assertEquals($expectedNotificationEmail, $invoice->getNotificationEmail());
    }

    public function testGetRedirectURL()
    {
        $expectedRedirectURL = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setRedirectURL($expectedRedirectURL);
        self::assertEquals($expectedRedirectURL, $invoice->getRedirectURL());
    }

    public function testGetOrderId()
    {
        $expectedOrderId = '15';

        $invoice = $this->createClassObject();
        $invoice->setOrderId($expectedOrderId);
        self::assertEquals($expectedOrderId, $invoice->getOrderId());
    }

    public function testGetItemDesc()
    {
        $expectedItemDesc = 'Test item desc';

        $invoice = $this->createClassObject();
        $invoice->setItemDesc($expectedItemDesc);
        self::assertEquals($expectedItemDesc, $invoice->getItemDesc());
    }

    public function testGetItemCode()
    {
        $expectedItemCode = 'X3NH';

        $invoice = $this->createClassObject();
        $invoice->setItemCode($expectedItemCode);
        self::assertEquals($expectedItemCode, $invoice->getItemCode());
    }

    public function testGetPhysical()
    {
        $invoice = $this->createClassObject();
        $invoice->setPhysical(false);
        self::assertFalse($invoice->getPhysical());
    }

    public function testGetPaymentCurrencies()
    {
        $expectedPaymentCurrencies = ['BTC'];

        $invoice = $this->createClassObject();
        $invoice->setPaymentCurrencies($expectedPaymentCurrencies);
        self::assertEquals($expectedPaymentCurrencies, $invoice->getPaymentCurrencies());
    }

    public function testGetAcceptanceWindow()
    {
        $expectedAcceptanceWindow = 15.0;

        $invoice = $this->createClassObject();
        $invoice->setAcceptanceWindow($expectedAcceptanceWindow);
        self::assertEquals($expectedAcceptanceWindow, $invoice->getAcceptanceWindow());
    }

    public function testGetCloseURL()
    {
        $expectedCloseURL = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setCloseURL($expectedCloseURL);
        self::assertEquals($expectedCloseURL, $invoice->getCloseURL());
    }

    public function testGetAutoRedirect()
    {
        $invoice = $this->createClassObject();
        $invoice->setAutoRedirect(true);
        self::assertTrue($invoice->getAutoRedirect());
    }

    public function testGetJsonPayProRequired()
    {
        $invoice = $this->createClassObject();
        $invoice->setJsonPayProRequired(false);
        self::assertFalse($invoice->getJsonPayProRequired());
    }

    public function testGetBitpayIdRequired()
    {
        $invoice = $this->createClassObject();
        $invoice->setBitpayIdRequired(true);
        self::assertTrue($invoice->getBitpayIdRequired());
    }

    public function testGetMerchantName()
    {
        $expectedMerchantName = 'Test merchant name';

        $invoice = $this->createClassObject();
        $invoice->setMerchantName($expectedMerchantName);
        self::assertEquals($expectedMerchantName, $invoice->getMerchantName());
    }

    public function testGetSelectedTransactionCurrency()
    {
        $expectedSelectedTransactionCurrency = 'BTC';

        $invoice = $this->createClassObject();
        $invoice->setSelectedTransactionCurrency($expectedSelectedTransactionCurrency);
        self::assertEquals($expectedSelectedTransactionCurrency, $invoice->getSelectedTransactionCurrency());
    }

    public function testGetForcedBuyerSelectedWallet()
    {
        $expectedForcedBuyerSelectedWallet = 'Test wallet';

        $invoice = $this->createClassObject();
        $invoice->setForcedBuyerSelectedWallet($expectedForcedBuyerSelectedWallet);
        self::assertEquals($expectedForcedBuyerSelectedWallet, $invoice->getForcedBuyerSelectedWallet());
    }

    public function testGetForcedBuyerSelectedTransactionCurrency()
    {
        $expectedForcedBuyerSelectedTransactionCurrency = 'BTC';

        $invoice = $this->createClassObject();
        $invoice->setForcedBuyerSelectedTransactionCurrency($expectedForcedBuyerSelectedTransactionCurrency);
        self::assertEquals($expectedForcedBuyerSelectedTransactionCurrency, $invoice->getForcedBuyerSelectedTransactionCurrency());
    }

    /**
     * @throws BitPayException
     */
    public function testGetItemizedDetailsAsArray(): void
    {
        $expectedDescription = 'testDescription';
        $itemizedDetails = new ItemizedDetails();
        $itemizedDetails->setAmount(1);
        $itemizedDetails->setDescription($expectedDescription);
        $itemizedDetails->setIsFee(true);

        $invoice = $this->createClassObject();
        $invoice->setItemizedDetails([$itemizedDetails]);

        self::assertSame([$itemizedDetails], $invoice->getItemizedDetails());
        self::assertSame($expectedDescription, $invoice->getItemizedDetails()[0]->getDescription());
        self::assertInstanceOf(ItemizedDetails::class, $invoice->getItemizedDetails()[0]);
    }

    public function testGetBuyer()
    {
        $expectedBuyer = $this->getMockBuilder(Buyer::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setBuyer($expectedBuyer);
        self::assertEquals($expectedBuyer, $invoice->getBuyer());
    }

    public function testGetBuyerEmail()
    {
        $expectedBuyerEmail = 'test@email.com';

        $invoice = $this->createClassObject();
        $invoice->setBuyerEmail($expectedBuyerEmail);
        self::assertEquals($expectedBuyerEmail, $invoice->getBuyerEmail());
    }

    public function testGetBuyerSms()
    {
        $expectedBuyerSms = 'Test buyer sms';

        $invoice = $this->createClassObject();
        $invoice->setBuyerSms($expectedBuyerSms);
        self::assertEquals($expectedBuyerSms, $invoice->getBuyerSms());
    }

    public function testGetRefundAddresses()
    {
        $expectedRefundAddresses = ['Test refund address'];

        $invoice = $this->createClassObject();
        $invoice->setRefundAddresses($expectedRefundAddresses);
        self::assertEquals($expectedRefundAddresses, $invoice->getRefundAddresses());
    }

    public function testGetId()
    {
        $expectedId = '12';

        $invoice = $this->createClassObject();
        $invoice->setId($expectedId);
        self::assertEquals($expectedId, $invoice->getId());
    }

    public function testGetUrl()
    {
        $expectedUrl = 'http://test.com';

        $invoice = $this->createClassObject();
        $invoice->setUrl($expectedUrl);
        self::assertEquals($expectedUrl, $invoice->getUrl());
    }

    public function testGetStatus()
    {
        $expectedStatus = 'pending';

        $invoice = $this->createClassObject();
        $invoice->setStatus($expectedStatus);
        self::assertEquals($expectedStatus, $invoice->getStatus());
    }

    public function testGetFeeDetected()
    {
        $invoice = $this->createClassObject();
        $invoice->setLowFeeDetected(true);
        self::assertTrue($invoice->getLowFeeDetected());
    }

    public function testGetInvoiceTime()
    {
        $expectedInvoiceTime = 1620669854224;

        $invoice = $this->createClassObject();
        $invoice->setInvoiceTime($expectedInvoiceTime);
        self::assertEquals($expectedInvoiceTime, $invoice->getInvoiceTime());
    }

    public function testGetExpirationTime()
    {
        $expectedExpirationTime = '01:01:01';

        $invoice = $this->createClassObject();
        $invoice->setExpirationTime($expectedExpirationTime);
        self::assertEquals($expectedExpirationTime, $invoice->getExpirationTime());
    }

    public function testGetCurrentTime()
    {
        $expectedCurrencyTime = '01:01:01';

        $invoice = $this->createClassObject();
        $invoice->setCurrentTime($expectedCurrencyTime);
        self::assertEquals($expectedCurrencyTime, $invoice->getCurrentTime());
    }

    public function testGetTransactions()
    {
        $expectedTransaction = [];

        $invoice = $this->createClassObject();
        $invoice->setTransactions($expectedTransaction);
        self::assertEquals($expectedTransaction, $invoice->getTransactions());
    }

    public function testGetExceptionStatus()
    {
        $expectedExceptionStatus = 'Test exception status';

        $invoice = $this->createClassObject();
        $invoice->setExceptionStatus($expectedExceptionStatus);
        self::assertEquals($expectedExceptionStatus, $invoice->getExceptionStatus());
    }

    public function testGetTargetConfirmations()
    {
        $expectedTargetConfirmation = 6;

        $invoice = $this->createClassObject();
        $invoice->setTargetConfirmations($expectedTargetConfirmation);
        self::assertEquals($expectedTargetConfirmation, $invoice->getTargetConfirmations());
    }

    public function testGetRefundAddressRequestPending()
    {
        $invoice = $this->createClassObject();
        $invoice->setRefundAddressRequestPending(false);
        self::assertFalse($invoice->getRefundAddressRequestPending());
    }

    public function testGetBuyerProvidedEmail()
    {
        $expectedBuyerProvidedEmail = 'test@email.com';

        $invoice = $this->createClassObject();
        $invoice->setBuyerProvidedEmail($expectedBuyerProvidedEmail);
        self::assertEquals($expectedBuyerProvidedEmail, $invoice->getBuyerProvidedEmail());
    }

    public function testGetBuyerProvidedInfo()
    {
        $expectedBuyerProvidedInfo = $this->getMockBuilder(BuyerProvidedInfo::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setBuyerProvidedInfo($expectedBuyerProvidedInfo);
        self::assertEquals($expectedBuyerProvidedInfo, $invoice->getBuyerProvidedInfo());
    }

    public function testGetUniversalCodes()
    {
        $expectedUniversalCodes = $this->getMockBuilder(UniversalCodes::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setUniversalCodes($expectedUniversalCodes);
        self::assertEquals($expectedUniversalCodes, $invoice->getUniversalCodes());
    }

    public function testGetSupportedTransactionCurrencies()
    {
        $expectedSupportedTransactionCurrencies = $this->getMockBuilder(SupportedTransactionCurrencies::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setSupportedTransactionCurrencies($expectedSupportedTransactionCurrencies);
        self::assertEquals($expectedSupportedTransactionCurrencies, $invoice->getSupportedTransactionCurrencies());
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
        self::assertEquals($expectedPaymentTotals, $invoice->getPaymentTotals());
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
        $invoice->setPaymentSubtotals($expectedPaymentSubTotals);
        self::assertEquals($expectedPaymentSubTotals, $invoice->getPaymentSubtotals());
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
        self::assertEquals($expectedPaymentDisplaySubTotals, $invoice->getPaymentDisplaySubTotals());
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
        self::assertEquals($expectedPaymentDisplayTotals, $invoice->getPaymentDisplayTotals());
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
        self::assertEquals($expectedPaymentCodes, $invoice->getPaymentCodes());
    }

    public function testGetUnderpaidAmount()
    {
        $expectedUnderpaidAmount = 10;

        $invoice = $this->createClassObject();
        $invoice->setUnderpaidAmount($expectedUnderpaidAmount);
        self::assertEquals($expectedUnderpaidAmount, $invoice->getUnderpaidAmount());
    }

    public function testGetOverpaidAmount()
    {
        $expectedOverpaidAmount = 10;

        $invoice = $this->createClassObject();
        $invoice->setOverpaidAmount($expectedOverpaidAmount);
        self::assertEquals($expectedOverpaidAmount, $invoice->getOverpaidAmount());
    }

    public function testGetMinerFees()
    {
        $expectedMinerFees = $this->getMockBuilder(MinerFees::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setMinerFees($expectedMinerFees);
        self::assertEquals($expectedMinerFees, $invoice->getMinerFees());
    }

    public function testGetNonPayProPaymentReceived()
    {
        $invoice = $this->createClassObject();
        $invoice->setNonPayProPaymentReceived(true);
        self::assertTrue($invoice->getNonPayProPaymentReceived());
    }

    public function testGetShopper()
    {
        $expectedShopper = $this->getMockBuilder(Shopper::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setShopper($expectedShopper);
        self::assertEquals($expectedShopper, $invoice->getShopper());
    }

    public function testGetBillId()
    {
        $expectedBillId = '123';

        $invoice = $this->createClassObject();
        $invoice->setBillId($expectedBillId);
        self::assertEquals($expectedBillId, $invoice->getBillId());
    }

    public function testGetRefundInfo()
    {
        $expectedRefundInfo = $this->getMockBuilder(RefundInfo::class)->getMock();

        $invoice = $this->createClassObject();
        $invoice->setRefundInfo($expectedRefundInfo);
        self::assertEquals($expectedRefundInfo, $invoice->getRefundInfo());
    }

    public function testGetExtendedNotifications()
    {
        $invoice = $this->createClassObject();
        $invoice->setExtendedNotifications(false);
        self::assertFalse($invoice->getExtendedNotifications());
    }

    public function testgetTransactionCurrency()
    {
        $expectedTransactionCurrency = 'BTC';

        $invoice = $this->createClassObject();
        $invoice->setTransactionCurrency($expectedTransactionCurrency);
        self::assertEquals($expectedTransactionCurrency, $invoice->getTransactionCurrency());
    }

    public function testGetAmountPaid()
    {
        $expectedAmountPaid = 11;

        $invoice = $this->createClassObject();
        $invoice->setAmountPaid($expectedAmountPaid);
        self::assertEquals($expectedAmountPaid, $invoice->getAmountPaid());
    }

    public function testGetDisplayAmountPaid()
    {
        $expectedDisplayAmountPaid = 'Test display amount paid';

        $invoice = $this->createClassObject();
        $invoice->setDisplayAmountPaid($expectedDisplayAmountPaid);
        self::assertEquals($expectedDisplayAmountPaid, $invoice->getDisplayAmountPaid());
    }

    public function testGetExchangeRates()
    {
        $expectedExchangeRates = $this->getExampleExchangeRates();

        $invoice = $this->createClassObject();
        $invoice->setExchangeRates($expectedExchangeRates);
        self::assertEquals($expectedExchangeRates, $invoice->getExchangeRates());
    }

    public function testGetIsCancelled()
    {
        $invoice = $this->createClassObject();
        $invoice->setIsCancelled(false);
        self::assertFalse($invoice->getIsCancelled());
    }

    /**
     * @throws BitPayException
     */
    public function testToArray()
    {
        $invoice = $this->createClassObject();
        $this->setObjectSetters($invoice);
        $invoiceArray = $invoice->toArray();

        self::assertNotNull($invoiceArray);
        self::assertIsArray($invoiceArray);

        self::assertArrayHasKey('currency', $invoiceArray);
        self::assertArrayHasKey('guid', $invoiceArray);
        self::assertArrayHasKey('token', $invoiceArray);
        self::assertArrayHasKey('price', $invoiceArray);
        self::assertArrayHasKey('posData', $invoiceArray);
        self::assertArrayHasKey('notificationURL', $invoiceArray);
        self::assertArrayHasKey('transactionSpeed', $invoiceArray);
        self::assertArrayHasKey('fullNotifications', $invoiceArray);
        self::assertArrayHasKey('notificationEmail', $invoiceArray);
        self::assertArrayHasKey('redirectURL', $invoiceArray);
        self::assertArrayHasKey('orderId', $invoiceArray);
        self::assertArrayHasKey('itemDesc', $invoiceArray);
        self::assertArrayHasKey('itemCode', $invoiceArray);
        self::assertArrayHasKey('physical', $invoiceArray);
        self::assertArrayHasKey('paymentCurrencies', $invoiceArray);
        self::assertArrayHasKey('acceptanceWindow', $invoiceArray);
        self::assertArrayHasKey('closeURL', $invoiceArray);
        self::assertArrayHasKey('autoRedirect', $invoiceArray);
        self::assertArrayHasKey('refundAddresses', $invoiceArray);
        self::assertArrayHasKey('id', $invoiceArray);
        self::assertArrayHasKey('url', $invoiceArray);
        self::assertArrayHasKey('status', $invoiceArray);
        self::assertArrayHasKey('lowFeeDetected', $invoiceArray);
        self::assertArrayHasKey('invoiceTime', $invoiceArray);
        self::assertArrayHasKey('expirationTime', $invoiceArray);
        self::assertArrayHasKey('currentTime', $invoiceArray);
        self::assertArrayHasKey('exceptionStatus', $invoiceArray);
        self::assertArrayHasKey('targetConfirmations', $invoiceArray);
//        self::assertArrayHasKey('refundAddressRequestPending', $invoiceArray);
        self::assertArrayHasKey('buyerProvidedEmail', $invoiceArray);
        self::assertArrayHasKey('billId', $invoiceArray);
        self::assertArrayHasKey('extendedNotifications', $invoiceArray);
        self::assertArrayHasKey('transactionCurrency', $invoiceArray);
        self::assertArrayHasKey('amountPaid', $invoiceArray);
        self::assertArrayHasKey('exchangeRates', $invoiceArray);
        self::assertArrayHasKey('merchantName', $invoiceArray);
        self::assertArrayHasKey('selectedTransactionCurrency', $invoiceArray);
        self::assertArrayHasKey('bitpayIdRequired', $invoiceArray);
        self::assertArrayHasKey('forcedBuyerSelectedWallet', $invoiceArray);
        self::assertArrayHasKey('isCancelled', $invoiceArray);
        self::assertArrayHasKey('buyerEmail', $invoiceArray);
        self::assertArrayHasKey('buyerSms', $invoiceArray);
        self::assertArrayHasKey('forcedBuyerSelectedTransactionCurrency', $invoiceArray);

        self::assertEquals('BTC', $invoiceArray['currency']);
        self::assertEquals('Test guid', $invoiceArray['guid']);
        self::assertEquals('4h2h7kee5eh2hh4', $invoiceArray['token']);
        self::assertEquals(355.3, $invoiceArray['price']);
        self::assertEquals('Test pos data', $invoiceArray['posData']);
        self::assertEquals('http://test.com', $invoiceArray['notificationURL']);
        self::assertEquals('Test transaction speed', $invoiceArray['transactionSpeed']);
        self::assertTrue($invoiceArray['fullNotifications']);
        self::assertEquals('test@email.com', $invoiceArray['notificationEmail']);
        self::assertEquals('http://test.com', $invoiceArray['redirectURL']);
        self::assertEquals('34', $invoiceArray['orderId']);
        self::assertEquals('Test item desc', $invoiceArray['itemDesc']);
        self::assertEquals('Test item code', $invoiceArray['itemCode']);
        self::assertTrue($invoiceArray['physical']);
        self::assertEquals(['BTC'], $invoiceArray['paymentCurrencies']);
        self::assertEquals(1.1, $invoiceArray['acceptanceWindow']);
        self::assertEquals('http://test.com', $invoiceArray['closeURL']);
        self::assertTrue($invoiceArray['autoRedirect']);
        self::assertEquals(['Test refund address'], $invoiceArray['refundAddresses']);
        self::assertEquals('12', $invoiceArray['id']);
        self::assertEquals('http://test.com', $invoiceArray['url']);
        self::assertEquals('pending', $invoiceArray['status']);
        self::assertEquals('Low fee detected', $invoiceArray['lowFeeDetected']);
        self::assertEquals(1620734545366, $invoiceArray['invoiceTime']);
        self::assertEquals('01:01:01', $invoiceArray['expirationTime']);
        self::assertEquals('01:01:01', $invoiceArray['currentTime']);
        self::assertEquals('Exception status', $invoiceArray['exceptionStatus']);
        self::assertEquals(6, $invoiceArray['targetConfirmations']);
        self::assertEquals('test@email.com', $invoiceArray['buyerProvidedEmail']);
        self::assertEquals('34', $invoiceArray['billId']);
        self::assertTrue($invoiceArray['extendedNotifications']);
        self::assertEquals('BTC', $invoiceArray['transactionCurrency']);
        self::assertEquals(12, $invoiceArray['amountPaid']);
        self::assertEquals($this->getExampleExchangeRates(), $invoiceArray['exchangeRates']);
        self::assertEquals('Merchant name', $invoiceArray['merchantName']);
        self::assertEquals('BTC', $invoiceArray['selectedTransactionCurrency']);
        self::assertTrue($invoiceArray['bitpayIdRequired']);
        self::assertEquals('Forced Buyer Selected Wallet', $invoiceArray['forcedBuyerSelectedWallet']);
        self::assertTrue($invoiceArray['isCancelled']);
        self::assertEquals('test@email.com', $invoiceArray['buyerEmail']);
        self::assertEquals('Buyer sms', $invoiceArray['buyerSms']);
        self::assertEquals('BTC', $invoiceArray['forcedBuyerSelectedTransactionCurrency']);
    }

    public function testToArrayEmptyKey()
    {
        $invoice = $this->createClassObject();
        $invoiceArray = $invoice->toArray();

        self::assertNotNull($invoiceArray);
        self::assertIsArray($invoiceArray);

        self::assertArrayNotHasKey('transactions', $invoiceArray);
        self::assertArrayNotHasKey('refundAddressRequestPending', $invoiceArray);
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
