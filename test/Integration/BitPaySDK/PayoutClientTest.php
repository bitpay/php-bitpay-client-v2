<?php
declare(strict_types=1);

namespace BitPaySDK\Integration;

use BitPaySDK\Client;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use PHPUnit\Framework\TestCase;

class PayoutClientTest extends TestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = Client::createWithFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . Config::BITPAY_CONFIG_FILE);
    }

    public function testPayoutRequests()
    {
        $currency = Currency::USD;
        $ledgerCurrency = Currency::USD;
        $amount = 10;
        $email = $this->getFromFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . 'email.txt');
        $submitPayout = $this->submitPayout($currency, $ledgerCurrency, $amount);
        $this->assertEquals($currency, $submitPayout->getCurrency());
        $payoutId = $submitPayout->getId();
        $payout = $this->client->getPayout($payoutId);
        $this->assertEquals(10, $payout->getAmount());
        $this->assertEquals($email, $payout->getNotificationEmail());

        $startDate = '2022-10-20T13:00:45.063Z';
        $endDate = '2023-01-01T13:00:45.063Z';

        $payouts = $this->client->getPayouts($startDate, $endDate);
        $this->assertTrue(is_array($payouts));
        $this->assertCount(count($payouts), $payouts);

        $requestPayoutNotification = $this->client->requestPayoutNotification($payoutId);
        $this->assertTrue($requestPayoutNotification);

        $cancelledPayout = $this->client->cancelPayout($payoutId);
        $this->assertTrue($cancelledPayout);
    }

    private function submitPayout(string $currency, string $ledgerCurrency, int $amount)
    {
        $email = $this->getFromFile(Config::INTEGRATION_TEST_PATH . DIRECTORY_SEPARATOR . 'email.txt');
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
        $payout->setReference("PHP Integration tests " . uniqid());

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