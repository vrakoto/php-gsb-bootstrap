<?php
require_once 'auth.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=gsbfrais', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET utf8',
    ]);

    $query = $pdo->query('SELECT * from utilisateur WHERE role = "C"');
    $comptables = $query->fetchAll();
    $errors = [];

} catch (PDOException $e) {
    $pdoError = $e->getMessage();
}

if (isset($_POST['login'], $_POST['password'])) {
    $login = htmlentities($_POST['login']);
    $password = htmlentities($_POST['password']);

    foreach ($comptables as $unComptable) {
        if ($login === $unComptable['login'] && $password === $unComptable['mdp']) {
            session_start();
            $_SESSION['admin'] = 1;
            header('Location: index.php');
            exit();
        } else {
            $errors['authentification'] = "Les identifiants ne sont pas correct";
        }
    }
}

?>

<?php
    if (is_connect()) {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Se connecter en tant qu'admin</title>
</head>
<body class="p-4">
    
    <?php if (isset($errors['authentification'])): ?>
        <div class="alert alert-danger">
            <?= $errors['authentification'] ?>
        </div>
    <?php endif ?>

    <h2>Se connecter en tant qu'administrateur</h2>
    <p>L'administrateur a accès aux identifiants des visiteurs</p>
    <form action="" method="post" class="form-group">
        <input type="text" name="login" class="form-control mb-4" placeholder="Insérer l'identifiant">
        <input type="password" name="password" class="form-control mb-4" placeholder="Insérer le mot de passe">
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

</body>
</html>