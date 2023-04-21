<?php

namespace BitPaySDK\Test\Model\Settlement;

use BitPaySDK\Model\Settlement\PayoutInfo;
use PHPUnit\Framework\TestCase;

class PayoutInfoTest extends TestCase
{
    public function testInstanceOf()
    {
        $payoutInfo = $this->createClassObject();
        self::assertInstanceOf(PayoutInfo::class, $payoutInfo);
    }

    public function testGetAccount()
    {
        $expectedAccount = 'Test account';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccount($expectedAccount);
        self::assertEquals($expectedAccount, $payoutInfo->getAccount());
    }

    public function testGetRouting()
    {
        $expectedRouting = 'Test routing';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setRouting($expectedRouting);
        self::assertEquals($expectedRouting, $payoutInfo->getRouting());
    }

    public function testGetMerchantEin()
    {
        $expectedMerchantEin = 'Test MerchantEin';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setMerchantEin($expectedMerchantEin);
        self::assertEquals($expectedMerchantEin, $payoutInfo->getMerchantEin());
    }

    public function testGetLabel()
    {
        $expectedLabel = 'Test label';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setLabel($expectedLabel);
        self::assertEquals($expectedLabel, $payoutInfo->getLabel());
    }

    public function testGetBankCountry()
    {
        $expectedBankCountry = 'USA';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankCountry($expectedBankCountry);
        self::assertEquals($expectedBankCountry, $payoutInfo->getBankCountry());
    }

    public function testGetName()
    {
        $expectedName = 'Test Name';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setName($expectedName);
        self::assertEquals($expectedName, $payoutInfo->getName());
    }

    public function testGetBank()
    {
        $expectedBank = 'Test bank';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBank($expectedBank);
        self::assertEquals($expectedBank, $payoutInfo->getBank());
    }

    public function testGetSwift()
    {
        $expectedSwift = 'Test swift';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setSwift($expectedSwift);
        self::assertEquals($expectedSwift, $payoutInfo->getSwift());
    }

    public function testGetAddress()
    {
        $expectedAddress = 'Test address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAddress($expectedAddress);
        self::assertEquals($expectedAddress, $payoutInfo->getAddress());
    }

    public function testGetCity()
    {
        $expectedCity = 'Miami';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setCity($expectedCity);
        self::assertEquals($expectedCity, $payoutInfo->getCity());
    }

    public function testGetPostal()
    {
        $expectedPostal = 'Test postal';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setPostal($expectedPostal);
        self::assertEquals($expectedPostal, $payoutInfo->getPostal());
    }

    public function testGetSort()
    {
        $expectedSort = 'Test sort';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setSort($expectedSort);
        self::assertEquals($expectedSort, $payoutInfo->getSort());
    }

    public function testGetWire()
    {
        $expectedWire = 'Test wire';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setWire($expectedWire);
        self::assertEquals($expectedWire, $payoutInfo->getWire());
    }

    public function testGetBankName()
    {
        $expectedBankName = 'Test bank name';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankName($expectedBankName);
        self::assertEquals($expectedBankName, $payoutInfo->getBankName());
    }

    public function testGetBankAddress()
    {
        $expectedBankAddress = 'Test bank address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankAddress($expectedBankAddress);
        self::assertEquals($expectedBankAddress, $payoutInfo->getBankAddress());
    }

    public function testGetBankAddress2()
    {
        $expectedBankAddress2 = 'Test bank address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setBankAddress2($expectedBankAddress2);
        self::assertEquals($expectedBankAddress2, $payoutInfo->getBankAddress2());
    }

    public function testGetIban()
    {
        $expectedIban = 'KW81CBKU00000000000012345601013';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setIban($expectedIban);
        self::assertEquals($expectedIban, $payoutInfo->getIban());
    }

    public function testGetAdditionalInformation()
    {
        $expectedAdditionalInformation = 'Test additional information';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAdditionalInformation($expectedAdditionalInformation);
        self::assertEquals($expectedAdditionalInformation, $payoutInfo->getAdditionalInformation());
    }

    public function testGetAccountHolderName()
    {
        $expectedAccountHolderName = 'Test account holder name';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderName($expectedAccountHolderName);
        self::assertEquals($expectedAccountHolderName, $payoutInfo->getAccountHolderName());
    }

    public function testGetAccountHolderAddress()
    {
        $expectedAccountHolderAddress = 'Test account holder address';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderAddress($expectedAccountHolderAddress);
        self::assertEquals($expectedAccountHolderAddress, $payoutInfo->getAccountHolderAddress());
    }

    public function testGetAccountHolderAddress2()
    {
        $expectedAccountHolderAddress2 = 'Test account holder address2';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderAddress2($expectedAccountHolderAddress2);
        self::assertEquals($expectedAccountHolderAddress2, $payoutInfo->getAccountHolderAddress2());
    }

    public function testGetAccountHolderPostalCode()
    {
        $expectedAccountHolderPostalCode = '12345';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderPostalCode($expectedAccountHolderPostalCode);
        self::assertEquals($expectedAccountHolderPostalCode, $payoutInfo->getAccountHolderPostalCode());
    }

    public function testGetAccountHolderCity()
    {
        $expectedAccountHolderCity = 'Miami';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderCity($expectedAccountHolderCity);
        self::assertEquals($expectedAccountHolderCity, $payoutInfo->getAccountHolderCity());
    }

    public function testGetAccountHolderCountry()
    {
        $expectedAccountHolderCountry = 'USA';

        $payoutInfo = $this->createClassObject();
        $payoutInfo->setAccountHolderCountry($expectedAccountHolderCountry);
        self::assertEquals($expectedAccountHolderCountry, $payoutInfo->getAccountHolderCountry());
    }

    public function testToArray()
    {
        $payoutInfo = $this->createClassObject();
        $this->setSetters($payoutInfo);
        $payoutInfoArray = $payoutInfo->toArray();

        self::assertNotNull($payoutInfoArray);
        self::assertIsArray($payoutInfoArray);

        self::assertArrayHasKey('label', $payoutInfoArray);
        self::assertArrayHasKey('bankCountry', $payoutInfoArray);
        self::assertArrayHasKey('name', $payoutInfoArray);
        self::assertArrayHasKey('bank', $payoutInfoArray);
        self::assertArrayHasKey('swift', $payoutInfoArray);
        self::assertArrayHasKey('address', $payoutInfoArray);
        self::assertArrayHasKey('city', $payoutInfoArray);
        self::assertArrayHasKey('postal', $payoutInfoArray);
        self::assertArrayHasKey('sort', $payoutInfoArray);
        self::assertArrayHasKey('wire', $payoutInfoArray);
        self::assertArrayHasKey('bankName', $payoutInfoArray);
        self::assertArrayHasKey('bankAddress', $payoutInfoArray);
        self::assertArrayHasKey('iban', $payoutInfoArray);
        self::assertArrayHasKey('additionalInformation', $payoutInfoArray);
        self::assertArrayHasKey('accountHolderName', $payoutInfoArray);
        self::assertArrayHasKey('accountHolderAddress', $payoutInfoArray);
        self::assertArrayHasKey('accountHolderAddress2', $payoutInfoArray);
        self::assertArrayHasKey('accountHolderPostalCode', $payoutInfoArray);
        self::assertArrayHasKey('accountHolderCity', $payoutInfoArray);
        self::assertArrayHasKey('accountHolderCountry', $payoutInfoArray);

        self::assertEquals('Label', $payoutInfoArray['label']);
        self::assertEquals('USA', $payoutInfoArray['bankCountry']);
        self::assertEquals('Name', $payoutInfoArray['name']);
        self::assertEquals('Bank', $payoutInfoArray['bank']);
        self::assertEquals('Swift', $payoutInfoArray['swift']);
        self::assertEquals('Address', $payoutInfoArray['address']);
        self::assertEquals('Miami', $payoutInfoArray['city']);
        self::assertEquals('12345', $payoutInfoArray['postal']);
        self::assertEquals('Sort', $payoutInfoArray['sort']);
        self::assertEquals('Wire', $payoutInfoArray['wire']);
        self::assertEquals('Bank name', $payoutInfoArray['bankName']);
        self::assertEquals('Bank address', $payoutInfoArray['bankAddress']);
        self::assertEquals('KW81CBKU00000000000012345601013', $payoutInfoArray['iban']);
        self::assertEquals('Additional information', $payoutInfoArray['additionalInformation']);
        self::assertEquals('Account holder name', $payoutInfoArray['accountHolderName']);
        self::assertEquals('Account holder address', $payoutInfoArray['accountHolderAddress']);
        self::assertEquals('Account holder address2', $payoutInfoArray['accountHolderAddress2']);
        self::assertEquals('Account holder postal code', $payoutInfoArray['accountHolderPostalCode']);
        self::assertEquals('Account holder city', $payoutInfoArray['accountHolderCity']);
        self::assertEquals('Account holder country', $payoutInfoArray['accountHolderCountry']);
    }

    private function createClassObject(): PayoutInfo
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
