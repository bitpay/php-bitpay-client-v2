<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Merchant;

use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use BitPaySDK\Model\Facade;
use BitPaySDKexamples\ClientProvider;

final class BillRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function createBill(): void
    {
        $client = ClientProvider::create();

        $bill = new Bill(null, 'USD');
        $bill->setName('someName');
        $bill->setEmail('someEmail@email.com');
        $bill->setAddress1('SomeAddress');
        $bill->setCity('MyCity');
        // ...

        $client->createBill($bill, Facade::MERCHANT, false);
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getBill(): void
    {
        $client = ClientProvider::create();

        $bill = $client->getBill('someBillId', Facade::MERCHANT, false);

        $bills = $client->getBills('draft');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function updateBill(): void
    {
        $client = ClientProvider::create();

        $item = new Item();
        $item->setPrice(12.34);
        $item->setQuantity(5);
        $item->setDescription('someDescription');

        $bill = new Bill();
        $bill->setEmail('myNew@email.com');
        $bill->setItems([$item]);

        $client->updateBill($bill, $bill->getId());
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function deliverBillViaEmail(): void
    {
        $client = ClientProvider::create();

        $client->deliverBill('someBillId', 'myBillToken');
    }
}
