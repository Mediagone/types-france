<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\France\Business\Siren;
use PHPUnit\Framework\TestCase;
use function range;
use function str_repeat;


/**
 * @covers \Mediagone\Types\France\Business\Siren
 */
final class SirenTest extends TestCase
{
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_declares_regex_constant() : void
    {
        self::assertTrue(defined(Siren::class . '::REGEX'));
    }
    
    
    
    /**
     * @dataProvider lettersProvider
     */
    public function test_cannot_contain_letters($letter) : void
    {
        $this->expectException(InvalidArgumentException::class);
        Siren::fromString(str_repeat($letter, Siren::LENGTH));
    }
    
    public function lettersProvider()
    {
        foreach (range('a', 'z') as $letter) {
            yield [$letter];
        }
    }
    
    
    
    /**
     * @dataProvider invalidLengthSirenProvider
     */
    public function test_cannot_be_too_short_or_too_long(string $siren) : void
    {
        $this->expectException(InvalidArgumentException::class);
        Siren::fromString($siren);
    }
    
    public function invalidLengthSirenProvider()
    {
        foreach (range(0, Siren::LENGTH - 1) as $length) {
            yield [str_repeat('1', $length)];
        }
        foreach (range(Siren::LENGTH + 1, Siren::LENGTH + 10) as $length) {
            yield [str_repeat('1', $length)];
        }
    }
    
    
    
    //========================================================================================================
    // Conversion tests
    //========================================================================================================
    
    public function test_can_be_encoded_to_json() : void
    {
        $value = '123456789';
        $siren = Siren::fromString($value);
        
        self::assertSame($value, $siren->jsonSerialize());
    }
    
    
    public function test_can_be_cast_to_string() : void
    {
        $value = '123456789';
        $siren = Siren::fromString($value);
        
        self::assertSame($value, (string)$siren);
    }
    
    
    
    //========================================================================================================
    // Misc
    //========================================================================================================
    
    public function test_can_tell_value_is_valid() : void
    {
        self::assertTrue(Siren::isValueValid('123456789'));
        self::assertFalse(Siren::isValueValid('12345678'));
    }
    
    
    public function test_can_tell_non_string_value_is_invalid() : void
    {
        self::assertFalse(Siren::isValueValid(100));
        self::assertFalse(Siren::isValueValid(true));
        self::assertFalse(Siren::isValueValid(1.2));
        self::assertFalse(Siren::isValueValid('12345678'));
    }
    
    
    
}
