<?php ob_start(); ?>
<main class="signin__main">
    <h1>Mes informations</h1>
    <?php if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])): ?>
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> container">
            <?= $_SESSION['alert']['msg'] ?>
        </div>
    <?php endif ?>
    <form action="/updateUser" class="form signin container" method="post">
        <label class="form__label" for="pseudo">
            <span class="span__label">Votre pseudo</span>
            <input class="form__input" type="text" name="pseudo" id="pseudo" value="<?= htmlentities($_SESSION['user']['pseudo']) ?>">
        </label>
        <label class="form__label" for="email">
            <span class="span__label">Votre email</span>
            <input class="form__input" type="email" name="email" id="email" value="<?= htmlentities($_SESSION['user']['email']) ?>">
        </label>
        <button class="form__submit" type="submit">Modifier mon compte</button>
    </form>
</main>
<?php
$content = ob_get_clean();
$title = "Mes informations";
require 'template.php';
?>