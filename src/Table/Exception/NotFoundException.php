<?php

namespace App\Table\Exception;

use \Exception;

class NotFoundException extends Exception
{
    public function __construct(string $table, int $id)
    {
        $this->message = "Aucun enregistrement ne corespond à l'id # $id dans la table $table";
    }
}
