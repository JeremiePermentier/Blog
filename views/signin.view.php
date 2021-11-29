<?php ob_start() ?>
<main class="signin__main">
    <h1>Connexion à mon compte</h1>
    <?php if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])): ?>
        <div  class="alert alert-<?= $_SESSION['alert']['type'] ?> container">
            <?= $_SESSION['alert']['msg'] ?>
        </div>
    <?php endif ?>
    <form class="form signin container" action="findUser" method="post">
        <label class="form__label" for="email">
            <span class="span__label">Votre email <span class="form__alert">*</span></span>
            <input class="form__input" type="email" name="email" id="email" required>
        </label>
        <label class="form__label" for="password">
            <span class="span__label">Votre mot de passe <span class="form__alert">*</span></span>
            <input class="form__input" type="password" name="password" id="password" minlength="5" maxlength="200" required>
        </label>
        <button id="submit" class="form__submit" type="submit">
            <span class="btn--load hidden"></span>
            <span class="btn__text">Se connecter</span>
        </button>
        <div class="form__info">
            <p>Les champs avec <span class="form__alert">*</span> sont obligatoires</p>
            <a class="form__link" href="creer-un-compte">Je n'ai pas de compte</a>
        </div>
    </form>
</main>
<?php
$content = ob_get_clean();
$title = "Connexion";
require 'template.php';
?>