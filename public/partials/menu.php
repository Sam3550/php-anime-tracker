<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Anime tracker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/src/animes/create.php">Create</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/src/favorites/">Favorites</a>
                </li>

            </ul>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<span>" . $_SESSION['username'] . "</span>";
            } ?>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
                
            </form>
            <a href="/disconnected.php" class="btn btn-outline-success" type="submit">Disconnected</a>
        </div>
    </div>
</nav>


<?php 
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success' role='alert'>" , $_SESSION['success_message'], "</div>";
    unset($_SESSION['success_message']); // Supprimer le message de la session après l'avoir affiché
}
if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger' role='alert'>" , $_SESSION['error_message'], "</div>";
    unset($_SESSION['error_message']); // Supprimer le message de la session après l'avoir affiché
}