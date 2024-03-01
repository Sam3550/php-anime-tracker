<main class='container'>

    <form action='#' method='POST'>
        <div class="mb-3">
            <label for="nameAnime" class="form-label">Nom de l'anime</label>
            <input type="text" class="form-control" id="nameAnime" name="nameAnime" aria-describedby="nameAnime" placeholder="<?= isset($record['nom']) ? $record['nom'] : '' ?>">
        </div>
        <div class="mb-3">
            <label for="nbEpisodesAnime" class="form-label">Nb Episodes</label>
            <input type="number" class="form-control" name="nombre_episodes" id="nbEpisodesAnime" min="0" step="1" value="<?= isset($record['episode_nb']) ? $record['episode_nb'] : '' ?>">
        </div>
        <div class="mb-3">
            <label for="noteAnime" class="form-label">Note</label>
            <input type="number" class="form-control" id="noteAnime" name="note" min="0" max="10" step="0.01" value="<?= isset($record['note']) ? $record['note'] : '' ?>">
        </div>
        <div class="mb-3">
            <label for="durationAnime" class="form-label">duration</label>
            <input type="number" class="form-control" id="durationAnime" name="duration" min="0" step="1" value="<?= isset($record['duration']) ? $record['duration'] : '' ?>">
        </div>
        <div class="mb-3">
            <label for="imgAnime" class="form-label">Image</label>
            <input type="url" class="form-control" id="imgAnime" name="img" value="<?= isset($record['img']) ? $record['img'] : '' ?>">
        </div>
        <div class="mb-3">
            <label for="typeAnime" class="form-label">Type</label>
            <?= htmlSelectType("typeAnime", isset($record['type_id']) ? $record['type_id'] : '') ?>
        </div>
        <div class="mb-3">
            <label for="statusAnime" class="form-label">Statut</label>
            <?= htmlSelectStatus("statusAnime", isset($record['statut_id']) ? $record['statut_id'] : '') ?>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>