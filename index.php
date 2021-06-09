<?php
require_once 'auth.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=gsbfrais', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET utf8',
    ]);

    $query = "SELECT * from utilisateur";
    $params = [];
} catch (PDOException $e) {
    $pdoError = $e->getMessage();
}

if (!empty($_GET['ville'])) {
    $query .= " WHERE ville LIKE :ville";
    $params['ville'] = '%' . $_GET['ville'] . '%';
}


if (!empty($_GET['selectFilter']) && !empty($_GET['inputFilter'])) {
    $query .= " WHERE " . $_GET['selectFilter']. " LIKE :".$_GET['selectFilter'];
    $params[$_GET['selectFilter']] = '%' . $_GET['inputFilter'] . '%';
   
}

$statement = $pdo->prepare($query);
$statement->execute($params);
$visiteurs = $statement->fetchAll();


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="app.js" defer></script>
    <title>Les visiteurs médicaux</title>
</head>

<body class="p-4">

    <?php if (isset($pdoError)) : ?>
        <div class="alert alert-danger">
            <?= $pdoError ?>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-between">
        <h2>Tous les visiteurs médicaux</h2>

        <?php if (!is_connect()) : ?>
            <a class="btn btn-primary mb-4" href="login.php">Se connecter en tant qu'administrateur</a>
        <?php else : ?>
            <a class="btn btn-danger mb-4" href="logout.php">Deconnexion</a>
        <?php endif ?>
    </div>


    <form action="" method="get">
        <div class="form-group">
            <input type="text" name="ville" class="form-control mb-2" placeholder="Insérer une ville">
        </div>
        <button class="btn btn-primary mb-2">Rechercher la ville</button>
    </form>
    <button class="btn btn-primary mb-4" onclick="showSelection();">Rechercher par un autre critère</button>

    <form action="" method="get" class="hidden" id="formSelect">
        <select onchange="yesnoCheck(this);" id="selectFilter" style="display: block;" class="mb-4" name="selectFilter">
            <option value="none" disabled selected>Rechercher les critères</option>
            <option libelle="un id" value="id">ID</option>
            <option libelle="un nom" value="nom">Nom</option>
            <option libelle="un prenom" value="prenom">Prenom</option>
            <option libelle="une adresse" value="adresse">Adresse</option>
            <option libelle="un code postal" value="cp">Code postal</option>
            <option libelle="une date d'embauche" value="dateEmbauche">dateEmbauche</option>
            <option libelle="un rôle" value="role">Rôle</option>
        </select>

        <div class="form-group hidden" id="filterItem">
            <input type="text" id="selectedFilter" class="form-control mb-2" name="inputFilter">
        </div>

        <button class="btn btn-primary hidden mb-4" id="searchFilter">Rechercher</button>
    </form>


    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Prenom</th>
                <?php if (is_connect()) : ?>
                    <th scope="col">Login</th>
                    <th scope="col">Mot de passe</th>
                <?php endif ?>
                <th scope="col">Adresse</th>
                <th scope="col">Code postal</th>
                <th scope="col">Ville</th>
                <th scope="col">dateEmbauche</th>
                <th scope="col">Role</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($visiteurs as $unVisiteur) : ?>
                <tr>
                    <th scope="row"><?= htmlentities($unVisiteur['id']) ?></th>
                    <td><?= htmlentities($unVisiteur['nom']) ?></td>
                    <td><?= htmlentities($unVisiteur['prenom']) ?></td>
                    <?php if (is_connect()) : ?>
                        <td><?= htmlentities($unVisiteur['login']) ?></td>
                        <td><?= htmlentities($unVisiteur['mdp']) ?></td>
                    <?php endif ?>
                    <td><?= htmlentities($unVisiteur['adresse']) ?></td>
                    <td><?= htmlentities($unVisiteur['cp']) ?></td>
                    <td><?= htmlentities($unVisiteur['ville']) ?></td>
                    <td><?= htmlentities($unVisiteur['dateEmbauche']) ?></td>
                    <td><?= htmlentities($unVisiteur['role']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>