<?php
include 'partials/header.php';
include 'partials/menu.php';
?>
<main class="d-flex flex-wrap justify-content-between">
    <?php
    include 'inc/functions.php';

    $records = fetchAllAnimeData();
    

    foreach ($records as $record) {
        $tags = '';
        if (!empty($record['genres'])) {
            foreach (explode(',', $record['genres']) as $genre) {
                $tags .= " <a href='category.php?name=" . $genre . "'><span class='badge bg-secondary'>$genre</span></a>";
            }
        }

        $html = "
            <div class='card bg-secondary m-4 col-12 col-md-3' style=''>
                <img src='" . ($record['img'] ?? 'https://placewaifu.com/image/200') . "' class='card-img-top' alt='...'>
                <p class='position-absolute top-0 end-0'><i class='me-2 mt-2 fa-regular fa-star'></i></p>
                <div class='position-absolute top-0 start-1 ranking'>" . $record['note'] . " / 10.0</div>
                <div class='card-body'>
                    <h5 class='card-title'>" . $record['nom'] . "</h5>
                    $tags
                    <p class='card-text'> Nb Episodes : " . $record['episode_nb'] . "</p>
                    
                    <a href='./src/animes/show.php?id=" . $record['id'] . "' class='btn btn-primary'>View</a>
                    <a href='./src/animes/edit.php?id=" . $record['id'] . "' class='btn btn-light'>Edit</a>
                    
                    <!-- Ajout du bouton de suppression avec confirmation -->
                    <button class='btn btn-danger' onclick='confirmDelete(" . $record['id'] . ")'>Delete</button>
                
                </div>
            </div>
        ";
        echo ($html);
    }
    ?>
</main>


<script>
    function confirmDelete(animeId) {
        if (confirm("Voulez-vous vraiment supprimer cet anime?")) {
            window.location.href = './src/animes/delete.php?id=' + animeId;
        }
    }
</script>
</body>

</html>

