<?php
include './partials/header.php';
include './partials/menu.php';
include './inc/functions.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = '';
    global $dbh;

    assert(!empty($_POST['username']));
    assert(!empty($_POST['password']));

    $sql = "INSERT INTO Utilisateur(login, password) VALUES (:login, :password)";
    $data = [
        'login' => $_POST['username'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];

    $sth = $dbh->prepare($sql);

    try {
        $is_successful = $sth->execute($data);
        if ($is_successful) {
            header('Location: login.php');
            exit(); // Assurez-vous de sortir après la redirection
        } else {
            $message = $sth->errorInfo()[2];
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
    }
}

?>

<h1>Register</h1>

<main class="container">
    <?php include 'connect.php'; ?>
</main>
