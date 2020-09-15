<?php

namespace App\Table;


use App\Model\Category;
use App\Model\Post;
use App\Table\Exception\NotFoundException;
use \PDO;


// Classe finale n'a pas vocartion  a etre héritée
final class CategoryTable extends Table
{
    protected $class = Category::class;
    
    protected $table = 'category';

    /**
     * @params Post[]
     */
    public function fillPosts(array $posts): void
    {
        $postsByID = [];
        foreach ($posts as $post)
        {
            $postsByID[$post->getID()] = $post;
        }
        $categories = $this->pdo->query('SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN ('. implode(',', array_keys($postsByID)).')'
        )->fetchAll(PDO::FETCH_CLASS, Category::class);
        foreach($categories as $category)
        {
            foreach($posts as $post)
            {
                if($category->getPostID() == $post->getID())
                {
                    $post->setCategories($category) ;
                }
            }
        }

        
    }


    public function all ()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }


    // public function create(Category $category): void
    // {
    //     $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name = :name, slug = :slug");
    //     $result = $query->execute([
    //         'name' => $category->getName(),
    //         'slug' => $category->getSlug(),
    //     ]);
    //     if($result === false)
    //     {
    //         throw new \Exception("Creation de la categorie inpossible");
    //     }    
    //     $category->setID($this->pdo->lastInsertId());
            
    // }

    // public function delete(int $id): void
    // {
    //     $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id= ?");
    //     $result = $query->execute([$id]);
    //     if($result === false)
    //     {
    //         throw new \Exception("la catégorie n° $id n'exisste pas:: Suppression inpossible");
    //     }    
            
    // }

    // public function update(Category $category): void
    // {
    //     $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name,  slug = :slug WHERE id= :id");
    //     $result = $query->execute([
    //         'name' => $category->getName(),
    //         'slug' => $category->getSlug(),
    //         'id' => $category->getID()
    //     ]);
    //     if($result === false)
    //     {
    //         throw new \Exception("la categorie ° {$category['id']} n'exisste pas:: Modification inpossible");
    //     }    
            
    // }

}