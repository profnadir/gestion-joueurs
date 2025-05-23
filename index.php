<?php
    require('connexion.php');
// Ajouter un nouveau joueur
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $nom = htmlspecialchars($_POST["nom"]);
    $age = htmlspecialchars($_POST["age"]);
    $position = htmlspecialchars($_POST["position"]);
    $id_equipe = htmlspecialchars($_POST["id_equipe"]);

    if($nom && $age && $position){
        $sql = "insert into joueurs(nom, age, position, id_equipe) values(?, ?, ?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$nom, $age, $position, $id_equipe])){
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
$sql = "select joueurs.*, equipes.nom as nom_equipe from joueurs 
        inner join equipes 
        on joueurs.id_equipe = equipes.id_equipe";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    die("Error : ".$e->getMessage());
}

// Récupérer la liste des equipes
$sql = "select * from equipes";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);
    $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        Equipe: 
        <select name="id_equipe" id="id_equipe">
            <?php foreach($equipes as $equipe) : ?>
                <option value="<?= $equipe['id_equipe']?>"><?= $equipe['nom']?></option>
            <?php endforeach?>
            
        </select>
        <br>
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
            <th>Equipe</th>
            <th>Actions</th>
        </tr>
        <?php foreach($joueurs as $joueur) :?>
            <tr>
                <td><?= $joueur['nom'] ?></td>
                <td><?= $joueur['age'] ?></td>
                <td><?= $joueur['position'] ?></td>
                <td><?= $joueur['nom_equipe'] ?></td>
                <td>
                    <a href="modifier_joueur.php?id=<?= $joueur['id_joueur'] ?>">Modifier</a>
                    <a href="supprimer_joueur.php?id=<?= $joueur['id_joueur'] ?>"
                        onclick="return confirm('are you sur ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach?>
    </table>
</body>

</html>