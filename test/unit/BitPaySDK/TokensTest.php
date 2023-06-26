<?php

namespace BitPaySDK\Test;

use BitPaySDK\Model\Facade;
use BitPaySDK\Tokens;
use Exception;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class TokensTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testLoadFromArray()
    {
        $tokens = Tokens::loadFromArray(['merchant' => 'test1', 'payout' => 'test2']);
        self::assertEquals('test1', $tokens->getTokenByFacade(Facade::MERCHANT));
        self::assertEquals('test2', $tokens->getTokenByFacade(Facade::PAYOUT));
        self::assertEquals('test2', $tokens->getPayoutToken());
    }

    public function testGetTokenByFacadeException()
    {
        $instance = new Tokens();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("given facade does not exist or no token defined for the given facade");
        $instance->getTokenByFacade(null);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testGetTokenByFacade()
    {
        $instance = new Tokens(Facade::MERCHANT, Facade::PAYOUT);
        self::assertEquals(
            $this->accessProtected($instance, 'merchant'),
            $instance->getTokenByFacade(Facade::MERCHANT)
        );

        self::assertEquals($instance->getPayoutToken(), $instance->getTokenByFacade(Facade::PAYOUT));
    }

    /**
     * @throws ReflectionException
     */
    private function accessProtected($obj, $prop)
    {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);

        return $property->getValue($obj);
    }
}
