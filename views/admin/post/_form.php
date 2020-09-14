<form action="" method="post">

    <?= $form->input('name','Le titre') ?>
    <?= $form->input('slug','L\'URL') ?>
    <?= $form->textarea('content','Le contenu') ?>
    <?= $form->input('created_at','La date') ?>

    <!-- <div class="form-group">

        <label for="content">Nom de l'aricle</label>
        <input class="form-control" type="text" name="content" value="<?= e($post->getContent()) ?>">
    </div> -->
    <button class="btn btn-primary mt-5">
    <?php if($post->getID() !== null): ?>
        Modifier
    <?php else : ?>
        Créer
    <?php endif ?>    
    </button>
</form>