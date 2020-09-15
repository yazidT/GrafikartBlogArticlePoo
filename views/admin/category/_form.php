<form action="" method="post">

    <?= $form->input('name','Le titre') ?>
    <?= $form->input('slug','L\'URL') ?>

    <button class="btn btn-primary mt-5">
    <?php if($item->getID() !== null): ?>
        Modifier
    <?php else : ?>
        Créer
    <?php endif ?>    
    </button>
</form>