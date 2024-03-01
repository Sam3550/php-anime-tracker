<?php
include '../../partials/header.php';
include '../../partials/menu.php';
include '../../inc/functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    global $dbh;
    

    $sql = "INSERT INTO Duree(label) VALUES (:duration)";
    $data = ['duration' => $_POST['duration']];
    $sth = $dbh->prepare($sql);
    $sth->execute($data);

    $sql = "INSERT INTO `Anime` (`nom`, `episode_nb`, `note`, `img`, duration_id, `type_id`, `statut_id`) 
            VALUES (:nom, :episode_nb, :note, :img,  LAST_INSERT_ID() , :type_id, :statut_id);";
    $data = [
        "nom" => $_POST["nameAnime"] ?? null,
        "episode_nb" => $_POST["nombre_episodes"],
        "note" => $_POST["note"],
        "img" => $_POST["img"],
        "type_id" => $_POST["typeAnime"],
        "statut_id" => $_POST["statusAnime"]
    ];

    $sth = $dbh->prepare($sql);
    try {
        $is_successful = $sth->execute($data);
    } catch (PDOException $e) {
        echo "Oh no ...." . $e->getMessage();
        error_log($e->getMessage());
    }
    if ($is_successful) {
        header('Location: /index.php');
    } else {
        echo "Oh no ..";
    }
}

include "form.php";


