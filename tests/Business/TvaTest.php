<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\Common\Geo\Country;
use Mediagone\Types\France\Business\Siren;
use Mediagone\Types\France\Business\Siret;
use Mediagone\Types\France\Business\Tva;
use PHPUnit\Framework\TestCase;


/**
 * @covers \Mediagone\Types\France\Business\Tva
 */
final class TvaTest extends TestCase
{
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_declares_regex_constant() : void
    {
        self::assertTrue(defined(Tva::class . '::REGEX'));
    }
    
    
    public function test_can_be_created_from_string() : void
    {
        self::assertSame('FR77523247930', (string)Tva::fromString('FR77523247930'));
    }
    
    
    public function test_can_be_created_from_siren() : void
    {
        $siren = Siren::fromString('523247930');
        self::assertSame('FR77523247930', (string)Tva::fromSiren($siren));
    }
    
    
    public function test_single_digit_key_is_padded() : void
    {
        $siren = Siren::fromString('637293879');
        self::assertSame('FR09637293879', (string)Tva::fromSiren($siren));
    }
    
    
    public function test_can_be_created_from_siret() : void
    {
        $siret = Siret::fromString('52324793012345');
        self::assertSame('FR77523247930', (string)Tva::fromSiret($siret));
    }
    
    
    /**
     * @dataProvider invalidLengthProvider
     */
    public function test_cannot_be_too_short(string $tva) : void
    {
        $this->expectException(InvalidArgumentException::class);
        Tva::fromString($tva);
    }
    
    public function invalidLengthProvider()
    {
        yield ['FR0'];
        yield ['FR00'];
        yield ['FR151'];
        yield ['FR4812'];
        yield ['FR90123'];
        yield ['FR281234'];
        yield ['FR9012345'];
        yield ['FR34123456'];
        yield ['FR591234567'];
        yield ['FR2112345678'];
    }
    
    
    
    //========================================================================================================
    // Conversion tests
    //========================================================================================================
    
    public function test_can_be_encoded_to_json() : void
    {
        $value = 'FR77523247930';
        $tva = Tva::fromString($value);
       
        self::assertSame($value, $tva->jsonSerialize());
    }
    
    
    public function test_can_be_cast_to_string() : void
    {
        $value = 'FR77523247930';
        $tva = Tva::fromString($value);
       
        self::assertSame($value, (string)$tva);
    }
    
    
    public function test_can_get_country() : void
    {
        $tva = Tva::fromString('FR77523247930');
        $country = $tva->getCountry();
        
        self::assertInstanceOf(Country::class, $country);
        self::assertSame('FRA', (string)$country);
    }
    
    
    
    //========================================================================================================
    // Misc
    //========================================================================================================
    
    public function test_can_tell_value_is_valid() : void
    {
        self::assertTrue(Tva::isValueValid('FR77523247930'));
    }
    
    
    public function test_can_tell_value_is_invalid() : void
    {
        self::assertFalse(Tva::isValueValid(100));
        self::assertFalse(Tva::isValueValid(true));
        self::assertFalse(Tva::isValueValid(1.2));
        self::assertFalse(Tva::isValueValid('77523247930'));
        self::assertFalse(Tva::isValueValid('FR7752324793'));
    }
    
    
    
}
