<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPaySDK\Client;
use BitPaySDK\Env;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use BitPaySDK\Model\Currency;
use BitPaySDK\Tokens;
use BitPaySDK\Util\RESTcli\RESTcli;
use PHPUnit\Framework\TestCase;

class BillClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile('src/BitPaySDK/config.yml');
    }

    public function testCreate(): void
    {
        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);

        $this->assertEquals('draft', $bill->getStatus());
        $this->assertEquals(1, $bill->getItems()[0]->getQuantity());
        $this->assertEquals(6.0, $bill->getItems()[0]->getPrice());
        $this->assertEquals(4.0, $bill->getItems()[1]->getPrice());
        $this->assertEquals(1, $bill->getItems()[1]->getQuantity());
        $this->assertEquals("Test Item 1", $bill->getItems()[0]->getDescription());
        $this->assertEquals("Test Item 2", $bill->getItems()[1]->getDescription());
        $this->assertEquals("Test Item 2", $bill->getItems()[1]->getDescription());
        $this->assertEquals("USD", $bill->getCurrency());
    }

    public function testGetBill(): void
    {
        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);
        $bill = $this->client->getBill($bill->getId());

        $this->assertEquals('draft', $bill->getStatus());
        $this->assertEquals(2, count($bill->getItems()));
        $this->assertEquals('USD', $bill->getCurrency());
        $this->assertEquals('bill1234-ABCD', $bill->getNumber());
        $this->assertEquals('john@doe.com', $bill->getEmail());
    }

    public function testGetBills(): void
    {
        $bills = $this->client->getBills();

        $this->assertNotNull($bills);
        $this->assertTrue(is_array($bills));
        $isCount = count($bills) > 0;
        $this->assertTrue($isCount);
    }
    public function testUpdateBill(): void
    {
        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);
        $bill = $this->client->getBill($bill->getId());
        $bill->setEmail('test@gmail.com');
        $bill = $this->client->updateBill($bill, $bill->getId());

        $this->assertEquals('test@gmail.com', $bill->getEmail());
    }

    public function testDeliverBill(): void
    {

        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);

        $bill = $this->client->getBill($bill->getId());
        $result = $this->client->deliverBill($bill->getId(), $bill->getToken());

        $this->assertIsString($result);
    }

    private function getBillExample(): Bill
    {
        $items = [];
        $item = new Item();
        $item->setPrice(6.0);
        $item->setQuantity(1);
        $item->setDescription("Test Item 1");
        array_push($items, $item);

        $item = new Item();
        $item->setPrice(4.0);
        $item->setQuantity(1);
        $item->setDescription("Test Item 2");
        array_push($items, $item);

        return new Bill("bill1234-ABCD", Currency::USD, "", $items);
    }
}