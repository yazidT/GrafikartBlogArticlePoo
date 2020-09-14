<?php 

namespace App;


class URL
{
    public static function getInt(string $name, ?int $default = null): ?int
    {
        if(!isset($_GET[$name])) return $default;
        if($default <= 0) return $default;
    
        if(!filter_var($_GET[$name], FILTER_VALIDATE_INT))
        {
            throw new \Exception(" Le paramètre $name n'est pas un entier ");
        }
        return (int)$_GET[$name];
    }

    public static function getPositiveInt(string $name, ?int $default = null): ?int
    {
        $param = self::getInt($name, $default);
        if($param == !null && $param <= 0)
        {
            throw new \Exception("le paramètre $name n'est pas un entier positif ");
        }
        return $param;
    }
}