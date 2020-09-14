<?php

use App\Connection;
use App\Table\PostTable;
use Valitron\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;

$pdo = Connection::getPDO();

$postTable = new PostTable($pdo);

$post = $postTable->find($params['id']);

$success = false;

$errors = [];

if(!empty($_POST))
{
    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getID());

    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);





    if($v->validate())
    {
        $postTable->update($post);
        $success = true;
    }else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if($_GET['created'] === '1'): ?>
    <div class="alert alert-success">
        Votre article a bien été ajouté.
    </div>
<?php endif ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Veillez vérrifier les informations saisies
    </div>
<?php endif ?>

<?php if($success === true ) :?>

    <div class="alert alert-success">L'article à bien été modifié</div>
<?php endif ?>    

<h1> Editer l'article : <?= $post->getName() ?></h1>

<?php require '_form.php'; ?>
