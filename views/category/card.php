

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <p class="text-muted"><?= $post->getCreatedAt()->format('d/m/Y') ?>

        </p>
        <p> Catégories::  </p>

            <?php foreach( $post->getCategories() as $category):?>
                <span class="bg-info" style="border-radius: 20%; margin-left:5px"> 
                    <?= $category->getName() ?>
                </span>
            <?php endforeach ?>

            <p><?= $post->getExcerpt() ?></p>
        <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug() ])?>" class="btn btn-primary">voir plus</a>
    </div>
</div>