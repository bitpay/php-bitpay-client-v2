<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use BitPaySDK\Model\Currency;

class BillClientTest extends AbstractClientTest
{
    public function testCreate(): void
    {
        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);

        self::assertEquals('draft', $bill->getStatus());
        self::assertEquals(1, $bill->getItems()[0]->getQuantity());
        self::assertEquals(6.0, $bill->getItems()[0]->getPrice());
        self::assertEquals(4.0, $bill->getItems()[1]->getPrice());
        self::assertEquals(1, $bill->getItems()[1]->getQuantity());
        self::assertEquals("Test Item 1", $bill->getItems()[0]->getDescription());
        self::assertEquals("Test Item 2", $bill->getItems()[1]->getDescription());
        self::assertEquals("Test Item 2", $bill->getItems()[1]->getDescription());
        self::assertEquals("USD", $bill->getCurrency());
    }

    public function testGetBill(): void
    {
        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);
        $bill = $this->client->getBill($bill->getId());

        self::assertEquals('draft', $bill->getStatus());
        self::assertEquals(2, count($bill->getItems()));
        self::assertEquals('USD', $bill->getCurrency());
        self::assertEquals('bill1234-ABCD', $bill->getNumber());
        self::assertEquals('john@doe.com', $bill->getEmail());
    }

    public function testGetBills(): void
    {
        $bills = $this->client->getBills();

        self::assertNotNull($bills);
        self::assertIsArray($bills);
        $isCount = count($bills) > 0;
        self::assertTrue($isCount);
    }
    public function testUpdateBill(): void
    {
        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);
        $bill = $this->client->getBill($bill->getId());
        $bill->setEmail('test@gmail.com');
        $bill = $this->client->updateBill($bill, $bill->getId());

        self::assertEquals('test@gmail.com', $bill->getEmail());
    }

    public function testDeliverBill(): void
    {

        $bill = $this->getBillExample();
        $bill->setEmail("john@doe.com");
        $bill = $this->client->createBill($bill);

        $bill = $this->client->getBill($bill->getId());
        $result = $this->client->deliverBill($bill->getId(), $bill->getToken());

        self::assertTrue($result);
    }

    private function getBillExample(): Bill
    {
        $items = [];
        $item = new Item();
        $item->setPrice(6.0);
        $item->setQuantity(1);
        $item->setDescription("Test Item 1");
        $items[] = $item;

        $item = new Item();
        $item->setPrice(4.0);
        $item->setQuantity(1);
        $item->setDescription("Test Item 2");
        $items[] = $item;

        return new Bill("bill1234-ABCD", Currency::USD, "", $items);
    }
}