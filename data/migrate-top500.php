<?php
include 'tools.php';


function saveStatuses($statuses)
{
    $dbh = DatabaseSingleton::getInstance();
    $sql = "INSERT INTO Statut(nom) VALUES (:name);";
    $dbh->prepare($sql);
    $statement = $dbh->prepare($sql);
    foreach ($statuses as $name) {
        if (empty($name))
            continue;
        $statement->execute(["name" => $name]);
    }

}
function saveDurations($durations)
{
    $sql = "INSERT INTO Duree(label) VALUES (:name);";
    $dbh->prepare($sql);
    $statement = $dbh->prepare($sql);
    foreach ($durations as $name) {
        if (empty($name))
            continue;
        $statement->execute(["name" => $name]);
    }
}
/***********
 * Here is the interesting part !
 */
$csvFilepath = "Top 500 Anime List.csv";
$animes = file_to_associative_array($csvFilepath);

// Generate the linked tables

// From the CSV file, generate statuses and durations
// Skip empty lines and duplicates
$statuses = $durations = [];
foreach ($animes as $anime) {
    $statuses[] = $anime["status"];
    $durations[] = $anime["duration"];
}
$statuses = clean_array($statuses);
saveStatuses($statuses);


$durations = clean_array($durations);
saveDurations($durations);


// Update existing animes

foreach ($animes as $anime) {
    $id = $anime["mal_id"];
    $stmt = $dbh->prepare('SELECT * FROM Anime where id = :id');
    $record = $stmt->execute(['id' => $id]);
    if (!empty($record)) {
        // The record exists, let's update it !

        // image
        $images = $anime['images'];
        preg_match('/\'webp\': {\'image_url\': \'(.*webp)\', \'small/', $images, $matches, PREG_OFFSET_CAPTURE);
        $url = empty($matches) ? null : $matches[1][0];

        // status
        $sql = "SELECT id from Statut where nom = :nom";
        $substmt = $dbh->prepare($sql);
        $substmt->execute(['nom' => trim($anime['status'])]);
        $sid = $substmt->fetch()['id'];

        // duration
        $sql = "SELECT id from Duree where label = :nom";
        $substmt = $dbh->prepare($sql);
        $substmt->execute(['nom' => trim($anime['duration'])]);
        $did = $substmt->fetch()['id'];

        $stmt = $dbh->prepare('UPDATE Anime SET img = :url, statut_id = :statut_id, duration_id = :duration_id WHERE id = :id');
        $record = $stmt->execute([
            'id' => $id,
            'url' => $url,
            'statut_id' => $sid,
            'duration_id' => $did
        ]);
    }
}
