<?php

namespace BitPaySDK\Test;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BillCreationException;
use BitPaySDK\Exceptions\BillDeliveryException;
use BitPaySDK\Exceptions\BillQueryException;
use BitPaySDK\Exceptions\BillUpdateException;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\CurrencyQueryException;
use BitPaySDK\Exceptions\InvoiceCancellationException;
use BitPaySDK\Exceptions\InvoiceCreationException;
use BitPaySDK\Exceptions\InvoicePaymentException;
use BitPaySDK\Exceptions\InvoiceQueryException;
use BitPaySDK\Exceptions\InvoiceUpdateException;
use BitPaySDK\Exceptions\LedgerQueryException;
use BitPaySDK\Exceptions\PayoutBatchCancellationException;
use BitPaySDK\Exceptions\PayoutBatchCreationException;
use BitPaySDK\Exceptions\PayoutBatchNotificationException;
use BitPaySDK\Exceptions\PayoutBatchQueryException;
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
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Ledger\LedgerEntry;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutBatch;
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
    private const CORRUPT_JSON_STRING = '{"code":"USD""name":"US Dollar","rate":21205.85}';
    private const CORRECT_JSON_STRING = '[ { "currency": "EUR", "balance": 0 }, { "currency": "USD", "balance": 2389.82 }, { "currency": "BTC", "balance": 0.000287 } ]';

    protected function setUp(): void
    {
        parent::setUp();
        error_reporting(E_ALL);
    }

    private function getTestedClassInstance(): Client
    {
        return Client::create();
    }

    private function getExampleSubscriptionData()
    {
        $exampleResponse = (trim(file_get_contents(__DIR__ . '/../../../examples/subscriptionObject.json')));
        return json_decode($exampleResponse);
    }

    private function getExampleInvoiceData()
    {
        $exampleResponse = (trim(file_get_contents(__DIR__ . '/../../../examples/invoicesObject.json')));
        return json_decode($exampleResponse);
    }

    private function getExamplePayoutData()
    {
        $fileContents = file_get_contents(__DIR__ . '/../../../examples/payoutsObject.json');
        return json_decode(trim($fileContents));
    }

    private function getMerchantTokenFromFile()
    {
        return json_decode(file_get_contents(__DIR__ . '/../../../examples/BitPay.config.json'), true)['BitPayConfiguration']['EnvConfig']['Test']['ApiTokens'][Facade::Merchant];
    }

    private function getPayoutTokenFromFile()
    {
        return json_decode(file_get_contents(__DIR__ . '/../../../examples/BitPay.config.json'), true)['BitPayConfiguration']['EnvConfig']['Test']['ApiTokens'][Facade::Payout];
    }

    private function getExampleBillData()
    {
        $fileContents = file_get_contents(__DIR__ . '/../../../examples/billObject.json');
        return json_decode(trim($fileContents));
    }

    public function testCreate()
    {
        $instance = Client::create();
        $this->assertInstanceOf(Client::class, $instance, 'Client class created successfully');
    }

    /**
     * @throws BitPayException
     */
    public function testWithData()
    {
        $tokens = $this->createMock(Tokens::class);
        $result = $this->getTestedClassInstance()->withData(
            Env::Test,
            __DIR__ . '/../../../examples/bitpay_private_test.key',
            $tokens,
            'YourMasterPassword'
        );

        $this->assertInstanceOf(Client::class, $result);
    }

    public function testWithDataException()
    {
        $instance = new Client();
        $tokens = $this->createMock(Tokens::class);
        $this->expectException(BitPayException::class);

        $instance->withData(
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
        $result = $instance->withFile(__DIR__ . '/../../../examples/BitPay.config.json');
        $this->assertInstanceOf(Client::class, $result);
        return $result;
    }

    /**
     * @throws BitPayException
     */
    public function testWithFileYmlConfig()
    {
        $instance = $this->getTestedClassInstance();
        $result = $instance->withFile(__DIR__ . '/../../../examples/BitPay.config.yml');
        $this->assertInstanceOf(Client::class, $result);
    }

    public function testWithFileException()
    {
        $instance = $this->getTestedClassInstance();
        $this->expectException(BitPayException::class);
        $instance->withFile('badpath');
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetCurrencies($testedObject)
    {
        $fileContents = file_get_contents(__DIR__ . '/../../../examples/currenciesResponse.json');
        $exampleResponse = json_encode(json_decode(trim($fileContents), true));
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("currencies/", null, false)->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $currencies = $testedObject->getCurrencies();
        $this->assertIsArray($currencies);

        return $testedObject;
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrenciesShouldCatchRestCliException()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(CurrencyQueryException::class);
        $testedObject->getCurrencies();
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrenciesShouldCatchJsonDecodeException()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willThrowException(new Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(CurrencyQueryException::class);
        $testedObject->getCurrencies();
    }

    /**
     * @depends testGetCurrencies
     * */
    public function testGetCurrencyInfoWhenNoCurrencyExists($testedObject)
    {
        $result = $testedObject->getCurrencyInfo('test');

        $this->assertNull($result);
    }

    /**
     * @depends testGetCurrencies
     * */
    public function testGetCurrencyInfoWhenCurrencyExists($testedObject)
    {
        $result = $testedObject->getCurrencyInfo(Currency::BTC);
        $this->assertIsObject($result);
    }

    /**
     * @depends testWithFileJsonConfig
     * @throws BitPayException
     */
    public function testGetCurrencyRates($testedObject)
    {
        $exampleCurrency = Currency::USD;
        $restCliMock = $this->getRestCliMock();

        $restCliMock->expects($this->once())->method('get')->with('rates/' . $exampleCurrency, null, false)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getCurrencyRates(Currency::USD);
        $this->assertInstanceOf(Rates::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     * @throws BitPayException
     */
    public function testGetCurrencyRatesShouldFailWhenDataInvalid($testedObject)
    {
        $exampleCurrency = Currency::USD;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with('rates/' . $exampleCurrency, null, false)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyRates(Currency::USD);
    }

    /**
     * @depends testWithFileJsonConfig
     * @throws BitPayException
     */
    public function testGetCurrencyRatesShouldHandleRestCliBitPayException($testedObject)
    {
        $exampleCurrency = Currency::USD;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with('rates/' . $exampleCurrency, null, false)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyRates(Currency::USD);
    }

    /**
     * @depends testWithFileJsonConfig
     * @throws BitPayException
     */
    public function testGetCurrencyRatesShouldHandleRestCliException($testedObject)
    {
        $exampleCurrency = Currency::USD;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with('rates/' . $exampleCurrency, null, false)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyRates(Currency::USD);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testPayInvoice($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with('invoices/pay/' . $invoiceId, $params, true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->payInvoice($invoiceId, $params['status']);
        $this->assertInstanceOf(Invoice::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testPayInvoiceShouldCatchRestCliBitPayException($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with('invoices/pay/' . $invoiceId, $params, true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice($invoiceId, $params['status']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testPayInvoiceShouldCatchRestCliException($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with('invoices/pay/' . $invoiceId, $params, true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice($invoiceId, $params['status']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testPayInvoiceShouldCatchJsonMapperException($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with('invoices/pay/' . $invoiceId, $params, true)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice($invoiceId, $params['status']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testPayInvoiceShouldBeAvailableOnly_In_Test_Or_Demo_Env($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';
        $params['complete'] = true;

        $restCliMock = $this->getRestCliMock();
	    $restCliMock->expects($this->never())->method('update')->with('invoices/pay/' . $invoiceId, $params, true)->willReturn(self::CORRUPT_JSON_STRING);
	    $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
            $this->_env = 'not_test';
        };
	    $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
	    $doSetRestCli();
	
	    $this->expectException(InvoicePaymentException::class);
        $testedObject->payInvoice($invoiceId, $params['status'], $params['complete']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelInvoice($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['forceCancel'] = true;
        $invoiceId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with('invoices/' . $invoiceId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->cancelInvoice($invoiceId, true);
        $this->assertInstanceOf(Invoice::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelInvoiceShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['forceCancel'] = true;
        $invoiceId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with('invoices/' . $invoiceId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceCancellationException::class);
        $result = $testedObject->cancelInvoice($invoiceId, true);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelInvoiceShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['forceCancel'] = true;
        $invoiceId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with('invoices/' . $invoiceId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceCancellationException::class);
        $testedObject->cancelInvoice($invoiceId, true);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelInvoiceShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['forceCancel'] = true;
        $invoiceId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with('invoices/' . $invoiceId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceCancellationException::class);
        $testedObject->cancelInvoice($invoiceId, true);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestInvoiceNotification($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("invoices/" . $invoiceId, $params, true)->willReturn(self::CORRECT_JSON_STRING);
        $params['token'] = false;
        $restCliMock->expects($this->once())->method('post')->with('invoices/' . $invoiceId . '/notifications', $params)->willReturn('string');
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $result = $testedObject->requestInvoiceNotification($invoiceId);
        $this->assertIsBool($result);
    }
	
	/**
	 * @depends testWithFileJsonConfig
	 */
	public function testRequestInvoiceNotificationShouldCatchExceptionFromGetInvoice($testedObject)
	{
		$invoiceId = 'testId';
		$params['token'] = $this->getMerchantTokenFromFile();
		$restCliMock = $this->getRestCliMock();
		$restCliMock->expects($this->once())->method('get')->with("invoices/" . $invoiceId, $params, true)->willThrowException(new BitPayException());
		$setRestCli = function () use ($restCliMock) {
			$this->_RESTcli = $restCliMock;
		};
		$doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
		$doSetRestCli();
		$this->expectException(InvoiceQueryException::class);
		$testedObject->requestInvoiceNotification($invoiceId);
	}
	
	/**
	 * @depends testWithFileJsonConfig
	 */
	public function testRequestInvoiceNotificationShouldCatchRestCliException($testedObject)
	{
		$invoiceId = 'testId';
		$params['token'] = $this->getMerchantTokenFromFile();
		$restCliMock = $this->getRestCliMock();
		$restCliMock->expects($this->once())->method('get')->with("invoices/" . $invoiceId, $params, true)->willReturn(self::CORRECT_JSON_STRING);
		$params['token'] = false;
		$restCliMock->expects($this->once())->method('post')->with('invoices/' . $invoiceId . '/notifications', $params)->willThrowException(new Exception());
		$setRestCli = function () use ($restCliMock) {
			$this->_RESTcli = $restCliMock;
		};
		$doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
		$doSetRestCli();
		$this->expectException(InvoiceQueryException::class);
		$testedObject->requestInvoiceNotification($invoiceId);
	}

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoice($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $invoiceId = 'test';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("invoices/" . $invoiceId, $params, true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getInvoice($invoiceId);
        $this->assertInstanceOf(Invoice::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoiceShouldHandleRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $invoiceId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("invoices/" . $invoiceId, $params, true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(InvoiceQueryException::class);
        $testedObject->getInvoice($invoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoiceShouldHandleRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $invoiceId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("invoices/" . $invoiceId, $params, true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(InvoiceQueryException::class);
        $testedObject->getInvoice($invoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoiceShouldHandleJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $invoiceId = 'test';
        $exampleResponse = '{"code":"USD""name":"US Dollar","rate":21205.85}';
        $restCliMock->expects($this->once())->method('get')->with("invoices/" . $invoiceId, $params, true)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(InvoiceQueryException::class);
        $testedObject->getInvoice($invoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoices($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $orderId = 'orderId';

        $params['status'] = $status;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['orderId'] = $orderId;

        $exampleResponse = json_encode($this->getExampleInvoiceData());
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("invoices", $params)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
        $this->assertIsArray($result);
        $this->assertInstanceOf(Invoice::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoicesShouldHandleRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $orderId = 'orderId';

        $params['status'] = $status;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['orderId'] = $orderId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("invoices", $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceQueryException::class);
        $testedObject->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoicesShouldHandleRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $orderId = 'orderId';

        $params['status'] = $status;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['orderId'] = $orderId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("invoices", $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceQueryException::class);
        $testedObject->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetInvoicesShouldHandleJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $orderId = 'orderId';

        $params['status'] = $status;
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['orderId'] = $orderId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("invoices", $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceQueryException::class);
        $testedObject->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateInvoice($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['buyerEmail'] = '';
	    $params['buyerSms'] = 'buyerSms';
	    $params['smsCode'] = 'smsCode';
	    $params['autoVerify'] = false;
		
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/" . $invoiceId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
	
	    $result = $testedObject->updateInvoice($invoiceId, $params['buyerSms'], $params['smsCode'], $params['buyerEmail'], $params['autoVerify']);
        $this->assertInstanceOf(Invoice::class, $result);
    }
	
	/**
	 * @depends testWithFileJsonConfig
	 */
	public function testUpdateInvoiceWhenLacksSmsCode($testedObject)
	{
		$invoiceId = 'testId';
		$params['token'] = $this->getMerchantTokenFromFile();
		$params['buyerEmail'] = '';
		$params['buyerSms'] = 'buyerSms';
		$params['smsCode'] = '';
		$params['autoVerify'] = false;
		
		$restCliMock = $this->getRestCliMock();
		$restCliMock->expects($this->never())->method('update')->with("invoices/" . $invoiceId, $params)->willReturn(self::CORRECT_JSON_STRING);
		$setRestCli = function () use ($restCliMock) {
			$this->_RESTcli = $restCliMock;
		};
		
		$doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
		$doSetRestCli();

		$this->expectException(InvoiceUpdateException::class);
		$testedObject->updateInvoice($invoiceId, $params['buyerSms'], $params['smsCode'], $params['buyerEmail'], $params['autoVerify']);
	}
	
	/**
	 * @depends testWithFileJsonConfig
	 */
	public function testUpdateInvoiceShouldPassWhenAutoVerifyTrue($testedObject)
	{
		$invoiceId = 'testId';
		$params['token'] = $this->getMerchantTokenFromFile();
		$params['buyerEmail'] = '';
		$params['buyerSms'] = 'buyerSms';
		$params['smsCode'] = '';
		$params['autoVerify'] = true;
		
		$restCliMock = $this->getRestCliMock();
		$restCliMock->expects($this->once())->method('update')->with("invoices/" . $invoiceId, $params)->willReturn(self::CORRECT_JSON_STRING);
		$setRestCli = function () use ($restCliMock) {
			$this->_RESTcli = $restCliMock;
		};
		
		$doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
		$doSetRestCli();
		
		$result = $testedObject->updateInvoice($invoiceId, $params['buyerSms'], $params['smsCode'], $params['buyerEmail'], $params['autoVerify']);
		$this->assertInstanceOf(Invoice::class, $result);
	}
	
	public function testUpdateInvoiceShouldThrowExceptionWhenProvidedBothBuyerSmsAndEmail()
	{
		$testedObject = $this->getTestedClassInstance();
		$invoiceId = 'testId';
		$params['token'] = $this->getMerchantTokenFromFile();
		$params['buyerEmail'] = 'buyerEmail';
		$params['buyerSms'] = 'buyerSms';
		$params['smsCode'] = 'smsCode';
		$params['autoVerify'] = false;
		
		$this->expectExceptionMessage('Updating the invoice requires buyerSms or buyerEmail, but not both.');
		$testedObject->updateInvoice($invoiceId, $params['buyerSms'], $params['smsCode'], $params['buyerEmail'], $params['autoVerify']);
	}

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateInvoiceShouldCatchRestCliBitPayException($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['buyerEmail'] = 'buyerEmail';
		$params['buyerSms'] = '';
		$params['smsCode'] = '';
		$params['autoVerify'] = false;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/" . $invoiceId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceUpdateException::class);
        $testedObject->updateInvoice($invoiceId, $params['buyerSms'], $params['smsCode'], $params['buyerEmail'], $params['autoVerify']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateInvoiceShouldCatchRestCliException($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
	    $params['buyerEmail'] = '';
	    $params['buyerSms'] = 'buyerSms';
	    $params['smsCode'] = 'smsCode';
	    $params['autoVerify'] = false;
		
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/" . $invoiceId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceUpdateException::class);
	    $testedObject->updateInvoice($invoiceId, $params['buyerSms'], $params['smsCode'], $params['buyerEmail'], $params['autoVerify']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateInvoiceShouldCatchJsonMapperException($testedObject)
    {
        $invoiceId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['buyerEmail'] = '';
	    $params['buyerSms'] = 'buyerSms';
	    $params['smsCode'] = 'smsCode';
	    $params['autoVerify'] = false;
		
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("invoices/" . $invoiceId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceUpdateException::class);
        $testedObject->updateInvoice($invoiceId, $params['buyerSms'], $params['smsCode'], $params['buyerEmail']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateInvoice($testedObject)
    {
        $invoice = $this->createMock(Invoice::class);
        $invoiceId = 'testId';

        $invoiceToArray = [
            'token' => $this->getMerchantTokenFromFile(),
            'id' => $invoiceId,
            'guid' => 'guid'
        ];

        $invoice->method('toArray')
            ->withAnyParameters()
            ->willReturn($invoiceToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("invoices", $invoice->toArray(), true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->createInvoice($invoice);
        $this->assertInstanceOf(Invoice::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateInvoiceShouldCatchRestCliBitPayException($testedObject)
    {
        $invoice = $this->createMock(Invoice::class);
        $invoiceId = 'testId';

        $invoiceToArray = [
            'token' => $this->getMerchantTokenFromFile(),
            'id' => $invoiceId,
            'guid' => 'guid'
        ];

        $invoice->method('toArray')
            ->withAnyParameters()
            ->willReturn($invoiceToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("invoices", $invoice->toArray(), true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceCreationException::class);
        $testedObject->createInvoice($invoice);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateInvoiceShouldCatchRestCliException($testedObject)
    {
        $invoice = $this->createMock(Invoice::class);
        $invoiceId = 'testId';

        $invoiceToArray = [
            'token' => $this->getMerchantTokenFromFile(),
            'id' => $invoiceId,
            'guid' => 'guid'
        ];

        $invoice->method('toArray')
            ->withAnyParameters()
            ->willReturn($invoiceToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("invoices", $invoice->toArray(), true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceCreationException::class);
        $testedObject->createInvoice($invoice);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateInvoiceShouldCatchJsonMapperException($testedObject)
    {
        $invoice = $this->createMock(Invoice::class);
        $invoiceId = 'testId';

        $invoiceToArray = [
            'token' => $this->getMerchantTokenFromFile(),
            'id' => $invoiceId,
            'guid' => 'guid'
        ];

        $invoice->method('toArray')
            ->withAnyParameters()
            ->willReturn($invoiceToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("invoices", $invoice->toArray(), true)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(InvoiceCreationException::class);
        $testedObject->createInvoice($invoice);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testUpdateSubscription($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);
        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionId = $exampleSubscriptionData->data->id;
        $exampleResponse = json_encode($exampleSubscriptionData->data);
        $subscription->method('getId')->willReturn($exampleSubscriptionId);
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willReturn($exampleResponse);
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->updateSubscription($subscription, $exampleSubscriptionId);
        $this->assertInstanceOf(Subscription::class, $result);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testUpdateSubscriptionShouldCatchRestCliBitPayException($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $exampleResponse = json_encode($exampleSubscriptionData->data);
        $exampleSubscriptionId = $exampleSubscriptionData->data->id;

        $subscription->method('getId')->willReturn($exampleSubscriptionId);
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willThrowException(new BitPayException());
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BitPayException::class);
        $testedObject->updateSubscription($subscription, $exampleSubscriptionId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testUpdateSubscriptionShouldCatchRestCliException($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $exampleResponse = json_encode($exampleSubscriptionData->data);
        $exampleSubscriptionId = $exampleSubscriptionData->data->id;

        $subscription->method('getId')->willReturn($exampleSubscriptionId);
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willThrowException(new Exception());
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BitPayException::class);
        $testedObject->updateSubscription($subscription, $exampleSubscriptionId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testUpdateSubscriptionShouldCatchJsonMapperException($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $exampleResponse = json_encode($exampleSubscriptionData->data);
        $exampleSubscriptionId = $exampleSubscriptionData->data->id;

        $subscription->method('getId')->willReturn($exampleSubscriptionId);
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('update')->withAnyParameters()->willReturn(self::CORRUPT_JSON_STRING);
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BitPayException::class);
        $testedObject->updateSubscription($subscription, $exampleSubscriptionId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testCreateSubscription($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);

        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $exampleResponse = json_encode($exampleSubscriptionData);
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionId = $exampleSubscriptionData->data->id;
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $result = $testedObject->createSubscription($subscription);
        $this->assertInstanceOf(Subscription::class, $result);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testCreateSubscriptionShouldCatchRestCliBitPayException($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);

        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionId = $exampleSubscriptionData->data->id;
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(SubscriptionCreationException::class);
        $testedObject->createSubscription($subscription);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testCreateSubscriptionShouldCatchRestCliException($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);

        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionId = $exampleSubscriptionData->data->id;
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(SubscriptionCreationException::class);
        $testedObject->createSubscription($subscription);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testCreateSubscriptionShouldCatchJsonMapperException($testedObject)
    {
        $subscription = $this->createMock(Subscription::class);

        $exampleSubscriptionData = $this->getExampleSubscriptionData();
        $restCliMock = $this->getRestCliMock();

        $exampleSubscriptionId = $exampleSubscriptionData->data->id;
        $subscriptionToArray = [
            'id'           => $exampleSubscriptionId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $subscription->method('toArray')->willReturn($subscriptionToArray);
        $restCliMock->expects($this->once())->method('post')->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(SubscriptionCreationException::class);
        $testedObject->createSubscription($subscription);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscriptions($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = '{"code":"USD","name":"US Dollar","rate":21205.85}';
        $params['token'] = $this->getMerchantTokenFromFile();
        $status = 'draft';
        $params['status'] = $status;

        $restCliMock->expects($this->once())->method('get')->with("subscriptions", $params)->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getSubscriptions($status);

        $this->assertIsArray($result);
        $this->assertInstanceOf(Subscription::class, $result['code']);
        $this->assertInstanceOf(Subscription::class, $result['name']);
        $this->assertInstanceOf(Subscription::class, $result['rate']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscriptionsShouldHandleJsonMapperException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();

        $restCliMock->expects($this->once())->method('get')->with("subscriptions", $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SubscriptionQueryException::class);
        $testedObject->getSubscriptions();
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscriptionsShouldHandleRestCliBitPayException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();

        $restCliMock->expects($this->once())->method('get')->with("subscriptions", $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };

        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SubscriptionQueryException::class);
        $testedObject->getSubscriptions();
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscriptionsShouldHandleRestCliException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions", $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SubscriptionQueryException::class);
        $testedObject->getSubscriptions();
    }
    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscription($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = json_encode($this->getExampleSubscriptionData());
        $exampleSubscriptionId = 'subscriptionId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getSubscription($exampleSubscriptionId);
        $this->assertInstanceOf(Subscription::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscriptionShouldHandleRestCliBitPayException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $exampleSubscriptionId = 'subscriptionId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SubscriptionQueryException::class);
        $testedObject->getSubscription($exampleSubscriptionId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscriptionShouldHandleRestCliException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $exampleSubscriptionId = 'subscriptionId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willThrowException(new Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SubscriptionQueryException::class);
        $testedObject->getSubscription($exampleSubscriptionId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSubscriptionShouldHandleJsonMapperException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $exampleSubscriptionId = 'subscriptionId';
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock->expects($this->once())->method('get')->with("subscriptions/" . $exampleSubscriptionId, $params)->willReturn(self::CORRUPT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SubscriptionQueryException::class);
        $testedObject->getSubscription($exampleSubscriptionId);
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrencyPairRate()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willReturn(self::CORRECT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getCurrencyPairRate(Currency::BTC, Currency::USD);
        $this->assertInstanceOf(Rate::class, $result);
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrencyPairRateShouldReturnExceptionWhenNoDataInJson()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();

        $restCliMock->expects($this->once())->method('get')->willReturn(self::CORRUPT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrencyPairRateShouldCatchRestCliBitPayException()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();

        $restCliMock->expects($this->once())->method('get')->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    /**
     * @throws BitPayException
     */
    public function testGetCurrencyPairRateShouldThrowExceptionWhenResponseIsException()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willThrowException(new \Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getCurrencyPairRate(Currency::BTC, Currency::USD);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetLedger($testedObject)
    {
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $restCliMock = $this->getRestCliMock();

        $params['token'] = $this->getMerchantTokenFromFile();
        $params["currency"] = $exampleCurrency;
        $params["startDate"] = $exampleStartDate;
        $params["endDate"] = $exampleEndDate;

        $restCliMock->expects($this->once())->method('get')->with("ledgers/".$exampleCurrency, $params)->willReturn(self::CORRECT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
        $this->assertIsArray($result);
        $this->assertInstanceOf(LedgerEntry::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetLedgerShouldCatchRestCliException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willThrowException(new \Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(LedgerQueryException::class);
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetLedgerShouldCatchRestCliBitPayException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(LedgerQueryException::class);
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetLedgerShouldCatchJsonMapperException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willReturn(self::CORRUPT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(LedgerQueryException::class);
        $exampleCurrency = Currency::BTC;
        $exampleStartDate = '2021-5-10';
        $exampleEndDate = '2021-5-31';
        $testedObject->getLedger($exampleCurrency, $exampleStartDate, $exampleEndDate);
    }

    /**
     * @depends testWithFileJsonConfig
     **/
    public function testGetLedgers($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();

        $restCliMock->expects($this->once())->method('get')->with("ledgers", $params)->willReturn(self::CORRECT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getLedgers();
        $this->assertIsArray($result);
        $this->assertInstanceOf(Ledger::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     **/
    public function testGetLedgersShouldCatchBitPayException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(LedgerQueryException::class);
        $testedObject->getLedgers();
    }

    /**
     * @depends testWithFileJsonConfig
     **/
    public function testGetLedgersShouldCatchRestCliException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willThrowException(new Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(LedgerQueryException::class);
        $testedObject->getLedgers();
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetLedgersShouldCatchJsonMapperException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->willReturn(self::CORRUPT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(LedgerQueryException::class);
        $testedObject->getLedgers();
    }

    private function getRestCliMock()
    {
        return $this->getMockBuilder(RESTcli::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get', 'update', 'post', 'delete'])
            ->getMock();
    }

    /**
     * @throws BitPayException
     */
    public function testGetRates()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with('rates', null, false)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getRates();
        $this->assertInstanceOf(Rates::class, $result);
    }

    /**
     * @throws BitPayException
     */
    public function testGetRatesShouldHandleRestCliBitPayException()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with('rates', null, false)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getRates();
    }

    public function testGetRatesShouldHandleRestCliException()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with('rates', null, false)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getRates();
    }

    /**
     * @throws BitPayException
     */
    public function testGetRatesShouldHandleCorruptJson()
    {
        $testedObject = $this->getTestedClassInstance();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with('rates', null, false)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RateQueryException::class);
        $testedObject->getRates();
    }

    /**
    * @depends testWithFileJsonConfig
     */
    public function testGetPayout($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $exampleResponse = json_encode($this->getExamplePayoutData());
        $payoutId = '123';
        $restCliMock->expects($this->once())->method('get')->with("payouts/" . $payoutId, $params)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $result = $testedObject->getPayout($payoutId);
        $this->assertInstanceOf(Payout::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutShouldHandleRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $payoutId = '123';
        $restCliMock->expects($this->once())->method('get')->with("payouts/" . $payoutId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayout($payoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutShouldHandleRestCliException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $payoutId = '123';
        $restCliMock->expects($this->once())->method('get')->with("payouts/" . $payoutId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayout($payoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutShouldHandleJsonMapperException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $payoutId = '123';
        $restCliMock->expects($this->once())->method('get')->with("payouts/" . $payoutId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayout($payoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayouts($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $reference = 'reference';

        $params['status'] = $status;
        $params['startDate'] = $dateStart;
        $params['endDate'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['reference'] = $reference;

        $restCliMock = $this->getRestCliMock();
        $exampleResponse = json_encode($this->getExamplePayoutData());
        $restCliMock->expects($this->once())->method('get')->with("payouts", $params)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getPayouts($dateStart, $dateEnd, $status, $reference, $limit, $offset);
        $this->assertIsArray($result);
        $this->assertInstanceOf(Payout::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutsShouldHandleRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $reference = 'reference';

        $params['status'] = $status;
        $params['startDate'] = $dateStart;
        $params['endDate'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['reference'] = $reference;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payouts", $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayouts($dateStart, $dateEnd, $status, $reference, $limit, $offset);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutsShouldHandleRestCliException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $reference = 'reference';

        $params['status'] = $status;
        $params['startDate'] = $dateStart;
        $params['endDate'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['reference'] = $reference;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payouts", $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayouts($dateStart, $dateEnd, $status, $reference, $limit, $offset);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutsShouldHandleJsonMapperException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';
        $reference = 'reference';

        $params['status'] = $status;
        $params['startDate'] = $dateStart;
        $params['endDate'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        $params['reference'] = $reference;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payouts", $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayouts($dateStart, $dateEnd, $status, $reference, $limit, $offset);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayout($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payouts/" . $examplePayoutId, $params)->willReturn('{"status":"success"}');
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->cancelPayout($examplePayoutId);
        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayoutShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payouts/" . $examplePayoutId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutCancellationException::class);
        $testedObject->cancelPayout($examplePayoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayoutShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payouts/" . $examplePayoutId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutCancellationException::class);
        $testedObject->cancelPayout($examplePayoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayoutShouldCatchUnexistentPropertyError($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payouts/" . $examplePayoutId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutCancellationException::class);
        $testedObject->cancelPayout($examplePayoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayout($testedObject)
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts", $payoutMock->toArray())->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->submitPayout($payoutMock);
        $this->assertInstanceOf(Payout::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutShouldCatchRestCliBitPayException($testedObject)
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts", $payoutMock->toArray())->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutCreationException::class);
        $testedObject->submitPayout($payoutMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutShouldCatchRestCliException($testedObject)
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts", $payoutMock->toArray())->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutCreationException::class);
        $testedObject->submitPayout($payoutMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutShouldCatchJsonMapperException($testedObject)
    {
        $payoutMock = $this->createMock(Payout::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutMock->method('toArray')->willReturn($payoutBatchToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts", $payoutMock->toArray())->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutCreationException::class);
        $testedObject->submitPayout($payoutMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatch($testedObject)
    {
        $examplePayoutBatchId = 'test';
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches/" . $examplePayoutBatchId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getPayoutBatch($examplePayoutBatchId);
        $this->assertInstanceOf(PayoutBatch::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutRecipientNotification($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $exampleRecipientId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients/" . $exampleRecipientId . '/notifications', $content)->willReturn('{"status":"success"}');
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutRecipientNotificationShouldCatchRestCliBitPayException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $exampleRecipientId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients/" . $exampleRecipientId . '/notifications', $content)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientNotificationException::class);
        $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutRecipientNotificationShouldCatchRestCliException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $exampleRecipientId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients/" . $exampleRecipientId . '/notifications', $content)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientNotificationException::class);
        $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutRecipientNotificationShouldCatchJsonDecodeException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $exampleRecipientId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients/" . $exampleRecipientId . '/notifications', $content)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientNotificationException::class);
        $testedObject->requestPayoutRecipientNotification($exampleRecipientId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testDeletePayoutRecipient($testedObject)
    {
        $exampleRecipientId = 'testId';
        $params['token'] = $this->getPayoutTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("recipients/" . $exampleRecipientId, $params)->willReturn('{"status":"success"}');
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->deletePayoutRecipient($exampleRecipientId);
        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testDeletePayoutRecipientShouldCatchRestCliBitPayException($testedObject)
    {
        $exampleRecipientId = 'testId';
        $params['token'] = $this->getPayoutTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("recipients/" . $exampleRecipientId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientCancellationException::class);
        $testedObject->deletePayoutRecipient($exampleRecipientId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testDeletePayoutRecipientShouldCatchRestCliException($testedObject)
    {
        $exampleRecipientId = 'testId';
        $params['token'] = $this->getPayoutTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("recipients/" . $exampleRecipientId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientCancellationException::class);
        $testedObject->deletePayoutRecipient($exampleRecipientId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testDeletePayoutRecipientShouldCatchJsonDecodeException($testedObject)
    {
        $exampleRecipientId = 'testId';
        $params['token'] = $this->getPayoutTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("recipients/" . $exampleRecipientId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientCancellationException::class);
        $testedObject->deletePayoutRecipient($exampleRecipientId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdatePayoutRecipient($testedObject)
    {
        $exampleRecipientId = 'testId';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
        $this->assertInstanceOf(PayoutRecipient::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdatePayoutRecipientShouldCatchRestCliBitPayException($testedObject)
    {
        $exampleRecipientId = 'testId';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientUpdateException::class);
        $result = $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdatePayoutRecipientShouldCatchRestCliException($testedObject)
    {
        $exampleRecipientId = 'testId';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientUpdateException::class);
        $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdatePayoutRecipientShouldCatchJsonMapperException($testedObject)
    {
        $exampleRecipientId = 'testId';
        $payoutRecipientMock = $this->createMock(PayoutRecipient::class);
        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("recipients/" . $exampleRecipientId, $payoutRecipientMock->toArray())->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientUpdateException::class);
        $testedObject->updatePayoutRecipient($exampleRecipientId, $payoutRecipientMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutRecipients($testedObject)
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'testId';

        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients", $payoutRecipientsMock->toArray())->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->submitPayoutRecipients($payoutRecipientsMock);
        $this->assertIsArray($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutRecipientsShouldCatchRestCliBitPayException($testedObject)
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'testId';
        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients", $payoutRecipientsMock->toArray())->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientCreationException::class);
        $testedObject->submitPayoutRecipients($payoutRecipientsMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutRecipientsShouldCatchRestCliException($testedObject)
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'testId';
        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients", $payoutRecipientsMock->toArray())->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientCreationException::class);
        $testedObject->submitPayoutRecipients($payoutRecipientsMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutRecipientsShouldCatchJsonMapperException($testedObject)
    {
        $payoutRecipientsMock = $this->createMock(PayoutRecipients::class);
        $exampleRecipientId = 'testId';
        $payoutRecipientToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'id' => $exampleRecipientId
        ];
        $payoutRecipientsMock->method('toArray')->willReturn($payoutRecipientToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("recipients", $payoutRecipientsMock->toArray())->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientCreationException::class);
        $testedObject->submitPayoutRecipients($payoutRecipientsMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatchShouldCatchRestCliBitPayException($testedObject)
    {
        $examplePayoutBatchId = 'test';
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches/" . $examplePayoutBatchId, $params)
            ->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchQueryException::class);
        $testedObject->getPayoutBatch($examplePayoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatchShouldCatchRestCliException($testedObject)
    {
        $examplePayoutBatchId = 'test';
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches/" . $examplePayoutBatchId, $params)
            ->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchQueryException::class);
        $testedObject->getPayoutBatch($examplePayoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatchShouldCatchJsonMapperException($testedObject)
    {
        $examplePayoutBatchId = 'test';
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches/" . $examplePayoutBatchId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchQueryException::class);
        $testedObject->getPayoutBatch($examplePayoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatches($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';

        $params['status'] = $status;
        $params['startDate'] = $dateStart;
        $params['endDate'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches", $params)
            ->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getPayoutBatches($dateStart, $dateEnd, $status, $limit, $offset);
        $this->assertIsArray($result);
        $this->assertInstanceOf(PayoutBatch::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatchesShouldCatchBitPayException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $limit = 1;
        $offset = 1;
        $status = 'status';

        $params['status'] = $status;
        $params['startDate'] = $dateStart;
        $params['endDate'] = $dateEnd;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches", $params)
            ->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchQueryException::class);
        $testedObject->getPayoutBatches($dateStart, $dateEnd, $status, $limit, $offset);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatchesShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches", $params)
            ->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchQueryException::class);
        $testedObject->getPayoutBatches();
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutBatchesShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("payoutBatches", $params)
            ->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchQueryException::class);
        $testedObject->getPayoutBatches();
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayoutBatch($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';
        $exampleResponse = json_encode(['status' => 'success']);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payoutBatches/" . $payoutBatchId, $params)
            ->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->cancelPayoutBatch($payoutBatchId);
        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayoutBatchShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payoutBatches/" . $payoutBatchId, $params)
            ->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchCancellationException::class);
        $testedObject->cancelPayoutBatch($payoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayoutBatchShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payoutBatches/" . $payoutBatchId, $params)
            ->willThrowException(new Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchCancellationException::class);
        $testedObject->cancelPayoutBatch($payoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelPayoutBatchShouldCatchJsonDecodeException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("payoutBatches/" . $payoutBatchId, $params)
            ->willReturn(self::CORRUPT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchCancellationException::class);
        $testedObject->cancelPayoutBatch($payoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutBatchNotification($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';
        $exampleResponse = json_encode(['status' => 'success']);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches/" . $payoutBatchId . "/notifications", $content)
            ->willReturn($exampleResponse);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();
        $result = $testedObject->requestPayoutBatchNotification($payoutBatchId);
        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutBatchNotificationShouldCatchRestCliBitPayException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches/" . $payoutBatchId . "/notifications", $content)
            ->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchNotificationException::class);
        $testedObject->requestPayoutBatchNotification($payoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutBatchNotificationShouldCatchRestCliException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches/" . $payoutBatchId . "/notifications", $content)
            ->willThrowException(new Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchNotificationException::class);
        $testedObject->requestPayoutBatchNotification($payoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutBatchNotificationShouldCatchJsonEncodeException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $payoutBatchId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches/" . $payoutBatchId . "/notifications", $content)
            ->willReturn(self::CORRUPT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchNotificationException::class);
        $testedObject->requestPayoutBatchNotification($payoutBatchId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutBatch($testedObject)
    {
        $payoutBatchMock = $this->createMock(PayoutBatch::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutBatchMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutBatchMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches", $payoutBatchMock->toArray() )
            ->willReturn(json_encode($payoutBatchMock->toArray()));

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->submitPayoutBatch($payoutBatchMock);
        $this->assertInstanceOf(PayoutBatch::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutBatchShouldCatchRestCliBitPayException($testedObject)
    {
        $payoutBatchMock = $this->createMock(PayoutBatch::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutBatchMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutBatchMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches", $payoutBatchMock->toArray() )
            ->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchCreationException::class);
        $testedObject->submitPayoutBatch($payoutBatchMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutBatchShouldCatchRestCliException($testedObject)
    {
        $payoutBatchMock = $this->createMock(PayoutBatch::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutBatchMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutBatchMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches", $payoutBatchMock->toArray() )
            ->willThrowException(new Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchCreationException::class);
        $testedObject->submitPayoutBatch($payoutBatchMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSubmitPayoutBatchShouldCatchJsonMapperException($testedObject)
    {
        $payoutBatchMock = $this->createMock(PayoutBatch::class);
        $exampleCurrency = Currency::USD;
        $payoutBatchToArray = [
            'token' => $this->getPayoutTokenFromFile(),
            'currency' => $exampleCurrency
        ];

        $payoutBatchMock->method('getCurrency')->willReturn(Currency::USD);
        $payoutBatchMock->method('toArray')->willReturn($payoutBatchToArray);
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payoutBatches", $payoutBatchMock->toArray() )
            ->willReturn(self::CORRUPT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutBatchCreationException::class);
        $testedObject->submitPayoutBatch($payoutBatchMock);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutNotification($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts/" . $examplePayoutId . '/notifications', $content )
            ->willReturn('{"status":"success"}');

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->requestPayoutNotification($examplePayoutId);
        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutNotificationShouldCatchRestCliBitPayException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts/" . $examplePayoutId . '/notifications', $content )
            ->willThrowException(new BitPayException());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutNotificationException::class);
        $testedObject->requestPayoutNotification($examplePayoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutNotificationShouldCatchRestCliException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts/" . $examplePayoutId . '/notifications', $content )
            ->willThrowException(new Exception());

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutNotificationException::class);
        $testedObject->requestPayoutNotification($examplePayoutId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testRequestPayoutNotificationShouldCatchJsonEncodeException($testedObject)
    {
        $content['token'] = $this->getPayoutTokenFromFile();
        $examplePayoutId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("payouts/" . $examplePayoutId . '/notifications', $content )
            ->willReturn(self::CORRECT_JSON_STRING);

        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutNotificationException::class);
        $testedObject->requestPayoutNotification($examplePayoutId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBill($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleBillId = '123';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills/" . $exampleBillId, $params, true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getBill($exampleBillId);
        $this->assertInstanceOf(Bill::class, $result);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleBillId = '123';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills/" . $exampleBillId, $params, true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BitPayException::class);
        $testedObject->getBill($exampleBillId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleBillId = '123';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills/" . $exampleBillId, $params, true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(Exception::class);
        $testedObject->getBill($exampleBillId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleBillId = '123';
        $exampleResponse = trim('[ { "currency": "EUR""balance": 0 }, { "currency": "USD", "balance": 2389.82 }, { "currency": "BTC", "balance": 0.000287 } ]');
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills/" . $exampleBillId, $params, true)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillQueryException::class);
        $testedObject->getBill($exampleBillId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBills($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleResponse = trim('[ { "currency": "EUR", "balance": 0 }, { "currency": "USD", "balance": 2389.82 }, { "currency": "BTC", "balance": 0.000287 } ]');
        $status = 'test';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills", $params)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getBills($status);
        $this->assertIsArray($result);
        $this->assertInstanceOf(Bill::class, $result[0]);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillsShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleResponse = trim('[ { "currency": "EUR", "balance": 0 }{ "currency": "USD", "balance": 2389.82 }, { "currency": "BTC", "balance": 0.000287 } ]');
        $status = 'test';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills", $params)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillQueryException::class);
        $testedObject->getBills($status);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillsShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $status = 'test';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills", $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillQueryException::class);
        $testedObject->getBills($status);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetBillsShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $status = 'test';
        $params['status'] = $status;
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("bills", $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillQueryException::class);
        $testedObject->getBills($status);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testDeliverBill($testedObject)
    {
        $exampleBillId = 'testId';
        $exampleBillToken = 'testToken';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("bills/". $exampleBillId . '/deliveries', [ 'token' => $exampleBillToken ])->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->deliverBill($exampleBillId, $exampleBillToken);
        $this->assertIsString($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testDeliverBillShouldCatchRestCliBitPayException($testedObject)
    {
        $exampleBillId = 'testId';
        $exampleBillToken = 'testToken';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("bills/". $exampleBillId . '/deliveries', [ 'token' => $exampleBillToken ])->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillDeliveryException::class);
        $testedObject->deliverBill($exampleBillId, $exampleBillToken);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testDeliverBillShouldCatchRestCliException($testedObject)
    {
        $exampleBillId = 'testId';
        $exampleBillToken = 'testToken';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("bills/". $exampleBillId . '/deliveries', [ 'token' => $exampleBillToken ])->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillDeliveryException::class);
        $testedObject->deliverBill($exampleBillId, $exampleBillToken);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateBill($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillData = $this->getExampleBillData();
        $params['token'] = $this->getMerchantTokenFromFile();

        $exampleBillId = $exampleBillData->data->id;
        $exampleResponse = json_encode($exampleBillData->data);
        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("bills/". $exampleBillId, $billMock->toArray())->willReturn($exampleResponse);
        $restCliMock->expects($this->once())->method('get')->with("bills/". $exampleBillId, $params, true)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->updateBill($billMock, $exampleBillId);
        $this->assertInstanceOf(Bill::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateBillShouldCatchRestCliBitPayException($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillData = $this->getExampleBillData();
        $params['token'] = $this->getMerchantTokenFromFile();

        $exampleBillId = $exampleBillData->data->id;
        $exampleResponse = json_encode($exampleBillData->data);
        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("bills/". $exampleBillId, $billMock->toArray())->willThrowException(new BitPayException());
        $restCliMock->expects($this->once())->method('get')->with("bills/". $exampleBillId, $params, true)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillUpdateException::class);
        $testedObject->updateBill($billMock, $exampleBillId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateBillShouldCatchRestCliException($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillData = $this->getExampleBillData();
        $params['token'] = $this->getMerchantTokenFromFile();

        $exampleBillId = $exampleBillData->data->id;
        $exampleResponse = json_encode($exampleBillData->data);
        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("bills/". $exampleBillId, $billMock->toArray())->willThrowException(new Exception());
        $restCliMock->expects($this->once())->method('get')->with("bills/". $exampleBillId, $params, true)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillUpdateException::class);
        $testedObject->updateBill($billMock, $exampleBillId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateBillShouldCatchJsonMapperException($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillData = $this->getExampleBillData();
        $params['token'] = $this->getMerchantTokenFromFile();

        $exampleBillId = $exampleBillData->data->id;
        $exampleResponse = json_encode($exampleBillData->data);
        $billMock->method('getId')->willReturn($exampleBillId);
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("bills/". $exampleBillId, $billMock->toArray())->willReturn(self::CORRUPT_JSON_STRING);
        $restCliMock->expects($this->once())->method('get')->with("bills/". $exampleBillId, $params, true)->willReturn($exampleResponse);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillUpdateException::class);
        $testedObject->updateBill($billMock, $exampleBillId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateBill($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillId = 'testId';
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("bills", $billMock->toArray(), true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->createBill($billMock, Facade::Merchant, true);
        $this->assertInstanceOf(Bill::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateBillShouldCatchRestCliBitPayException($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillId = 'testId';
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("bills", $billMock->toArray(), true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillCreationException::class);
        $testedObject->createBill($billMock, Facade::Merchant, true);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateBillShouldCatchRestCliException($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillId = 'testId';
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("bills", $billMock->toArray(), true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillCreationException::class);
        $testedObject->createBill($billMock, Facade::Merchant, true);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateBillShouldCatchJsonMapperException($testedObject)
    {
        $billMock = $this->createMock(Bill::class);
        $exampleBillId = 'testId';
        $billToArray = [
            'id'           => $exampleBillId,
            'status'       => 'status',
            'token'        => 'token',
        ];
        $billMock->method('toArray')->willReturn($billToArray);

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("bills", $billMock->toArray(), true)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(BillCreationException::class);
        $testedObject->createBill($billMock, Facade::Merchant, true);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSupportedWallets($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("supportedWallets/", null, false)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getSupportedWallets();
        $this->assertIsArray($result);
        $this->assertInstanceOf(Wallet::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSupportedWalletsShouldCatchRestCliBitPayException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("supportedWallets/", null, false)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(WalletQueryException::class);
        $testedObject->getSupportedWallets();
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSupportedWalletsShouldCatchRestCliException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("supportedWallets/", null, false)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(WalletQueryException::class);
        $testedObject->getSupportedWallets();
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetSupportedWalletsShouldCatchJsonMapperException($testedObject)
    {
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("supportedWallets/", null, false)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(WalletQueryException::class);
        $testedObject->getSupportedWallets();
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipient($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $recipientId = 'test';
        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("recipients/" .$recipientId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getPayoutRecipient($recipientId);
        $this->assertInstanceOf(PayoutRecipient::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelRefund($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("refunds/" . $exampleRefundId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->cancelRefund($exampleRefundId);
        $this->assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelRefundShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("refunds/" . $exampleRefundId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundCancellationException::class);
        $testedObject->cancelRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotification($testedObject)
    {
        $exampleRefundId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/" . $exampleRefundId . "/notifications", $params, true)->willReturn('{"status":"success"}');
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->sendRefundNotification($exampleRefundId);
        $this->assertIsBool($result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchRestCliBitPayException($testedObject)
    {
        $exampleRefundId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/" . $exampleRefundId . "/notifications", $params, true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundNotificationException::class);
        $testedObject->sendRefundNotification($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchRestCliException($testedObject)
    {
        $exampleRefundId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/" . $exampleRefundId . "/notifications", $params, true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundNotificationException::class);
        $testedObject->sendRefundNotification($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testSendRefundNotificationShouldCatchJsonMapperException($testedObject)
    {
        $exampleRefundId = 'testId';
        $params['token'] = $this->getMerchantTokenFromFile();

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/" . $exampleRefundId . "/notifications", $params, true)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundNotificationException::class);
        $testedObject->sendRefundNotification($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefund($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/" . $exampleRefundId, $params, true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getRefund($exampleRefundId);
        $this->assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/" . $exampleRefundId, $params, true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundQueryException::class);
        $testedObject->getRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/" . $exampleRefundId, $params, true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundQueryException::class);
        $testedObject->getRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundShouldCatchRestCliJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/" . $exampleRefundId, $params, true)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundQueryException::class);
        $testedObject->getRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefunds($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/", $params, true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getRefunds($exampleInvoiceId);
        $this->assertIsArray($result);
        $this->assertInstanceOf(Refund::class, $result[0]);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/", $params, true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundQueryException::class);
        $testedObject->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/", $params, true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundQueryException::class);
        $testedObject->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testGetRefundsShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleInvoiceId = 'testId';
        $params['invoiceId'] = $exampleInvoiceId;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("refunds/", $params, true)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundQueryException::class);
        $testedObject->getRefunds($exampleInvoiceId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateRefund($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("refunds/" . $refundId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->updateRefund($refundId, $params['status']);
        $this->assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateRefundShouldCatchRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("refunds/" . $refundId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundUpdateException::class);
        $result = $testedObject->updateRefund($refundId, $params['status']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateRefundShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("refunds/" . $refundId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundUpdateException::class);
        $result = $testedObject->updateRefund($refundId, $params['status']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testUpdateRefundShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['status'] = 'status';
        $refundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('update')->with("refunds/" . $refundId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundUpdateException::class);
        $result = $testedObject->updateRefund($refundId, $params['status']);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateRefund($testedObject)
    {
        $invoiceId = 'exampleId';
        $amount = 10.11;
        $currency = Currency::BTC;
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['invoiceId'] = $invoiceId;
        $params['amount'] = $amount;
        $params['currency'] = $currency;
        $params['preview'] = false;
        $params['immediate'] = false;
        $params['buyerPaysRefundFee'] = false;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/", $params, true)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->createRefund($invoiceId, $amount, $currency);
        $this->assertInstanceOf(Refund::class, $result);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateRefundShouldCatchRestCliBitPayException($testedObject)
    {
        $invoiceId = 'exampleId';
        $amount = 10.11;
        $currency = Currency::BTC;
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['invoiceId'] = $invoiceId;
        $params['amount'] = $amount;
        $params['currency'] = $currency;
        $params['preview'] = false;
        $params['immediate'] = false;
        $params['buyerPaysRefundFee'] = false;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/", $params, true)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundCreationException::class);
        $testedObject->createRefund($invoiceId, $amount, $currency);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateRefundShouldCatchRestCliException($testedObject)
    {
        $invoiceId = 'exampleId';
        $amount = 10.11;
        $currency = Currency::BTC;
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['invoiceId'] = $invoiceId;
        $params['amount'] = $amount;
        $params['currency'] = $currency;
        $params['preview'] = false;
        $params['immediate'] = false;
        $params['buyerPaysRefundFee'] = false;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/", $params, true)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundCreationException::class);
        $testedObject->createRefund($invoiceId, $amount, $currency);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCreateRefundShouldCatchJsonMapperException($testedObject)
    {
        $invoiceId = 'exampleId';
        $amount = 10.11;
        $currency = Currency::BTC;
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['invoiceId'] = $invoiceId;
        $params['amount'] = $amount;
        $params['currency'] = $currency;
        $params['preview'] = false;
        $params['immediate'] = false;
        $params['buyerPaysRefundFee'] = false;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('post')->with("refunds/", $params, true)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundCreationException::class);
        $testedObject->createRefund($invoiceId, $amount, $currency);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelRefundShouldCatchRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("refunds/" . $exampleRefundId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundCancellationException::class);
        $testedObject->cancelRefund($exampleRefundId);
    }

    /**
     * @depends testWithFileJsonConfig
     */
    public function testCancelRefundShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $exampleRefundId = 'testId';

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('delete')->with("refunds/" . $exampleRefundId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(RefundCancellationException::class);
        $testedObject->cancelRefund($exampleRefundId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipientShouldHandleRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $recipientId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("recipients/" .$recipientId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipient($recipientId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipientShouldHandleRestCliException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $recipientId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("recipients/" .$recipientId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipient($recipientId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipientShouldHandleJsonMapperException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $recipientId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("recipients/" .$recipientId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutQueryException::class);
        $testedObject->getPayoutRecipient($recipientId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipients($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("recipients", $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getPayoutRecipients($status, $limit, $offset);
        $this->assertIsArray($result);
        $this->assertInstanceOf(PayoutRecipient::class, $result[0]);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipientsShouldHandleRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("recipients", $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipients($status, $limit, $offset);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipientsShouldHandleRestCliException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("recipients", $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipients($status, $limit, $offset);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetPayoutRecipientsShouldHandleJsonMapperException($testedObject)
    {
        $params['token'] = $this->getPayoutTokenFromFile();
        $restCliMock = $this->getRestCliMock();

        $status = 'status';
        $limit = 1;
        $offset = 1;

        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("recipients", $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(PayoutRecipientQueryException::class);
        $testedObject->getPayoutRecipients($status, $limit, $offset);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlement($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $settlementId, $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getSettlement($settlementId);
        $this->assertInstanceOf(Settlement::class, $result);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementShouldCatchJsonMapperException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $settlementId, $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlement($settlementId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementShouldHandleRestCliBitPayException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $settlementId, $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlement($settlementId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementShouldHandleRestCliException($testedObject)
    {
        $params['token'] = $this->getMerchantTokenFromFile();
        $restCliMock = $this->getRestCliMock();
        $settlementId = 'test';
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $settlementId, $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlement($settlementId);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlements($testedObject)
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("settlements", $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
        $this->assertIsArray($result);
        $this->assertInstanceOf(Settlement::class, $result[0]);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementsShouldCatchRestCliBitPayException($testedObject)
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("settlements", $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementsShouldCatchRestCliException($testedObject)
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("settlements", $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementsShouldCatchJsonMapperException($testedObject)
    {
        $currency = Currency::USD;
        $dateStart = 'dateStart';
        $dateEnd = 'dateEnd';
        $status = 'status';
        $limit = 1;
        $offset = 1;
        $restCliMock = $this->getRestCliMock();
        $params['token'] = $this->getMerchantTokenFromFile();
        $params['dateStart'] = $dateStart;
        $params['dateEnd'] = $dateEnd;
        $params['currency'] = $currency;
        $params['status'] = $status;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $restCliMock->expects($this->once())->method('get')->with("settlements", $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlements($currency, $dateStart, $dateEnd, $status, $limit, $offset);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementReconciliationReport($testedObject)
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'testToken';
        $exampleId = 'testId';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $exampleId . '/reconciliationReport',
            $params)->willReturn(self::CORRECT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $result = $testedObject->getSettlementReconciliationReport($settlement);
        $this->assertInstanceOf(Settlement::class, $result);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementReconciliationReportShouldCatchRestCliBitPayException($testedObject)
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'testToken';
        $exampleId = 'testId';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $exampleId . '/reconciliationReport',
            $params)->willThrowException(new BitPayException());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlementReconciliationReport($settlement);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementReconciliationReportShouldCatchRestCliException($testedObject)
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'testToken';
        $exampleId = 'testId';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $exampleId . '/reconciliationReport',
            $params)->willThrowException(new Exception());
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlementReconciliationReport($settlement);
    }

    /**
     * @throws BitPayException
     * @depends testWithFileJsonConfig
     */
    public function testGetSettlementReconciliationReportShouldCatchJsonMapperException($testedObject)
    {
        $settlement = $this->createMock(Settlement::class);
        $exampleToken = 'testToken';
        $exampleId = 'testId';
        $settlement->method('getToken')->willReturn($exampleToken);
        $settlement->method('getId')->willReturn($exampleId);
        $params['token'] = $exampleToken;

        $restCliMock = $this->getRestCliMock();
        $restCliMock->expects($this->once())->method('get')->with("settlements/" . $exampleId . '/reconciliationReport',
            $params)->willReturn(self::CORRUPT_JSON_STRING);
        $setRestCli = function () use ($restCliMock) {
            $this->_RESTcli = $restCliMock;
        };
        $doSetRestCli = $setRestCli->bindTo($testedObject, get_class($testedObject));
        $doSetRestCli();

        $this->expectException(SettlementQueryException::class);
        $testedObject->getSettlementReconciliationReport($settlement);
    }
}
