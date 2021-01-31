<?php
    if (!isset($_GET["playlist"])) {
        header("Location: ./playlists.php");
    }
	require(__DIR__ . '/vendor/autoload.php');

    if (file_exists(__DIR__ . '/.env')) {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
    
    $pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);
    $sql = "SELECT tracks.name, albums.title, artists.name AS artist, tracks.unit_price, genres.name AS genre_name FROM tracks 
    INNER JOIN playlist_track
    ON playlist_track.playlist_id=" . $_GET["playlist"] . " AND tracks.id=playlist_track.track_id
    INNER JOIN genres
    ON tracks.genre_id=genres.id
    INNER JOIN albums
    ON albums.id=tracks.album_id
    INNER JOIN artists
    ON albums.artist_id=artists.id";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $tracks = $statement->fetchAll(PDO::FETCH_OBJ);
    $sql = "SELECT playlists.name FROM playlists WHERE playlists.id=" . $_GET["playlist"];
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $playlist_name = $statement->fetch(PDO::FETCH_OBJ);
?>

<?php 
    if (count($tracks) == 0): {  
?>
<h1>No tracks found for <?php echo $playlist_name->name; ?></h1>
<?php
    } else: {
?>
<table>
  <thead>
    <tr>
      <th>Track name</th>
      <th>Album title</th>
      <th>Artist name</th>
      <th>Price</th>
      <th>Genre name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($tracks as $track): ?>
    <tr>
      <td> <?php echo $track->name ?></td>
      <td> <?php echo $track->title ?></td>
      <td> <?php echo $track->artist ?></td>
      <td> <?php echo $track->unit_price ?></td>
      <td> <?php echo $track->genre_name ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php 
} endif ?>