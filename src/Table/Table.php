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

    public function all ()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

    public function delete(int $id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $result = $query->execute([$id]);
        if($result === false)
        {
            throw new \Exception("l'enregistrement n° $id n'exisste :: Suppression inpossible");
        }    
            
    }

    public function create(array $data): int
    {
        $sqlFields = [];
        foreach( $data as $key => $value)
        {
            $sqlFields[] = "$key = :$key"; 
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET ". implode(', ', $sqlFields));
        $result = $query->execute($data);
        if($result === false)
        {
            throw new \Exception("Creation d'article inpossible");
        }    
        return (int)$this->pdo->lastInsertId();
            
    } 

    public function update(array $data, $id)
    {
        $sqlFields = [];
        foreach( $data as $key => $value)
        {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET ". implode(', ', $sqlFields). " WHERE id = :id");
        $result = $query->execute(array_merge( $data, ['id' => $id]));
        if($result === false)
        {
            throw new \Exception("Mise a jour inpossible");
        }    
            
    }

}