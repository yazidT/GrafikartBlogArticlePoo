<?php

namespace App;

use \PDO;


class Connection 
{
    public static function getPDO()
    {
        return new PDO('mysql:dbname=jawhar;host=127.0.0.1', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

}