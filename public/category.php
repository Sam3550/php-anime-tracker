<?php
include 'partials/header.php';
include 'partials/menu.php';
?>
<main class="d-flex flex-wrap justify-content-between">
    <?php
    include 'inc/connectDB.php';

    $label = $_GET['name'];

    $sql = "Select Anime.id, Anime.nom, Anime.episode_nb, Anime.note, Anime.img, GROUP_CONCAT(Genre.nom) as 'genres'
    From Anime
    JOIN Anime_a_Genre aag ON aag.anime_id = Anime.id
    JOIN Genre ON Genre.id = aag.genre_id
    WHERE Anime.id IN (Select Anime.id
        From Anime
        JOIN Anime_a_Genre aag ON aag.anime_id = Anime.id
        JOIN Genre ON Genre.id = aag.genre_id
        WHERE Genre.nom = :label)
    GROUP BY Anime.id
    ORDER BY note DESC";
    $data = ["label" => $label];

    $sth = $dbh->prepare($sql);
    $is_successful = $sth->execute($data);

    if ($is_successful) {

        $records = $sth->fetchAll();
        foreach ($records as $record) {
            if (!empty($record['genres'])) {
                $tags = '';
                foreach (explode(',', $record['genres']) as $genre) {
                    $tags .= " <a href='category.php?name=" . $genre . "'><span class='badge bg-secondary'>$genre</span></a>";
                }
            }
            $html = "
                <div class='card m-4 col-12 col-md-3' style=''>
                    <img src='" . ($record['img'] ?? 'https://placewaifu.com/image/200') . "' class='card-img-top' alt='...'>
                    <p class='position-absolute top-0 end-0'><i class='me-2 mt-2 fa-regular fa-star'></i></p>
                    <div class='position-absolute top-0 start-1 ranking'>" . $record['note'] . " / 10.0</div>
                    <div class='card-body'>
                        <h5 class='card-title'>" . $record['nom'] . "</h5>
                        $tags
                        <p class='card-text'> Nb Episodes : " . $record['episode_nb'] . "</p>
                        
                        <a href='./src/animes/show.php?id=" . $record['id'] . "' class='btn btn-primary'>View</a>
                    </div>
                </div>
            ";
            echo ($html);
        }
    } else {
        echo "Oh no... something wrong occured";
    }
    ?>
</main>
</body>

</html>
