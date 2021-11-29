<?php ob_start();
$idPost = $post->getId();
$url_img = $post->getUrl_image();
$title = $post->getTitle();
$message = $post->getPost();

/**
 * @param array $elt likes or dislikes 
 * @param int $idPost post id
 * @return string for add this class css
 * @return ternaire
 * checks if the user likes or dislikes the post
 */
function ctrlLike($elt,$idPost) {
    if ($_SESSION['user']['auth'] === 1) {
        $user = $_SESSION['user']['idUser'];
    } else {
        $user = null;
    }

    if (empty($elt[$idPost]) || empty($user)) {
        return "far";
    }
    return in_array($user, $elt[$idPost]) ? "fas" : "far";

}
?>
<main class="main-single">
    <?php if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])): ?>
            <div  class="alert alert-<?= $_SESSION['alert']['type'] ?> container">
                <?= $_SESSION['alert']['msg'] ?>
            </div>
    <?php endif ?>
    <div class="card__single">
        <img class="card__img" src="../public/img/<?= $url_img ?>">
        <div class="card__content">
            <h3 class="card__title"><?= $title ?></h3>
            <p class="card__desc">
            <?= $message ?>
            </p>
            <div class="card__social">
                <a class="card__like" href="/like/<?= $idPost ?>">
                    <?php 
                        if (isset($likes[$idPost])) {
                            echo '<span>' . count($likes[$idPost]) . '</span>';
                        }
                    ?>
                    <i class="<?= ctrlLike($likes,$idPost) ?> fa-thumbs-up"></i>
                </a>
                <a class="card__dislike" href="/dislike/<?= $idPost ?>">
                    <?php 
                        if (isset($dislikes[$idPost])) {
                            echo '<span>' . count($dislikes[$idPost]) . '</span>';
                        }
                    ?>
                    <i class="<?= ctrlLike($dislikes,$idPost) ?> fa-thumbs-down"></i>
                </a>
            </div>
        </div>
    </div>
    <?php if($_SESSION['user']['auth'] === 1): ?>
        <div class="container">
            <h3>Ajouter un commentaire</h3>
            <form class="form" action="/comment/<?= $idPost ?>" method="post">
                <textarea class="form__input" name="message" id="message" cols="30" rows="5" ></textarea>
                <button class="form__submit" type="submit">Envoyer</button>
            </form>
        </div>
    <?php endif ?>
    <?php if(!isset($comments[$idPost])): ?>
        <p class="info">Pas de commentaires pour l'instant</p>
    <?php else: ?>
        <?php foreach($comments[$idPost] as $comment): ?>
            <div class="container">
                <p class="comment__author">Commentaire de : <?= $comment->getPseudo() ?></p>
                <p class="comment__text"><?= $comment->getComment() ?></p>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</main>
<?php
$content = ob_get_clean();
$title = "single post";
require 'template.php';