<?php
include 'tools.php';


/*********** Load anime.csv */

function saveTypes($names)
{
    $names = clean_array($names);
    $dbh = DatabaseSingleton::getInstance();
    $sql = "INSERT INTO Type(nom) VALUES (:name);";
    $dbh->prepare($sql);
    $statement = $dbh->prepare($sql);
    foreach ($names as $name) {
        if (empty($name))
            continue;
        $statement->execute(["name" => trim($name)]);
    }
}
function saveGenres($names)
{
    $names = clean_array($names);
    $dbh = DatabaseSingleton::getInstance();
    $sql = "INSERT INTO Genre(nom) VALUES (:name);";
    $statement = $dbh->prepare($sql);
    foreach ($names as $name) {
        if (empty($name))
            continue;
        $statement->execute(["name" => trim($name)]);
    }
}








/***************************
 * Here is the real stuff.
 */

$csvFilepath = "anime.csv";
$animes = file_to_associative_array($csvFilepath);

// Generate the linked tables
// Skip empty lines and duplicates
$types = $genres = [];

foreach ($animes as $anime) {
    $types[] = $anime["type"];
    foreach (explode(",", $anime["genre"]) as $genre) {
        array_push($genres, $genre);
    }
}
saveTypes($types);
saveGenres($genres);

// Generate the animes

$dbh = DatabaseSingleton::getInstance();
foreach ($animes as $anime) {

    // Get associated type
    $sql = "SELECT id from Type where nom = :nom";
    $statement = $dbh->prepare($sql);
    $statement->execute(["nom" => $anime["type"]]);
    $type = $statement->fetch();
    // var_dump($anime);
    // Save anime
    $record = [
        "id" => $anime["anime_id"],
        "nom" => $anime["name"],
        "episode_nb" => is_numeric($anime["episodes"]) ? $anime["episodes"] : null,
        "note" => empty($anime["rating"]) ? null : $anime["rating"],
        "type" => $type['id']
    ];
    $sql = "INSERT INTO Anime(id, nom, episode_nb, note, type_id) VALUES (:id, :nom, :episode_nb, :note, :type);";
    $statement = $dbh->prepare($sql);
    var_dump($record);
    $statement->execute($record);

    // Link to other tables
    $sql = "INSERT INTO Anime_a_Genre(anime_id, genre_id) VALUES (:id, :gid);";
    $statement = $dbh->prepare($sql);
    foreach (explode(",", $anime["genre"]) as $genre) {
        if (!empty(trim($genre))) {
            $sql = "SELECT id from Genre where nom = :nom";
            $substmt = $dbh->prepare($sql);
            $substmt->execute(['nom' => trim($genre)]);
            $gid = $substmt->fetch()['id'];

            $data = ["id" => $anime['anime_id'], "gid" => $gid];
            $statement->execute($data);
        }
    }


}