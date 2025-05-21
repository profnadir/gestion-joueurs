<?php 
require('connexion.php');

$sql="create table if not exists equipes(id_equipe int unsigned not null auto_increment primary key,nom varchar(100) not null)";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (\PDOException $e) {
    die("error : ". $e->getMessage());
}

/* $sql="insert into equipes(nom) values('wac'),('rca'),('asfar')";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (\PDOException $e) {
    die("error : ". $e->getMessage());
} */

$sql="ALTER TABLE joueurs
        ADD COLUMN id_equipe INT unsigned,
        ADD CONSTRAINT fk_joueur_equipe FOREIGN KEY (id_equipe) REFERENCES equipes(id_equipe) ON DELETE SET NULL;";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (\PDOException $e) {
    die("error : ". $e->getMessage());
}