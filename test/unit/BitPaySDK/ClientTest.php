<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test;

use BitPaySDK\Client;
use BitPaySDK\Client\BillClient;
use BitPaySDK\Client\InvoiceClient;
use BitPaySDK\Client\LedgerClient;
use BitPaySDK\Client\PayoutClient;
use BitPaySDK\Client\PayoutRecipientsClient;
use BitPaySDK\Client\RateClient;
use BitPaySDK\Client\RefundClient;
use BitPaySDK\Client\SettlementClient;
use BitPaySDK\Client\TokenClient;
use BitPaySDK\Client\WalletClient;
use BitPaySDK\Env;
use BitPaySDK\Exceptions\BitPayApiException;
use BitPaySDK\Exceptions\BitPayGenericException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Ledger\LedgerEntry;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Model\Wallet\Wallet;
use BitPaySDK\Tokens;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;


class ClientTest extends TestCase
{
    private const MERCHANT_TOKEN = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
    private const PAYOUT_TOKEN = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
    private const CORRUPT_JSON_STRING = '{"code":"USD""name":"US Dollar","rate":21205.85}';
    private const TEST_INVOICE_ID = 'UZjwcYkWAKfTMn9J1yyfs4';
    private const TEST_INVOICE_GUID = 'chc9kj52-04g0-4b6f-941d-3a844e352758';
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
     * @throws \ReflectionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshResourceClients();
    }

    /**
     * @throws BitPayApiException
     */
    public function testWithData()
    {
        $tokens = $this->createMock(Tokens::class);
        $result = $this->getTestedClassInstance()::createWithData(
            Env::TEST,
            __DIR__ . '/bitpay_private_test.key',
            $tokens,
            'YourMasterPassword'
        );

        self::assertInstanceOf(Client::class, $result);
    }

    /**
     * @throws BitPayApiException
     */
    public function testWithDataAndXBitPayPlatformInfoHeader()
    {
        $tokens = $this->createMock(Tokens::class);
        $result = $this->getTestedClassInstance()::createWithData(
            Env::TEST,
            __DIR__ . '/bitpay_private_test.key',
            $tokens,
            'YourMasterPassword',
            null,
            'MyPlatform_v1.0.0'
        );

        self::assertInstanceOf(Client::class, $result);
    }

    public function testWithDataException()
    {
        $instance = $this->getTestedClassInstance();
        $tokens = $this->createMock(Tokens::class);
        $this->expectException(BitPayGenericException::class);

        $instance::createWithData(
            Env::TEST,
            __DIR__ . '/bitpay_private_test.key',
            $tokens,
            'badPassword'
        );
    }

    /**
     * @throws BitPayApiException
     */
    public function testWithFileJsonConfig(): Client
    {
        $instance = $this->getTestedClassInstance();
        $result = $instance::createWithFile(__DIR__ . '/BitPay.config-unit.json');
        self::assertInstanceOf(Client::class, $result);
        return $result;
    }

    /**
     * @throws BitPayApiException
     */
    public function testWithFileJsonConfigAndXBitPayPlatformInfoHeader(): Client
    {
        $instance = $this->getTestedClassInstance();
        $result = $instance::createWithFile(
            __DIR__ . '/BitPay.config-unit.json',
            'MyPlatform_v1.0.0'
        );
        self::assertInstanceOf(Client::class, $result);
        return $result;
    }

    /**
     * @throws BitPayGenericException
     */
    public function testWithFileYmlConfig()
    {
        $instance = $this->getTestedClassInstance();
        $result = $instance::createWithFile(__DIR__ . '/BitPay.config-unit.yml');
        self::assertInstanceOf(Client::class, $result);
    }

    /**
     * @throws BitPayGenericException
     */
    public function testWithFileYmlConfigAndXBitPayPlatformInfoHeader()
    {
        $instance = $this->getTestedClassInstance();
        $result = $instance::createWithFile(
            __DIR__ . '/BitPay.config-unit.yml',
            'MyPlatform_v1.0.0'
        );
        self::assertInstanceOf(Client::class, $result);
    }

    public function testWithFileException()
    {
        $instance = $this->getTestedClassInstance();
        $this->expectException(BitPayGenericException::class);
        $instance::createWithFile('badpath');
    }

    public function testGetTokens(): void
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("tokens")
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/getTokensResponse.json'));

        $tokenClient = $this->getClient($restCliMock);
        $tokens = $tokenClient->getTokens();

        self::assertEquals('someMerchantToken', $tokens[0]['merchant']);
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
            ->expects(self::once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/createBillResponse.json'));

        $billClient = $this->getClient($restCliMock);
        $createdBill = $billClient->createBill($billMock, Facade::MERCHANT);

        self::assertEquals($expectedId, $createdBill->getId());
        self::assertEquals($expectedStatus, $createdBill->getStatus());
        self::assertEquals($expectedToken, $createdBill->getToken());
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
            ->expects(self::once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willThrowException($this->getBitPayApiException());
        $billClient = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);

        $billClient->createBill($billMock, Facade::MERCHANT);
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
            ->expects(self::once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->createBill($billMock, Facade::MERCHANT, true);
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
            ->expects(self::once())
            ->method('post')
            ->with("bills", $billMock->toArray(), true)
            ->willReturn($exampleBadResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->createBill($billMock, Facade::MERCHANT, true);
    }

    public function testGetBill()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/getBill.json'));

        $client = $this->getClient($restCliMock);

        $result = $client->getBill($exampleBillId);

        self::assertEquals(
            '6EBQR37MgDJPfEiLY3jtRq7eTP2aodR5V5wmXyyZhru5FM5yF4RCGKYQtnT7nhwHjA',
            $result->getToken()
        );
        self::assertInstanceOf(Bill::class, $result);
    }

    public function testGetBillShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getBill($exampleBillId);
    }

    public function testGetBillShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getBill($exampleBillId);
    }

    public function testGetBillShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBadResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleBadResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getBill($exampleBillId);
    }

    public function testGetBills()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBills.json');
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getBills($status);
        self::assertIsArray($result);
        self::assertEquals(
            '6EBQR37MgDJPfEiLY3jtRqBMYLg8XSDqhp2kp7VSDqCMHGHnsw4bqnnwQmtehzCvSo',
            $result[0]->getToken()
        );
        self::assertEquals(
            '6EBQR37MgDJPfEiLY3jtRq7eTP2aodR5V5wmXyyZhru5FM5yF4RCGKYQtnT7nhwHjA',
            $result[1]->getToken()
        );
        self::assertInstanceOf(Bill::class, $result[0]);
        self::assertInstanceOf(Bill::class, $result[1]);
    }

    public function testGetBillsShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getBills($status);
    }

    public function testGetBillsShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills", $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getBills($status);
    }

    /**
     * @throws BitPayApiException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillsShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $status = 'draft';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills", $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getBills($status);
    }

    public function testUpdateBill()
    {
        $billMock = $this->createMock(Bill::class);
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getBill.json');

        $params['token'] = self::MERCHANT_TOKEN;

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
            ->expects(self::once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willReturn($exampleResponse);
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->updateBill($billMock, $exampleBillId);
        self::assertInstanceOf(Bill::class, $result);
    }

    public function testUpdateBillShouldCatchRestCliBitPayException()
    {
        $billMock = $this->createMock(Bill::class);
        $params['token'] = self::MERCHANT_TOKEN;
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
            ->expects(self::once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willThrowException($this->getBitPayApiException());

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->updateBill($billMock, $exampleBillId);
    }

    public function testUpdateBillShouldCatchRestCliException()
    {
        $billMock = $this->createMock(Bill::class);
        $params['token'] = self::MERCHANT_TOKEN;
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
            ->expects(self::once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willThrowException($this->getBitPayApiException());

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->updateBill($billMock, $exampleBillId);
    }

    public function testUpdateBillShouldCatchJsonMapperException()
    {
        $billMock = $this->createMock(Bill::class);
        $params['token'] = self::MERCHANT_TOKEN;
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
            ->expects(self::once())
            ->method('update')
            ->with("bills/" . $exampleBillId, $billMock->toArray())
            ->willReturn($badResponse);

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("bills/" . $exampleBillId, $params, true)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->updateBill($billMock, $exampleBillId);
    }

    /**
     * @throws BitPayApiException
     */
    public function testDeliverBill()
    {
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBillToken = self::MERCHANT_TOKEN;
        $exampleResponse = 'Success';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("bills/" . $exampleBillId . '/deliveries', ['token' => $exampleBillToken])
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->deliverBill($exampleBillId, $exampleBillToken);
        self::assertTrue($result);
    }

    public function testDeliverBillShouldCatchRestCliBitPayException()
    {
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBillToken = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("bills/" . $exampleBillId . '/deliveries', ['token' => $exampleBillToken])
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->deliverBill($exampleBillId, $exampleBillToken);
    }

    public function testDeliverBillShouldCatchRestCliException()
    {
        $exampleBillId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleBillToken = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("bills/" . $exampleBillId . '/deliveries', ['token' => $exampleBillToken])
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->deliverBill($exampleBillId, $exampleBillToken);
    }

    public function testGetLedgerEntries()
    {
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getLedgerEntriesResponse.json');

        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $params["currency"] = $exampleCurrency;
        $params["startDate"] = $exampleStartDate;
        $params["endDate"] = $exampleEndDate;

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("ledgers/" . $exampleCurrency, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);
        $result = $client->getLedgerEntries($exampleCurrency, $exampleStartDate, $exampleEndDate);

        self::assertIsArray($result);
        self::assertCount(3, $result);
        self::assertEquals(-8000000, $result[1]->getAmount());
        self::assertEquals("John Doe", $result[1]->getBuyerFields()->getBuyerName());
        self::assertInstanceOf(LedgerEntry::class, $result[0]);
    }

    public function testGetLedgerShouldCatchRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $client->getLedgerEntries($exampleCurrency, $exampleStartDate, $exampleEndDate);
    }

    public function testGetLedgerShouldCatchRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $client->getLedgerEntries($exampleCurrency, $exampleStartDate, $exampleEndDate);
    }

    public function testGetLedgerShouldCatchJsonMapperException()
    {
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $client->getLedgerEntries($exampleCurrency, $exampleStartDate, $exampleEndDate);
    }

    public function testGetLedgers()
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getLedgersResponse.json');

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("ledgers", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getLedgers();


        self::assertIsArray($result);
        $ledger = $result[1];
        self::assertInstanceOf(Ledger::class, $ledger);
        self::assertEquals(2389.82, $ledger->getBalance());
    }

    public function testGetLedgersShouldCatchBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getLedgers();
    }

    public function testGetLedgersShouldCatchRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getLedgers();
    }

    public function testGetLedgersShouldCatchJsonMapperException()
    {
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getLedgers();
    }

    public function testSubmitPayoutRecipients()
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'X6KJbe9RxAGWNReCwd1xRw';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/submitPayoutRecipientsResponse.json');

        $payoutRecipientToArray = [
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->submitPayoutRecipients($payoutRecipientsMock);
        self::assertIsArray($result);
    }

    public function testSubmitPayoutRecipientsShouldCatchRestCliBitPayException()
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'X6KJbe9RxAGWNReCwd1xRw';
        $payoutRecipientToArray = [
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->submitPayoutRecipients($payoutRecipientsMock);
    }

    public function testSubmitPayoutRecipientsShouldCatchRestCliException()
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'X6KJbe9RxAGWNReCwd1xRw';
        $payoutRecipientToArray = [
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
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
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients", $payoutRecipientsMock->toArray())
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->submitPayoutRecipients($payoutRecipientsMock);
    }

    public function testGetPayoutRecipient()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $recipientId = 'test';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayoutRecipient.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getPayoutRecipient($recipientId);
        self::assertInstanceOf(PayoutRecipient::class, $result);
    }

    public function testGetPayoutRecipientShouldHandleRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $recipientId = 'test';
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getPayoutRecipient($recipientId);
    }

    public function testGetPayoutRecipientShouldHandleRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $recipientId = 'test';
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getPayoutRecipient($recipientId);
    }

    public function testGetPayoutRecipientShouldHandleJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $recipientId = 'test';
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients/" . $recipientId, $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getPayoutRecipient($recipientId);
    }

    public function testGetPayoutRecipients()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayoutRecipients.json');

        $status = 'status';
        $limit = 2;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getPayoutRecipients($status, $limit, $offset);
        self::assertIsArray($result);
        self::assertInstanceOf(PayoutRecipient::class, $result[0]);
    }

    public function testGetPayoutRecipientsShouldHandleRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients", $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getPayoutRecipients($status, $limit, $offset);
    }

    public function testGetPayoutRecipientsShouldHandleRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients", $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getPayoutRecipients($status, $limit, $offset);
    }

    public function testGetPayoutRecipientsShouldHandleJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("recipients", $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getPayoutRecipients($status, $limit, $offset);
    }

    public function testUpdatePayoutRecipient()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayoutRecipient.json');
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
        self::assertInstanceOf(PayoutRecipient::class, $result);
    }

    public function testUpdatePayoutRecipientShouldCatchRestCliBitPayException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    public function testUpdatePayoutRecipientShouldCatchRestCliException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    public function testUpdatePayoutRecipientShouldCatchJsonMapperException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $payoutRecipientToArray = [
            'token' => self::MERCHANT_TOKEN,
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('update')
            ->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    public function testDeletePayoutRecipient()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = self::MERCHANT_TOKEN;
        $successResponse = file_get_contents(__DIR__ . '/jsonResponse/success.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willReturn($successResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->deletePayoutRecipient($exampleRecipientId);
        self::assertIsBool($result);
        self::assertTrue($result);
    }

    public function testDeletePayoutRecipientShouldCatchRestCliBitPayException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->deletePayoutRecipient($exampleRecipientId);
    }

    public function testDeletePayoutRecipientShouldCatchRestCliException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->deletePayoutRecipient($exampleRecipientId);
    }

    public function testDeletePayoutRecipientShouldCatchJsonDecodeException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = self::MERCHANT_TOKEN;
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/false.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        self::assertFalse($client->deletePayoutRecipient($exampleRecipientId));
    }

    public function testRequestPayoutRecipientNotification()
    {
        $content['token'] = self::MERCHANT_TOKEN;
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $successResponse = file_get_contents(__DIR__ . '/jsonResponse/success.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willReturn($successResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->requestPayoutRecipientNotification($exampleRecipientId);
        self::assertIsBool($result);
        self::assertTrue($result);
    }

    public function testRequestPayoutRecipientNotificationShouldCatchRestCliBitPayException()
    {
        $content['token'] = self::MERCHANT_TOKEN;
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->requestPayoutRecipientNotification($exampleRecipientId);
    }

    public function testRequestPayoutRecipientNotificationShouldCatchRestCliException()
    {
        $content['token'] = self::MERCHANT_TOKEN;
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->requestPayoutRecipientNotification($exampleRecipientId);
    }

    public function testRequestPayoutRecipientNotificationShouldCatchJsonDecodeException()
    {
        $content['token'] = self::MERCHANT_TOKEN;
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/false.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        self::assertFalse($client->requestPayoutRecipientNotification($exampleRecipientId));
    }

    public function testGetRates()
    {
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getRates.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates', null, false)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getRates();
        self::assertEquals('41248.11', $result->getRate('USD'));
        self::assertIsArray($result->getRates());
        self::assertInstanceOf(Rates::class, $result);
    }

    public function testGetRatesShouldHandleRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates', null, false)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getRates();
    }

    public function testGetRatesShouldHandleRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates', null, false)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getRates();
    }

    public function testGetRatesShouldHandleCorruptJson()
    {
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates', null, false)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getRates();
    }

    public function testGetCurrencyRates()
    {
        $exampleCurrency = Currency::BTC;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getCurrencyRates.json');

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getCurrencyRates(Currency::BTC);
        self::assertEquals('41248.11', $result->getRate(Currency::USD));
        self::assertIsArray($result->getRates());
        self::assertInstanceOf(Rates::class, $result);
    }

    public function testGetCurrencyRatesShouldHandleRestCliBitPayException()
    {
        $exampleCurrency = Currency::USD;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getCurrencyRates(Currency::USD);
    }

    public function testGetCurrencyRatesShouldHandleRestCliException()
    {
        $exampleCurrency = Currency::USD;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getCurrencyRates(Currency::USD);
    }

    public function testGetCurrencyRatesShouldFailWhenDataInvalid()
    {
        $exampleCurrency = Currency::USD;
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates/' . $exampleCurrency, null, false)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getCurrencyRates(Currency::USD);
    }

    public function testGetCurrencyPairRate()
    {
        $baseCurrency = Currency::USD;
        $currency = Currency::USD;
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getCurrencyPairRate.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with('rates/' . $baseCurrency . '/' . $currency, null, false)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getCurrencyPairRate($baseCurrency, $currency);
        self::assertEquals('41154.05', $result->getRate());
        self::assertEquals('US Dollar', $result->getName());
        self::assertEquals('USD', $result->getCode());
        self::assertInstanceOf(Rate::class, $result);
    }

    public function testGetCurrencyPairRateShouldCatchRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    public function testGetCurrencyPairRateShouldThrowExceptionWhenResponseIsException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    public function testGetCurrencyPairRateShouldReturnExceptionWhenNoDataInJson()
    {
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
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
        $params['token'] = self::MERCHANT_TOKEN;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getSettlementsResponse.json');

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements", $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
        self::assertIsArray($result);
        self::assertEquals('KBkdURgmE3Lsy9VTnavZHX', $result[0]->getId());
        self::assertEquals('processing', $result[0]->getStatus());
        self::assertEquals('RPWTabW8urd3xWv2To989v', $result[1]->getId());
        self::assertEquals('processing', $result[1]->getStatus());
        self::assertInstanceOf(Settlement::class, $result[0]);
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
        $params['token'] = self::MERCHANT_TOKEN;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements", $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
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
        $params['token'] = self::MERCHANT_TOKEN;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements", $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
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
        $params['token'] = self::MERCHANT_TOKEN;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements", $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    public function testGetSettlement()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getSettlementResponse.json');

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSettlement($settlementId);
        self::assertEquals('RPWTabW8urd3xWv2To989v', $result->getId());
        self::assertEquals('EUR', $result->getCurrency());
        self::assertEquals(
            '2GrR6GDeYxUFYM9sDKViy6nFFTy4Rjvm1SYdLBjK46jkeJdgUTRccRfhtwkhNcuZky',
            $result->getToken()
        );
        self::assertEquals('processing', $result->getStatus());
        self::assertInstanceOf(Settlement::class, $result);
    }

    public function testGetSettlementShouldHandleRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getSettlement($settlementId);
    }

    public function testGetSettlementShouldHandleRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getSettlement($settlementId);
    }

    public function testGetSettlementShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'RPWTabW8urd3xWv2To989v';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $settlementId, $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getSettlement($settlementId);
    }

    public function testGetSettlementReconciliationReport()
    {
        $exampleToken = self::MERCHANT_TOKEN;
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $params['token'] = $exampleToken;
        $exampleResponse = file_get_contents(
            __DIR__ . '/jsonResponse/getSettlementReconciliationReportResponse.json'
        );

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willReturn($exampleResponse);

        $client = $this->getClient($restCliMock);

        $result = $client->getSettlementReconciliationReport($exampleId, $exampleToken);

        self::assertEquals('RvNuCTMAkURKimwgvSVEMP', $result->getId());
        self::assertEquals('processing', $result->getStatus());
        self::assertEquals('USD', $result->getCurrency());
        self::assertInstanceOf(Settlement::class, $result);
    }

    public function testGetSettlementReconciliationReportShouldCatchRestCliBitPayException()
    {
        $exampleToken = self::MERCHANT_TOKEN;
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getSettlementReconciliationReport($exampleId, $exampleToken);
    }

    public function testGetSettlementReconciliationReportShouldCatchRestCliException()
    {
        $exampleToken = self::MERCHANT_TOKEN;
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getSettlementReconciliationReport($exampleId, $exampleToken);
    }

    public function testGetSettlementReconciliationReportShouldCatchJsonMapperException()
    {
        $exampleToken = self::MERCHANT_TOKEN;
        $exampleId = 'RPWTabW8urd3xWv2To989v';
        $params['token'] = $exampleToken;
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("settlements/" . $exampleId . '/reconciliationReport', $params)
            ->willReturn($badResponse);

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getSettlementReconciliationReport($exampleId, $exampleToken);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayout()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects(self::once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willReturn($exampleResponse);
        $client = $this->getClient($restCliMock);
        $result = $client->getPayout($payoutId);
        self::assertEquals(self::MERCHANT_TOKEN, $result->getToken());
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutShouldHandleRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects(self::once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->getPayout($payoutId);
    }

    public function testGetPayoutShouldHandleJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects(self::once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $client->getPayout($payoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutShouldHandleRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayout.json');
        $exampleResponseArray = json_decode($exampleResponse,  true);
        $payoutId = $exampleResponseArray['id'];
        $restCliMock->expects(self::once())->method('get')
            ->with("payouts/" . $payoutId, $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->getPayout($payoutId);
    }

    public function testGetPayouts()
    {
        $params = $this->getPayoutParams();
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = file_get_contents(__DIR__ . '/jsonResponse/getPayouts.json');
        $restCliMock->expects(self::once())->method('get')
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
        self::assertIsArray($result);
        self::assertEquals('JMwv8wQCXANoU2ZZQ9a9GH', $result[0]->getId());
        self::assertEquals(10, $result[0]->getAmount());
        self::assertEquals('USD', $result[0]->getCurrency());
        self::assertInstanceOf(Payout::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutsShouldHandleRestCliBitPayException()
    {
        $params = $this->getPayoutParams();
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("payouts", $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

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
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("payouts", $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

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
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("payouts", $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

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
        $params['token'] = self::MERCHANT_TOKEN;
        $examplePayoutId = 'test';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willReturn('{"status":"success"}');
        $client = $this->getClient($restCliMock);
        $result = $client->cancelPayout($examplePayoutId);

        self::assertIsBool($result);
    }

    public function testCancelPayoutShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $examplePayoutId = 'test';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->cancelPayout($examplePayoutId);
    }

    public function testCancelPayoutShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $examplePayoutId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->cancelPayout($examplePayoutId);
    }

    public function testCancelPayoutShouldCatchUnexistentPropertyError()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $examplePayoutId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("payouts/" . $examplePayoutId, $params)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/false.json', true));
        $client = $this->getClient($restCliMock);

        self::assertFalse($client->cancelPayout($examplePayoutId));
    }

    public function testSubmitPayout()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' =>  self::MERCHANT_TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willReturn('{ "currency": "EUR", "balance": 0 }');
        $client = $this->getClient($restCliMock);
        $result = $client->submitPayout($payoutMock);

        self::assertEquals('EUR', $result->getCurrency());
        self::assertInstanceOf(Payout::class, $result);
    }

    public function testSubmitPayoutShouldCatchRestCliBitPayException()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => self::MERCHANT_TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->submitPayout($payoutMock);
    }

    public function testSubmitPayoutShouldCatchRestCliException()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => self::MERCHANT_TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->submitPayout($payoutMock);
    }

    public function testSubmitPayoutShouldCatchJsonMapperException()
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => self::MERCHANT_TOKEN,
            'currency' => $exampleCurrency
        ];
        $payoutMock->method('getCurrency')->willReturn($exampleCurrency);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts", $payoutMock->toArray())
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $client->submitPayout($payoutMock);
    }

    public function testRequestNotification()
    {
        $content = ['token' => self::MERCHANT_TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willReturn('{ "status": "success", "data": {}, "message": null }');
        $client = $this->getClient($restCliMock);
        $result = $client->requestPayoutNotification($payoutId);

        self::assertTrue($result);
    }

    public function testRequestNotificationShouldCatchRestCliBitPayException()
    {
        $content = ['token' => self::MERCHANT_TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->requestPayoutNotification($payoutId);
    }

    public function testRequestNotificationShouldCatchRestCliException()
    {
        $content = ['token' => self::MERCHANT_TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->requestPayoutNotification($payoutId);
    }

    public function testRequestNotificationShouldCatchJsonException()
    {
        $content = ['token' => self::MERCHANT_TOKEN];
        $payoutId = 'JMwv8wQCXANoU2ZZQ9a9GH';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts/{$payoutId}/notifications", $content)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/false.json', true));
        $client = $this->getClient($restCliMock);

        self::assertFalse($client->requestPayoutNotification($payoutId));
    }

    public function testCreatePayoutGroup(): void
    {
        $expectedRequest = json_decode(
            file_get_contents(__DIR__ . '/jsonResponse/createPayoutGroupRequest.json', true),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $notificationURL = 'https://yournotiticationURL.com/wed3sa0wx1rz5bg0bv97851eqx';
        $shopperId = '7qohDf2zZnQK5Qanj8oyC2';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("payouts/group", $expectedRequest)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/createPayoutGroupResponse.json', true));

        $client = $this->getClient($restCliMock);

        $payout = new Payout();
        $payout->setAmount(10);
        $payout->setCurrency(Currency::USD);
        $payout->setLedgerCurrency(Currency::USD);
        $payout->setReference('payout_20210527');
        $payout->setNotificationEmail('merchant@email.com');
        $payout->setNotificationURL($notificationURL);
        $payout->setEmail('john@doe.com');
        $payout->setRecipientId('LDxRZCGq174SF8AnQpdBPB');
        $payout->setShopperId($shopperId);

        $result = $client->createPayoutGroup([$payout]);
        $firstPayout = $result->getPayouts()[0];
        $firstFailed = $result->getFailed()[0];

        self::assertCount(1, $result->getPayouts());
        self::assertEquals($notificationURL, $firstPayout->getNotificationURL());
        self::assertEquals($shopperId, $firstPayout->getShopperId());
        self::assertEquals('Ledger currency is required', $firstFailed->getErrorMessage());
        self::assertEquals('john@doe.com', $firstFailed->getPayee());
    }

    public function testCancelPayoutGroup(): void
    {
        $groupId = '12345';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("payouts/group/" . $groupId, ['token' => self::PAYOUT_TOKEN])
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/cancelPayoutGroupResponse.json', true));

        $client = $this->getClient($restCliMock);

        $result = $client->cancelPayoutGroup($groupId);
        $firstPayout = $result->getPayouts()[0];
        $firstFailed = $result->getFailed()[0];

        self::assertCount(2, $result->getPayouts());
        self::assertEquals(
            'https://yournotiticationURL.com/wed3sa0wx1rz5bg0bv97851eqx',
            $firstPayout->getNotificationURL()
        );
        self::assertEquals('7qohDf2zZnQK5Qanj8oyC2', $firstPayout->getShopperId());
        self::assertEquals('PayoutId is missing or invalid', $firstFailed->getErrorMessage());
        self::assertEquals('D8tgWzn1psUua4NYWW1vYo', $firstFailed->getPayoutId());
    }

    public function testCreateRefund()
    {
        $params = $this->getInvoiceRefundParams();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())
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

        self::assertEquals('Eso8srxKJR5U71ahCspAAA', $result->getId());
        self::assertEquals($params['invoiceId'], $result->getInvoice());
    }

    public function testCreateRefundShouldCatchRestCliBitPayException()
    {
        $params = $this->getInvoiceRefundParams();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("refunds/", $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

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
        $restCliMock->expects(self::once())->method('post')
            ->with("refunds/", $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

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
        $restCliMock->expects(self::once())->method('post')->with("refunds/", $params, true)->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

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
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willReturn(self::CANCEL_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);

        $result = $client->cancelRefund($exampleRefundId);
        self::assertEquals('USD', $result->getCurrency());
        self::assertEquals(10, $result->getAmount());
        self::assertEquals('cancelled', $result->getStatus());
        self::assertInstanceOf(Refund::class, $result);
    }

    public function testCancelRefundShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->cancelRefund($exampleRefundId);
    }

    public function testCancelRefundShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->cancelRefund($exampleRefundId);
    }

    public function testCancelRefundShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/" . $exampleRefundId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $client->cancelRefund($exampleRefundId);
    }

    public function testCancelRefundByGuid()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::CANCEL_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);

        $result = $client->cancelRefundByGuid($guid);
        self::assertEquals('USD', $result->getCurrency());
        self::assertEquals(10, $result->getAmount());
        self::assertEquals('cancelled', $result->getStatus());
        self::assertInstanceOf(Refund::class, $result);
    }

    public function testCancelRefundByGuidShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->cancelRefundByGuid($guid);
    }

    public function testCancelRefundByGuidShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->cancelRefundByGuid($guid);
    }

    public function testCancelRefundByGuidShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('delete')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $client->cancelRefundByGuid($guid);
    }

    public function testUpdateRefund()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->updateRefund($refundId, $params['status']);

        self::assertInstanceOf(Refund::class, $result);
    }

    public function testUpdateRefundShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->updateRefund($refundId, $params['status']);
    }

    public function testUpdateRefundShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);
        $client->updateRefund($refundId, $params['status']);
    }

    public function testUpdateRefundShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/" . $refundId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $client->updateRefund($refundId, $params['status']);
    }

    public function testUpdateRefundByGuid()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->updateRefundByGuid($guid, $params['status']);

        self::assertInstanceOf(Refund::class, $result);
        self::assertEquals('created', $result->getStatus());
        self::assertEquals(10, $result->getAmount());
    }

    public function testUpdateRefundBuGuidShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->updateRefundByGuid($guid, $params['status']);
    }

    public function testUpdateRefundBuGuidShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willThrowException($this->getBitPayApiException());

        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);
        $client->updateRefundByGuid($guid, $params['status']);
    }

    public function testUpdateRefundByGuidShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $params['status'] = 'status';
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("refunds/guid/" . $guid, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $client->updateRefundByGuid($guid, $params['status']);
    }

    public function testGetRefunds()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/", $params, true)
            ->willReturn(self::CORRECT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $result = $client->getRefunds($exampleInvoiceId);

        self::assertIsArray($result);
        self::assertInstanceOf(Refund::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/", $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/", $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/", $params, true)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $client->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefund()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->getRefund($exampleRefundId);

        self::assertEquals('USD', $result->getCurrency());
        self::assertEquals(10, $result->getAmount());
        self::assertEquals('created', $result->getStatus());
        self::assertEquals('WoE46gSLkJQS48RJEiNw3L', $result->getId());
        self::assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/" . $exampleRefundId, $params, true)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getRefund($exampleRefundId);
    }

    public function testGetRefundByGuid()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willReturn(self::UPDATE_REFUND_JSON_STRING);

        $client = $this->getClient($restCliMock);
        $result = $client->getRefundByGuid($guid);

        self::assertEquals('USD', $result->getCurrency());
        self::assertEquals(10, $result->getAmount());
        self::assertEquals('created', $result->getStatus());
        self::assertEquals('WoE46gSLkJQS48RJEiNw3L', $result->getId());
        self::assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundByGuidShouldCatchRestCliBitPayException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getRefundByGuid($guid);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundByGuidShouldCatchRestCliException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $client->getRefundByGuid($guid);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundByGuidShouldCatchRestCliJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $guid = 'testGuid';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('get')
            ->with("refunds/guid/" . $guid, $params, true)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $client = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $client->getRefundByGuid($guid);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotification()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willReturn('{"status":"success"}');
        $client = $this->getClient($restCliMock);
        $result = $client->sendRefundNotification($exampleRefundId);

        self::assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchRestCliBitPayException()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->sendRefundNotification($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchRestCliException()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willThrowException($this->getBitPayApiException());
        $client = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $client->sendRefundNotification($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchJsonMapperException()
    {
        $exampleRefundId = 'testId';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with("refunds/" . $exampleRefundId . "/notifications", $params, true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/false.json', true));
        $client = $this->getClient($restCliMock);

        self::assertFalse($client->sendRefundNotification($exampleRefundId));
    }

    public function testGetInvoice()
    {
        $exampleInvoiceObject = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => self::MERCHANT_TOKEN], true)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $testedObject = $this->getClient($restCliMock);
        $result = $testedObject->getInvoice($exampleInvoiceObject->id, Facade::MERCHANT, true);

        self::assertEquals($exampleInvoiceObject->id, $result->getId());
        self::assertEquals($exampleInvoiceObject->amountPaid, $result->getAmountPaid());
        self::assertEquals($exampleInvoiceObject->currency, $result->getCurrency());
    }

    public function testGetInvoiceByGuid()
    {
        $exampleInvoiceObject = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method("get")
            ->with('invoices/guid/' . $exampleInvoiceObject->guid, ['token' => self::MERCHANT_TOKEN], true)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $testedObject = $this->getClient($restCliMock);
        $result = $testedObject->getInvoiceByGuid($exampleInvoiceObject->guid, Facade::MERCHANT, true);

        self::assertEquals($exampleInvoiceObject->id, $result->getId());
        self::assertEquals($exampleInvoiceObject->amountPaid, $result->getAmountPaid());
        self::assertEquals($exampleInvoiceObject->currency, $result->getCurrency());
    }

    public function testGetInvoiceShouldCatchRestCliExceptions(): void
    {
        $exampleInvoiceObject = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willThrowException($this->getBitPayApiException());

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(BitPayApiException::class);

        $testedObject->getInvoice($exampleInvoiceObject->id, Facade::MERCHANT, true);
    }

    public function testGetInvoiceShouldCatchJsonMapperException()
    {
        $exampleInvoiceObject = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willReturn('badString');

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $testedObject->getInvoice($exampleInvoiceObject->id, Facade::MERCHANT, true);
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
            'token' => self::MERCHANT_TOKEN
        ];

        $successResponse = file_get_contents(__DIR__ . '/jsonResponse/getInvoices.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
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

        self::assertInstanceOf(Invoice::class, $result[0]);
        self::assertEquals($responseToCompare[0]['id'], $result[0]->getId());
        self::assertEquals($responseToCompare[0]['guid'], $result[0]->getGuid());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testGetInvoicesShouldCatchRestCliExceptions(Exception $exceptionClass)
    {
        $params = [
            'status' => 'status',
            'dateStart' => 'dateStart',
            'dateEnd' => 'dateEnd',
            'limit' => 1,
            'offset' => 1,
            'orderId' => 'orderId',
            'token' => self::MERCHANT_TOKEN
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method("get")
            ->with('invoices', $params)
            ->willThrowException($exceptionClass);

        $testedObject = $this->getClient($restCliMock);
        $this->expectException($exceptionClass::class);

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
            'token' => self::MERCHANT_TOKEN
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method("get")
            ->with('invoices', $params)
            ->willReturn('badString');

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);

        $testedObject->getInvoices(
            $params['dateStart'],
            $params['dateEnd'],
            $params['status'],
            $params['orderId'],
            $params['limit'],
            $params['offset']);
    }

    public function testRequestInvoiceNotificationShouldReturnTrueOnSuccess()
    {
        $invoiceId = self::TEST_INVOICE_ID;
        $params['token'] = self::MERCHANT_TOKEN;
        $expectedSuccessResponse = 'success';
        $restCliMock = $this->getRestCliMock();

        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with('invoices/' . $invoiceId . '/notifications', $params)
            ->willReturn($expectedSuccessResponse);

        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->requestInvoiceNotification($invoiceId);
        self::assertTrue($result);
    }

    public function testRequestInvoiceNotificationShouldReturnFalseOnFailure()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $expectedFailResponse = 'fail';
        $restCliMock = $this->getRestCliMock();

        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with('invoices/' . self::TEST_INVOICE_ID . '/notifications', $params)
            ->willReturn($expectedFailResponse);
        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
        self::assertFalse($result);
    }

    public function testRequestInvoiceNotificationShouldCatchJsonMapperException()
    {
        $params['token'] = self::MERCHANT_TOKEN;
        $restCliMock = $this->getRestCliMock();

        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with("invoices/" . self::TEST_INVOICE_ID . '/notifications', $params, true)
            ->willThrowException(new BitPayGenericException());

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
    }

    public function testCancelInvoice()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::MERCHANT_TOKEN,
            'forceCancel' => true
        ];
        $invoice = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));
        $invoice->isCancelled = true;
        $restCliMock->expects(self::once())->method('delete')->with("invoices/" . self::TEST_INVOICE_ID, $params)->willReturn(json_encode($invoice));
        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
        self::assertEquals(self::TEST_INVOICE_ID, $result->getId());
        self::assertTrue($result->getIsCancelled());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testCancelInvoiceShouldCatchRestCliExceptions(Exception $exceptionClass)
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::MERCHANT_TOKEN,
            'forceCancel' => true
        ];
        $restCliMock->expects(self::once())->method('delete')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params)
            ->willThrowException($exceptionClass);
        $testedObject = $this->getClient($restCliMock);

        $this->expectException($exceptionClass::class);
        $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
    }

    public function testCancelInvoiceShouldCatchJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::MERCHANT_TOKEN,
            'forceCancel' => true
        ];
        $restCliMock->expects(self::once())->method('delete')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params)
            ->willReturn('corruptJson');
        $testedObject = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
    }

    public function testCancelInvoiceByGuid()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::MERCHANT_TOKEN,
            'forceCancel' => true
        ];
        $invoice = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'));
        $invoice->isCancelled = true;
        $restCliMock
            ->expects(self::once())
            ->method('delete')
            ->with("invoices/guid/" . self::TEST_INVOICE_GUID, $params)
            ->willReturn(json_encode($invoice));

        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->cancelInvoiceByGuid(self::TEST_INVOICE_GUID, $params['forceCancel']);
        self::assertEquals(self::TEST_INVOICE_GUID, $result->getGuid());
        self::assertEquals(self::TEST_INVOICE_ID, $result->getId());
        self::assertTrue($result->getIsCancelled());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testCancelInvoiceByGuidShouldCatchRestCliExceptions(Exception $exceptionClass)
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::MERCHANT_TOKEN,
            'forceCancel' => true
        ];
        $restCliMock
            ->expects(self::once())
            ->method('delete')
            ->with("invoices/guid/" . self::TEST_INVOICE_GUID, $params)
            ->willThrowException($exceptionClass);

        $testedObject = $this->getClient($restCliMock);

        $this->expectException($exceptionClass::class);
        $testedObject->cancelInvoiceByGuid(self::TEST_INVOICE_GUID, $params['forceCancel']);
    }

    public function testCancelInvoiceByGuidShouldCatchJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::MERCHANT_TOKEN,
            'forceCancel' => true
        ];
        $restCliMock
            ->expects(self::once())
            ->method('delete')
            ->with("invoices/guid/" . self::TEST_INVOICE_GUID, $params)
            ->willReturn('corruptJson');

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $testedObject->cancelInvoiceByGuid(self::TEST_INVOICE_GUID, $params['forceCancel']);
    }

    public function testPayInvoice()
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('update')
            ->with("invoices/pay/" . self::TEST_INVOICE_ID, $params)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/payInvoiceResponse.json'));
        $testedObject = $this->getClient($restCliMock);

        $result = $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
        self::assertEquals("7f3b1a02-d6ee-4185-bcd5-838276a598b5", $result->getGuid());
        self::assertEquals('complete', $result->getStatus());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testPayInvoiceShouldCatchRestCliExceptions(Exception $exceptionClass)
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("invoices/pay/" . self::TEST_INVOICE_ID, $params)
            ->willThrowException($exceptionClass);
        $testedObject = $this->getClient($restCliMock);

        $this->expectException($exceptionClass::class);
        $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
    }

    public function testPayInvoiceShouldCatchJsonMapperException()
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::MERCHANT_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('update')
            ->with("invoices/pay/" . self::TEST_INVOICE_ID, $params)
            ->willReturn('corruptJson');
        $testedObject = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
    }

    /**
     * @throws BitPayApiException
     */
    public function testCreateInvoice()
    {
        $invoiceArray = json_decode(file_get_contents(__DIR__.'/jsonResponse/createInvoiceResponse.json'), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects(self::once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('post')
            ->with('invoices', $invoiceArray, true)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/createInvoiceResponse.json'));

        $testedObject = $this->getClient($restCliMock);
        $result = $testedObject->createInvoice($invoiceMock);
        self::assertEquals($invoiceArray['id'], $result->getId());
        self::assertEquals($invoiceArray['status'], $result->getStatus());
        self::assertEquals($invoiceArray['guid'], $result->getGuid());
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testCreateInvoiceShouldCatchRestCliExceptions(Exception $exceptionClass)
    {
        $invoiceArray = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects(self::once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with('invoices', $invoiceArray, true)
            ->willThrowException($exceptionClass);

        $testedObject = $this->getClient($restCliMock);
        $this->expectException($exceptionClass::class);
        $testedObject->createInvoice($invoiceMock);
    }

    public function testCreateInvoiceShouldCatchJsonMapperException()
    {
        $invoiceArray = json_decode(file_get_contents(__DIR__.'/jsonResponse/getInvoice.json'), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects(self::once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects(self::once())->method('post')
            ->with('invoices', $invoiceArray, true)
            ->willReturn('corruptJson');

        $testedObject = $this->getClient($restCliMock);
        $this->expectException(BitPayGenericException::class);
        $testedObject->createInvoice($invoiceMock);
    }

    public function testUpdateInvoiceShouldCatchRestCliExceptions()
    {
        $params = [
            'token' => self::MERCHANT_TOKEN,
            'buyerEmail' => '',
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('update')
            ->with('invoices/'. self::TEST_INVOICE_ID, $params)
            ->willThrowException($this->getBitPayApiException());

        $this->expectException(BitPayApiException::class);
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
            'token' => self::MERCHANT_TOKEN,
            'buyerEmail' => '',
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('update')
            ->with('invoices/'. self::TEST_INVOICE_ID, $params)
            ->willReturn('corruptJson');

        $this->expectException(BitPayGenericException::class);
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
            'token' => self::MERCHANT_TOKEN,
            'buyerEmail' => null,
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $successResponse = file_get_contents(__DIR__.'/jsonResponse/getInvoice.json');
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
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
        self::assertEquals($invoiceArray['id'], $result->getId());
        self::assertEquals($invoiceArray['status'], $result->getStatus());
        self::assertEquals($invoiceArray['guid'], $result->getGuid());
    }

    public function testGetSupportedWallets()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willReturn(file_get_contents(__DIR__.'/jsonResponse/getSupportedWalletsResponse.json'));

        $client = $this->getClient($restCliMock);

        $result = $client->getSupportedWallets();
        self::assertIsArray($result);
        self::assertInstanceOf(Wallet::class, $result[0]);
        self::assertEquals('bitpay-wallet.png', $result[0]->getAvatar());
        self::assertEquals('copay-wallet.svg', $result[1]->getAvatar());
        self::assertEquals('BitPay', $result[0]->getDisplayName());
        self::assertEquals('Copay', $result[1]->getDisplayName());
    }

    public function testGetSupportedWalletsShouldCatchRestCliBitPayException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willThrowException($this->getBitPayApiException());

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $testedObject->getSupportedWallets();
    }

    public function testGetSupportedWalletsShouldCatchRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willThrowException($this->getBitPayApiException());

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(BitPayApiException::class);
        $testedObject->getSupportedWallets();
    }

    public function testGetSupportedWalletsShouldCatchJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects(self::once())
            ->method('get')
            ->with("supportedWallets/", null, false)
            ->willReturn(self::CORRUPT_JSON_STRING);

        $testedObject = $this->getClient($restCliMock);

        $this->expectException(BitPayGenericException::class);
        $testedObject->getSupportedWallets();
    }

    public static function exceptionClassProvider(): array
    {
        return [
            [new BitPayApiException("any", null)],
            [new BitPayGenericException()],
        ];
    }

    private function getClient(RESTcli $restCli)
    {
        $testToken = self::MERCHANT_TOKEN;

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
            'token' => self::MERCHANT_TOKEN,
            'invoiceId' => 'UZjwcYkWAKfTMn9J1yyfs4',
            'amount' => 10.10,
            'currency' => Currency::BTC,
            'preview' => true,
            'immediate' => false,
            'buyerPaysRefundFee' => false,
            'guid' => '3df73895-2531-e26a-3caa-098a746389b7'
        ];
    }

    /**
     * @throws \ReflectionException
     */
    private function refreshResourceClients(): void
    {
        $listOfClientsToClear = [
            BillClient::class,
            InvoiceClient::class,
            LedgerClient::class,
            PayoutClient::class,
            PayoutRecipientsClient::class,
            RateClient::class,
            RefundClient::class,
            SettlementClient::class,
            WalletClient::class,
            TokenClient::class
        ];

        foreach ($listOfClientsToClear as $className) {
            $refProperty = new ReflectionProperty($className, 'instance');
            $refProperty->setAccessible(true);
            $refProperty->setValue(null, null);
        }
    }

    /**
     * @return BitPayApiException
     */
    private function getBitPayApiException(): BitPayApiException
    {
        return $this->getMockBuilder(BitPayApiException::class)->disableOriginalConstructor()->getMock();
    }
}
