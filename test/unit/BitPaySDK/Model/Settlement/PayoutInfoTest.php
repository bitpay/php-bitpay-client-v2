<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\PayoutInfo;
use PHPUnit\Framework\TestCase;

class PayoutInfoTest extends TestCase
{
    public function testInstanceOf()
    {
        $payoutInfo = $this->createClassObject();
        $this->assertInstanceOf(PayoutInfo::class, $payoutInfo);
    }

    public function testGetAccount()
    {
        $expectedAccount = 'Test account';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccount($expectedAccount);
        $this->assertEquals($expectedAccount, $payoutInfo->getAccount());
    }

    public function testGetRouting()
    {
        $expectedRouting = 'Test routing';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setRouting($expectedRouting);
        $this->assertEquals($expectedRouting, $payoutInfo->getRouting());
    }

    public function testGetMerchantEin()
    {
        $expectedMerchantEin = 'Test MerchantEin';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setMerchantEin($expectedMerchantEin);
        $this->assertEquals($expectedMerchantEin, $payoutInfo->getMerchantEin());
    }

    public function testGetLabel()
    {
        $expectedLabel = 'Test label';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setLabel($expectedLabel);
        $this->assertEquals($expectedLabel, $payoutInfo->getLabel());
    }

    public function testGetBankCountry()
    {
        $expectedBankCountry = 'USA';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankCountry($expectedBankCountry);
        $this->assertEquals($expectedBankCountry, $payoutInfo->getBankCountry());
    }

    public function testGetName()
    {
        $expectedName = 'Test Name';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setName($expectedName);
        $this->assertEquals($expectedName, $payoutInfo->getName());
    }

    public function testGetBank()
    {
        $expectedBank = 'Test bank';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBank($expectedBank);
        $this->assertEquals($expectedBank, $payoutInfo->getBank());
    }

    public function testGetSwift()
    {
        $expectedSwift = 'Test swift';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setSwift($expectedSwift);
        $this->assertEquals($expectedSwift, $payoutInfo->getSwift());
    }

    public function testGetAddress()
    {
        $expectedAddress = 'Test address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAddress($expectedAddress);
        $this->assertEquals($expectedAddress, $payoutInfo->getAddress());
    }

    public function testGetCity()
    {
        $expectedCity = 'Miami';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setCity($expectedCity);
        $this->assertEquals($expectedCity, $payoutInfo->getCity());
    }

    public function testGetPostal()
    {
        $expectedPostal = 'Test postal';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setPostal($expectedPostal);
        $this->assertEquals($expectedPostal, $payoutInfo->getPostal());
    }

    public function testGetSort()
    {
        $expectedSort = 'Test sort';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setSort($expectedSort);
        $this->assertEquals($expectedSort, $payoutInfo->getSort());
    }

    public function testGetWire()
    {
        $expectedWire = 'Test wire';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setWire($expectedWire);
        $this->assertEquals($expectedWire, $payoutInfo->getWire());
    }

    public function testGetBankName()
    {
        $expectedBankName = 'Test bank name';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankName($expectedBankName);
        $this->assertEquals($expectedBankName, $payoutInfo->getBankName());
    }

    public function testGetBankAddress()
    {
        $expectedBankAddress = 'Test bank address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankAddress($expectedBankAddress);
        $this->assertEquals($expectedBankAddress, $payoutInfo->getBankAddress());
    }

    public function testGetBankAddress2()
    {
        $expectedBankAddress2 = 'Test bank address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankAddress2($expectedBankAddress2);
        $this->assertEquals($expectedBankAddress2, $payoutInfo->getBankAddress2());
    }

    public function testGetIban()
    {
        $expectedIban = 'KW81CBKU00000000000012345601013';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setIban($expectedIban);
        $this->assertEquals($expectedIban, $payoutInfo->getIban());
    }

    public function testGetAdditionalInformation()
    {
        $expectedAdditionalInformation = 'Test additional information';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAdditionalInformation($expectedAdditionalInformation);
        $this->assertEquals($expectedAdditionalInformation, $payoutInfo->getAdditionalInformation());
    }

    public function testGetAccountHolderName()
    {
        $expectedAccountHolderName = 'Test account holder name';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderName($expectedAccountHolderName);
        $this->assertEquals($expectedAccountHolderName, $payoutInfo->getAccountHolderName());
    }

    public function testGetAccountHolderAddress()
    {
        $expectedAccountHolderAddress = 'Test account holder address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderAddress($expectedAccountHolderAddress);
        $this->assertEquals($expectedAccountHolderAddress, $payoutInfo->getAccountHolderAddress());
    }

    public function testGetAccountHolderAddress2()
    {
        $expectedAccountHolderAddress2 = 'Test account holder address2';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderAddress2($expectedAccountHolderAddress2);
        $this->assertEquals($expectedAccountHolderAddress2, $payoutInfo->getAccountHolderAddress2());
    }

    public function testGetAccountHolderPostalCode()
    {
        $expectedAccountHolderPostalCode = '12345';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderPostalCode($expectedAccountHolderPostalCode);
        $this->assertEquals($expectedAccountHolderPostalCode, $payoutInfo->getAccountHolderPostalCode());
    }

    public function testGetAccountHolderCity()
    {
        $expectedAccountHolderCity = 'Miami';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderCity($expectedAccountHolderCity);
        $this->assertEquals($expectedAccountHolderCity, $payoutInfo->getAccountHolderCity());
    }

    public function testGetAccountHolderCountry()
    {
        $expectedAccountHolderCountry = 'USA';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderCountry($expectedAccountHolderCountry);
        $this->assertEquals($expectedAccountHolderCountry, $payoutInfo->getAccountHolderCountry());
    }

    public function testToArray()
    {
        $payoutInfo = $this->createClassObject();
        $this->setSetters($payoutInfo);
        $payoutInfoArray = $payoutInfo->toArray();

        $this->assertNotNull($payoutInfoArray);
        $this->assertIsArray($payoutInfoArray);

        $this->assertArrayHasKey('label', $payoutInfoArray);
        $this->assertArrayHasKey('bankCountry', $payoutInfoArray);
        $this->assertArrayHasKey('name', $payoutInfoArray);
        $this->assertArrayHasKey('bank', $payoutInfoArray);
        $this->assertArrayHasKey('swift', $payoutInfoArray);
        $this->assertArrayHasKey('address', $payoutInfoArray);
        $this->assertArrayHasKey('city', $payoutInfoArray);
        $this->assertArrayHasKey('postal', $payoutInfoArray);
        $this->assertArrayHasKey('sort', $payoutInfoArray);
        $this->assertArrayHasKey('wire', $payoutInfoArray);
        $this->assertArrayHasKey('bankName', $payoutInfoArray);
        $this->assertArrayHasKey('bankAddress', $payoutInfoArray);
        $this->assertArrayHasKey('iban', $payoutInfoArray);
        $this->assertArrayHasKey('additionalInformation', $payoutInfoArray);
        $this->assertArrayHasKey('accountHolderName', $payoutInfoArray);
        $this->assertArrayHasKey('accountHolderAddress', $payoutInfoArray);
        $this->assertArrayHasKey('accountHolderAddress2', $payoutInfoArray);
        $this->assertArrayHasKey('accountHolderPostalCode', $payoutInfoArray);
        $this->assertArrayHasKey('accountHolderCity', $payoutInfoArray);
        $this->assertArrayHasKey('accountHolderCountry', $payoutInfoArray);

        $this->assertEquals($payoutInfoArray['label'], 'Label');
        $this->assertEquals($payoutInfoArray['bankCountry'], 'USA');
        $this->assertEquals($payoutInfoArray['name'], 'Name');
        $this->assertEquals($payoutInfoArray['bank'], 'Bank');
        $this->assertEquals($payoutInfoArray['swift'], 'Swift');
        $this->assertEquals($payoutInfoArray['address'], 'Address');
        $this->assertEquals($payoutInfoArray['city'], 'Miami');
        $this->assertEquals($payoutInfoArray['postal'], '12345');
        $this->assertEquals($payoutInfoArray['sort'], 'Sort');
        $this->assertEquals($payoutInfoArray['wire'], 'Wire');
        $this->assertEquals($payoutInfoArray['bankName'], 'Bank name');
        $this->assertEquals($payoutInfoArray['bankAddress'], 'Bank address');
        $this->assertEquals($payoutInfoArray['iban'], 'KW81CBKU00000000000012345601013');
        $this->assertEquals($payoutInfoArray['additionalInformation'], 'Additional information');
        $this->assertEquals($payoutInfoArray['accountHolderName'], 'Account holder name');
        $this->assertEquals($payoutInfoArray['accountHolderAddress'], 'Account holder address');
        $this->assertEquals($payoutInfoArray['accountHolderAddress2'], 'Account holder address2');
        $this->assertEquals($payoutInfoArray['accountHolderPostalCode'], 'Account holder postal code');
        $this->assertEquals($payoutInfoArray['accountHolderCity'], 'Account holder city');
        $this->assertEquals($payoutInfoArray['accountHolderCountry'], 'Account holder country');
    }

    private function createClassObject()
    {
        return new PayoutInfo();
    }

    private function setSetters(PayoutInfo $payoutInfo)
    {
        $payoutInfo->setLabel('Label');
        $payoutInfo->setBankCountry('USA');
        $payoutInfo->setName('Name');
        $payoutInfo->setBank('Bank');
        $payoutInfo->setSwift('Swift');
        $payoutInfo->setAddress('Address');
        $payoutInfo->setCity('Miami');
        $payoutInfo->setPostal('12345');
        $payoutInfo->setSort('Sort');
        $payoutInfo->setWire('Wire');
        $payoutInfo->setBankName('Bank name');
        $payoutInfo->setBankAddress('Bank address');
        $payoutInfo->setIban('KW81CBKU00000000000012345601013');
        $payoutInfo->setAdditionalInformation('Additional information');
        $payoutInfo->setAccountHolderName('Account holder name');
        $payoutInfo->setAccountHolderAddress('Account holder address');
        $payoutInfo->setAccountHolderAddress2('Account holder address2');
        $payoutInfo->setAccountHolderPostalCode('Account holder postal code');
        $payoutInfo->setAccountHolderCity('Account holder city');
        $payoutInfo->setAccountHolderCountry('Account holder country');
    }
}
