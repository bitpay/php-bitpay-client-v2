<?php

declare(strict_types=1);

namespace BitPaySDKexamples\Pos;

use BitPaySDK\Model\Bill\Bill;
use BitPaySDKexamples\ClientProvider;

final class BillRequests
{
    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function createBill(): void
    {
        $client = ClientProvider::createPos();

        $bill = new Bill(null, 'USD');
        $bill->setName('someName');
        $bill->setEmail('someEmail@email.com');
        $bill->setAddress1('SomeAddress');
        $bill->setCity('MyCity');
        // ...

        $client->createBill($bill);
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function getBill(): void
    {
        $client = ClientProvider::createPos();

        $bill = $client->getBill('someBillId');
    }

    /**
     * @throws \BitPaySDK\Exceptions\BitPayApiException
     * @throws \BitPaySDK\Exceptions\BitPayGenericException
     */
    public function deliverBillViaEmail(): void
    {
        $client = ClientProvider::createPos();

        $result = $client->deliverBill('someBillId', 'myBillToken');
    }
}
