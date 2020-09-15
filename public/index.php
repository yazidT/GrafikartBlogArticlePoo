<?php 
require '../vendor/autoload.php';
use \App\Router;

define('DEBUG_TIME', microtime(true)); // constante générée au début du script


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//sleep(1); // permet de ralentir le temps d'une seconde



// gestionnaire d'url

if(isset($_GET['page']) && $_GET['page'] === '1')
{
    //réecrir l'url dans le parametre page
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    
    $query = http_build_query($get);
    if(!empty($query))
    {
        $uri = $uri . '?' . $query;
    }
    http_response_code(301);
    header('location: ' . $uri);
    exit(); 
}







$router = new Router(dirname(__DIR__).'/views');

$router // LA methode Fluent nous perment le chainage des methodes
    ->get('/', 'post/index', 'home')
    ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    /**
     * Admin 
     * Gestion des articles
     */
    ->get('/admin', 'admin/post/index', 'admin_posts')
    ->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post')
    ->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete')
    ->match('/admin/post/new', 'admin/post/new', 'admin_post_new')
    /**
     * Admin 
     * Gestion des catégories
     */
    ->get('/admin/categories', 'admin/category/index', 'admin_categories')
    ->match('/admin/category/[i:id]', 'admin/category/edit', 'admin_category')
    ->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete')
    ->match('/admin/category/new', 'admin/category/new', 'admin_category_new')
    ->run();

/*
   
$router = new AltoRouter();



define('VIEW_PATH', dirname(__DIR__).'/views');

$router->map('GET', '/blog', function(){
    require VIEW_PATH . '/post/index.php';
});

$router->map('GET', '/blog/category', function(){
    require VIEW_PATH . '/category/show.php';
});
 
$match = $router->match();
$match['target']();

 */