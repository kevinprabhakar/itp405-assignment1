<?php
    $pdo  = new PDO('sqlite:chinook.db');
    $sqlQuery = "SELECT genres.GenreId, genres.Name FROM genres";

    // if (isset($_GET['genre'])){
    //     $sqlQuery = $sqlQuery . ' WHERE genres.Name = ?';
    // }

    $statement = $pdo->prepare($sqlQuery);

    // if (isset($_GET['genre'])){
    //     $statement->bindParam(1, $_GET["genre"]);
    // }
    $statement->execute();

    $genres = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Week 2</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    </head>
    <body>
        <!-- <form action="index.php" method="get">
            <input
            type="text"
            name="genre"
            value="<?php echo isset($_GET['genre']) ? $_GET['genre'] : ' '?>">
            <button class="btn btn-default" type="submit">Search</button>
            <a href="/" class="btn btn-default">Clear</a>
        </form> -->
        <table class="table">
            <tr>
                <th>Genre ID</th>
                <th>Genre Name</th>
            </tr>

            <?php foreach($genres as $genre) : ?>
                <tr>
                    <td>
                        <?php echo $genre->GenreId ?>
                    </td>
                    <td>
                        <a href="tracks.php?genre=<?php echo urlencode($genre->Name) ?>"><?php echo $genre->Name ?></a>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if(count($genres) === 0) : ?>
                <tr>
                    <td colspan=4>No Genres Found!</td>
                </tr>
            <?php endif ?>


    </body>
</html>
