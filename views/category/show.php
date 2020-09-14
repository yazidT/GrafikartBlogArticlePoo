<?php

use App\Model\Category;
use App\Model\Post;
use App\Connection;
use App\PaginatedQuery;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\URL;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();


$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);


/*
if($category == null)
{
    throw new \Exception('Aucune categorie ne correspond a cet ID');
}
*/


if($category->getSlug() !== $slug )
{
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location: ' . $url);
    exit(); 
}

$title =  'Catégorie: '. $category->getName();
$currentPage = URL::getPositiveInt('page', 1);


[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getID());


$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()])
?>

<h1> <?= e($title) ?></h1>



<div class="row">
    <?php foreach($posts as $post ): ?>
    <div class="col-md-3">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach ?>
</div>
<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>

