<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\France\Geo\PostalCode;
use PHPUnit\Framework\TestCase;
use function range;
use function str_repeat;


/**
 * @covers \Mediagone\Types\France\Geo\PostalCode
 */
final class PostalCodeTest extends TestCase
{
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_declares_regex_constant() : void
    {
        self::assertTrue(defined(PostalCode::class . '::REGEX'));
    }
    
    
    
    /**
     * @dataProvider lettersProvider
     */
    public function test_cannot_contain_letters($letter) : void
    {
        $this->expectException(InvalidArgumentException::class);
        PostalCode::fromString(str_repeat($letter, PostalCode::LENGTH));
    }
    
    public function lettersProvider()
    {
        foreach (range('a', 'z') as $letter) {
            yield [$letter];
        }
    }
    
    
    
    /**
     * @dataProvider invalidLengthPostalCodeProvider
     */
    public function test_cannot_be_too_short_or_too_long(string $siren) : void
    {
        $this->expectException(InvalidArgumentException::class);
        PostalCode::fromString($siren);
    }
    
    public function invalidLengthPostalCodeProvider()
    {
        foreach (range(0, PostalCode::LENGTH - 1) as $length) {
            yield [str_repeat('1', $length)];
        }
        foreach (range(PostalCode::LENGTH + 1, PostalCode::LENGTH + 10) as $length) {
            yield [str_repeat('1', $length)];
        }
    }
    
    
    
    //========================================================================================================
    // Conversion tests
    //========================================================================================================
    
    public function test_can_be_encoded_to_json() : void
    {
        $value = '12345';
        $code = PostalCode::fromString($value);
        
        self::assertSame($value, $code->jsonSerialize());
    }
    
    
    public function test_can_be_cast_to_string() : void
    {
        $value = '12345';
        $code = PostalCode::fromString($value);
        
        self::assertSame($value, (string)$code);
    }
    
    
    
    //========================================================================================================
    // Misc
    //========================================================================================================
    
    public function test_can_tell_value_is_valid() : void
    {
        self::assertTrue(PostalCode::isValueValid('12345'));
        self::assertFalse(PostalCode::isValueValid('1234'));
    }
    
    
    public function test_can_tell_non_string_value_is_invalid() : void
    {
        self::assertFalse(PostalCode::isValueValid(100));
        self::assertFalse(PostalCode::isValueValid(true));
        self::assertFalse(PostalCode::isValueValid(1.2));
        self::assertFalse(PostalCode::isValueValid('1234'));
    }
    
    
    
}
