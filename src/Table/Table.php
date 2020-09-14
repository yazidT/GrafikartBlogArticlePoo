<?php

namespace App\Table;
use \PDO;
use App\Table\Exception\NotFoundException;
use Exception;

// Classe abstraisre ne sert qu'a faire des enfants et n'a pas vocartion  a etre instanciée

abstract class Table
{

    protected $pdo;

    protected $table = null;

    protected $class = null;

    public function __construct(PDO $pdo)
    {
        if($this->class === null)
        {
            throw new Exception('la classe '. get_class($this).' n\'a pas été précisée');
        }
        $this->pdo = $pdo;
    }


    public function find(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM '.$this->table.' WHERE id = :id');
        $query->execute(['id' => $id ]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result =  $query->fetch();
        
        if($result === false)
        {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /**
     *  vérifie si une valeu existe dans la table
     * @param string $field champs à rechercher
     * @param mixed $value Valeur associée au champs
     */
    public function exists(string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WhERE $field = ?";
        $params = [$value];
        if($except !== null){
            $sql .= " AND id != ?";
            $params[] = $except; 
        }

        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
 
    }

}