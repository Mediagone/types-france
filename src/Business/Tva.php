<?php declare(strict_types=1);

namespace Mediagone\Types\France\Business;

use InvalidArgumentException;
use Mediagone\Types\Common\Geo\Country;
use Mediagone\Types\Common\ValueObject;
use function is_string;
use function preg_match;
use function substr;


/**
 * Represents a French TVA number.
 *
 * The value must match the following format: FRkksssssssss
 *      - starts by "FR"
 *      - <kk> : 2 "key" digits
 *      - <sssssssss> : SIREN number
 */
final class Tva implements ValueObject
{
    //========================================================================================================
    // Constants
    //========================================================================================================
    
    public const LENGTH = 13;
    
    public const REGEX = '#^FR[0-9]{11}$#';
    
    
    
    //========================================================================================================
    // 
    //========================================================================================================
    
    private string $tva;
    
    private string $countryAlpha2;
    
    
    
    //========================================================================================================
    // Constructor
    //========================================================================================================
    
    private function __construct(string $tva)
    {
        if (! self::isValueValid($tva)) {
            throw new InvalidArgumentException("The supplied TVA number ($tva) is invalid (it must follow specific country structure).");
        }
        
        $this->tva = $tva;
        $this->countryAlpha2 = substr($tva, 0, 2);
    }
    
    
    /**
     * Creates a new instance from the given string.
     */
    public static function fromString(string $tva) : self
    {
        return new self($tva);
    }
    
    
    public static function fromSiren(Siren $siren) : self
    {
        $sirenNumber = (int)(string)$siren;
        $key = (12 + 3 * ($sirenNumber % 97)) % 97;
        
        return new self("FR$key$sirenNumber");
    }
    
    
    public static function fromSiret(Siret $siret) : self
    {
        return self::fromSiren($siret->getSiren());
    }
    
    
    
    //========================================================================================================
    // Static methods
    //========================================================================================================
    
    /**
     * Returns whether the given value is a valid NIC number.
     *
     * @param string $tva
     */
    public static function isValueValid($tva) : bool
    {
        if (! is_string($tva)) {
            return false;
        }
        
        return preg_match(self::REGEX, $tva) === 1 && self::checkKey($tva);
    }
    
    
    
    //========================================================================================================
    // Methods
    //========================================================================================================
    
    public function jsonSerialize()
    {
        return $this->tva;
    }
    
    
    public function __toString() : string
    {
        return $this->tva;
    }
    
    
    public function getCountry() : Country
    {
        return Country::fromAlpha2($this->countryAlpha2);
    }
    
    
    
    //========================================================================================================
    // Helper Methods
    //========================================================================================================
    
    private static function checkKey(string $tva) : bool
    {
        $key = substr($tva, 2, 2);
        $siren = substr($tva, 4, 9);
        $computedKey = (12 + 3 * ($siren % 97)) % 97;
        
        return $key === (string)$computedKey;
    }
    
    
    
}
