<?php
    require(__DIR__ . '/vendor/autoload.php');

    if (file_exists(__DIR__ . '/.env')) {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
    
    $pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);
    $sql = "SELECT * FROM playlists";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $playlists = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<table>
  <thead>
    <tr>
      <th>Playlist Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($playlists as $playlist) : ?>
    <tr>
      <td><a href=<?php echo './tracks.php?playlist=' . $playlist->id; ?>><?php echo $playlist->name; ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>