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

}