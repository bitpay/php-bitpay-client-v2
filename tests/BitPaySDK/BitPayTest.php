<?php

namespace BitPaySDK\Test;


use BitPaySDK;
use BitPaySDK\Model\Bill\BillStatus;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Invoice\Invoice as Invoice;
use BitPaySDK\Model\Payout\PayoutStatus;
use BitPaySDK\Model\Payout\RecipientStatus;
use BitPaySDK\Model\Payout\RecipientReferenceMethod;
use PHPUnit\Framework\TestCase;

class BitPayTest extends TestCase
{
    /**
     * @var BitPaySDK\Client
     */
    protected $client;
    protected $client1;
    protected $client2;
    protected $clientMock;

    protected function setUp(): void
    {
        /**
         * You need to generate new tokens first
         * */
        $this->clientMock = $this->createMock(BitPaySDK\Client::class);
        $this->clientMock->withData(
            BitPaySDK\Env::Test,
            __DIR__."/../../examples/bitpay_private_test.key",
            new BitPaySDK\Tokens(
                "7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ",
                "5j48K7pUrX5k59DLhRVYkCupgw2CtoEt8DBFrHo2vW47"
            ),
            "YourMasterPassword"
        );

        // $this->client = BitPaySDK\Client::create()->withData(
        //     BitPaySDK\Env::Test,
        //     __DIR__."/../../examples/bitpay_private_test.key",
        //     new BitPaySDK\Tokens(
        //         "7UeQtMcsHamehE4gDZojUQbNRbSuSdggbH17sawtobGJ",
        //         "5j48K7pUrX5k59DLhRVYkCupgw2CtoEt8DBFrHo2vW47"
        //     ),
        //     "YourMasterPassword");

        /**
         * Uncomment only if you wish to test the client with config files
         * */
        $this->client = BitPaySDK\Client::create()->withFile(__DIR__."/../../examples/BitPay.config.json");
//        $this->client2 = BitPaySDK\Client::create()->withFile(__DIR__."/../../examples/BitPay.config.yml");


        $this->assertNotNull($this->client);
        /**
         * Uncomment only if you wish to test the client with config files
         * */
//        $this->assertNotNull($this->client1);
//        $this->assertNotNull($this->client2);
    }

    public function testShouldGetInvoiceId()
    {
        $invoice = new Invoice(2.16, "eur");
        $invoice->setOrderId("98e572ea-910e-415d-b6de-65f5090680f6");
        $invoice->setFullNotifications(true);
        $invoice->setExtendedNotifications(true);
        $invoice->setTransactionSpeed("medium");
        $invoice->setNotificationURL("https://hookbin.com/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setRedirectURL("https://hookbin.com/lJnJg9WW7MtG9GZlPVdj");
        $invoice->setPosData("98e572ea35hj356xft8y8cgh56h5090680f6");
        $invoice->setItemDesc("Ab tempora sed ut.");

        $buyer = new BitPaySDK\Model\Invoice\Buyer();
        $buyer->setName("Bily Matthews");
        $buyer->setEmail("sandbox@bitpay.com");
        $buyer->setAddress1("168 General Grove");
        $buyer->setAddress2("sandbox@bitpay.com");
        $buyer->setCountry("AD");
        $buyer->setLocality("Port Horizon");
        $buyer->setNotify(true);
        $buyer->setPhone("+99477512690");
        $buyer->setPostalCode("KY7 1TH");
        $buyer->setRegion("New Port");

        $invoice->setBuyer($buyer);

        try {
            $basicInvoice = $this->client->createInvoice($invoice);
            $retrievedInvoice = $this->client->getInvoice($basicInvoice->getId());//JHJsfknvgUpZjL9ksSKFZu
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicInvoice->getId());
        $this->assertNotNull($retrievedInvoice->getId());
        $this->assertEquals($basicInvoice->getId(), $retrievedInvoice->getId());
    }

    public function testShouldCreateInvoiceBtc()
    {
        try {
            $basicInvoice = $this->client->createInvoice(new Invoice(0.1, Currency::BTC));
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicInvoice->getId());

    }

    public function testShouldCreateInvoiceBch()
    {
        try {
            $basicInvoice = $this->client->createInvoice(new Invoice(0.1, Currency::BCH));
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicInvoice->getId());

    }

    public function testShouldCreateInvoiceEth()
    {
        try {
            $basicInvoice = $this->client->createInvoice(new Invoice(0.1, Currency::ETH));
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicInvoice->getId());

    }

    public function testShouldGetInvoices()
    {
        $invoices = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-30 day');
            $sevenDaysAgo = $dateBefore->format("Y-m-d");
            $invoices = $this->client->getInvoices($sevenDaysAgo, $today, null, null, 46);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($invoices);
        $this->assertGreaterThan(0, count($invoices));
    }

    public function testShouldCreateGetCancelRefundRequest()
    {
        $invoices = null;
        $firstInvoice = null;
        $firstRefund = null;
        $retrievedRefund = null;
        $retrievedRefunds = null;
        $cancelRefund = null;
        try {
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-30 day');
            $sevenDaysAgo = $dateBefore->format("Y-m-d");
            $invoices = $this->client->getInvoices(
                $sevenDaysAgo, $today, BitPaySDK\Model\Invoice\InvoiceStatus::Complete);
            /**
             * var Invoice
             */
//            $firstInvoice = $invoices[0];
            $firstInvoice = $this->client->getInvoice("CaZmogErHPfAYiko5cmGQC");
            $refunded = $this->client->createRefund(
                $firstInvoice,
                "sandbox@bitpay.com",
                $firstInvoice->getPrice(),
                $firstInvoice->getCurrency()
            );
            $retrievedRefunds = $this->client->getRefunds($firstInvoice);
            $firstRefund = $retrievedRefunds[0];
            $retrievedRefund = $this->client->getRefund($firstInvoice, $firstRefund->getId());
            $cancelRefund = $this->client->cancelRefund($firstInvoice->getId(), $firstRefund);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($invoices);
        $this->assertNotNull($retrievedRefunds);
        $this->assertEquals($firstRefund->getId(), $retrievedRefund->getId());
        $this->assertTrue($cancelRefund);
    }

    public function testShouldCreateBillUSD()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1001", Currency::USD, "sandbox@bitpay.com", $items);
        $basicBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicBill->getId());
        $this->assertNotNull($basicBill->getItems()[0]->getId());
    }

    public function testShouldCreateBillEUR()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1002", Currency::EUR, "sandbox@bitpay.com", $items);
        $basicBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicBill->getId());
        $this->assertNotNull($basicBill->getUrl());
        $this->assertEquals(BillStatus::Draft, $basicBill->getStatus());
        $this->assertNotNull($basicBill->getItems()[0]->getId());
    }

    public function testShouldGetBill()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1003", Currency::EUR, "sandbox@bitpay.com", $items);
        $basicBill = null;
        $retrievedBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
            $retrievedBill = $this->client->getBill($basicBill->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertEquals($basicBill->getId(), $retrievedBill->getId());
        $this->assertEquals($basicBill->getItems(), $retrievedBill->getItems());
    }

    public function testShouldUpdateBill()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1004", Currency::EUR, "sandbox@bitpay.com", $items);
        $basicBill = null;
        $retrievedBill = null;
        $updatedBill = null;
        try {
            $basicBill = $this->client->createBill($bill);
            $retrievedBill = $this->client->getBill($basicBill->getId());

            $this->assertEquals($basicBill->getId(), $retrievedBill->getId());
            $this->assertEquals($basicBill->getItems(), $retrievedBill->getItems());
            $this->assertCount(4, $retrievedBill->getItems());

            $items = $retrievedBill->getItems();

            $item = new BitPaySDK\Model\Bill\Item();
            $item->setPrice(60);
            $item->setQuantity(7);
            $item->setDescription("product-added");
            array_push($items, $item);

            $retrievedBill->setItems($items);
            $updatedBill = $this->client->updateBill($retrievedBill, $retrievedBill->getId());
            $items = $updatedBill->getItems();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertCount(5, $updatedBill->getItems());
        $this->assertEquals(end($items)->getDescription(), "product-added");
    }

    public function testShouldGetBills()
    {
        $bills = null;
        try {
            $bills = $this->client->getBills();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($bills));
    }

    public function testShouldGetBillsByStatus()
    {
        $bills = null;
        try {
            $bills = $this->client->getBills(BillStatus::Draft);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($bills));
    }

    public function testShouldDeliverBill()
    {
        $items = [];

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Bill\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        $bill = new BitPaySDK\Model\Bill\Bill("1005", Currency::EUR, "sandbox@bitpay.com", $items);
        $basicBill = null;
        $retrievedBill = null;
        $result = null;
        try {
            $basicBill = $this->client->createBill($bill);
            $result = $this->client->deliverBill($basicBill->getId(), $basicBill->getToken());
            $retrievedBill = $this->client->getBill($basicBill->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertEquals($basicBill->getId(), $retrievedBill->getId());
        $this->assertEquals($basicBill->getItems(), $retrievedBill->getItems());
        $this->assertEquals("Success", $result);
        $this->assertNotEquals($basicBill->getStatus(), $retrievedBill->getStatus());
        $this->assertEquals($retrievedBill->getStatus(), BillStatus::Sent);
    }

    public function testShouldGetExchangeRates()
    {
        $ratesList = null;
        try {
            $rates = $this->client->getRates();
            $ratesList = $rates->getRates();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ratesList);
    }

    public function testShouldGetEURExchangeRate()
    {
        $rate = null;
        try {
            $rates = $this->client->getRates();
            $rate = $rates->getRate(Currency::EUR);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotEquals(0, $rate);
    }

    public function testShouldGetCNYExchangeRate()
    {
        $rate = null;
        try {
            $rates = $this->client->getRates();
            $rate = $rates->getRate(Currency::CNY);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotEquals(0, $rate);
    }

    public function testShouldUpdateExchangeRates()
    {
        $rates = null;
        $ratesList = null;
        try {
            $rates = $this->client->getRates();
            $rates->update();
            $ratesList = $rates->getRates();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ratesList);
    }

    public function testShouldGetLedgerBtc()
    {
        $ledger = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-30 day');
            $sevenDaysAgo = $dateBefore->format("Y-m-d");
            $ledger = $this->client->getLedger(Currency::BTC, $sevenDaysAgo, $today);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ledger);
        $this->assertGreaterThan(0, count($ledger));
    }

    public function testShouldGetLedgerUsd()
    {
        $ledger = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-30 day');
            $sevenDaysAgo = $dateBefore->format("Y-m-d");
            $ledger = $this->client->getLedger(Currency::USD, $sevenDaysAgo, $today);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ledger);
        $this->assertGreaterThan(0, count($ledger));
    }

    public function testShouldGetLedgers()
    {
        $ledgers = null;
        try {
            $ledgers = $this->client->getLedgers();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($ledgers);
        $this->assertGreaterThan(0, count($ledgers));
    }

    public function testShouldSubmitPayoutRecipients()
    {
        $recipientsList = [
            new BitPaySDK\Model\Payout\PayoutRecipient(
                "sandbox@bitpay.com",
                "recipient1",
                "https://hookb.in/QJOPBdMgRkukpp2WO60o"),
            new BitPaySDK\Model\Payout\PayoutRecipient(
                "sandbox@bitpay.com",
                "recipient2",
                "https://hookb.in/QJOPBdMgRkukpp2WO60o"),
            new BitPaySDK\Model\Payout\PayoutRecipient(
                "sandbox@bitpay.com",
                "recipient3",
                "https://hookb.in/QJOPBdMgRkukpp2WO60o"),
        ];

        $recipientsObj = new BitPaySDK\Model\Payout\PayoutRecipients($recipientsList);
        try {
            $recipients = $this->client->submitPayoutRecipients($recipientsObj);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($recipients);
        $this->assertCount(3, $recipients);
    }

    public function testShouldGetPayoutRecipientId()
    {
        $recipientsList = [
            new BitPaySDK\Model\Payout\PayoutRecipient(
                "nsoni_test@mailinator.com",
                "recipient",
                "https://hookb.in/QJOPBdMgRkukpp2WO60o"),
        ];

        $recipientsObj = new BitPaySDK\Model\Payout\PayoutRecipients($recipientsList);
        try {
            $basicRecipient = $this->client->submitPayoutRecipients($recipientsObj);
            $basicRecipient = reset($basicRecipient);
            $retrievedRecipient = $this->client->getPayoutRecipient($basicRecipient->getId());//9EsKtXQ1nj41EQ1Dk7VxhE
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicRecipient);
        $this->assertNotNull($retrievedRecipient->getId());
        $this->assertEquals($basicRecipient->getId(), $retrievedRecipient->getId());
    }

    public function testShouldGetPayoutRecipients()
    {
        $recipients = null;
        $status = 'active';
        try {
            $recipients = $this->client->getPayoutRecipients($status, 2);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($recipients);
        $this->assertCount(2, $recipients);
    }

    public function testShouldSubmitGetAndDeletePayoutRecipient()
    {
        $recipientsList = [
            new BitPaySDK\Model\Payout\PayoutRecipient(
                "sandbox@bitpay.com",
                "recipient1",
                "https://hookb.in/QJOPBdMgRkukpp2WO60o"),
        ];

        $recipientsObj = new BitPaySDK\Model\Payout\PayoutRecipients($recipientsList);
        try {
            $basicRecipient = $this->client->submitPayoutRecipients($recipientsObj);
            $basicRecipient = reset($basicRecipient);
            $retrievedRecipient = $this->client->getPayoutRecipient($basicRecipient->getId());//9EsKtXQ1nj41EQ1Dk7VxhE
            $retrievedRecipient->setLabel("updatedLabel");
            $updatedRecipient = $this->client->updatePayoutRecipient($retrievedRecipient->getId(), $retrievedRecipient);
            $deletedRecipient = $this->client->deletePayoutRecipient($retrievedRecipient->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicRecipient);
        $this->assertNotNull($retrievedRecipient->getId());
        $this->assertEquals($basicRecipient->getId(), $retrievedRecipient->getId());
        $this->assertEquals($retrievedRecipient->getStatus(), RecipientStatus::INVITED);
        $this->assertTrue($deletedRecipient);
        $this->assertEquals($updatedRecipient->getLabel(), "updatedLabel");
    }

    public function testShouldNotifyPayoutRecipientId()
    {
        $result = null;
        $recipientsList = [
            new BitPaySDK\Model\Payout\PayoutRecipient(
                "sandbox@bitpay.com",
                "recipient1",
                "https://hookb.in/QJOPBdMgRkukpp2WO60o"),
        ];

        $recipientsObj = new BitPaySDK\Model\Payout\PayoutRecipients($recipientsList);
        try {
            $basicRecipient = $this->client->submitPayoutRecipients($recipientsObj);
            $basicRecipient = reset($basicRecipient);
            $result = $this->client->notifyPayoutRecipient($basicRecipient->getId());//9EsKtXQ1nj41EQ1Dk7VxhE
            //$result = $this->client->notifyPayoutRecipient("9EsKtXQ1nj41EQ1Dk7VxhE");
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertTrue($result);
    }

    public function testShouldSubmitPayout()
    {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;

        $recipients = $this->client->getPayoutRecipients('active', 1);

        $instruction1 = new BitPaySDK\Model\Payout\PayoutInstruction(15.0, RecipientReferenceMethod::EMAIL, $recipients[0]->getEmail());
        $instruction1->setRecipientId($recipients[0]->getId());
        $instruction1->setShopperId($recipients[0]->getShopperId());

        $instructions = [
            $instruction1
        ];

        $ledgerCurrency = Currency::BTC;

        $payout = new BitPaySDK\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions, $ledgerCurrency);
        $cancelledPayout = null;
        $createPayout = null;

        try {
            $createPayout = $this->client->submitPayout($payout);
            $cancelledPayout = $this->client->cancelPayout($payout->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($createPayout->getId());
        $this->assertNotNull($cancelledPayout->getId());
        $this->assertCount(1, $createPayout->getInstructions());
    }

    public function testShouldGetPayouts()
    {
        try {
            $batches = $this->client->getPayouts();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($batches));
    }

    public function testShouldGetPayoutsByStatus()
    {
        try {
            $batches = $this->client->getPayouts(PayoutStatus::New);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($batches));
    }

    public function testShouldSubmitGetAndDeletePayout()
    {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;

        $recipients = $this->client->getPayoutRecipients('active', 1);

        $instructions = [
            new BitPaySDK\Model\Payout\PayoutInstruction(12.0, RecipientReferenceMethod::EMAIL, $recipients[0]->getEmail())
        ];

        $batch = new BitPaySDK\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions);
        $batchRetrieved = null;

        try {
            $batch = $this->client->submitPayout($batch);
            $batchRetrieved = $this->client->getPayout($batch->getId());
            $batchCancelled = $this->client->cancelPayout($batchRetrieved->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($batch->getId());
        $this->assertNotNull($batchRetrieved->getId());
        $this->assertNotNull($batchCancelled->getId());
        $this->assertCount(1, $batch->getInstructions());
        $this->assertEquals($batch->getId(), $batchRetrieved->getId());
        $this->assertEquals($batchRetrieved->getId(), $batchCancelled->getId());
        $this->assertEquals($batchRetrieved->getStatus(), PayoutStatus::New);
        $this->assertEquals($batchCancelled->getStatus(), PayoutStatus::Cancelled);
    }

    public function testShouldSubmitPayoutBatch()
    {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;

        $recipients = $this->client->getPayoutRecipients(null, 2);

        $instructions = [
            new BitPaySDK\Model\Payout\PayoutInstruction(15.0, RecipientReferenceMethod::EMAIL, $recipients[0]->getEmail()),
            new BitPaySDK\Model\Payout\PayoutInstruction(35.0, RecipientReferenceMethod::RECIPIENT_ID, $recipients[1]->getId()),
        ];

        $batch = new BitPaySDK\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions);
        try {
            $batch = $this->client->submitPayoutBatch($batch);
            $this->client->cancelPayoutBatch($batch->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($batch->getId());
        $this->assertCount(2, $batch->getInstructions());
    }

    public function testShouldGetPayoutBatches()
    {
        try {
            $batches = $this->client->getPayoutBatches();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($batches));
    }

    public function testShouldGetPayoutBatchesByStatus()
    {
        try {
            $batches = $this->client->getPayoutBatches(PayoutStatus::New);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($batches));
    }

    public function testShouldSubmitGetAndDeletePayoutBatch()
    {
        $date = new \DateTime();
        $threeDaysFromNow = $date->modify('+3 day');

        $effectiveDate = $threeDaysFromNow->format("Y-m-d");
        $currency = Currency::USD;

        $recipients = $this->client->getPayoutRecipients(null, 2);

        $instructions = [
            new BitPaySDK\Model\Payout\PayoutInstruction(15.0, RecipientReferenceMethod::EMAIL, $recipients[0]->getEmail()),
            new BitPaySDK\Model\Payout\PayoutInstruction(35.0, RecipientReferenceMethod::RECIPIENT_ID, $recipients[1]->getId()),
        ];

        $batch = new BitPaySDK\Model\Payout\PayoutBatch($currency, $effectiveDate, $instructions);
        $batchRetrieved = null;

        try {
            $batch = $this->client->submitPayoutBatch($batch);
            $batchRetrieved = $this->client->getPayoutBatch($batch->getId());
            $batchCancelled = $this->client->cancelPayoutBatch($batchRetrieved->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($batch->getId());
        $this->assertNotNull($batchRetrieved->getId());
        $this->assertNotNull($batchCancelled->getId());
        $this->assertCount(2, $batch->getInstructions());
        $this->assertEquals($batch->getId(), $batchRetrieved->getId());
        $this->assertEquals($batchRetrieved->getId(), $batchCancelled->getId());
        $this->assertEquals($batchRetrieved->getStatus(), PayoutStatus::New);
        $this->assertEquals($batchCancelled->getStatus(), PayoutStatus::Cancelled);
    }

    public function testGetSettlements()
    {
        $settlements = null;
        $firstSettlement = null;
        $settlement = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-365 day');
            $oneMonthAgo = $dateBefore->format("Y-m-d");

            $settlements = $this->client->getSettlements(Currency::USD, $oneMonthAgo, $today, null, null, null);
            $firstSettlement = $settlements[0];
            $settlement = $this->client->getSettlement($firstSettlement->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($settlements);
        $this->assertGreaterThan(0, count($settlements));
        $this->assertNotNull($settlement->getId());
        $this->assertEquals($firstSettlement->getId(), $settlement->getId());
    }

    public function testGetSettlementReconciliationReport()
    {
        $settlements = null;
        $firstSettlement = null;
        $settlement = null;
        try {
            //check within the last few days
            $date = new \DateTime();
            $today = $date->format("Y-m-d");
            $dateBefore = $date->modify('-365 day');
            $oneMonthAgo = $dateBefore->format("Y-m-d");

            $settlements = $this->client->getSettlements(Currency::USD, $oneMonthAgo, $today, null, null, null);
            $firstSettlement = $settlements[0];
            $settlement = $this->client->getSettlementReconciliationReport($firstSettlement);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($settlements);
        $this->assertGreaterThan(0, count($settlements));
        $this->assertNotNull($settlement->getId());
        $this->assertEquals($firstSettlement->getId(), $settlement->getId());
    }

    public function testShouldCreateSubscription()
    {
        $items = [];

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        //Stop subscription a few days later
        $date = new \DateTime();
        $date->modify('+1 month');
        $dueDate = $date->format("Y-m-d");

        $billData = new BitPaySDK\Model\Subscription\BillData(
            Currency::USD,
            "sandbox@bitpay.com",
            $dueDate,
            $items
        );

        $subscription = new BitPaySDK\Model\Subscription\Subscription();
        $subscription->setBillData($billData);
        $subscription->setSchedule("weekly");
        $basicSubscription = null;
        try {
            $basicSubscription = $this->client->createSubscription($subscription);
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($basicSubscription->getId());
        $this->assertNotNull($basicSubscription->getBillData()->getItems()[0]);
    }

    public function testShouldGetSubscription()
    {
        $items = [];

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        //Stop subscription a few days later
        $date = new \DateTime();
        $date->modify('+1 month');
        $dueDate = $date->format("Y-m-d");

        $billData = new BitPaySDK\Model\Subscription\BillData(
            Currency::USD,
            "sandbox@bitpay.com",
            $dueDate,
            $items
        );

        $subscription = new BitPaySDK\Model\Subscription\Subscription();
        $subscription->setBillData($billData);
        $subscription->setSchedule("weekly");
        $basicSubscription = null;
        $retrievedSubscription = null;
        try {
            $basicSubscription = $this->client->createSubscription($subscription);
            $retrievedSubscription = $this->client->getSubscription($basicSubscription->getId());
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertEquals($basicSubscription->getId(), $retrievedSubscription->getId());
        $this->assertEquals(
            $basicSubscription->getBillData()->getItems(), $retrievedSubscription->getBillData()->getItems());
    }

    public function testShouldUpdateSubscription()
    {
        $items = [];

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(30.0);
        $item->setQuantity(9);
        $item->setDescription("product-a");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(14.0);
        $item->setQuantity(16);
        $item->setDescription("product-b");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(3.90);
        $item->setQuantity(42);
        $item->setDescription("product-c");
        array_push($items, $item);

        $item = new BitPaySDK\Model\Subscription\Item();
        $item->setPrice(6.99);
        $item->setQuantity(12);
        $item->setDescription("product-d");
        array_push($items, $item);

        //Stop subscription a few days later
        $date = new \DateTime();
        $date->modify('+1 month');
        $dueDate = $date->format("Y-m-d");

        $billData = new BitPaySDK\Model\Subscription\BillData(
            Currency::USD,
            "sandbox@bitpay.com",
            $dueDate,
            $items
        );

        $subscription = new BitPaySDK\Model\Subscription\Subscription();
        $subscription->setBillData($billData);
        $subscription->setSchedule("weekly");
        $basicSubscription = null;
        $retrievedSubscription = null;
        $updatedSubscription = null;
        try {
            $basicSubscription = $this->client->createSubscription($subscription);
            $retrievedSubscription = $this->client->getSubscription($basicSubscription->getId());

            $this->assertEquals($basicSubscription->getId(), $retrievedSubscription->getId());
            $this->assertEquals(
                $basicSubscription->getBillData()->getItems(), $retrievedSubscription->getBillData()->getItems());
            $this->assertCount(4, $retrievedSubscription->getBillData()->getItems());

            $items = $retrievedSubscription->getBillData()->getItems();

            $item = new BitPaySDK\Model\Subscription\Item();
            $item->setPrice(60);
            $item->setQuantity(7);
            $item->setDescription("product-added");
            array_push($items, $item);

            $retrievedSubscription->getBillData()->setItems($items);
            $updatedSubscription = $this->client->updateSubscription(
                $retrievedSubscription, $retrievedSubscription->getId());
            $items = $updatedSubscription->getBillData()->getItems();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertCount(5, $updatedSubscription->getBillData()->getItems());
        $this->assertEquals(end($items)->getDescription(), "product-added");
    }

    public function testShouldGetSubscriptions()
    {
        $subscriptions = null;
        try {
            $subscriptions = $this->client->getSubscriptions();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($subscriptions));
    }

    public function testShouldGetSubscriptionsByStatus()
    {
        $subscriptions = null;
        try {
            $subscriptions = $this->client->getSubscriptions();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertGreaterThan(0, count($subscriptions));
    }

    public function testShouldGetCurrencies()
    {
        $currencyList = null;
        try {
            $currencyList = $this->client->getCurrencies();
        } catch (\Exception $e) {
            $e->getTraceAsString();
            self::fail($e->getMessage());
        }

        $this->assertNotNull($currencyList);
    }
}
