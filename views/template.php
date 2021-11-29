<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" 
    integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../public/css/normalize.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/body.css">
    <link rel="stylesheet" href="../public/css/components.css">
    <link rel="stylesheet" href="../public/css/font.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <script src="../public/js/app.js" async></script>
</head>
<body>
    <div id="loader" class="lds"><div></div><div></div><div></div></div>
    <header>
        <nav class="nav">
            <a class="nav__brand" href="../index.php">Mini Blog</a>
            <button class="nav__button" id="nav__button">
                <i class="fas fa-user"></i>
            </button>
            <div class="nav__subMenu">
                <?php if(isset($_SESSION['user']) && $_SESSION['user']['auth'] === 0): ?>
                    <a href="/se-connecter">Me connecter</a>
                    <a href="/creer-un-compte">Créer un compte</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user'])  && $_SESSION['user']['auth'] === 1): ?>
                    <a href="/dashboard">Tableau de bord</a>
                    <a href="/logout">Déconnexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <?= $content ?>
</body>
</html>