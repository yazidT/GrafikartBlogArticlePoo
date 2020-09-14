<?php

use App\Connection;
use App\Table\PostTable;
use Valitron\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Model\Post;


$success = false;

$errors = [];

$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));

if(!empty($_POST))
{

    $pdo = Connection::getPDO();

    $postTable = new PostTable($pdo);

    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getID());

    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);





    if($v->validate())
    {
        $postTable->create($post);

        header('location: '.$router->url('admin_post', [ 'id' => $post->getID() ] ) . '?created=1' );
        exit;
    }else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Veillez vérrifier les informations saisies
    </div>
<?php endif ?>

<?php if($success === true ) :?>

    <div class="alert alert-success">L'article à bien été enregistré</div>
<?php endif ?>    

<h1> Creer un nouvle article :</h1>

<?php require '_form.php'; ?>