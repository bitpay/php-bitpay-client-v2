<?php

namespace BitPaySDK\Test;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BillCreationException;
use BitPaySDK\Exceptions\BillDeliveryException;
use BitPaySDK\Exceptions\BillQueryException;
use BitPaySDK\Exceptions\BillUpdateException;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\InvoiceCancellationException;
use BitPaySDK\Exceptions\InvoiceCreationException;
use BitPaySDK\Exceptions\InvoicePaymentException;
use BitPaySDK\Exceptions\InvoiceQueryException;
use BitPaySDK\Exceptions\InvoiceUpdateException;
use BitPaySDK\Exceptions\PayoutCancellationException;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutNotificationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Exceptions\PayoutRecipientCancellationException;
use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use BitPaySDK\Exceptions\PayoutRecipientNotificationException;
use BitPaySDK\Exceptions\PayoutRecipientQueryException;
use BitPaySDK\Exceptions\PayoutRecipientUpdateException;
use BitPaySDK\Exceptions\RateQueryException;
use BitPaySDK\Exceptions\RefundCancellationException;
use BitPaySDK\Exceptions\RefundCreationException;
use BitPaySDK\Exceptions\RefundNotificationException;
use BitPaySDK\Exceptions\RefundQueryException;
use BitPaySDK\Exceptions\RefundUpdateException;
use BitPaySDK\Exceptions\SettlementQueryException;
use BitPaySDK\Exceptions\SubscriptionCreationException;
use BitPaySDK\Exceptions\SubscriptionQueryException;
use BitPaySDK\Exceptions\WalletQueryException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Model\Wallet\Wallet;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use PHPUnit\Framework\TestCase;
use BitPaySDK\Env;
use BitPaySDK\Tokens;


class ClientTest extends TestCase
{
    private const TOKEN = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
    private const CORRUPT_JSON_STRING = '{"code":"USD""name":"US Dollar","rate":21205.85}';
    private const TEST_INVOICE_ID = 'UZjwcYkWAKfTMn9J1yyfs4';
    private const CORRECT_JSON_STRING = '[ 
        { "currency": "EUR", "balance": 0 }, 
        { "currency": "USD", "balance": 2389.82 }, 
        { "currency": "BTC", "balance": 0.000287 } 
    ]';
    private const CANCEL_REFUND_JSON_STRING = '{
        "id": "WoE46gSLkJQS48RJEiNw3L",
        "invoice": "Hpqc63wvE1ZjzeeH4kEycF",
        "reference": "Test refund",
        "status": "cancelled",
        "amount": 10,
        "transactionCurrency": "BTC",
        "transactionAmount": 0.000594,
        "transactionRefundFee": 0.000002,
        "currency": "USD",
        "lastRefundNotification": "2021-08-29T20:45:35.368Z",
        "refundFee": 0.04,
        "immediate": false,
        "buyerPaysRefundFee": false,
        "requestDate": "2021-08-29T20:45:34.000Z"
    }';
    private const UPDATE_REFUND_JSON_STRING = '{"id": "WoE46gSLkJQS48RJEiNw3L",
        "invoice": "Hpqc63wvE1ZjzeeH4kEycF",
        "reference": "Test refund",
        "status": "created",
        "amount": 10,
        "transactionCurrency": "BTC",
        "transactionAmount": 0.000594,
        "transactionRefundFee": 0.000002,
        "currency": "USD",
        "lastRefundNotification": "2021-08-29T20:45:35.368Z",
        "refundFee": 0.04,
        "immediate": false,
        "buyerPaysRefundFee": false,
        "requestDate": "2021-08-29T20:45:34.000Z"
    }';

    /**
     * @throws BitPayException
     */
    public function testWithData()
    {
        $tokens = $this->createMock(Tokens::class);
        $result = $this->getTestedClassInstance()::createWithData(
            Env::Test,
            __DIR__ . '/../../../examples/bitpay_private_test.key',
            $tokens,
            'YourMasterPassword'
        );

        $this->assertInstanceOf(Client::class, $result);
    }

    public function testWithDataException()
    {
        $instance = $this->getTestedClassInstance();
        $tokens = $this->createMock(Tokens::class);
        $this->expectException(BitPayException::class);

        $instance::createWithData(
            Env::Test,
            __DIR__ . '/../../../examples/bitpay_private_test.key',
            $tokens,
            'badPassword'
        );
    }

    /**
     * @throws BitPayException
     */
    public function testWithFileJsonConfig(): Client
    {
        $instance = $this->getTestedClassInstance();
        $result = $instance::createWithFile(__DIR__ . '/../../../examples/BitPay.config.json');
        $this->assertInstanceOf(Client::class, $result);
        return $result;
    }

    /**
     * @throws BitPayException
     */
    public function testWithFileYmlConfig()
    {
        $instance = $this->getTestedClassInstance();
        $result = $instance::createWithFile(__DIR__ . '/../../../examples/BitPay.config.yml');
        $this->assertInstanceOf(Client::class, $result);
    }

    public function testWithFileException()
    {
        $instance = $this->getTestedClassInstance();
        $this->expectException(BitPayException::class);
        $instance::createWithFile('badpath');
    }

    public function testCreateBill()
    {
        $expectedId = 'X6KJbe9RxAGWNReCwd1xRw';
        $expectedStatus = 'draft';
        $expectedToken = 'qVVgRARN6fKtNZ7Tcq6qpoPBBE3NxdrmdMD883RyMK4Pf8EHENKVxCXhRwyynWveo';

        $billMock = $this->createMock(Bill::class);
        $billToArray = [
            'id' => $expectedId,
            'status' => $expectedStatus,
            'token' => $expectedToken,
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/createBillResponse.json'));

        $billClient = $this->getClient($restCliMock);
        $createdBill = $billClient->createBill($billMock, Facade::Merchant);

        $this->assertEquals($expectedId, $createdBill->getId());
        $this->assertEquals($expectedStatus, $createdBill->getStatus());
        $this->assertEquals($expectedToken, $createdBill->getToken());
    }

    public function testCreateBillException()
    {
        $billMock = $this->createMock(Bill::class);
        $restCliMock = $this->getRestCliMock();
        $billToArray = [
            'id' => 'testId',
            'status' => 'status',
            'token' => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willThrowException(new BitPayException());
        $billClient = $this->getClient($restCliMock);

        $this->expectException(BillCreationException::class);

        $billClient->createBill($billMock, Facade::Merchant);
    }

    public function testCreateBillShouldCatchRestCliException()
    {
        $billMock = $this->createMock(Bill::class);
        $billToArray = [
            'id' => 'testId',
            'status' => 'status',
            'token' => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(BillCreationException::class);
        $client->createBill($billMock, Facade::Merchant, true);
    }

    public function testCreateBillShouldCatchJsonMapperException()
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillId = 'testId';
        $exampleBadResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $billToArray = [
            'id' => $exampleBillId,
            'status' => 'status',
            'token' => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willReturn($exampleBadResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BillCreationException::class);
        $client->createBill($billMock, Facade::Merchant, true);
    }

    public function testGetBill()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/getBill.json'));

        $client = $this->getClient($restCliMock);

        $result = $client->getBill($exampleBillId);

        $this->assertEquals(
            '6EBQR37MgDJPfEiLY3jtRq7eTP2aodR5V5wmXyyZhru5FM5yF4RCGKYQtnT7nhwHjA',
            $result->getToken()
        );
        $this->assertInstanceOf(Bill::class, $result);
    }

    public function testGetBillShouldCatchRestCliBitPayException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willThrowException(new BillQueryException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BillQueryException::class);
        $client->getBill($exampleBillId);
    }

    public function testGetBillShouldCatchRestCliException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(Exception::class);
        $client->getBill($exampleBillId);
    }

    public function testGetBillShouldCatchJsonMapperException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBadResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleBadResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BillQueryException::class);
        $client->getBill($exampleBillId);
    }

    public function testGetBills()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBills.json');
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getBills($status);
        $this->assertIsArray($result);
        $this->assertEquals(
            '6EBQR37MgDJPfEiLY3jtRqBMYLg8XSDqhp2kp7VSDqCMHGHnsw4bqnnwQmtehzCvSo',
            $result[0]->getToken()
        );
        $this->assertEquals(
            '6EBQR37MgDJPfEiLY3jtRq7eTP2aodR5V5wmXyyZhru5FM5yF4RCGKYQtnT7nhwHjA',
            $result[1]->getToken()
        );
        $this->assertInstanceOf(Bill::class, $result[0]);
        $this->assertInstanceOf(Bill::class, $result[1]);
    }

    public function testGetBillsShouldCatchJsonMapperException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BillQueryException::class);
        $client->getBills($status);
    }

    public function testGetBillsShouldCatchRestCliBitPayException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills", $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BillQueryException::class);
        $client->getBills($status);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillsShouldCatchRestCliException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills", $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(BillQueryException::class);
        $client->getBills($status);
    }

    public function testUpdateBill()
    {
        $billMock = $this->createMock(Bill::class);
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBill.json');

        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';

        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id' => $exampleBillId,
            'status' => 'status',
            'token' => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willReturn($exampleResponse);
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->updateBill($billMock, $exampleBillId);
        $this->assertInstanceOf(Bill::class, $result);
    }

    public function testUpdateBillShouldCatchRestCliBitPayException()
    {
        $billMock = $this->createMock(Bill::class);
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBill.json', true);
        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id' => $exampleBillId,
            'status' => 'status',
            'token' => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willThrowException(new BitPayException());

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BillUpdateException::class);
        $client->updateBill($billMock, $exampleBillId);
    }

    public function testUpdateBillShouldCatchRestCliException()
    {
        $billMock = $this->createMock(Bill::class);
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBill.json');
        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id' => $exampleBillId,
            'status' => 'status',
            'token' => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willThrowException(new Exception());

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BillUpdateException::class);
        $client->updateBill($billMock, $exampleBillId);
    }

    public function testUpdateBillShouldCatchJsonMapperException()
    {
        $billMock = $this->createMock(Bill::class);
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBill.json');
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id' => $exampleBillId,
            'status' => 'status',
            'token' => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willReturn($badResponse);

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BillUpdateException::class);
        $client->updateBill($billMock, $exampleBillId);
    }

    public function testDeliverBill()
    {
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBillToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBill.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("bills/" . $exampleBillId . '/deliveries', ['token' => $exampleBillToken])
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->deliverBill($exampleBillId, $exampleBillToken);
        $this->assertIsString($result);
    }

    public function testDeliverBillShouldCatchRestCliBitPayException()
    {
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBillToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("bills/" . $exampleBillId . '/deliveries', ['token' => $exampleBillToken])
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BillDeliveryException::class);
        $client->deliverBill($exampleBillId, $exampleBillToken);
    }

    public function testDeliverBillShouldCatchRestCliException()
    {
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBillToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("bills/" . $exampleBillId . '/deliveries', ['token' => $exampleBillToken])
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(BillDeliveryException::class);
        $client->deliverBill($exampleBillId, $exampleBillToken);
    }

//    public function testGetLedger()
//    {
//        $exampleCurrency = Currency::BTC;
//        $exampleStartDate = '2021-5-10';
//        $exampleEndDate = '2021-5-31';
//        $restCliMock = $this->getRestCliMock();
//        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getLedgerBalances.json');
//
//        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
//        $params["currency"] = $exampleCurrency;
//        $params["startDate"] = $exampleStartDate;
//        $params["endDate"] = $exampleEndDate;
//
//        $restCliMock
//            ->expects($this->once())
//            ->method('get')
//            ->with("ledgers/" . $exampleCurrency, $params)
//            ->willReturn($exampleResponse);
//
//        $client = $this->getClient($restCliMock);
//        $result = $client->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
//
//        $this->assertIsArray($result);
//        $this->assertEquals('EUR', $result[0]->getCurrency());
//        $this->assertEquals('USD', $result[1]->getCurrency());
//        $this->assertEquals('BTC', $result[2]->getCurrency());
//        $this->assertInstanceOf(LedgerEntry::class, $result[0]);
//    }
//
//    public function testGetLedgerShouldCatchRestCliException()
//    {
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock
//            ->expects($this->once())
//            ->method('get')
//            ->willThrowException(new \Exception());
//
//        $client = $this->getClient($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $exampleCurrency = Currency::BTC;
//        $exampleStartDate = '2021-5-10';
//        $exampleEndDate = '2021-5-31';
//        $client->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
//    }
//
//    public function testGetLedgerShouldCatchRestCliBitPayException()
//    {
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock->expects($this->once())->method('get')->willThrowException(new BitPayException());
//
//        $client = $this->getClient($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $exampleCurrency = Currency::BTC;
//        $exampleStartDate = '2021-5-10';
//        $exampleEndDate = '2021-5-31';
//        $client->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
//    }
//
//    public function testGetLedgerShouldCatchJsonMapperException()
//    {
//        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
//
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock
//            ->expects($this->once())
//            ->method('get')
//            ->willReturn($badResponse);
//
//        $client = $this->getClient($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $exampleCurrency = Currency::BTC;
//        $exampleStartDate = '2021-5-10';
//        $exampleEndDate = '2021-5-31';
//        $client->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
//    }
//
//    public function testGetLedgers()
//    {
//        $restCliMock = $this->getRestCliMock();
//        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
//        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getLedgers.json');
//
//        $restCliMock
//            ->expects($this->once())
//            ->method('get')
//            ->with("ledgers", $params)
//            ->willReturn($exampleResponse);
//
//        $client = $this->getClient($restCliMock);
//
//        $result = $client->getLedgers();
//
//
//        $this->assertIsArray($result);
//        $this->assertInstanceOf(Ledger::class, $result[0]);
//    }
//
//    public function testGetLedgersShouldCatchBitPayException()
//    {
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock->expects($this->once())->method('get')->willThrowException(new BitPayException());
//
//        $client = $this->getClient($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $client->getLedgers();
//    }
//
//    public function testGetLedgersShouldCatchRestCliException()
//    {
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock->expects($this->once())->method('get')->willThrowException(new Exception());
//
//        $client = $this->getClient($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $client->getLedgers();
//    }
//
//    public function testGetLedgersShouldCatchJsonMapperException()
//    {
//        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
//
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock->expects($this->once())->method('get')->willReturn($badResponse);
//
//        $client = $this->getClient($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $client->getLedgers();
//    }

    public function testSubmitPayoutRecipients()
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/submitPayoutRecipientsResponse.json');

        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->submitPayoutRecipients($payoutRecipientsMock);
        $this->assertIsArray($result);
    }

    public function testSubmitPayoutRecipientsShouldCatchRestCliBitPayException()
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'X6KJbe9RxAGWNReCwd1xRw';
        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientCreationException::class);
        $client->submitPayoutRecipients($payoutRecipientsMock);
    }

    public function testSubmitPayoutRecipientsShouldCatchRestCliException()
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'X6KJbe9RxAGWNReCwd1xRw';
        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(Exception::class);
        $client->submitPayoutRecipients($payoutRecipientsMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutRecipientsShouldCatchJsonMapperException()
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'X6KJbe9RxAGWNReCwd1xRw';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientCreationException::class);
        $client->submitPayoutRecipients($payoutRecipientsMock);
    }

    public function testGetPayoutRecipient()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $recipientId = 'test';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayoutRecipient.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getPayoutRecipient($recipientId);
        $this->assertInstanceOf(PayoutRecipient::class, $result);
    }

    public function testGetPayoutRecipientShouldHandleRestCliBitPayException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $recipientId = 'test';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $client->getPayoutRecipient($recipientId);
    }

    public function testGetPayoutRecipientShouldHandleRestCliException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $recipientId = 'test';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $client->getPayoutRecipient($recipientId);
    }

    public function testGetPayoutRecipientShouldHandleJsonMapperException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $recipientId = 'test';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutQueryException::class);
        $client->getPayoutRecipient($recipientId);
    }

    public function testGetPayoutRecipients()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayoutRecipients.json');

        $status = 'status';
        $limit = 2;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getPayoutRecipients($status, $limit, $offset);
        $this->assertIsArray($result);
        $this->assertInstanceOf(PayoutRecipient::class, $result[0]);
    }

    public function testGetPayoutRecipientsShouldHandleRestCliBitPayException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients", $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $client->getPayoutRecipients($status, $limit, $offset);
    }

    public function testGetPayoutRecipientsShouldHandleRestCliException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients", $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $client->getPayoutRecipients($status, $limit, $offset);
    }

    public function testGetPayoutRecipientsShouldHandleJsonMapperException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("recipients", $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $client->getPayoutRecipients($status, $limit, $offset);
    }

    public function testUpdatePayoutRecipient()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayoutRecipients.json');
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
        $this->assertInstanceOf(PayoutRecipient::class, $result);
    }

    public function testUpdatePayoutRecipientShouldCatchRestCliBitPayException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientUpdateException::class);
        $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    public function testUpdatePayoutRecipientShouldCatchRestCliException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientUpdateException::class);
        $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    public function testUpdatePayoutRecipientShouldCatchJsonMapperException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $payoutRecipientToArray = [
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb',
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientUpdateException::class);
        $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    public function testDeletePayoutRecipient()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $successResponse = file_get_contents(__DIR__ . '/jsonResponse/success.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willReturn($successResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->deletePayoutRecipient($exampleRecipientId);
        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    public function testDeletePayoutRecipientShouldCatchRestCliBitPayException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientCancellationException::class);
        $client->deletePayoutRecipient($exampleRecipientId);
    }

    public function testDeletePayoutRecipientShouldCatchRestCliException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientCancellationException::class);
        $client->deletePayoutRecipient($exampleRecipientId);
    }

    public function testDeletePayoutRecipientShouldCatchJsonDecodeException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/false.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->assertFalse($client->deletePayoutRecipient($exampleRecipientId));
    }

    public function testRequestPayoutRecipientNotification()
    {
        $content['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $successResponse = file_get_contents(__DIR__ . '/jsonResponse/success.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willReturn($successResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->requestPayoutRecipientNotification($exampleRecipientId);
        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    public function testRequestPayoutRecipientNotificationShouldCatchRestCliBitPayException()
    {
        $content['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientNotificationException::class);
        $client->requestPayoutRecipientNotification($exampleRecipientId);
    }

    public function testRequestPayoutRecipientNotificationShouldCatchRestCliException()
    {
        $content['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(PayoutRecipientNotificationException::class);
        $client->requestPayoutRecipientNotification($exampleRecipientId);
    }

    public function testRequestPayoutRecipientNotificationShouldCatchJsonDecodeException()
    {
        $content['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/false.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->assertFalse($client->requestPayoutRecipientNotification($exampleRecipientId));
    }

    public function testGetRates()
    {
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getRates.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates', null, false)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getRates();
        $this->assertEquals('41248.11', $result->getRate('USD'));
        $this->assertIsArray($result->getRates());
        $this->assertInstanceOf(Rates::class, $result);
    }

    public function testGetRatesShouldHandleRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates', null, false)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getRates();
    }

    public function testGetRatesShouldHandleRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates', null, false)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getRates();
    }

    public function testGetRatesShouldHandleCorruptJson()
    {
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates', null, false)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getRates();
    }

    public function testGetCurrencyRates()
    {
        $exampleCurrency = Currency::BTC;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getCurrencyRates.json');

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getCurrencyRates(Currency::BTC);
        $this->assertEquals('41248.11', $result->getRate(Currency::USD));
        $this->assertIsArray($result->getRates());
        $this->assertInstanceOf(Rates::class, $result);
    }

    public function testGetCurrencyRatesShouldHandleRestCliBitPayException()
    {
        $exampleCurrency = Currency::USD;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getCurrencyRates(Currency::USD);
    }

    public function testGetCurrencyRatesShouldHandleRestCliException()
    {
        $exampleCurrency = Currency::USD;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getCurrencyRates(Currency::USD);
    }

    public function testGetCurrencyRatesShouldFailWhenDataInvalid()
    {
        $exampleCurrency = Currency::USD;
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getCurrencyRates(Currency::USD);
    }

    public function testGetCurrencyPairRate()
    {
        $baseCurrency = Currency::USD;
        $currency = Currency::USD;
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getCurrencyPairRate.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates/' . $baseCurrency . '/' . $currency, null, false)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getCurrencyPairRate($baseCurrency, $currency);
        $this->assertEquals('41154.05', $result->getRate());
        $this->assertEquals('US Dollar', $result->getName());
        $this->assertEquals('USD', $result->getCode());
        $this->assertInstanceOf(Rate::class, $result);
    }

    public function testGetCurrencyPairRateShouldCatchRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    public function testGetCurrencyPairRateShouldThrowExceptionWhenResponseIsException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->willThrowException(new \Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    public function testGetCurrencyPairRateShouldReturnExceptionWhenNoDataInJson()
    {
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(RateQueryException::class);
        $client->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    public function testGetSettlements()
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getSettlementsResponse.json');

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
        $this->assertIsArray($result);
        $this->assertEquals('KBkdURgmE3Lsy9VTnavZHX', $result[0]->getId());
        $this->assertEquals('processing', $result[0]->getStatus());
        $this->assertEquals('RPWTabW8urd3xWv2To989v', $result[1]->getId());
        $this->assertEquals('processing', $result[1]->getStatus());
        $this->assertInstanceOf(Settlement::class, $result[0]);
    }

    public function testGetSettlementsShouldCatchRestCliBitPayException()
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements", $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    public function testGetSettlementsShouldCatchRestCliException()
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements", $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    public function testGetSettlementsShouldCatchJsonMapperException()
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements", $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    public function testGetSettlement()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getSettlementResponse.json');

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSettlement($settlementId);
        $this->assertEquals('RPWTabW8urd3xWv2To989v', $result->getId());
        $this->assertEquals('EUR', $result->getCurrency());
        $this->assertEquals(
            '2GrR6GDeYxUFYM9sDKViy6nFFTy4Rjvm1SYdLBjK46jkeJdgUTRccRfhtwkhNcuZky',
            $result->getToken()
        );
        $this->assertEquals('processing', $result->getStatus());
        $this->assertInstanceOf(Settlement::class, $result);
    }

    public function testGetSettlementShouldHandleRestCliBitPayException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlement($settlementId);
    }

    public function testGetSettlementShouldHandleRestCliException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlement($settlementId);
    }

    public function testGetSettlementShouldCatchJsonMapperException()
    {
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlement($settlementId);
    }

    public function testGetSettlementReconciliationReport()
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;
        $exampleResponse = file_get_contents(
            __DIR__ . '/jsonResponse/getSettlementReconciliationReportResponse.json'
        );

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSettlementReconciliationReport($settlement);

        $this->assertEquals('RvNuCTMAkURKimwgvSVEMP', $result->getId());
        $this->assertEquals('processing', $result->getStatus());
        $this->assertEquals('USD', $result->getCurrency());
        $this->assertInstanceOf(Settlement::class, $result);
    }

    public function testGetSettlementReconciliationReportShouldCatchRestCliBitPayException()
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlementReconciliationReport($settlement);
    }

    public function testGetSettlementReconciliationReportShouldCatchRestCliException()
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlementReconciliationReport($settlement);
    }

    public function testGetSettlementReconciliationReportShouldCatchJsonMapperException()
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $client->getSettlementReconciliationReport($settlement);
    }

    public function testGetSubscriptions()
    {
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getSubscriptions.json');
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $status = 'draft';
        $params['status'] = $status;

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSubscriptions($status);

        $this->assertIsArray($result);
        $this->assertEquals('SeL33Hjyr3VmFHA5Skc4zy', $result[0]->getId());
        $this->assertEquals('draft', $result[0]->getStatus());
        $this->assertEquals('2021-05-21T12:29:54.428Z', $result[0]->getCreatedDate());
    }

    public function testGetSubscriptionsShouldHandleJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions", $params)
            ->willReturn($badResponse);
        $client = $this->getClient($restCliMock);

        $this->expectException(SubscriptionQueryException::class);
        $client->getSubscriptions();
    }

    public function testGetSubscriptionsShouldHandleRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions", $params)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);

        $this->expectException(SubscriptionQueryException::class);
        $client->getSubscriptions();
    }

    public function testGetSubscriptionsShouldHandleRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions", $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(SubscriptionQueryException::class);
        $client->getSubscriptions();
    }

    public function testCreateSubscription()
    {
        $subscription = $this->createMock(Subscription::class);

        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/createSubscription.json');
        $restCliMock = $this->getRestCliMock();

        $subscriptionToArray = [
            'id' => 'SeL33Hjyr3VmFHA5Skc4zy',
            'status' => 'draft',
            'token' => '85yxWk7aEgPdJME6zTkXkAGA3K13MtXf3WHqvtBvyhw3ycfEebJ5WMBRZHXsssSBvn',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->createSubscription($subscription);
        $this->assertInstanceOf(Subscription::class, $result);
    }

    public function testCreateSubscriptionShouldCatchRestCliBitPayException()
    {
        $subscription = $this->createMock(Subscription::class);

        $restCliMock = $this->getRestCliMock();

        $subscriptionToArray = [
            'id' => 'SeL33Hjyr3VmFHA5Skc4zy',
            'status' => 'draft',
            'token' => '85yxWk7aEgPdJME6zTkXkAGA3K13MtXf3WHqvtBvyhw3ycfEebJ5WMBRZHXsssSBvn',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);
        $this->expectException(SubscriptionCreationException::class);
        $client->createSubscription($subscription);
    }

    public function testCreateSubscriptionShouldCatchRestCliException()
    {
        $subscription = $this->createMock(Subscription::class);

        $restCliMock = $this->getRestCliMock();

        $subscriptionToArray = [
            'id' => 'SeL33Hjyr3VmFHA5Skc4zy',
            'status' => 'draft',
            'token' => '85yxWk7aEgPdJME6zTkXkAGA3K13MtXf3WHqvtBvyhw3ycfEebJ5WMBRZHXsssSBvn',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(SubscriptionCreationException::class);
        $client->createSubscription($subscription);
    }

    public function testCreateSubscriptionShouldCatchJsonMapperException()
    {
        $subscription = $this->createMock(Subscription::class);
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();

        $subscriptionToArray = [
            'id' => 'SeL33Hjyr3VmFHA5Skc4zy',
            'status' => 'draft',
            'token' => '85yxWk7aEgPdJME6zTkXkAGA3K13MtXf3WHqvtBvyhw3ycfEebJ5WMBRZHXsssSBvn',
        ];

        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willReturn($badResponse);
        $client = $this->getClient($restCliMock);
        $this->expectException(SubscriptionCreationException::class);
        $client->createSubscription($subscription);
    }

    public function testGetSubscription()
    {
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getSubscription.json');
        $exampleSubscriptionId = 'SeL33Hjyr3VmFHA5Skc4zy';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions/" . $exampleSubscriptionId, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSubscription($exampleSubscriptionId);

        $this->assertInstanceOf(Subscription::class, $result);
        $this->assertEquals('SeL33Hjyr3VmFHA5Skc4zy', $result->getId());
        $this->assertEquals('draft', $result->getStatus());
    }

    public function testGetSubscriptionShouldHandleRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $exampleSubscriptionId = 'subscriptionId';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions/" . $exampleSubscriptionId, $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);

        $this->expectException(SubscriptionQueryException::class);
        $client->getSubscription($exampleSubscriptionId);
    }

    public function testGetSubscriptionShouldHandleRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $exampleSubscriptionId = 'subscriptionId';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions/" . $exampleSubscriptionId, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(SubscriptionQueryException::class);
        $client->getSubscription($exampleSubscriptionId);
    }

    public function testGetSubscriptionShouldHandleJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $exampleSubscriptionId = 'subscriptionId';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions/" . $exampleSubscriptionId, $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(SubscriptionQueryException::class);
        $client->getSubscription($exampleSubscriptionId);
    }

    public function testUpdateSubscription()
    {
        $subscription = $this->createMock(Subscription::class);
        $restCliMock = $this->getRestCliMock();

        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/updateSubscription.json');
        $subscription->method('getId')->willReturn('SeL33Hjyr3VmFHA5Skc4zy');
        $subscriptionToArray = [
            'id' => 'SeL33Hjyr3VmFHA5Skc4zy',
            'status' => 'draft',
            'token' => '85yxWk7aEgPdJME6zTkXkAGA3K13MtXf3WHqvtBvyhw3ycfEebJ5WMBRZHXsssSBvn',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willReturn($exampleResponse);
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions/" . 'SeL33Hjyr3VmFHA5Skc4zy', $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->updateSubscription($subscription, 'SeL33Hjyr3VmFHA5Skc4zy');

        $this->assertInstanceOf(Subscription::class, $result);
        $this->assertEquals(null, $result->getStatus());
    }

    public function testUpdateSubscriptionShouldCatchRestCliBitPayException()
    {
        $subscription = $this->createMock(Subscription::class);
        $restCliMock = $this->getRestCliMock();

        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/updateSubscription.json');
        $exampleSubscriptionId = 'SeL33Hjyr3VmFHA5Skc4zy';

        $subscription->method('getId')->willReturn($exampleSubscriptionId);
        $subscriptionToArray = [
            'id' => $exampleSubscriptionId,
            'status' => 'status',
            'token' => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willThrowException(new BitPayException());
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions/" . $exampleSubscriptionId, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayException::class);
        $client->updateSubscription($subscription, $exampleSubscriptionId);
    }

    public function testUpdateSubscriptionShouldCatchRestCliException()
    {
        $subscription = $this->createMock(Subscription::class);
        $restCliMock = $this->getRestCliMock();

        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/updateSubscription.json');
        $exampleSubscriptionId = 'SeL33Hjyr3VmFHA5Skc4zy';

        $subscription->method('getId')->willReturn($exampleSubscriptionId);
        $subscriptionToArray = [
            'id' => $exampleSubscriptionId,
            'status' => 'status',
            'token' => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willThrowException(new Exception());
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("subscriptions/" . $exampleSubscriptionId, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayException::class);
        $client->updateSubscription($subscription, $exampleSubscriptionId);
    }

    public function testUpdateSubscriptionShouldCatchJsonMapperException()
    {
        $subscription = $this->createMock(Subscription::class);
        $restCliMock = $this->getRestCliMock();
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/updateSubscription.json');
        $exampleSubscriptionId = 'SeL33Hjyr3VmFHA5Skc4zy';

        $subscription->method('getId')->willReturn($exampleSubscriptionId);
        $subscriptionToArray = [
            'id' => $exampleSubscriptionId,
            'status' => 'status',
            'token' => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willReturn($badResponse);
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayException::class);
        $client->updateSubscription($subscription, $exampleSubscriptionId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayout()
    {
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willReturn($exampleResponse);
        $client = $this->getClient($restCliMock);
        $result = $client->getPayout($payoutId);
        $this->assertEquals(self::TOKEN, $result->getToken());

        $this->assertInstanceOf(Payout::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutShouldHandleRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutQueryException::class);

        $client->getPayout($payoutId);
    }

    public function testGetPayoutShouldHandleJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutQueryException::class);

        $client->getPayout($payoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutShouldHandleRestCliException()
    {
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutQueryException::class);

        $client->getPayout($payoutId);
    }

    public function testGetPayouts()
    {
        $params = $this->getPayoutParams();
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayouts.json');
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts", $params)
            ->willReturn($exampleResponse);
        $client = $this->getClient($restCliMock);
        $result =   $client->getPayouts(
            $params['startDate'],
            $params['endDate'],
            $params['status'],
            $params['reference'],
            $params['limit'],
            $params['offset']
        );
        $this->assertIsArray($result);
        $this->assertEquals('JMwv8wQCXANoU2ZZQ9a9GH', $result[0]->getId());
        $this->assertEquals(10, $result[0]->getAmount());
        $this->assertEquals('USD', $result[0]->getCurrency());
        $this->assertInstanceOf(Payout::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutsShouldHandleRestCliBitPayException()
    {
        $params = $this->getPayoutParams();
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts", $params)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutQueryException::class);

        $client->getPayouts(
            $params['startDate'],
            $params['endDate'],
            $params['status'],
            $params['reference'],
            $params['limit'],
            $params['offset']
        );
    }

    public function testGetPayoutsShouldHandleRestCliException()
    {
        $params = $this->getPayoutParams();
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts", $params)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutQueryException::class);

        $client->getPayouts(
            $params['startDate'],
            $params['endDate'],
            $params['status'],
            $params['reference'],
            $params['limit'],
            $params['offset']
        );
    }

    public function testGetPayoutsShouldHandleJsonMapperException()
    {
        $params = $this->getPayoutParams();
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("payouts", $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutQueryException::class);

        $client->getPayouts(
            $params['startDate'],
            $params['endDate'],
            $params['status'],
            $params['reference'],
            $params['limit'],
            $params['offset']
        );
    }

    public function testCancelPayout()
    {
        $params['token'] = self::TOKEN;
        $examplePayoutId = 'test';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willReturn('{"status":"success"}');
        $client = $this->getClient($restCliMock);
        $result = $client->cancelPayout($examplePayoutId);

        $this->assertIsBool($result);
    }

    public function testCancelPayoutShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $examplePayoutId = 'test';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutCancellationException::class);

        $client->cancelPayout($examplePayoutId);
    }

    public function testCancelPayoutShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $examplePayoutId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutCancellationException::class);

        $client->cancelPayout($examplePayoutId);
    }

    public function testCancelPayoutShouldCatchUnexistentPropertyError()
    {
        $params['token'] = self::TOKEN;
        $examplePayoutId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/false.json', true));
        $client = $this->getClient($restCliMock);

        $this->assertFalse($client->cancelPayout($examplePayoutId));
    }

    public function testSubmitPayout()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' =>  self::TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willReturn('{ "currency": "EUR", "balance": 0 }');
        $client = $this->getClient($restCliMock);
        $result = $client->submitPayout($payoutMock);

        $this->assertEquals('EUR', $result->getCurrency());
        $this->assertInstanceOf(Payout::class, $result);
    }

    public function testSubmitPayoutShouldCatchRestCliBitPayException()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => self::TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutCreationException::class);

        $client->submitPayout($payoutMock);
    }

    public function testSubmitPayoutShouldCatchRestCliException()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => self::TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutCreationException::class);

        $client->submitPayout($payoutMock);
    }

    public function testSubmitPayoutShouldCatchJsonMapperException()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => self::TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutCreationException::class);

        $client->submitPayout($payoutMock);
    }

    public function testRequestNotification()
    {
        $content = ['token' => self::TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willReturn('{ "status": "success", "data": {}, "message": null }');
        $client = $this->getClient($restCliMock);
        $result = $client->requestPayoutNotification($payoutId);

        $this->assertTrue($result);
    }

    public function testRequestNotificationShouldCatchRestCliBitPayException()
    {
        $content = ['token' => self::TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutNotificationException::class);

        $client->requestPayoutNotification($payoutId);
    }

    public function testRequestNotificationShouldCatchRestCliException()
    {
        $content = ['token' => self::TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(PayoutNotificationException::class);

        $client->requestPayoutNotification($payoutId);
    }

    public function testRequestNotificationShouldCatchJsonException()
    {
        $content = ['token' => self::TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/false.json', true));
        $client = $this->getClient($restCliMock);

        $this->assertFalse($client->requestPayoutNotification($payoutId));
    }

    public function testCreateRefund()
    {
        $params = $this->getInvoiceRefundParams();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())
            ->method('post')
            ->with("refunds/", $params, true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/createRefundResponse.json', true));

        $client = $this->getClient($restCliMock);
        /** @var Refund $result */
        $result = $client->createRefund(
            $params['invoiceId'],
            $params['amount'],
            $params['currency'],
            $params['preview'],
            $params['immediate'],
            $params['buyerPaysRefundFee'],
            $params['guid']
        );

        $this->assertEquals('Eso8srxKJR5U71ahCspAAA', $result->getId());
        $this->assertEquals($params['invoiceId'], $result->getInvoice());
    }

    public function testCreateRefundShouldCatchRestCliBitPayException()
    {
        $params = $this->getInvoiceRefundParams();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("refunds/", $params, true)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundCreationException::class);

        $client->createRefund(
            $params['invoiceId'],
            $params['amount'],
            $params['currency'],
            $params['preview'],
            $params['immediate'],
            $params['buyerPaysRefundFee'],
            $params['guid']
        );
    }

    public function testCreateRefundShouldCatchRestCliException()
    {
        $params = $this->getInvoiceRefundParams();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("refunds/", $params, true)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundCreationException::class);

        $client->createRefund(
            $params['invoiceId'],
            $params['amount'],
            $params['currency'],
            $params['preview'],
            $params['immediate'],
            $params['buyerPaysRefundFee'],
            $params['guid']
        );
    }

    public function testCreateRefundShouldCatchJsonMapperException()
    {
        $params = $this->getInvoiceRefundParams();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/", $params, true)->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundCreationException::class);

        $client->createRefund(
            $params['invoiceId'],
            $params['amount'],
            $params['currency'],
            $params['preview'],
            $params['immediate'],
            $params['buyerPaysRefundFee'],
            $params['guid']
        );
    }

    public function testCancelRefund()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willReturn(self::CANCEL_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);

        $result = $client->cancelRefund($exampleRefundId);
        $this->assertEquals('USD', $result->getCurrency());
        $this->assertEquals(10, $result->getAmount());
        $this->assertEquals('cancelled', $result->getStatus());
        $this->assertInstanceOf(Refund::class, $result);
    }

    public function testCancelRefundShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);
        $this->expectException(RefundCancellationException::class);

        $client->cancelRefund($exampleRefundId);
    }

    public function testCancelRefundShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(RefundCancellationException::class);
        $client->cancelRefund($exampleRefundId);
    }

    public function testCancelRefundShouldCatchJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundCancellationException::class);

        $client->cancelRefund($exampleRefundId);
    }

    public function testCancelRefundByGuid()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::CANCEL_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);

        $result = $client->cancelRefundByGuid($guid);
        $this->assertEquals('USD', $result->getCurrency());
        $this->assertEquals(10, $result->getAmount());
        $this->assertEquals('cancelled', $result->getStatus());
        $this->assertInstanceOf(Refund::class, $result);
    }

    public function testCancelRefundByGuidShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException(new BitPayException());

        $client = $this->getClient($restCliMock);
        $this->expectException(RefundCancellationException::class);

        $client->cancelRefundByGuid($guid);
    }

    public function testCancelRefundByGuidShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);

        $this->expectException(RefundCancellationException::class);
        $client->cancelRefundByGuid($guid);
    }

    public function testCancelRefundByGuidShouldCatchJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundCancellationException::class);

        $client->cancelRefundByGuid($guid);
    }

    public function testUpdateRefund()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->updateRefund($refundId, $params['status']);

        $this->assertInstanceOf(Refund::class, $result);
    }

    public function testUpdateRefundShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundUpdateException::class);

        $client->updateRefund($refundId, $params['status']);
    }

    public function testUpdateRefundShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);
        $this->expectException(RefundUpdateException::class);
        $client->updateRefund($refundId, $params['status']);
    }

    public function testUpdateRefundShouldCatchJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundUpdateException::class);

        $client->updateRefund($refundId, $params['status']);
    }

    public function testUpdateRefundByGuid()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->updateRefundByGuid($guid, $params['status']);

        $this->assertInstanceOf(Refund::class, $result);
        $this->assertEquals('created', $result->getStatus());
        $this->assertEquals(10, $result->getAmount());
    }

    public function testUpdateRefundBuGuidShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundUpdateException::class);

        $client->updateRefundByGuid($guid, $params['status']);
    }

    public function testUpdateRefundBuGuidShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException(new Exception());

        $client = $this->getClient($restCliMock);
        $this->expectException(RefundUpdateException::class);
        $client->updateRefundByGuid($guid, $params['status']);
    }

    public function testUpdateRefundByGuidShouldCatchJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundUpdateException::class);

        $client->updateRefundByGuid($guid, $params['status']);
    }

    public function testGetRefunds()
    {
        $params['token'] = self::TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/", $params, true)
            ->willReturn(self::CORRECT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $result = $client->getRefunds($exampleInvoiceId);

        $this->assertIsArray($result);
        $this->assertInstanceOf(Refund::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/", $params, true)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundQueryException::class);

        $client->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/", $params, true)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundQueryException::class);

        $client->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/", $params, true)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundQueryException::class);

        $client->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefund()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->getRefund($exampleRefundId);

        $this->assertEquals('USD', $result->getCurrency());
        $this->assertEquals(10, $result->getAmount());
        $this->assertEquals('created', $result->getStatus());
        $this->assertEquals('WoE46gSLkJQS48RJEiNw3L', $result->getId());
        $this->assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);

        $this->expectException(RefundQueryException::class);
        $client->getRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);

        $this->expectException(RefundQueryException::class);
        $client->getRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);

        $this->expectException(RefundQueryException::class);
        $client->getRefund($exampleRefundId);
    }

    public function testGetRefundByGuid()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->getRefundByGuid($guid);

        $this->assertEquals('USD', $result->getCurrency());
        $this->assertEquals(10, $result->getAmount());
        $this->assertEquals('created', $result->getStatus());
        $this->assertEquals('WoE46gSLkJQS48RJEiNw3L', $result->getId());
        $this->assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundByGuidShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);

        $this->expectException(RefundQueryException::class);
        $client->getRefundByGuid($guid);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundByGuidShouldCatchRestCliException()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);

        $this->expectException(RefundQueryException::class);
        $client->getRefundByGuid($guid);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundByGuidShouldCatchRestCliJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);

        $this->expectException(RefundQueryException::class);
        $client->getRefundByGuid($guid);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotification()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willReturn('{"status":"success"}');
        $client = $this->getClient($restCliMock);
        $result = $client->sendRefundNotification($exampleRefundId);

        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchRestCliBitPayException()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willThrowException(new BitPayException());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundNotificationException::class);

        $client->sendRefundNotification($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchRestCliException()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willThrowException(new Exception());
        $client = $this->getClient($restCliMock);
        $this->expectException(RefundNotificationException::class);

        $client->sendRefundNotification($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchJsonMapperException()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/false.json', true));
        $client = $this->getClient($restCliMock);

        $this->assertFalse($client->sendRefundNotification($exampleRefundId));
    }

    public function testGetInvoice()
    {
        $exampleInvoiceObject = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $testedObject = $this->getClient($restCliMock);
        $result = $testedObject->getInvoice($exampleInvoiceObject->id, Facade::Merchant, true);

        $this->assertEquals($exampleInvoiceObject->id, $result->getId());
        $this->assertEquals($exampleInvoiceObject->amountPaid, $result->getAmountPaid());
        $this->assertEquals($exampleInvoiceObject->currency, $result->getCurrency());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testGetInvoiceShouldCatchRestCliExceptions(string $exceptionClass)
    {
        $exampleInvoiceObject = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willThrowException(new $exceptionClass);

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(InvoiceQueryException::class);

        $testedObject->getInvoice($exampleInvoiceObject->id, Facade::Merchant, true);
    }

    public function testGetInvoiceShouldCatchJsonMapperException()
    {
        $exampleInvoiceObject = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willReturn('badString');

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(InvoiceQueryException::class);

        $testedObject->getInvoice($exampleInvoiceObject->id, Facade::Merchant, true);
    }

    public function testGetInvoices()
    {
        $params = [
            'status' => 'status',
            'dateStart' => 'dateStart',
            'dateEnd' => 'dateEnd',
            'limit' => 1,
            'offset' => 1,
            'orderId' => 'orderId',
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb'
        ];

        $successResponse = file_get_contents(__DIR__ . '/jsonResponse/getInvoices.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices', $params)
            ->willReturn($successResponse);

        $testedObject = $this->getClient($restCliMock);
        $result = $testedObject->getInvoices(
            $params['dateStart'],
            $params['dateEnd'],
            $params['status'],
            $params['orderId'],
            $params['limit'],
            $params['offset']);

        $responseToCompare = json_decode($successResponse, true);

        $this->assertInstanceOf(Invoice::class, $result[0]);
        $this->assertEquals($responseToCompare[0]['id'], $result[0]->getId());
        $this->assertEquals($responseToCompare[0]['guid'], $result[0]->getGuid());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testGetInvoicesShouldCatchRestCliExceptions(string $exceptionClass)
    {
        $params = [
            'status' => 'status',
            'dateStart' => 'dateStart',
            'dateEnd' => 'dateEnd',
            'limit' => 1,
            'offset' => 1,
            'orderId' => 'orderId',
            'token' => 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb'
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices', $params)
            ->willThrowException(new $exceptionClass);

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(InvoiceQueryException::class);

        $testedObject->getInvoices(
            $params['dateStart'],
            $params['dateEnd'],
            $params['status'],
            $params['orderId'],
            $params['limit'],
            $params['offset']);
    }

    public function testGetInvoicesShouldCatchJsonMapperException()
    {
        $params = [
            'status' => 'status',
            'dateStart' => 'dateStart',
            'dateEnd' => 'dateEnd',
            'limit' => 1,
            'offset' => 1,
            'orderId' => 'orderId',
            'token' => self::TOKEN
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices', $params)
            ->willReturn('badString');

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(InvoiceQueryException::class);

        $testedObject->getInvoices(
            $params['dateStart'],
            $params['dateEnd'],
            $params['status'],
            $params['orderId'],
            $params['limit'],
            $params['offset']);
    }

    // TODO: There's a bug probably
//    public function testRequestInvoiceNotificationShouldReturnTrueOnSuccess()
//    {
//        $invoiceId = self::TEST_INVOICE_ID;
//        $params['token'] = self::TOKEN;
//        $expectedSuccessResponse = 'success';
//        $restCliMock = $this->getRestCliMock();
//
//        $restCliMock
//            ->expects($this->once())
//            ->method('get')
//            ->with("invoices/" . self::TEST_INVOICE_ID, $params, true)
//            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));
//
//        $restCliMock
//            ->expects($this->once())
//            ->method('post')
//            ->with('invoices/' . $invoiceId . '/notifications', $params)
//            ->willReturn($expectedSuccessResponse);
//
//        $testedObject = $this->getClient($restCliMock);
//
//        $result = $testedObject->requestInvoiceNotification($invoiceId);
//        $this->assertTrue($result);
//    }

    public function testRequestInvoiceNotificationShouldReturnFalseOnFailure()
    {
        $params['token'] = self::TOKEN;
        $expectedFailResponse = 'fail';
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with('invoices/' . self::TEST_INVOICE_ID . '/notifications', $params)
            ->willReturn($expectedFailResponse);
        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
        $this->assertFalse($result);
    }

    public function testRequestInvoiceNotificationShouldCatchExceptionFromGetInvoice()
    {
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("invoices/" . self::TEST_INVOICE_ID . '/notifications', $params, true)
            ->willThrowException(new InvoiceQueryException());

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(InvoiceQueryException::class);
        $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
    }

    public function testRequestInvoiceNotificationShouldCatchJsonMapperException()
    {
        $params['token'] = self::TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn('corruptJson');

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(InvoiceQueryException::class);
        $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
    }

    public function testCancelInvoice()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::TOKEN,
            'forceCancel' => true
        ];
        $invoice = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));
        $invoice->isCancelled = true;
        $restCliMock->expects($this->once())->method('delete')->with("invoices/" . self::TEST_INVOICE_ID, $params)->willReturn(json_encode($invoice));
        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
        $this->assertEquals(self::TEST_INVOICE_ID, $result->getId());
        $this->assertEquals(true, $result->getIsCancelled());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testCancelInvoiceShouldCatchRestCliExceptions(string $exceptionClass)
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::TOKEN,
            'forceCancel' => true
        ];
        $restCliMock->expects($this->once())->method('delete')->with("invoices/" . self::TEST_INVOICE_ID, $params)->willThrowException(new $exceptionClass());
        $testedObject = $this->getClient($restCliMock);

        $this->expectException(InvoiceCancellationException::class);
        $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
    }

    public function testCancelInvoiceShouldCatchJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::TOKEN,
            'forceCancel' => true
        ];
        $restCliMock->expects($this->once())->method('delete')->with("invoices/" . self::TEST_INVOICE_ID, $params)->willReturn('corruptJson');
        $testedObject = $this->getClient($restCliMock);

        $this->expectException(InvoiceCancellationException::class);
        $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
    }

    public function testPayInvoice()
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("invoices/pay/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/payInvoiceResponse.json'));
        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
        $this->assertEquals("7f3b1a02-d6ee-4185-bcd5-838276a598b5", $result->getGuid());
        $this->assertEquals('complete', $result->getStatus());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testPayInvoiceShouldCatchRestCliExceptions(string $exceptionClass)
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/pay/" . self::TEST_INVOICE_ID, $params)->willThrowException(new $exceptionClass());
        $testedObject = $this->getClient($restCliMock);

        $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
    }

    public function testPayInvoiceShouldCatchJsonMapperException()
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/pay/" . self::TEST_INVOICE_ID, $params)->willReturn('corruptJson');
        $testedObject = $this->getClient($restCliMock);

        $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
    }

    public function testCreateInvoice()
    {
        $invoiceArray = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects($this->once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with('invoices', $invoiceArray, true)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $testedObject = $this->getClient($restCliMock);
        $result = $testedObject->createInvoice($invoiceMock);
        $this->assertEquals($invoiceArray['id'], $result->getId());
        $this->assertEquals($invoiceArray['status'], $result->getStatus());
        $this->assertEquals($invoiceArray['guid'], $result->getGuid());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testCreateInvoiceShouldCatchRestCliExceptions(string $exceptionClass)
    {
        $invoiceArray = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects($this->once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with('invoices', $invoiceArray, true)->willThrowException(new $exceptionClass());

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(InvoiceCreationException::class);
        $testedObject->createInvoice($invoiceMock);
    }

    public function testCreateInvoiceShouldCatchJsonMapperException()
    {
        $invoiceArray = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects($this->once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with('invoices', $invoiceArray, true)->willReturn('corruptJson');

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(InvoiceCreationException::class);
        $testedObject->createInvoice($invoiceMock);
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testUpdateInvoiceShouldCatchRestCliExceptions(string $exceptionClass)
    {
        $params = [
            'token' => self::TOKEN,
            'buyerEmail' => '',
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with('invoices/'. self::TEST_INVOICE_ID, $params)
            ->willThrowException(new $exceptionClass());

        $this->expectException(InvoiceUpdateException::class);
        $testedObject = $this->getClient($restCliMock);
        $testedObject->updateInvoice(
            self::TEST_INVOICE_ID,
            $params['buyerSms'],
            $params['smsCode'],
            $params['buyerEmail'],
            $params['autoVerify']
        );
    }

    public function testUpdateInvoiceShouldCatchJsonMapperException()
    {
        $params = [
            'token' => self::TOKEN,
            'buyerEmail' => '',
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with('invoices/'. self::TEST_INVOICE_ID, $params)
            ->willReturn('corruptJson');

        $this->expectException(InvoiceUpdateException::class);
        $testedObject = $this->getClient($restCliMock);
        $testedObject->updateInvoice(
            self::TEST_INVOICE_ID,
            $params['buyerSms'],
            $params['smsCode'],
            $params['buyerEmail'],
            $params['autoVerify']
        );
    }

    public function testUpdateInvoiceShouldThrowExceptionWhenBothBuyerEmailAndSmsProvided()
    {
        $params = [
            'buyerEmail' => 'test',
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $this->expectExceptionMessage('Updating the invoice requires buyerSms or buyerEmail, but not both.');
        $testedObject = $this->getClient($this->getRestCliMock());
        $testedObject->updateInvoice(
            self::TEST_INVOICE_ID,
            $params['buyerSms'],
            $params['smsCode'],
            $params['buyerEmail'],
            $params['autoVerify']
        );
    }

    public function testUpdateInvoiceShouldThrowExceptionWhenNoSmsCodeProvided()
    {
        $params = [
            'buyerEmail' => '',
            'buyerSms' => 'buyerSms',
            'smsCode' => '',
            'autoVerify' => false
        ];

        $this->expectExceptionMessage('Updating the invoice requires both buyerSms and smsCode when verifying SMS.');
        $testedObject = $this->getClient($this->getRestCliMock());
        $testedObject->updateInvoice(
            self::TEST_INVOICE_ID,
            $params['buyerSms'],
            $params['smsCode'],
            $params['buyerEmail'],
            $params['autoVerify']
        );
    }

    public function testUpdateInvoice()
    {
        $params = [
            'token' => self::TOKEN,
            'buyerEmail' => null,
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $successResponse = file_get_contents(__DIR__.'/jsonResponse/getInvoice.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with('invoices/'. self::TEST_INVOICE_ID, $params)
            ->willReturn($successResponse);

        $testedObject = $this->getClient($restCliMock);
        $result = $testedObject->updateInvoice(
            self::TEST_INVOICE_ID,
            $params['buyerSms'],
            $params['smsCode'],
            $params['buyerEmail'],
            $params['autoVerify']
        );

        $invoiceArray = json_decode($successResponse, true);
        $this->assertEquals($invoiceArray['id'], $result->getId());
        $this->assertEquals($invoiceArray['status'], $result->getStatus());
        $this->assertEquals($invoiceArray['guid'], $result->getGuid());
    }

    public function testGetSupportedWallets()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getSupportedWalletsResponse.json'));

        $client = $this->getClient($restCliMock);

        $result = $client->getSupportedWallets();
        $this->assertIsArray($result);
        $this->assertInstanceOf(Wallet::class, $result[0]);
        $this->assertEquals('bitpay-wallet.png', $result[0]->getAvatar());
        $this->assertEquals('copay-wallet.svg', $result[1]->getAvatar());
        $this->assertEquals('BitPay', $result[0]->getDisplayName());
        $this->assertEquals('Copay', $result[1]->getDisplayName());
    }

    public function testGetSupportedWalletsShouldCatchRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willThrowException(new BitPayException());

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(WalletQueryException::class);
        $testedObject->getSupportedWallets();
    }

    public function testGetSupportedWalletsShouldCatchRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willThrowException(new Exception());

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(WalletQueryException::class);
        $testedObject->getSupportedWallets();
    }

    public function testGetSupportedWalletsShouldCatchJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willReturn(self::CORRUPT_JSON_STRING);

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(WalletQueryException::class);
        $testedObject->getSupportedWallets();
    }

    public function exceptionClassProvider(): array
    {
        return [
            [BitPayException::class],
            [Exception::class],
        ];
    }

    private function getClient(RESTcli $restCli)
    {
        $testToken = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';

        $tokens = $this->getMockBuilder(Tokens::class)->getMock();
        $tokens->setMerchantToken($testToken);
        $tokens->method('getTokenByFacade')->willReturn($testToken);

        return new Client($restCli, $tokens);
    }

    private function getTestedClassInstance(): Client
    {
        $restCli = $this->getMockBuilder(RESTcli::class)->disableOriginalConstructor()->getMock();
        $tokens = $this->getMockBuilder(Tokens::class)->disableOriginalConstructor()->getMock();

        return new Client($restCli, $tokens);
    }

    private function getRestCliMock()
    {
        return $this->getMockBuilder(RESTcli::class)->disableOriginalConstructor()->getMock();
    }

    private function getPayoutParams(): array
    {
        return [
            'status' => 'status',
            'startDate' => '2021-07-08 14:21:05',
            'endDate' => '2021-07-08 14:24:05',
            'limit' => 1,
            'offset' => 1,
            'reference' => 'reference',
        ];
    }

    private function getInvoiceRefundParams(): array
    {
        return [
            'token' => self::TOKEN,
            'invoiceId' => 'UZjwcYkWAKfTMn9J1yyfs4',
            'amount' => 10.10,
            'currency' => Currency::BTC,
            'preview' => true,
            'immediate' => false,
            'buyerPaysRefundFee' => false,
            'guid' => '3df73895-2531-e26a-3caa-098a746389b7'
        ];
    }
}
