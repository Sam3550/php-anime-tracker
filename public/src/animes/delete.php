<?php
include '../../partials/header.php';
include '../../partials/menu.php';
include '../../inc/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_select = "SELECT * FROM Anime WHERE id = :id";
    $sth_select = $dbh->prepare($sql_select);
    $sth_select->execute(['id' => $id]);
    $animeToDelete = $sth_select->fetch(PDO::FETCH_ASSOC);

    if (!$animeToDelete) {
        echo "L'Anime avec l'ID spécifié n'a pas été trouvé.";
    } else {
        $sql_delete = "DELETE FROM Anime WHERE id = :id";
        $sth_delete = $dbh->prepare($sql_delete);

        try {
            $sth_delete->execute(['id' => $id]);
            $_SESSION['success_message'] = "L'Anime a été supprimé avec succès.";
            header("Location: ../../index.php");
            exit;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de l'Anime : " . $e->getMessage();
            error_log($e->getMessage());
        }
    }
} else {
    echo "ID non spécifié.";
}
?>
