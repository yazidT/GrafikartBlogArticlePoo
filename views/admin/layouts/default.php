<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="#" class="navbar-brand">Jawher Al Islam</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a href="<?=  $router->url('admin_posts') ?>" class="nav-link">Articles</a></li>
            <li class="nav-item"><a href="<?=  $router->url('admin_categories') ?>" class="nav-link">Catégories</a></li>
        </ul>
    </nav>
    <div class="container mt-4">


    <!-- //////////////  LA variable de la vue  /////////////  --> 
    <?= $content ?>



    </div>

    <footer class="bg-light py-4 footer mt-auto">

        <div class="container">
            <?php if(defined('DEBUG_TIME')):?>
            page générée en : <?= round(1000 *(microtime(true) - DEBUG_TIME))  // variable générée en fin du script?>  ms
            <?php endif?>
        
        
        </div>
    </footer>
    
</body>
</html>