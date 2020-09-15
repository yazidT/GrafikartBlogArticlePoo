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


    public function updatePost(Post $post): void
    {
        $this->update([
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'slug' => $post->getSlug(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            'id' => $post->getID()
        ], $post->getID());
        
            
    }

    public function createPost(Post $post): void
    {
        $id = $this->create([
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'slug' => $post->getSlug(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        $post->setID($id);

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