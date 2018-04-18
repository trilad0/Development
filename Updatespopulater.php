<?php
include_once 'db_connection.php';

//check if a mediaitem is alreadybeing tracked. if so do nothing, if not add it to the tracker.

//ADD THIS TO ALIS FOLLOW CODE.make sure can only follow tv shows.
tracker("7339");

function tracker($mediaID){
include 'db_connection.php';

$query = "SELECT trackerID FROM updatestracker WHERE mediaID = $mediaID";
$result = $pdo->query($query);
$num = $result->rowCount();
echo count($num);
        if ($num < 1){
          $film_url = "https://api.themoviedb.org/3/tv/".$mediaID."?api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US";
          $film_data = file_get_contents($film_url);
          $film_encod = json_decode($film_data);
          $films_count = count($film_encod->results);
          //$addtuple = "INSERT INTO updatestracker (mediaID,episodeCount,seriesCount) VALUES ($mediaID,$film_encod->number_of_episodes,$film_encod->number_of_seasons)";
          $addtuple = "INSERT INTO updatestracker (mediaID,episodeCount,seriesCount) VALUES ($mediaID,0,0)";
          $result = $pdo->query($addtuple);
}
}

update();


//run seperately. checks for changes to the database. look for episode numbers/series numbers change.
function update(){
    include 'db_connection.php';
   
    $query = "SELECT * FROM updatestracker";
    $result = $pdo->query($query);

    while ($row = $result->fetch()) {
        
        $film_url = "https://api.themoviedb.org/3/tv/".$row['mediaID']."?api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US";
        $film_data = file_get_contents($film_url);
        $film_encod = json_decode($film_data);
        $films_count = count($film_encod->results);
//check episode numbers
        if ($row['episodeCount'] != $film_encod->number_of_episodes){
            $updatetracker = "UPDATE updatestracker set episodeCount = $film_encod->number_of_episodes WHERE mediaID = ".$row['mediaID'];
            $results = $pdo->query($updatetracker);
            $updateString = "Episode number ".$film_encod->number_of_episodes." of ".$film_encod->original_name." has been released on .".$film_encod->last_air_date."";
            echo $updatequery;
            $addupdate = "INSERT INTO mediaupdate (MediaID, updatetext) VALUES (".$row['MediaID'].",'".$updateString."')";
            $results = $pdo->query($addupdate);
        }
//check season numbers
        if ($row['seriesCount'] != $film_encod->number_of_seasons){
            $updatetracker = "UPDATE updatestracker set seriesCount = $film_encod->number_of_seasons WHERE mediaID = ".$row['mediaID'];
            $results = $pdo->query($updatetracker);
            $updateString = "Season number ".$film_encod->number_of_seasons." of ".$film_encod->original_name." has been released on .".$film_encod->last_air_date;
            echo $updateString;
            $addupdate = "INSERT INTO mediaupdate (MediaID, updatetext) VALUES (".$row['MediaID'].",'".$updateString."')";
            $results = $pdo->query($addupdate);
        }
    }


}


?>