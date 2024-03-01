<?php
include '../../partials/header.php';
include '../../partials/menu.php';
include '../../inc/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    global $dbh;
    $sql = "UPDATE Anime SET type_id =:type, statut_id = :status, nom = :nom,  episode_nb= :nb,	note = :note, img = :img WHERE id = :id";
    $data = [
        'type' => $_POST['typeAnime'],
        'status' => $_POST['statusAnime'],
        'nom' => $_POST['nameAnime'],
        'nb' => $_POST['nombre_episodes'],
        'note' => $_POST['note'],
        'img' => $_POST['img'],
        'id' => $_GET['id']
    ];
    $sth = $dbh->prepare($sql);
    $is_successful = $sth->execute($data);
    if ($is_successful) {
        header('Location: ../../index.php');
    } else {
        print_r($sth->errorInfo());
    }
}

$sql = "SELECT * from Anime where id = :id";
$data = ['id' => $_GET['id']];

$sth = $dbh->prepare($sql);
$sth->execute($data);
$record = $sth->fetch();
// var_dump($record)

include 'form.php';
