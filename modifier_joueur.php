<?php 
    require('connexion.php');

    $id = htmlspecialchars($_GET["id"]);

    if($id){
        //tester if joueur existe
        $sql = "select * from joueurs where id_joueur = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $joueur = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$joueur){
                $error = "joueur n'existe pas !!" ?? "";
            }

        } catch (\PDOException $e) {
            die("Error : ".$e->getMessage());
        }
    }else{
        $error = "il faut spécifier le joueur" ?? "";
    }

    // Modifier un joueur
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $nom = htmlspecialchars($_POST["nom"]);
        $age = htmlspecialchars($_POST["age"]);
        $position = htmlspecialchars($_POST["position"]);

        if($nom && $age && $position){
            $sql = "update joueurs set nom = ?, age = ?, position = ? where id_joueur= ?";
            try {
                $stmt = $pdo->prepare($sql);
                if($stmt->execute([$nom, $age, $position, $id])){
                    //$success = "joueur modifié avec succès";
                    header("Location: index.php");

                }else {
                    $error = "erreur lors de la modification" ?? "";
                }

            } catch (\PDOException $e) {
                die("Error : ".$e->getMessage());
            }
        }else{
            $error = "tous les champs sont obligatoires" ?? "";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo !empty($error) ? $error : "" ?>
    <?php echo !empty($success) ? $success : "" ?>
    <h1>Gestion des joueurs</h1>
    <h2>Modifier un joueur</h2>
    <form  method="post">
        Nom: <input type="text" name="nom" value="<?= isset($joueur['nom']) ? $joueur['nom'] : "" ?>" required><br>
        Âge: <input type="number" name="age" value="<?= isset($joueur['age']) ? $joueur['age'] : "" ?>" required><br>
        Position: <input type="text" name="position" value="<?= isset($joueur['position']) ? $joueur['position'] : "" ?>" required><br>
        <input type="submit" name="modifier_joueur" value="Modifier joueur">
    </form>
</body>
</html>