<?php
    $pdo  = new PDO('sqlite:chinook.db');

    $sqlQuery = "SELECT tracks.Name, albums.Title as AlbumTitle, artists.Name as ArtistName, tracks.UnitPrice FROM tracks INNER JOIN albums ON tracks.AlbumId = albums.AlbumId INNER JOIN artists ON albums.ArtistId = artists.ArtistId";

    if (isset($_GET['genre'])){
        $genreSqlQuery = "SELECT genres.GenreId as GenreID FROM genres WHERE genres.Name = ?";

        $genreStatement = $pdo->prepare($genreSqlQuery);

        $genreUrlEncoded = urldecode($_GET["genre"]);

        $genreStatement->bindParam(1, $genreUrlEncoded);

        $genreStatement->execute();

        $genreId = $genreStatement->fetch(PDO::FETCH_OBJ);

        $modSqlQuery = $sqlQuery . ' WHERE tracks.GenreId = ?';

        $statement = $pdo->prepare($modSqlQuery);

        $statement->bindParam(1, $genreId->GenreID);

        $statement->execute();

    }else{
        $statement = $pdo->prepare($sqlQuery);

        $statement->execute();
    }
    $tracks = $statement->fetchAll(PDO::FETCH_OBJ);


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Week 2</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    </head>
    <body>
        <table class="table">
            <tr>
                <th>Track Name</th>
                <th>Track Album</th>
                <th>Track Artist</th>
                <th>Track Price</th>
            </tr>

            <?php foreach($tracks as $track) : ?>
                <tr>
                    <td>
                        <?php echo $track->Name ?>
                    </td>
                    <td>
                        <?php echo $track->AlbumTitle ?>
                    </td>
                    <td>
                        <?php echo $track->ArtistName ?>
                    </td>
                    <td>
                        <?php echo $track->UnitPrice ?>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if(count($tracks) === 0) : ?>
                <tr>
                    <td colspan=4>No Tracks Found!</td>
                </tr>
            <?php endif ?>


    </body>
</html>
