<?php declare(strict_types=1);

namespace Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\Common\ValueObject;
use function is_string;
use function preg_match;


/**
 * Represents a NIC number.
 *
 * The value must match the following properties:
 *      - 5 digits long
 */
final class Nic implements ValueObject
{
    //========================================================================================================
    // Constants
    //========================================================================================================
    
    public const LENGTH = 5;
    
    public const REGEX = '#^[0-9]{'.self::LENGTH.'}$#';
    
    
    
    //========================================================================================================
    //
    //========================================================================================================
    
    private string $nic;
    
    
    
    //========================================================================================================
    // Constructor
    //========================================================================================================
    
    private function __construct(string $nic)
    {
        if (! self::isValueValid($nic)) {
            throw new InvalidArgumentException("The supplied NIC ($nic) is invalid (it must be ".self::LENGTH." digits long).");
        }
        
        $this->nic = $nic;
    }
    
    
    /**
     * Creates a new instance from the given string.
     */
    public static function fromString(string $nic) : self
    {
        return new self($nic);
    }
    
    
    
    //========================================================================================================
    // Static methods
    //========================================================================================================
    
    /**
     * Returns whether the given value is a valid NIC number.
     *
     * @param string $nic
     */
    public static function isValueValid($nic) : bool
    {
        if (! is_string($nic)) {
            return false;
        }
        
        return preg_match(self::REGEX, $nic) === 1;
    }
    
    
    
    //========================================================================================================
    // Methods
    //========================================================================================================
    
    public function jsonSerialize()
    {
        return $this->nic;
    }
    
    
    public function __toString() : string
    {
        return $this->nic;
    }
    
    
    
}
