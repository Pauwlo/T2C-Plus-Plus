<?php

require_once 'Utils/Endpoint.php';

class Validation
{
    public static function sanitizeInteger(int $i) : int
    {
        return filter_var($i, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanitizeString(string $s) : string
    {
        return filter_var($s, FILTER_SANITIZE_STRING);
    }


    public static function validateBoolean(string $s) : bool
    {
        return filter_var($s, FILTER_VALIDATE_BOOLEAN);
    }

    public static function validateBooleanAsString(string $s) : bool
    {
        return $s == 'false' || $s == 'true';
    }
    

    public static function validatePassword(string $s) : bool
    {
        return (strlen($s) == 64) && (preg_match('/[0-9a-f]{64}/', $s));
    }
    
    public static function validateStop(string $s) : bool
    {
        return Endpoint::stopExists($s);
    }

    public static function validateDirection(string $s) : bool
    {
        return Endpoint::directionExists($s);
    }

    public static function validateFormat(string $s) : bool
    {
        $directions = [
            'default',
            'french'
        ];

        return in_array($s, $directions);
    }
}
