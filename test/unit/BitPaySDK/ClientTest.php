<?php

namespace BitPaySDK\Test;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BillCreationException;
use BitPaySDK\Exceptions\BillDeliveryException;
use BitPaySDK\Exceptions\BillQueryException;
use BitPaySDK\Exceptions\BillUpdateException;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Exceptions\PayoutRecipientCancellationException;
use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use BitPaySDK\Exceptions\PayoutRecipientNotificationException;
use BitPaySDK\Exceptions\PayoutRecipientQueryException;
use BitPaySDK\Exceptions\PayoutRecipientUpdateException;
use BitPaySDK\Exceptions\RateQueryException;
use BitPaySDK\Exceptions\SettlementQueryException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Model\Rate\Rate;
use BitPaySDK\Model\Rate\Rates;
use BitPaySDK\Model\Settlement\Settlement;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use PHPUnit\Framework\TestCase;
use BitPaySDK\Env;
use BitPaySDK\Tokens;


class ClientTest extends TestCase
{
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

        $billClient = $this->createObject($restCliMock);
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
        $billClient = $this->createObject($restCliMock);

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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillCreationException::class);
        $testedObject->createBill($billMock, Facade::Merchant, true);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillCreationException::class);
        $testedObject->createBill($billMock, Facade::Merchant, true);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getBill($exampleBillId);

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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillQueryException::class);
        $testedObject->getBill($exampleBillId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(Exception::class);
        $testedObject->getBill($exampleBillId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillQueryException::class);
        $testedObject->getBill($exampleBillId);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getBills($status);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillQueryException::class);
        $testedObject->getBills($status);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillQueryException::class);
        $testedObject->getBills($status);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillQueryException::class);
        $testedObject->getBills($status);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->updateBill($billMock, $exampleBillId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillUpdateException::class);
        $testedObject->updateBill($billMock, $exampleBillId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillUpdateException::class);
        $testedObject->updateBill($billMock, $exampleBillId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillUpdateException::class);
        $testedObject->updateBill($billMock, $exampleBillId);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->deliverBill($exampleBillId, $exampleBillToken);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillDeliveryException::class);
        $testedObject->deliverBill($exampleBillId, $exampleBillToken);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(BillDeliveryException::class);
        $testedObject->deliverBill($exampleBillId, $exampleBillToken);
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
//        $testedObject = $this->createObject($restCliMock);
//        $result = $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
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
//        $testedObject = $this->createObject($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $exampleCurrency = Currency::BTC;
//        $exampleStartDate = '2021-5-10';
//        $exampleEndDate = '2021-5-31';
//        $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
//    }
//
//    public function testGetLedgerShouldCatchRestCliBitPayException()
//    {
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock->expects($this->once())->method('get')->willThrowException(new BitPayException());
//
//        $testedObject = $this->createObject($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $exampleCurrency = Currency::BTC;
//        $exampleStartDate = '2021-5-10';
//        $exampleEndDate = '2021-5-31';
//        $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
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
//        $testedObject = $this->createObject($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $exampleCurrency = Currency::BTC;
//        $exampleStartDate = '2021-5-10';
//        $exampleEndDate = '2021-5-31';
//        $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
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
//        $testedObject = $this->createObject($restCliMock);
//
//        $result = $testedObject->getLedgers();
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
//        $testedObject = $this->createObject($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $testedObject->getLedgers();
//    }
//
//    public function testGetLedgersShouldCatchRestCliException()
//    {
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock->expects($this->once())->method('get')->willThrowException(new Exception());
//
//        $testedObject = $this->createObject($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $testedObject->getLedgers();
//    }
//
//    public function testGetLedgersShouldCatchJsonMapperException()
//    {
//        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
//
//        $restCliMock = $this->getRestCliMock();
//        $restCliMock->expects($this->once())->method('get')->willReturn($badResponse);
//
//        $testedObject = $this->createObject($restCliMock);
//
//        $this->expectException(LedgerQueryException::class);
//        $testedObject->getLedgers();
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->submitPayoutRecipients($payoutRecipientsMock);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientCreationException::class);
        $testedObject->submitPayoutRecipients($payoutRecipientsMock);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(Exception::class);
        $testedObject->submitPayoutRecipients($payoutRecipientsMock);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientCreationException::class);
        $testedObject->submitPayoutRecipients($payoutRecipientsMock);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getPayoutRecipient($recipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipient($recipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipient($recipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayoutRecipient($recipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getPayoutRecipients($status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipients($status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipients($status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipients($status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientUpdateException::class);
        $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientUpdateException::class);
        $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientUpdateException::class);
        $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->deletePayoutRecipient($exampleRecipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientCancellationException::class);
        $testedObject->deletePayoutRecipient($exampleRecipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientCancellationException::class);
        $testedObject->deletePayoutRecipient($exampleRecipientId);
    }

    public function testDeletePayoutRecipientShouldCatchJsonDecodeException()
    {
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $params['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('delete')
            ->with("recipients/" . $exampleRecipientId, $params)
            ->willReturn($badResponse);

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientCancellationException::class);
        $testedObject->deletePayoutRecipient($exampleRecipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientNotificationException::class);
        $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientNotificationException::class);
        $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
    }

    public function testRequestPayoutRecipientNotificationShouldCatchJsonDecodeException()
    {
        $content['token'] = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
        $exampleRecipientId = 'X3icwc4tE8KJ5hEPNPpDXW';
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("recipients/" . $exampleRecipientId . '/notifications', $content)
            ->willReturn($badResponse);

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(PayoutRecipientNotificationException::class);
        $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getRates();
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getRates();
    }

    public function testGetRatesShouldHandleRestCliException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with('rates', null, false)
            ->willThrowException(new Exception());

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getRates();
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getRates();
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getCurrencyRates(Currency::BTC);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyRates(Currency::USD);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyRates(Currency::USD);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyRates(Currency::USD);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getCurrencyPairRate($baseCurrency, $currency);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    public function testGetCurrencyPairRateShouldThrowExceptionWhenResponseIsException()
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->willThrowException(new \Exception());

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    public function testGetCurrencyPairRateShouldReturnExceptionWhenNoDataInJson()
    {
        $badResponse = file_get_contents(__DIR__ . '/jsonResponse/badResponse.json');
        $restCliMock = $this->getRestCliMock();

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->willReturn($badResponse);

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyPairRate(Currency::BTC, Currency::USD);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getSettlement($settlementId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlement($settlementId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlement($settlementId);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlement($settlementId);
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

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->getSettlementReconciliationReport($settlement);

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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlementReconciliationReport($settlement);
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlementReconciliationReport($settlement);
    }

    public function testGetSettlementReconciliationReportShouldCatchJsonMapperException()
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'testToken';
        $exampleId = 'testId';
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

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlementReconciliationReport($settlement);
    }




















    private function createObject(RESTcli $restCli)
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
}
