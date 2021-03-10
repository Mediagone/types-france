<?php declare(strict_types=1);

namespace Mediagone\Types\France\Geo;

use InvalidArgumentException;
use Mediagone\Types\Common\ValueObject;
use function is_string;
use function preg_match;


/**
 * Represents a french PostalCode.
 *
 * The value must match the following properties:
 *      - 5 digits long
 */
final class PostalCode implements ValueObject
{
    //========================================================================================================
    // Constants
    //========================================================================================================
    
    public const LENGTH = 5;
    
    public const REGEX = '#^[0-9]{'.self::LENGTH.'}$#';
    
    
    
    //========================================================================================================
    //
    //========================================================================================================
    
    private string $code;
    
    
    
    //========================================================================================================
    // Constructor
    //========================================================================================================
    
    private function __construct(string $code)
    {
        if (! self::isValueValid($code)) {
            throw new InvalidArgumentException("The supplied Postal Code ($code) is invalid (it must be ".self::LENGTH." digits long).");
        }
        
        $this->code = $code;
    }
    
    
    /**
     * Creates a new instance from the given string.
     */
    public static function fromString(string $code) : self
    {
        return new self($code);
    }
    
    
    
    //========================================================================================================
    // Static methods
    //========================================================================================================
    
    /**
     * Returns whether the given value is a valid french Postal Code.
     *
     * @param string $code
     */
    public static function isValueValid($code) : bool
    {
        if (! is_string($code)) {
            return false;
        }
        
        return preg_match(self::REGEX, $code) === 1;
    }
    
    
    
    //========================================================================================================
    // Methods
    //========================================================================================================
    
    public function jsonSerialize()
    {
        return $this->code;
    }
    
    
    public function __toString() : string
    {
        return $this->code;
    }
    
    
    
}
