<?php ob_start();
$title = "Erreur 404";
?>
<main class="page__404">
    <h1><?= $title ?></h1>
    <h2><?= $error ?></h2>
</main>
<?php
$content = ob_get_clean();
require 'template.php';