<?php declare(strict_types=1);

namespace Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\Common\ValueObject;
use function is_string;
use function preg_match;


/**
 * Represents a SIREN number.
 *
 * The value must match the following properties:
 *      - 9 digits long
 */
final class Siren implements ValueObject
{
    //========================================================================================================
    // Constants
    //========================================================================================================
    
    public const LENGTH = 9;
    
    public const REGEX = '#^[0-9]{'.self::LENGTH.'}$#';
    
    
    
    //========================================================================================================
    //
    //========================================================================================================
    
    private string $siren;
    
    
    
    //========================================================================================================
    // Constructor
    //========================================================================================================
    
    private function __construct(string $siren)
    {
        if (! self::isValueValid($siren)) {
            throw new InvalidArgumentException("The supplied SIREN ($siren) is invalid (it must be ".self::LENGTH." digits long).");
        }
        
        $this->siren = $siren;
    }
    
    
    /**
     * Creates a new instance from the given string.
     */
    public static function fromString(string $siren) : self
    {
        return new self($siren);
    }
    
    
    
    //========================================================================================================
    // Static methods
    //========================================================================================================
    
    /**
     * Returns whether the given value is a valid SIREN number.
     *
     * @param string $siren
     */
    public static function isValueValid($siren) : bool
    {
        if (! is_string($siren)) {
            return false;
        }
        
        return preg_match(self::REGEX, $siren) === 1;
    }
    
    
    
    //========================================================================================================
    // Methods
    //========================================================================================================
    
    public function jsonSerialize()
    {
        return $this->siren;
    }
    
    
    public function __toString() : string
    {
        return $this->siren;
    }
    
    
    
}
