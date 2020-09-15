<?php
use App\Auth;

use App\Connection;
use App\Table\CategoryTable;
use Valitron\Validator;
use App\HTML\Form;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
use App\Model\Category;

Auth::check();


$router->layouts = 'admin/layouts/default';


$success = false;

$errors = [];

$item = new Category();

if(!empty($_POST))
{

    $pdo = Connection::getPDO();

    $table = new CategoryTable($pdo);

    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $table);

    ObjectHelper::hydrate($item, $_POST, ['name', 'slug']);




    if($v->validate())
    {
        $table->create([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ]);

        header('location: '.$router->url('admin_categories', [ 'id' => $item->getID() ] ) . '?created=1' );
        exit;
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

    <div class="alert alert-success">La catégorie à bien été enregistré</div>
<?php endif ?>    

<h1> Creer un nouvllee categorie :</h1>

<?php require '_form.php'; ?>