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
        $invoice->setItemizedDetails([$expectedItemizedDetails]);

        $this->assertIsArray($invoice->getItemizedDetails());
        $this->assertNotNull($invoice->getItemizedDetails());

        foreach ($invoice->getItemizedDetails() as $item) {
            $this->assertArrayHasKey('amount', $item);
            $this->assertArrayHasKey('description', $item);
            $this->assertArrayHasKey('isFee', $item);
            $this->assertEquals($expectedArray, $item);
        }
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
        $expectedInvoiceTime = '01:01:01';

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
        $expectedTransaction = 'Test transaction';

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
        $expectedTargetConfirmation = 'Test target confirmation';

        $invoice = $this->createClassObject();
        $invoice->setTargetConfirmations($expectedTargetConfirmation);
        $this->assertEquals($expectedTargetConfirmation, $invoice->getTargetConfirmations());
    }

    public function testGetRefundAddressRequestPending()
    {
        $expectedRefundAddressRequestPending = 'Test Refund Address Request Pending';

        $invoice = $this->createClassObject();
        $invoice->setRefundAddressRequestPending($expectedRefundAddressRequestPending);
        $this->assertEquals($expectedRefundAddressRequestPending, $invoice->getRefundAddressRequestPending());
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
        $expectedPaymentTotals = 'Test payment totals';

        $invoice = $this->createClassObject();
        $invoice->setPaymentTotals($expectedPaymentTotals);
        $this->assertEquals($expectedPaymentTotals, $invoice->getPaymentTotals());
    }

    public function testGetPaymentSubTotals()
    {
        $expectedPaymentSubTotals = 'Test payment sub totals';

        $invoice = $this->createClassObject();
        $invoice->setPaymentSubTotals($expectedPaymentSubTotals);
        $this->assertEquals($expectedPaymentSubTotals, $invoice->getPaymentSubTotals());
    }

    public function testGetPaymentDisplaySubTotals()
    {
        $expectedPaymentDisplaySubTotals = 'Test payment display sub totals';

        $invoice = $this->createClassObject();
        $invoice->setPaymentDisplaySubTotals($expectedPaymentDisplaySubTotals);
        $this->assertEquals($expectedPaymentDisplaySubTotals, $invoice->getPaymentDisplaySubTotals());
    }

    public function testGetPaymentDisplayTotals()
    {
        $expectedPaymentDisplayTotals = 'Test payment display totals';

        $invoice = $this->createClassObject();
        $invoice->setPaymentDisplayTotals($expectedPaymentDisplayTotals);
        $this->assertEquals($expectedPaymentDisplayTotals, $invoice->getPaymentDisplayTotals());
    }

    public function testGetPaymentCodes()
    {
        $expectedPaymentCodes = 'Test payment codes';

        $invoice = $this->createClassObject();
        $invoice->setPaymentCodes($expectedPaymentCodes);
        $this->assertEquals($expectedPaymentCodes, $invoice->getPaymentCodes());
    }

    public function testGetUnderpaidAmount()
    {
        $expectedUnderpaidAmount = 'Test underpaid amount';

        $invoice = $this->createClassObject();
        $invoice->setUnderpaidAmount($expectedUnderpaidAmount);
        $this->assertEquals($expectedUnderpaidAmount, $invoice->getUnderpaidAmount());
    }

    public function testGetOverpaidAmount()
    {
        $expectedOverpaidAmount = 'Test overpaid amount';

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
        $expectedExchangeRates = 'Test exchange rates';

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
        $this->assertArrayHasKey('transactions', $invoiceArray);
        $this->assertArrayHasKey('exceptionStatus', $invoiceArray);
        $this->assertArrayHasKey('targetConfirmations', $invoiceArray);
        $this->assertArrayHasKey('refundAddressRequestPending', $invoiceArray);
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

        $this->assertEquals($invoiceArray['currency'], 'BTC');
        $this->assertEquals($invoiceArray['guid'], 'Test guid');
        $this->assertEquals($invoiceArray['token'], '4h2h7kee5eh2hh4');
        $this->assertEquals($invoiceArray['price'], 355.3);
        $this->assertEquals($invoiceArray['posData'], 'Test pos data');
        $this->assertEquals($invoiceArray['notificationURL'], 'http://test.com');
        $this->assertEquals($invoiceArray['transactionSpeed'], 'Test transaction speed');
        $this->assertTrue($invoiceArray['fullNotifications']);
        $this->assertEquals($invoiceArray['notificationEmail'], 'test@email.com');
        $this->assertEquals($invoiceArray['redirectURL'], 'http://test.com');
        $this->assertEquals($invoiceArray['orderId'], '34');
        $this->assertEquals($invoiceArray['itemDesc'], 'Test item desc');
        $this->assertEquals($invoiceArray['itemCode'], 'Test item code');
        $this->assertTrue($invoiceArray['physical']);
        $this->assertEquals($invoiceArray['paymentCurrencies'], ['BTC']);
        $this->assertEquals($invoiceArray['acceptanceWindow'], 1.1);
        $this->assertEquals($invoiceArray['closeURL'], 'http://test.com');
        $this->assertTrue($invoiceArray['autoRedirect']);
        $this->assertEquals($invoiceArray['refundAddresses'], ['Test refund address']);
        $this->assertEquals($invoiceArray['id'], '12');
        $this->assertEquals($invoiceArray['url'], 'http://test.com');
        $this->assertEquals($invoiceArray['status'], 'pending');
        $this->assertEquals($invoiceArray['lowFeeDetected'], 'Low fee detected');
        $this->assertEquals($invoiceArray['invoiceTime'], '01:01:01');
        $this->assertEquals($invoiceArray['expirationTime'], '01:01:01');
        $this->assertEquals($invoiceArray['currentTime'], '01:01:01');
        $this->assertEquals($invoiceArray['transactions'], 'Transactions');
        $this->assertEquals($invoiceArray['exceptionStatus'], 'Exception status');
        $this->assertEquals($invoiceArray['targetConfirmations'], 'Target confirmations');
        $this->assertEquals($invoiceArray['refundAddressRequestPending'], 'Refund address request pending');
        $this->assertEquals($invoiceArray['buyerProvidedEmail'], 'test@email.com');
        $this->assertEquals($invoiceArray['billId'], '34');
        $this->assertTrue($invoiceArray['extendedNotifications']);
        $this->assertEquals($invoiceArray['transactionCurrency'], 'BTC');
        $this->assertEquals($invoiceArray['amountPaid'], 12);
        $this->assertEquals($invoiceArray['exchangeRates'], 'ExchangeRates');
        $this->assertEquals($invoiceArray['merchantName'], 'Merchant name');
        $this->assertEquals($invoiceArray['selectedTransactionCurrency'], 'BTC');
        $this->assertTrue($invoiceArray['bitpayIdRequired']);
        $this->assertEquals($invoiceArray['forcedBuyerSelectedWallet'], 'Forced Buyer Selected Wallet');
        $this->assertEquals($invoiceArray['paymentString'], 'Payment string');
        $this->assertEquals($invoiceArray['verificationLink'], 'http://test.com');
        $this->assertTrue($invoiceArray['isCancelled']);
        $this->assertEquals($invoiceArray['buyerEmail'], 'test@email.com');
        $this->assertEquals($invoiceArray['buyerSms'], 'Buyer sms');
        $this->assertEquals($invoiceArray['forcedBuyerSelectedTransactionCurrency'], 'BTC');
    }

    public function testToArrayEmptyKey()
    {
        $invoice = $this->createClassObject();
        $invoiceArray = $invoice->toArray();

        $this->assertNotNull($invoiceArray);
        $this->assertIsArray($invoiceArray);

        $this->assertArrayNotHasKey('currency', $invoiceArray);
    }

    private function createClassObject()
    {
        return new Invoice();
    }

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
        $invoice->setInvoiceTime('01:01:01');
        $invoice->setExpirationTime('01:01:01');
        $invoice->setCurrentTime('01:01:01');
        $invoice->setTransactions('Transactions');
        $invoice->setExceptionStatus('Exception status');
        $invoice->setTargetConfirmations('Target confirmations');
        $invoice->setRefundAddressRequestPending('Refund address request pending');
        $invoice->setBuyerProvidedEmail('test@email.com');
        $invoice->setBillId('34');
        $invoice->setExtendedNotifications(true);
        $invoice->setTransactionCurrency('BTC');
        $invoice->setAmountPaid(12);
        $invoice->setExchangeRates('ExchangeRates');
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
}
