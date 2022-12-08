<?php

namespace BitPaySDK\Test;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BillCreationException;
use BitPaySDK\Exceptions\BillDeliveryException;
use BitPaySDK\Exceptions\BillQueryException;
use BitPaySDK\Exceptions\BillUpdateException;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\LedgerQueryException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Ledger\LedgerEntry;
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
