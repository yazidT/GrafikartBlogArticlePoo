<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$post =(new PostTable($pdo))->find($id);

(new CategoryTable($pdo))->fillPosts([$post]);

if($post->getSlug() !== $slug )
{
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location: ' . $url);
    exit(); 
}



?>


<h1><?= e($post->getName()) ?></h1>
<p class="text-muted"><?= $post->getCreatedAt()->format('d/m/Y') ?></p>
<?php foreach($post->getCategories() as $category): ?>
    <a class="btn btn-outline-primary" href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"><?= e($category->getName()) ?> </a>

<?php endforeach ?>    

<p><?= $post->getFormattedContent() ?></p>



