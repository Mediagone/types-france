<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\France\Business\Nic;
use PHPUnit\Framework\TestCase;
use function range;
use function str_repeat;


/**
 * @covers \Mediagone\Types\France\Business\Nic
 */
final class NicTest extends TestCase
{
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_declares_regex_constant() : void
    {
        self::assertTrue(defined(Nic::class . '::REGEX'));
    }
    
    
    
    /**
     * @dataProvider lettersProvider
     */
    public function test_cannot_contain_letters($letter) : void
    {
        $this->expectException(InvalidArgumentException::class);
        Nic::fromString(str_repeat($letter, Nic::LENGTH));
    }
    
    public function lettersProvider()
    {
        foreach (range('a', 'z') as $letter) {
            yield [$letter];
        }
    }
    
    
    
    /**
     * @dataProvider invalidLengthNicProvider
     */
    public function test_cannot_be_too_short_or_too_long(string $siren) : void
    {
        $this->expectException(InvalidArgumentException::class);
        Nic::fromString($siren);
    }
    
    public function invalidLengthNicProvider()
    {
        foreach (range(0, Nic::LENGTH - 1) as $length) {
            yield [str_repeat('1', $length)];
        }
        foreach (range(Nic::LENGTH + 1, Nic::LENGTH + 10) as $length) {
            yield [str_repeat('1', $length)];
        }
    }
    
    
    
    //========================================================================================================
    // Conversion tests
    //========================================================================================================
    
    public function test_can_be_encoded_to_json() : void
    {
        $value = '12345';
        $nic = Nic::fromString($value);
        
        self::assertSame($value, $nic->jsonSerialize());
    }
    
    
    public function test_can_be_cast_to_string() : void
    {
        $value = '12345';
        $nic = Nic::fromString($value);
        
        self::assertSame($value, (string)$nic);
    }
    
    
    
    //========================================================================================================
    // Misc
    //========================================================================================================
    
    public function test_can_tell_value_is_valid() : void
    {
        self::assertTrue(Nic::isValueValid('12345'));
        self::assertFalse(Nic::isValueValid('1234'));
    }
    
    
    public function test_can_tell_non_string_value_is_invalid() : void
    {
        self::assertFalse(Nic::isValueValid(100));
        self::assertFalse(Nic::isValueValid(true));
        self::assertFalse(Nic::isValueValid(1.2));
        self::assertFalse(Nic::isValueValid('1234'));
    }
    
    
    
}
