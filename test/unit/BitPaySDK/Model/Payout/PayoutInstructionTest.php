<?php

namespace BitPaySDK\Test\Model\Payout;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutBatchCreationException;
use BitPaySDK\Model\Payout\PayoutInstruction;
use BitPaySDK\Model\Payout\PayoutInstructionBtcSummary;
use BitPaySDK\Model\Payout\PayoutInstructionTransaction;
use BitPaySDK\Model\Payout\RecipientReferenceMethod;
use PHPUnit\Framework\TestCase;

class PayoutInstructionTest extends TestCase
{
    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testConstructEmail()
  {
    $expectedEmail = 'john@doe.com';

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, $expectedEmail);
    $this->assertEquals($expectedEmail, $payoutInstruction->getEmail());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testConstructRecipientId()
  {
    $expectedRecipientId = 'abcd123';

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::RECIPIENT_ID, $expectedRecipientId);
    $this->assertEquals($expectedRecipientId, $payoutInstruction->getRecipientId());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testConstructShopperId()
  {
    $expectedShopperId = 'abcd123';

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::SHOPPER_ID, $expectedShopperId);
    $this->assertEquals($expectedShopperId, $payoutInstruction->getShopperId());
  }

    /**
     * @throws BitPayException
     */
    public function testConstructInvalid()
  {
    $this->expectException(PayoutBatchCreationException::class);
    new PayoutInstruction(5.0, 999, 'abcd123');
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetAmount()
  {
    $expectedAmount = 10.0;

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
      try {
          $payoutInstruction->setAmount($expectedAmount);
      } catch (BitPayException) {
      }

      $this->assertEquals($expectedAmount, $payoutInstruction->getAmount());
  }

    /**
     * @throws PayoutBatchCreationException
     */
    public function testGetAmountLessThanFive()
  {
    $this->expectException(BitPayException::class);
    new PayoutInstruction(1.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetEmail()
  {
    $expectedEmail = 'jane@doe.com';

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $payoutInstruction->setEmail($expectedEmail);

    $this->assertEquals($expectedEmail, $payoutInstruction->getEmail());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetRecipientId()
  {
    $expectedRecipientId = 'efgh456';

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::RECIPIENT_ID, 'abcd123');
    $payoutInstruction->setRecipientId($expectedRecipientId);

    $this->assertEquals($expectedRecipientId, $payoutInstruction->getRecipientId());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetShopperId()
  {
    $expectedShopperId = 'efgh456';

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::RECIPIENT_ID, 'abcd123');
    $payoutInstruction->setShopperId($expectedShopperId);

    $this->assertEquals($expectedShopperId, $payoutInstruction->getShopperId());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetLabel()
  {
    $expectedLabel = 'My label';
    
    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $payoutInstruction->setLabel($expectedLabel);

    $this->assertEquals($expectedLabel, $payoutInstruction->getLabel());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetId()
  {
    $expectedId = 'id_1234';
    
    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $payoutInstruction->setId($expectedId);

    $this->assertEquals($expectedId, $payoutInstruction->getId());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetBtc()
  {
    $expectedPayoutInstructionBtcSummary = new PayoutInstructionBtcSummary(1.23, 4.56);

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $payoutInstruction->setBtc($expectedPayoutInstructionBtcSummary);

    $this->assertEquals($expectedPayoutInstructionBtcSummary->toArray(), $payoutInstruction->getBtc($expectedPayoutInstructionBtcSummary));
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetTransactions()
  {
    $expectedTransactions = [];

    $transaction = new PayoutInstructionTransaction();
    $transaction->setTxid('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
    $transaction->setAmount(0.000254);
    $transaction->setDate('2021-05-27T11:04:23.155Z');
    $expectedTransactions[] = $transaction;

    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $payoutInstruction->setTransactions($expectedTransactions);

    $this->assertEquals($expectedTransactions, $payoutInstruction->getTransactions());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testGetStatus()
  {
    $expectedStatus = 'success';
    
    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $payoutInstruction->setStatus($expectedStatus);

    $this->assertEquals($expectedStatus, $payoutInstruction->getStatus());
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testToArray()
  {
    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $this->objectSetters($payoutInstruction);
    $payoutInstructionArray = $payoutInstruction->toArray();

    $this->assertNotNull($payoutInstructionArray);
    $this->assertIsArray($payoutInstructionArray);

    $this->assertArrayHasKey('amount', $payoutInstructionArray);
    $this->assertArrayHasKey('email', $payoutInstructionArray);
    $this->assertArrayHasKey('recipientId', $payoutInstructionArray);
    $this->assertArrayHasKey('shopperId', $payoutInstructionArray);
    $this->assertArrayHasKey('label', $payoutInstructionArray);
    $this->assertArrayHasKey('id', $payoutInstructionArray);
    $this->assertArrayHasKey('btc', $payoutInstructionArray);
    $this->assertArrayHasKey('transactions', $payoutInstructionArray);
    $this->assertArrayHasKey('status', $payoutInstructionArray);

    $this->assertEquals(10.0, $payoutInstructionArray['amount']);
    $this->assertEquals('jane@doe.com', $payoutInstructionArray['email']);
    $this->assertEquals('abcd123', $payoutInstructionArray['recipientId']);
    $this->assertEquals('efgh456', $payoutInstructionArray['shopperId']);
    $this->assertEquals('My label', $payoutInstructionArray['label']);
    $this->assertEquals('ijkl789', $payoutInstructionArray['id']);
    $this->assertEquals(1.23, $payoutInstructionArray['btc']['paid']);
    $this->assertEquals(4.56, $payoutInstructionArray['btc']['unpaid']);
    $this->assertEquals('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057', $payoutInstructionArray['transactions'][0]['txid']);
    $this->assertEquals(0.000254, $payoutInstructionArray['transactions'][0]['amount']);
    $this->assertEquals('2021-05-27T11:04:23.155Z', $payoutInstructionArray['transactions'][0]['date']);
    $this->assertEquals('success', $payoutInstructionArray['status']);
  }

    /**
     * @throws PayoutBatchCreationException
     * @throws BitPayException
     */
    public function testToArrayEmptyKey()
  {
    $payoutInstruction = new PayoutInstruction(5.0, RecipientReferenceMethod::EMAIL, 'john@doe.com');
    $payoutInstructionArray = $payoutInstruction->toArray();

    $this->assertNotNull($payoutInstructionArray);
    $this->assertIsArray($payoutInstructionArray);

    $this->assertArrayNotHasKey('transactions', $payoutInstructionArray);
  }

    /**
     * @throws BitPayException
     */
    private function objectSetters(PayoutInstruction $payoutInstruction)
  {
    $transactions = [];
    $transaction = new PayoutInstructionTransaction();
    $transaction->setTxid('db53d7e2bf3385a31257ce09396202d9c2823370a5ca186db315c45e24594057');
    $transaction->setAmount(0.000254);
    $transaction->setDate('2021-05-27T11:04:23.155Z');
    $transactions[] = $transaction->toArray();

    $payoutInstruction->setAmount(10.0);
    $payoutInstruction->setEmail('jane@doe.com');
    $payoutInstruction->setRecipientId('abcd123');
    $payoutInstruction->setShopperId('efgh456');
    $payoutInstruction->setLabel('My label');
    $payoutInstruction->setId('ijkl789');
    $payoutInstruction->setBtc(new PayoutInstructionBtcSummary(1.23, 4.56));
    $payoutInstruction->setTransactions($transactions);
    $payoutInstruction->setStatus('success');
  }
}