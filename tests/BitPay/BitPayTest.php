<?php

namespace BitPay\Test;


use Bitpay;
use Bitpay\Model\Invoice\Invoice;
use PHPUnit\Framework\TestCase;

class BitPayTest extends TestCase
{
    protected $client;
    protected $clientMock;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(Bitpay\Client::class);
        $this->clientMock->withData(
            Bitpay\Env::Test,
            __DIR__."/../../bitpay_private_test.key",
            new Bitpay\Tokens("7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ"),
            "YourMasterPassword"
        );

        $this->client = Bitpay\Client::create()->withData(
            Bitpay\Env::Test,
            __DIR__."/../../bitpay_private_test.key",
            new Bitpay\Tokens("7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ"),
            "YourMasterPassword");
        $this->assertNotNull($this->client);
    }

    public function testShouldGetInvoiceId()
    {
        $invoice = new Invoice("37.16", "eur");
        try {
            $basicInvoice = $this->client->createInvoice($invoice);
        } catch (BitPayException $e) {
            $e->getTraceAsString();
            self::fail($e.getMessage());
        }
        $this->assertNotNull($basicInvoice->getId());
    }
}
