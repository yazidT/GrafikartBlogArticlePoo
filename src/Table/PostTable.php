<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post; 
use App\Model\Category; 
use App\Table\Exception\NotFoundException;
use App\URL;
use Exception;
use \PDO;


// Classe finale n'a pas vocartion  a etre hérité

final class PostTable extends Table
{


    protected $class = Post::class;

    protected $table = 'post';


    public function update(Post $post): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, content = :content, slug = :slug, created_at = :date WHERE id= :id");
        $result = $query->execute([
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'slug' => $post->getSlug(),
            'date' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            'id' => $post->getID()
        ]);
        if($result === false)
        {
            throw new \Exception("l'article n° {$post['id']} n'exisste pas:: Modification inpossible");
        }    
            
    }

    public function create(Post $post): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name = :name, content = :content, slug = :slug, created_at = :date");
        $result = $query->execute([
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'slug' => $post->getSlug(),
            'date' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
        if($result === false)
        {
            throw new \Exception("Creation d'article inpossible");
        }    
        $post->setID($this->pdo->lastInsertId());
            
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id= ?");
        $result = $query->execute([$id]);
        if($result === false)
        {
            throw new \Exception("l'article n° $id n'exisste pas:: Suppression inpossible");
        }    
            
    }
    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);

        // permet de ne pas stocker dans une variablle vue que le retour  = void

        (new CategoryTable($this->pdo))->fillPosts($posts);

        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID)
    {
        $paginatedQuery = new PaginatedQuery("
        SELECT p.* FROM {$this->table} p 
        JOIN post_category pc ON pc.post_id = p.id
        WHERE pc.category_id ={$categoryID}
        ORDER BY created_at DESC ",
        "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}"
        );
        $posts = $paginatedQuery->getItems(Post::class);

        // permet de ne pas stocker dans une variablle vue que le retour  = void

        (new CategoryTable($this->pdo))->fillPosts($posts);

        
        return [$posts, $paginatedQuery];
        
    }



}