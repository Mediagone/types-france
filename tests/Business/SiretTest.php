<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\France\Business\Nic;
use Mediagone\Types\France\Business\Siren;
use Mediagone\Types\France\Business\Siret;
use PHPUnit\Framework\TestCase;
use function range;
use function str_repeat;


/**
 * @covers \Mediagone\Types\France\Business\Siret
 */
final class SiretTest extends TestCase
{
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_declares_regex_constant() : void
    {
        self::assertTrue(defined(Siret::class . '::REGEX'));
    }
    
    
    
    /**
     * @dataProvider lettersProvider
     */
    public function test_cannot_contain_letters($letter) : void
    {
        $this->expectException(InvalidArgumentException::class);
        Siret::fromString(str_repeat($letter, Siret::LENGTH));
    }
    
    public function lettersProvider()
    {
        foreach (range('a', 'z') as $letter) {
            yield [$letter];
        }
    }
    
    
    
    /**
     * @dataProvider invalidLengthSiretProvider
     */
    public function test_cannot_be_too_short_or_too_long(string $siret) : void
    {
        $this->expectException(InvalidArgumentException::class);
        Siret::fromString($siret);
    }
    
    public function invalidLengthSiretProvider()
    {
        foreach (range(0, Siret::LENGTH - 1) as $length) {
            yield [str_repeat('1', $length)];
        }
        foreach (range(Siret::LENGTH + 1, Siret::LENGTH + 10) as $length) {
            yield [str_repeat('1', $length)];
        }
    }
    
    
    
    //========================================================================================================
    // Conversion tests
    //========================================================================================================
    
    public function test_can_be_encoded_to_json() : void
    {
        $value = '12345678901234';
        $siret = Siret::fromString($value);
        
        self::assertSame($value, $siret->jsonSerialize());
    }
    
    
    public function test_can_be_cast_to_string() : void
    {
        $value = '12345678901234';
        $siret = Siret::fromString($value);
        
        self::assertSame($value, (string)$siret);
    }
    
    
    public function test_can_get_siren() : void
    {
        $siret = Siret::fromString('12345678901234');
    
        self::assertInstanceOf(Siren::class, $siret->getSiren());
        self::assertSame('123456789', (string)$siret->getSiren());
    }
    
    
    public function test_can_get_nic() : void
    {
        $siret = Siret::fromString('12345678901234');
        
        self::assertInstanceOf(Nic::class, $siret->getNic());
        self::assertSame('01234', (string)$siret->getNic());
    }
    
    
    
    //========================================================================================================
    // Misc
    //========================================================================================================
    
    public function test_can_tell_value_is_valid() : void
    {
        self::assertTrue(Siret::isValueValid('12345678901234'));
    }
    
    
    public function test_can_tell_non_string_value_is_invalid() : void
    {
        self::assertFalse(Siret::isValueValid(100));
        self::assertFalse(Siret::isValueValid(true));
        self::assertFalse(Siret::isValueValid(1.2));
        self::assertFalse(Siret::isValueValid('1234567890123'));
    }
    
    
    
}
