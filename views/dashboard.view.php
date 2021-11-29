<?php ob_start()?>
<main>
    <div class="panels">
        <div class="panel__card">
            <a href="dashboard/ajouter-un-post"><i class="fas fa-plus fa-2x"></i></a>
        </div>
        <div class="panel__card">
            <a href="dashboard/mes-informations"><i class="fas fa-user fa-2x"></i></a>
        </div>
    </div>
    <form action="/dashboard" class="container dashboard" method="post">
        <select name="table" id="table" class="dashboard__input">
            <option value="posts" >Mes messages</option>
            <option value="comment" >Mes commentaires</option>
            <?php if($_SESSION['user']['role'] === "admin"): ?>
                <option value="users">Voir les utilisateurs</option>
                <option value="users-posts">Voir tous les messages</option>
                <option value="users-comments">Voir tous les commentaires</option>
            <?php endif ?>
        </select>
        <button class="form__submit" type="submit">Envoyer</button>
    </form>
    <div class="container__table">
        <h1>
            <?php
                if (isset($_POST['table'])){
                    switch($_POST['table']) {
                        case "posts": echo "Mes messages";
                        break;
                        case "comment": echo "Mes commentaires";
                        break;
                        case "users": echo "Les utilisateurs";
                        break;
                        case "users-posts": echo "Tous les messages";
                        break;
                        case "users-comments": echo "Tous les commentaires";
                        break;
                    }
                } else {
                    echo "Mes messages";
                }
        
            ?>
        </h1>
        <?php  if(count($table[0]->getData()) === 0): ?>
            <p class="info">
            <?php
                if (isset($_POST['table'])){
                    switch($_POST['table']) {
                        case "posts": echo "Vous n'avez pas de messages";
                        break;
                        case "comment": echo "Vous n'avez pas de commentaires";
                        break;
                        case "users": echo "Aucun utilisateur";
                        break;
                        case "users-posts": echo "Aucun message des utilisateurs";
                        break;
                        case "users-comments": echo "Aucun commentaire des utilisateurs";
                        break;
                    }
                } else {
                    echo "Vous n'avez pas de messages";
                }
        
            ?>
            </p>
        <?php else: ?>
            <?php if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])): ?>
            <div  class="alert alert-<?= $_SESSION['alert']['type'] ?>">
                <?= $_SESSION['alert']['msg'] ?>
            </div>
            <?php endif ?>
            <table>
            <thead>
                <tr>
                    <?php foreach($table[0]->getCols() as $col): ?>
                        <th><?= $col['Field'] ?></th>
                    <?php endforeach ?>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($table[0]->getData() as $data): ?>
                    <tr>
                        <?php for($i = 0; $i < count($data); $i++): ?>
                            <?php 
                                if($table[0]->getCols()[$i]['Field'] === "url_image") {
                                    echo "<td><img class='dashboard__img' src='../public/img/" . $data[$i] . "?>'></td>";
                                } else {
                                    echo "<td>" . $data[$i] . "</td>";
                                }  
                            ?>
                        <?php endfor ?>
                        <td class="dashboard__action">
                            <?php foreach($table[0]->getActions() as $action): ?>
                            <?php if($action === "Supprimer"): ?>
                                <form action="<?= $_SESSION['action'] ?>/delete/<?= $data[0] ?>" method="post"><button type="submit" class="form__submit"><i class="far fa-trash-alt"></i></button></form>
                            <?php elseif($action === "Modifier"): ?>
                            <form action="/dashboard/modifier-un-post" method="post">
                                <input type="hidden" name="id" value="<?= $data[0] ?>">
                                <input type="hidden" name="title" value="<?= $data[2] ?>">
                                <input type="hidden" name="post" value="<?= $data[3] ?>">
                                <input type="hidden" name="image" value="<?= $data[4] ?>">
                                <button type="submit" class="form__submit"><i class="fas fa-edit"></i></button>
                            </form>
                            <?php endif ?>
                            <?php endforeach ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php  endif; ?>
    </div>
</main>
<?php
$content = ob_get_clean();
$title = "Mon tableau de bord";
require 'template.php';