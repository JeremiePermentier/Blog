<?php ob_start() ?>
<main class="signin__main">
    <h1>Création d'un compte</h1>
    <?php if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])): ?>
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> container">
            <?= $_SESSION['alert']['msg'] ?>
        </div>
    <?php endif ?>
    <form class="form signin container" action="sendUsers" method="post">
        <label class="form__label" for="pseudo">
            <span class="span__label">Votre pseudo <span class="form__alert">*</span></span>
            <input class="form__input" type="text" name="pseudo" id="pseudo" minlength="5" maxlength="25" required>
        </label>
        <label class="form__label" for="email">
            <span class="span__label">Votre email <span class="form__alert">*</span></span> 
            <input class="form__input" type="email" name="email" id="email" required>
        </label>
        <label class="form__label" for="password">
            <span class="span__label">Votre mot de passe <span class="form__alert">*</span></span>
            <input class="form__input" type="password" name="password" id="password" minlength="5" maxlength="200" required> 
        </label>
        <label class="form__label" for="confirm_password">
            <span class="span__label">Confirmation du mot de passe <span class="form__alert">*</span></span>
            <input class="form__input" type="password" name="confirm_password" id="confirm_password" minlength="5" maxlength="200" required>
        </label>
        <button id="submit" class="form__submit" type="submit">
            <span class="btn--load hidden"></span>
            <span class="btn__text">S'inscrire</span>
        </button>
        <div class="form__info">
            <p>Les champs avec <span class="form__alert">*</span> sont obligatoires</p>
            <a class="form__link" href="se-connecter">J'ai déjà un compte</a>
        </div>
    </form>
</main>
<?php
$content = ob_get_clean();
$title = "Inscription";
require 'template.php';
?>