<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;


Auth::check();

$title = "Gestion des catégories";

$pdo = Connection::getPDO();

$items = (new CategoryTable($pdo))->all();

$router->layouts = 'admin/layouts/default';

$link = $router->url('admin_categories');


?>
<?php if(isset($_GET['delete'])): ?>
<div class="alert alert-success">l'enregistrement a bien été supprimé</div>
<?php endif ?>    
<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>Titre</th>
        <th>
                
                <a  class="btn btn-success" href="<?= $router->url('admin_category_new') ?>"> ajouer une catégorie</a>    
        
        </th>
    </thead>
    <tbody>
        <?php foreach($items as $item): ?>
            <tr>
                <td><?= $item->getID() ?></td>

                <td>
                    <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?>">
                    <?= e($item->getName()) ?>
                    </a>
                </td>
                <td>
                    <p>
                    <?= $item->getSlug() ?>
                    </p>
                </td>
                <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?>" class="btn btn-primary"> Editer </a>
                <form style="display: inline;" method="POST" action="<?= $router->url('admin_category_delete', ['id' => $item->getID()]) ?>" onconfirm="return confirm('Voulez vous vraiment supprimer cet article')"> 
                
                    <button type="submit" class="btn btn-danger"> Supprimer</button>    
            
                </form>

                </td>
            </tr>    
        <?php endforeach ?>
    </tbody>
</table>

