<?php 
    require('connexion.php');

    $id = htmlspecialchars($_GET["id"]);

    if($id){
        //tester if joueur existe
        $sql = "select * from joueurs where id_joueur = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $joueur = $stmt->fetch();
            if($joueur){

                // supprimer le joueur

                $sql = "delete from joueurs where id_joueur = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                //$success = "joueur supprimé avec succès";
                header("Location: index.php");
            }else {
                $error = "joueur n'existe pas !!" ?? "";
            }

        } catch (\PDOException $e) {
            die("Error : ".$e->getMessage());
        }
    }else{
        $error = "il faut spécifier le joueur" ?? "";
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
</body>
</html>