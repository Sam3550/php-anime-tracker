<?php

include 'connectDB.php';
function fetchAllAnimeData()
{
    global $dbh;
    $sql = "Select Anime.id, Anime.nom, Anime.episode_nb, Anime.note, Anime.img, GROUP_CONCAT(Genre.nom) as 'genres'
        From Anime
        LEFT JOIN Anime_a_Genre aag ON aag.anime_id = Anime.id
        LEFT JOIN Genre ON Genre.id = aag.genre_id
        GROUP BY Anime.id
        ORDER BY note DESC
        LIMIT 100 ";
    $data = [];

    $sth = $dbh->prepare($sql);
    $is_successful = $sth->execute($data);
    return $sth->fetchAll();
}

function htmlSelectType($fieldName, $id = null)
{
    global $dbh;
    $sql = "Select id, nom from Type";
    $data = [];

    $sth = $dbh->prepare($sql);
    $is_successful = $sth->execute($data);

    if ($is_successful) {
        $html = "<select name='$fieldName'  class='form-select' aria-label='Default select example'>";
        foreach ($sth->fetchAll() as $record) {
            if ($id == $record['id']) {
                $selected = "selected ";
            } else {
                $selected = "";
            }
            $html .= "<option  $selected value='" . $record['id'] . "'>" . $record['nom'] . "</option>";
        }
        $html .= "</select>";
    }
    return $html;
}
function htmlSelectStatus($fieldName, $id = null)
{
    global $dbh;
    $sql = "Select id, nom from Statut;";
    $data = [];

    $sth = $dbh->prepare($sql);
    $is_successful = $sth->execute($data);

    $html = "<select name='$fieldName'  class='form-select' aria-label='Default select example'>";
    if ($is_successful) {
        
        foreach ($sth->fetchAll() as $record) {
            if ($id == $record['id']) {
                $selected = "selected ";
            } else {
                $selected = "";
            }
            $html .= "<option $selected value='" . $record['id'] . "'>" . $record['nom'] . "</option>";
        }
    }
    $html .= "</select>";
    return $html;
}
