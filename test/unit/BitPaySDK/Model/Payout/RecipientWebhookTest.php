<?php

declare(strict_types=1);

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Model\Payout\RecipientWebhook;
use PHPUnit\Framework\TestCase;

class RecipientWebhookTest extends TestCase
{
    public function testModifyEmail(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setEmail($expected);

        self::assertEquals($expected, $testedClass->getEmail());
    }

    public function testModifyId(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setId($expected);

        self::assertEquals($expected, $testedClass->getId());
    }

    public function testModifyLabel(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setLabel($expected);

        self::assertEquals($expected, $testedClass->getLabel());
    }

    public function testModifyShopperId(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setShopperId($expected);

        self::assertEquals($expected, $testedClass->getShopperId());
    }

    public function testModifyStatus(): void
    {
        $testedClass = $this->getTestedClass();
        $expected = 'someValue';
        $testedClass->setstatus($expected);

        self::assertEquals($expected, $testedClass->getStatus());
    }

    private function getTestedClass(): RecipientWebhook
    {
        return new RecipientWebhook();
    }
}
