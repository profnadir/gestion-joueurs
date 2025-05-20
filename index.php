<?php
    require('connexion.php');
// Ajouter un nouveau joueur
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $nom = htmlspecialchars($_POST["nom"]);
    $age = htmlspecialchars($_POST["age"]);
    $position = htmlspecialchars($_POST["position"]);

    if($nom && $age && $position){
        $sql = "insert into joueurs(nom, age, position) values(?, ?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$nom, $age, $position])){
                $success = "joueur ajouté avec succès";
            }else {
                $error = "erreur lors de l'ajout" ?? "";
            }

        } catch (\PDOException $e) {
            die("Error : ".$e->getMessage());
        }
    }else{
        $error = "tous les champs sont obligatoires" ?? "";
    }
}

// Récupérer la liste des joueurs
$sql = "select * from joueurs";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    die("Error : ".$e->getMessage());
}

$pdo=null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des joueurs</title>
</head>

<body>
    <h1>Gestion des joueurs</h1>
    <h2>Ajouter un joueur</h2>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
        Nom: <input type="text" name="nom" required><br>
        Âge: <input type="number" name="age" required><br>
        Position: <input type="text" name="position" required><br>
        <input type="submit" name="ajouter_joueur" value="Ajouter joueur">
    </form>
    <?php echo !empty($error) ? $error : "" ?>
    <?php echo !empty($success) ? $success : "" ?>
    <h2>Liste des joueurs</h2>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Âge</th>
            <th>Position</th>
            <th>Actions</th>
        </tr>
        <?php foreach($joueurs as $joueur) :?>
            <tr>
                <th><?= $joueur['nom'] ?></th>
                <th><?= $joueur['age'] ?></th>
                <th><?= $joueur['position'] ?></th>
                <th>
                    <a href="modifier_joueur.php?id=<?= $joueur['id_joueur'] ?>">Modifier</a>
                    <a href="supprimer_joueur.php?id=<?= $joueur['id_joueur'] ?>"
                        onclick="return confirm('are you sur ?')">Supprimer</a>
                </th>
            </tr>
        <?php endforeach?>
    </table>
</body>

</html>