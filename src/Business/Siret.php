<?php declare(strict_types=1);

namespace Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\Common\ValueObject;
use function is_string;
use function preg_match;
use function substr;


/**
 * Represents a SIRET number.
 *
 * The value must match the following properties:
 *      - 14 digits long
 */
final class Siret implements ValueObject
{
    //========================================================================================================
    // Constants
    //========================================================================================================
    
    public const LENGTH = 14;
    
    public const REGEX = '#^[0-9]{'.self::LENGTH.'}$#';
    
    
    
    //========================================================================================================
    //
    //========================================================================================================
    
    private string $siret;
    
    
    
    //========================================================================================================
    // Constructor
    //========================================================================================================
    
    private function __construct(string $siret)
    {
        if (! self::isValueValid($siret)) {
            throw new InvalidArgumentException("The supplied SIRET ($siret) is invalid (it must be ".self::LENGTH." digits long).");
        }
        
        $this->siret = $siret;
    }
    
    
    /**
     * Creates a new instance from the given string.
     */
    public static function fromString(string $siret) : self
    {
        return new self($siret);
    }
    
    
    
    //========================================================================================================
    // Static methods
    //========================================================================================================
    
    /**
     * Returns whether the given value is a valid SIRET number.
     *
     * @param string $siret
     */
    public static function isValueValid($siret) : bool
    {
        if (! is_string($siret)) {
            return false;
        }
        
        return preg_match(self::REGEX, $siret) === 1;
    }
    
    
    
    //========================================================================================================
    // Methods
    //========================================================================================================
    
    public function jsonSerialize()
    {
        return $this->siret;
    }
    
    
    public function __toString() : string
    {
        return $this->siret;
    }
    
    
    public function getSiren() : Siren
    {
        return Siren::fromString(substr($this->siret, 0, 9));
    }
    
    
    public function getNic() : Nic
    {
        return Nic::fromString(substr($this->siret, 9, 5));
    }
    
    
    
}
