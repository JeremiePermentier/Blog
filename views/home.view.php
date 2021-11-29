<?php ob_start() ?>
<?php if(!empty($posts)): ?>
    <main>
    <?php for($i=0; $i < count($posts); $i++): ?>
        <a class="link-container" href="post/<?= $posts[$i]->getId(); ?>">
        <div class="card">
            <img class="card__img" src="../public/img/<?= $posts[$i]->getUrl_image(); ?>">
            <div class="card__content">
                <p class="card__author">Post de : <?= $posts[$i]->getPseudo() ?></p>
                <h3 class="card__title"><?= $posts[$i]->getTitle(); ?></h3>
                <p class="card__desc">
                <?= $posts[$i]->getPost(); ?>
                </p>
                <p class="card__link">Voir plus</p>
            </div>
        </div>
        </a>
    <?php endfor ?>
    </main>
    <?= $test = password_hash("adminadmin", PASSWORD_DEFAULT) ?>
    <?= password_verify($test, "admindmin") ?>
<?php else: ?>
    <h1>Soyez le premier à ajouter du contenu</h1>
<?php endif; ?>
<?php
$content = ob_get_clean();
$title = "Page d'acceuil";
require 'template.php';
?>