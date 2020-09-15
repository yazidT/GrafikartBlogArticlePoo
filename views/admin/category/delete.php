<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();



$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
$table->delete($params['id']);

header('location: ' . $router->url('admin_categories') . '?delete=1');
exit;
 
?>
<h1>Supression de l'article n° <?= $params['id'] ?></h1>