<?php
use App\Auth;

use App\Connection;
use App\Table\CategoryTable;
use Valitron\Validator;
use App\HTML\Form;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
Auth::check();


$router->layouts = 'admin/layouts/default';

$pdo = Connection::getPDO();

$table = new CategoryTable($pdo);

$item = $table->find($params['id']);

$success = false;

$errors = [];

$fields= ['name',  'slug'];

if(!empty($_POST))
{
    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $table, $item->getID());

    ObjectHelper::hydrate($item, $_POST, $fields);





    if($v->validate())
    {
        $table->update([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ], $item->getID());
        $success = true;
    }else {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors);
?>



<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Veillez vérrifier les informations saisies
    </div>
<?php endif ?>

<?php if($success === true ) :?>

    <div class="alert alert-success">L'article à bien été modifié</div>
<?php endif ?>    

<h1> Editer la catégorie : <?= $item->getName() ?></h1>

<?php require '_form.php'; ?>
