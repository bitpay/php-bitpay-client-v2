<?php

namespace BitPaySDK\Test;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\InvoiceCancellationException;
use BitPaySDK\Exceptions\InvoiceCreationException;
use BitPaySDK\Exceptions\InvoicePaymentException;
use BitPaySDK\Exceptions\InvoiceQueryException;
use BitPaySDK\Exceptions\InvoiceUpdateException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Util\RESTcli\RESTcli;
use Exception;
use PHPUnit\Framework\TestCase;
use BitPaySDK\Env;
use BitPaySDK\Tokens;


class ClientTest extends TestCase
{
    const UNIVERSAL_TOKEN = 'kQLZ7C9YKPSnMCC4EJwrqRHXuQkLzL1W8DfZCh37DHb';
    const TEST_INVOICE_ID = 'UZjwcYkWAKfTMn9J1yyfs4';

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

    public function testGetInvoice()
    {
        $exampleInvoiceObject = json_decode($this->getGetInvoiceExampleResponseString());

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willReturn($this->getGetInvoiceExampleResponseString());

        $testedObject = $this->createObject($restCliMock);
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
        $exampleInvoiceObject = json_decode($this->getGetInvoiceExampleResponseString());

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willThrowException(new $exceptionClass);

        $testedObject = $this->createObject($restCliMock);
        $this->expectException(InvoiceQueryException::class);

        $testedObject->getInvoice($exampleInvoiceObject->id, Facade::Merchant, true);
    }

    public function testGetInvoiceShouldCatchJsonMapperException()
    {
        $exampleInvoiceObject = json_decode($this->getGetInvoiceExampleResponseString());

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices/' . $exampleInvoiceObject->id, ['token' => $exampleInvoiceObject->token], true)
            ->willReturn('badString');

        $testedObject = $this->createObject($restCliMock);
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

        $testedObject = $this->createObject($restCliMock);
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

        $testedObject = $this->createObject($restCliMock);
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
            'token' => self::UNIVERSAL_TOKEN
        ];

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method("get")
            ->with('invoices', $params)
            ->willReturn('badString');

        $testedObject = $this->createObject($restCliMock);
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
    public function testRequestInvoiceNotificationShouldReturnTrueOnSuccess()
    {
        $invoiceId = self::TEST_INVOICE_ID;
        $params['token'] = self::UNIVERSAL_TOKEN;
        $expectedSuccessResponse = 'Success';
        $restCliMock = $this->getRestCliMock();

        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn($this->getGetInvoiceExampleResponseString());

        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with('invoices/' . $invoiceId . '/notifications', $params)
            ->willReturn($expectedSuccessResponse);

        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->requestInvoiceNotification($invoiceId);
        $this->assertTrue($result);
    }

    public function testRequestInvoiceNotificationShouldReturnFalseOnFailure()
    {
        $params['token'] = self::UNIVERSAL_TOKEN;
        $expectedFailResponse = 'fail';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("invoices/" . self::TEST_INVOICE_ID, $params, true)->willReturn($this->getGetInvoiceExampleResponseString());
        $restCliMock->expects($this->once())->method('post')->with('invoices/' . self::TEST_INVOICE_ID . '/notifications', $params)->willReturn($expectedFailResponse);
        $testedObject = $this->createObject($restCliMock);

        $result = $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
        $this->assertFalse($result);
    }

    public function testRequestInvoiceNotificationShouldCatchExceptionFromGetInvoice()
    {
        $params['token'] = self::UNIVERSAL_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn($this->getGetInvoiceExampleResponseString());

        $restCliMock
            ->expects($this->once())
            ->method('post')
            ->with("invoices/" . self::TEST_INVOICE_ID . '/notifications', $params, true)
            ->willThrowException(new InvoiceQueryException());

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(InvoiceQueryException::class);
        $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
    }

    public function testRequestInvoiceNotificationShouldCatchJsonMapperException()
    {
        $params['token'] = self::UNIVERSAL_TOKEN;
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('get')
            ->with("invoices/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn('corruptJson');

        $testedObject = $this->createObject($restCliMock);

        $this->expectException(InvoiceQueryException::class);
        $testedObject->requestInvoiceNotification(self::TEST_INVOICE_ID);
    }

    public function testCancelInvoice()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::UNIVERSAL_TOKEN,
            'forceCancel' => true
        ];
        $invoice = json_decode($this->getGetInvoiceExampleResponseString());
        $invoice->isCancelled = true;
        $restCliMock->expects($this->once())->method('delete')->with("invoices/" . self::TEST_INVOICE_ID, $params)->willReturn(json_encode($invoice));
        $testedObject = $this->createObject($restCliMock);

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
            'token' => self::UNIVERSAL_TOKEN,
            'forceCancel' => true
        ];
        $restCliMock->expects($this->once())->method('delete')->with("invoices/" . self::TEST_INVOICE_ID, $params)->willThrowException(new $exceptionClass());
        $testedObject = $this->createObject($restCliMock);

        $this->expectException(InvoiceCancellationException::class);
        $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
    }

    public function testCancelInvoiceShouldCatchJsonMapperException()
    {
        $restCliMock = $this->getRestCliMock();
        $params = [
            'token' => self::UNIVERSAL_TOKEN,
            'forceCancel' => true
        ];
        $restCliMock->expects($this->once())->method('delete')->with("invoices/" . self::TEST_INVOICE_ID, $params)->willReturn('corruptJson');
        $testedObject = $this->createObject($restCliMock);

        $this->expectException(InvoiceCancellationException::class);
        $testedObject->cancelInvoice(self::TEST_INVOICE_ID, $params['forceCancel']);
    }

    public function testPayInvoice()
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::UNIVERSAL_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with("invoices/pay/" . self::TEST_INVOICE_ID, $params, true)
            ->willReturn(file_get_contents(__DIR__ . '/jsonResponse/payInvoiceResponse.json'));
        $testedObject = $this->createObject($restCliMock);

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
        $params['token'] = self::UNIVERSAL_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/pay/" . self::TEST_INVOICE_ID, $params)->willThrowException(new $exceptionClass());
        $testedObject = $this->createObject($restCliMock);

        $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
    }

    public function testPayInvoiceShouldCatchJsonMapperException()
    {
        $params['status'] = 'confirmed';
        $params['token'] = self::UNIVERSAL_TOKEN;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/pay/" . self::TEST_INVOICE_ID, $params)->willReturn('corruptJson');
        $testedObject = $this->createObject($restCliMock);

        $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice(self::TEST_INVOICE_ID, $params['status']);
    }

    public function testCreateInvoice()
    {
        $invoiceArray = json_decode($this->getGetInvoiceExampleResponseString(), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects($this->once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with('invoices', $invoiceArray, true)->willReturn($this->getGetInvoiceExampleResponseString());

        $testedObject = $this->createObject($restCliMock);
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
        $invoiceArray = json_decode($this->getGetInvoiceExampleResponseString(), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects($this->once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with('invoices', $invoiceArray, true)->willThrowException(new $exceptionClass());

        $testedObject = $this->createObject($restCliMock);
        $this->expectException(InvoiceCreationException::class);
        $testedObject->createInvoice($invoiceMock);
    }

    public function testCreateInvoiceShouldCatchJsonMapperException()
    {
        $invoiceArray = json_decode($this->getGetInvoiceExampleResponseString(), true);
        $invoiceMock = $this->createMock(Invoice::class);
        $invoiceMock->expects($this->once())->method('toArray')->willReturn($invoiceArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with('invoices', $invoiceArray, true)->willReturn('corruptJson');

        $testedObject = $this->createObject($restCliMock);
        $this->expectException(InvoiceCreationException::class);
        $testedObject->createInvoice($invoiceMock);
    }

    /**
     * @dataProvider exceptionClassProvider
     */
    public function testUpdateInvoiceShouldCatchRestCliExceptions(string $exceptionClass)
    {
        $params = [
            'token' => self::UNIVERSAL_TOKEN,
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
        $testedObject = $this->createObject($restCliMock);
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
            'token' => self::UNIVERSAL_TOKEN,
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
        $testedObject = $this->createObject($restCliMock);
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
        $testedObject = $this->createObject($this->getRestCliMock());
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
        $testedObject = $this->createObject($this->getRestCliMock());
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
            'token' => self::UNIVERSAL_TOKEN,
            'buyerEmail' => null,
            'buyerSms' => 'buyerSms',
            'smsCode' => 'smsCode',
            'autoVerify' => false
        ];

        $successResponse = $this->getGetInvoiceExampleResponseString();
        $restCliMock = $this->getRestCliMock();
        $restCliMock
            ->expects($this->once())
            ->method('update')
            ->with('invoices/'. self::TEST_INVOICE_ID, $params)
            ->willReturn($successResponse);

        $testedObject = $this->createObject($restCliMock);
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

    public function exceptionClassProvider(): array
    {
        return [
            [BitPayException::class],
            [Exception::class],
        ];
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

    private function getGetInvoiceExampleResponseString()
    {
        return file_get_contents(__DIR__.'/jsonResponse/getInvoice.json');
    }
}