<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Functional;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use BitPaySDK\Model\Payout\PayoutStatus;

class PayoutClientTest extends AbstractClientTest
{
    public function testPayoutRequests()
    {
        $currency = Currency::USD;
        $ledgerCurrency = Currency::USD;
        $amount = 10;
        $email = $this->getFromFile(Config::FUNCTIONAL_TEST_PATH . DIRECTORY_SEPARATOR . 'email.txt');
        $submitPayout = $this->submitPayout($currency, $ledgerCurrency, $amount);
        self::assertEquals($currency, $submitPayout->getCurrency());
        $payoutId = $submitPayout->getId();
        $payout = $this->client->getPayout($payoutId);
        self::assertEquals(10, $payout->getAmount());
        self::assertEquals($email, $payout->getNotificationEmail());

        $startDate = '2022-10-20T13:00:45.063Z';
        $endDate = '2023-01-01T13:00:45.063Z';

        $payouts = $this->client->getPayouts($startDate, $endDate);
        self::assertIsArray($payouts);
        self::assertCount(count($payouts), $payouts);

        $requestPayoutNotification = $this->client->requestPayoutNotification($payoutId);
        self::assertTrue($requestPayoutNotification);

        $cancelledPayout = $this->client->cancelPayout($payoutId);
        self::assertTrue($cancelledPayout);
    }

    /**
     * @throws BitPayException
     * @throws \BitPaySDK\Exceptions\PayoutCancellationException
     * @throws \BitPaySDK\Exceptions\PayoutCreationException
     */
    public function testPayoutGroupRequests(): void
    {
        $payout = new Payout();
        $payout->setAmount(10);
        $payout->setCurrency(Currency::USD);
        $payout->setLedgerCurrency(Currency::USD);
        $payout->setReference('payout_20210527');
        $payout->setNotificationEmail('merchant@email.com');
        $payout->setNotificationURL('https://yournotiticationURL.com/wed3sa0wx1rz5bg0bv97851eqx');
        $payout->setEmail($this->getFromFile(Config::FUNCTIONAL_TEST_PATH . DIRECTORY_SEPARATOR . 'email.txt'));

        $createGroupResponse = $this->client->createPayoutGroup([$payout]);
        self::assertCount(1, $createGroupResponse->getPayouts());
        self::assertEquals(PayoutStatus::NEW, $createGroupResponse->getPayouts()[0]->getStatus());

        $groupId = $createGroupResponse->getPayouts()[0]->getGroupId();
        $cancelGroupResponse = $this->client->cancelPayoutGroup($groupId);
        self::assertEquals(PayoutStatus::CANCELLED, $cancelGroupResponse->getPayouts()[0]->getStatus());
    }

    private function submitPayout(string $currency, string $ledgerCurrency, int $amount)
    {
        $email = $this->getFromFile(Config::FUNCTIONAL_TEST_PATH . DIRECTORY_SEPARATOR . 'email.txt');
        $payout = new Payout($amount, $currency, $ledgerCurrency);

        $recipientsList = [
            new PayoutRecipient(
                $email,
                "recipient1",
                "https://yournotiticationURL.com/b3sarz5bg0wx01eq1bv9785amx")
        ];

        $recipients = new PayoutRecipients($recipientsList);
        $payoutRecipients = $this->client->submitPayoutRecipients($recipients);
        $payoutRecipientId = $payoutRecipients[0]->getId();

        $payout->setRecipientId($payoutRecipientId);
        $payout->setNotificationURL("https://somenotiticationURL.com");
        $payout->setNotificationEmail($email);
        $payout->setReference("PHP functional tests " . uniqid('', true));
        $payout->setTransactions([]);

        return $this->client->submitPayout($payout);
    }

    private function getFromFile(string $path): string
    {
        if (!file_exists($path)) {
            throw new BitPayException("File not found");
        }

        return file_get_contents($path);
    }
}