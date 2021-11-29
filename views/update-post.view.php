<?php ob_start() ?>
<main class="signin__main">
    <h1>Modifier un post</h1>
    <?php if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])): ?>
        <div  class="alert alert-<?= $_SESSION['alert']['type'] ?> container">
            <?= $_SESSION['alert']['msg'] ?>
        </div>
    <?php endif ?>
    <form class="form signin container" action="/update-post" method="post" enctype="multipart/form-data">
        <label class="form__label" for="title">
            <span class="span__label">Votre titre</span>
            <input class="form__input" type="text" name="title" id="title" value="<?= $_POST['title'] ?>">
        </label>
        <label class="form__label" for="message">
            <span class="span__label">Votre titre</span>
            <textarea class="form__input" name="message" id="message" cols="30" rows="10"><?= $_POST['post'] ?></textarea>
        </label>
        <input type="file" name="file" id="file" accept="image/png, image/jpeg, image/gif" value="<?= $_POST['image'] ?>">
        <img width="150" src="../public/img/<?= $_POST['image'] ?>">
        <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
        <button id="submit" class="form__submit form__submit--margin" type="submit">
            <span class="btn--load hidden"></span>
            <span class="btn__text">Envoyer les modifications</span>
        </button>
    </form>
</main>
<?php
$content = ob_get_clean();
$title = "Modifier un post";
require 'template.php';