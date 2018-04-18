<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>trilado</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style.css">

  </head>
  <body>

<?php 

include_once 'db_connection.php'; 
	//put at beginning of every page except media info page
#session_start();
// gives access to : $_SESSION['username'];
//               and $_SESSION['userid']
#if (!isset($_SESSION['username'])) {
	#$_SESSION['msg'] = "You must log in first";
	#header('location: login.php');
#}

//database info stuff and establishing the connection
$UserID = $_SESSION['userid'];
//$pdo = new PDO($dsn, $user , $pass, $opt);



$jack_films = array(675, 354912, 597);
$danny_films = array(597, 120, 36897, 675);
$ali_films = array(120, 354912);
$dean_films = array(36897, 675, 245891);
$martin_films = array(245891, 120, 597);
$john_films = array(120, 597, 36897, 675, 245891);

$jack_shows = array(1399, 2691, 1396);
$danny_shows = array(1396, 1668, 1402, 1399);
$ali_shows = array(1668, 2691);
$dean_shows = array(1402, 1399, 48866);
$martin_shows = array(48866, 1668, 1396);
$john_shows = array(1668, 1396, 1402, 1399, 48866);

$users_films = array($jack_films, $danny_films, $ali_films, $dean_films, $martin_films, $john_films);
$users_shows = array($jack_shows, $danny_shows, $ali_shows, $dean_shows, $martin_shows, $john_shows);

$split = explode(".",frequent_itemset_mine($users_films));
$filmID1 = $split[0];
$filmID2 = $split[1];
$filmID3 = $split[2];

$split = explode(".",frequent_itemset_mine($users_shows));
$showID1 = $split[0];
$showID2 = $split[1];
$showID3 = $split[2];

// Frequent-itemset mining function
function frequent_itemset_mine($users_media) {
	// pass all the occurances of media into an array
	$media = array();
	foreach($users_media as $user){
		array_push($media, $user[0], $user[1], $user[2], $user[3], $user[4]);
	}
	$media_count = array_count_values($media); 

	$support = 3; // set the support = 3

	// remove from hash all films rated < support times
	foreach ($media_count as $media => $value) {
			if ($value < $support) {
					unset($media_count[$media]);
			}
	}

	/* make pairs of these films as new hash key and assign value 
	the number of times each pair rated 5 stars by each user */
	$media2 = array();
	foreach ($media_count as $media => $value) {
			array_push($media2, $media);
	}
	$media_pairs = array();
	for ($x = 0; $x < count($media2); $x++) {
			for ($y = 0; $y < count($media2); $y++) {
					if ($media2[$x+$y+1]) {
							$pair = $media2[$x].'.'.$media2[$x+$y+1];
					} else continue;
					array_push($media_pairs, $pair);
			}
	} 

	$existing_media_pairs = array();
	foreach ($media_pairs as $pair) {
			$split = explode(".",$pair);
			$mediaID1 = $split[0];
			$mediaID2 = $split[1];
			foreach($users_media as $user) {
					$contains_mediaID1 = False;
					$contains_mediaID2 = False;
					for ($x = 0; $x < 5; $x++) { // change this magic number
							if ($user[$x] == $mediaID1) $contains_mediaID1 = True;
							if ($user[$x] == $mediaID2) $contains_mediaID2 = True;
					}
					if ($contains_mediaID1 && $contains_mediaID2) {
							array_push($existing_media_pairs, $pair);
					}
			}
	}
	$media_pairs_count = array_count_values($existing_media_pairs);

	// remove all film pairs with value < support
	foreach ($media_pairs_count as $media => $value) {
			if ($value < $support) {
					unset($media_pairs_count[$media]);
			}
	}

	// make set of 3 films by self-joining ie. XY + XZ = XYZ
	$frequent_media_pairs = array();
	foreach ($media_pairs_count as $pair => $value) {
			array_push($frequent_media_pairs, $pair);
	}

	$triple_medias = array();
	for ($x = 0; $x < count($frequent_media_pairs); $x++) {
			$split1 = explode(".",$frequent_media_pairs[$x]);
			$media1ID1 = $split1[0];
			$media1ID2 = $split1[1];

			$split2 = explode(".",$frequent_media_pairs[$x+1]);
			$media2ID1 = $split2[0];
			$media2ID2 = $split2[1];

			if ($media1ID1 == $media2ID1) {
					$triple = $media1ID1.".".$media1ID2.".".$media2ID2;
					array_push($triple_medias, $triple);
			}
	}

	/* make 3-sets of these films as new hash key and assign value 
	the number of times each 3-set rated 5 stars by each user */
	$existing_media_triples = array();
	foreach ($triple_medias as $triple) {
			$split = explode(".",$pair);
			$mediaID1 = $split[0];
			$mediaID2 = $split[1];
			$mediaID3 = $split[2];
			foreach($users_media as $user) {
					$contains_mediaID1 = False;
					$contains_mediaID2 = False;
					$contains_mediaID3 = False;
					for ($x = 0; $x < 5; $x++) { // change this magic number
							if ($user[$x] == $mediaID1) $contains_mediaID1 = True;
							if ($user[$x] == $mediaID2) $contains_mediaID2 = True;
							if ($user[$x] == $mediaID3) $contains_mediaID3 = True;
					}
					if ($contains_mediaID1 && $contains_mediaID2 && $contains_mediaID3) {
							array_push($existing_media_triples, $triple);
					}
			}
	}
	$media_triples_count = array_count_values($existing_media_triples);

	$max_value = 0;
	$most_popular_triple = "";
	foreach ($media_triples_count as $triple => $value) {
			if ($value > $max_value) $most_popular_triple = $triple;
	}

	return $most_popular_triple;
	/**** DO UP TO HERE FOR NOW ****/

	/* ( for 4-sets look for two 3-sets starting with the first films
			eg. ABC and ABD -> ABCD ) */
}


// for each user {
		// if they have 5-starred a film 
				// print the frequent itemset of that film to the carousel
		// if they have 5-starred a tv show
				// print the frequent itemset of that show to the carousel
// }

// if items in frequent itemset < 4
		// for all users
				// find highest rated film
				// api call to tmdb genre="favourite_genre"
				// return set of 3 highest rated film in that genre


// function to get film
function get_title($mediaID, $is_film) {
	if ($is_film) {
		$url = "https://api.themoviedb.org/3/movie/".$mediaID."?api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US";
	} else {
		$url = "https://api.themoviedb.org/3/tv/".$mediaID."?api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US";
	}
	$curl = curl_init();
	curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "{}",
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
			return "cURL Error #:" . $err;
	} else {
			$obj = json_decode($response);
			if ($is_film) {
				return $obj->original_title;
			} else {
				return $obj->name;
			}
	}
}

function get_poster($mediaID, $is_film) {
	if ($is_film) {
		$url = "https://api.themoviedb.org/3/movie/".$mediaID."?api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US";
	} else {
		$url = "https://api.themoviedb.org/3/tv/".$mediaID."?api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US";
	}
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_POSTFIELDS => "{}",
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
				return "cURL Error #:" . $err;
		} else {
				$obj = json_decode($response);
				return $obj->poster_path;
		}
}
?>

  <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4" id = "clear">
			<a href=index.php>
                <img src="logo.png" alt="Trilado" style="width:200px;height:75px;">
            </a>
			</div>
            <div class="col-md-4" id = "clear">
                <form action = search.php method = post>
                    <input type="text2" name="search" placeholder="Search..">
                  </form>
            </div>
            <div class="col-md-4" id = "clear">
                <a href="friends.php" style = "color:white">FRIENDS  </a> 
                |
                 <a href="messages.php" style = "color:white">  MESSAGES</a> 
            </div>
          </div>
        </div>
      </div>
    </div>



	<div class="row">
		<div class="col-md-1">
      
		</div>

			<!-- ##### START OF NEWS FEED ##### -->
		<div class="col-md-5">
		<h1>News Feed</h1> 
		<br><br>
		<?php 
			//the queries that get pulled from the db and printed in the newsfeed as notifications
			$stmt1 = $pdo->prepare("SELECT MediaID FROM follow_list WHERE UserID = :UserID");
			$stmt1->execute(array("UserID" => $UserID));
			$result = $stmt1->fetchAll();
			$stmt2 = $pdo->prepare("SELECT updateText FROM mediaupdate WHERE MediaID = '1'");
					$stmt2->execute($result);
			$result2 = $stmt2->fetchAll();
			if (!$result){
				echo "Ain't nothing here fucko";
			} else{
			foreach ($result2 as $update){
				echo $update["updateText"]."<br>";
			}
			}
		?>
		</div>
		<div class="col-md-1">
    </div>

		<!-- ##### START OF SUGGESTIONS ##### -->
    <div class="col-md-4">
	    <div class="contain">

  <h1>Suggestions</h1>

  <p>3 films most commonly 'favourited' by the same user</p>

  <div class="row">
    <div class="row__inner">

      <div class="tile">
        <div class="tile__media">
          <img class="tile__img" src=<?php echo '"http://image.tmdb.org/t/p/original/'.get_poster($filmID1, true).'"' ?> alt=""  />
        </div>
        <div class="tile__details">
          <div class="tile__title">
          <?php echo get_title($filmID1, true)?>
          </div>
        </div>
      </div>

      <div class="tile">
        <div class="tile__media">
          <img class="tile__img" src=<?php echo '"http://image.tmdb.org/t/p/original/'.get_poster($filmID2, true).'"' ?> alt=""  />
        </div>
        <div class="tile__details">
          <div class="tile__title">
          <?php echo get_title($filmID2, true)?>
          </div>
        </div>
      </div>

      <div class="tile">
        <div class="tile__media">
          <img class="tile__img" src=<?php echo '"http://image.tmdb.org/t/p/original/'.get_poster($filmID3, true).'"' ?> alt=""  />
        </div>
        <div class="tile__details">
          <div class="tile__title">
          <?php echo get_title($filmID3, true)?>
          </div>
        </div>
      </div>

    </div>
  </div>

	<p>3 TV shows most commonly 'favourited' by the same user</p>

<div class="row">
	<div class="row__inner">

		<div class="tile">
			<div class="tile__media">
				<img class="tile__img" src=<?php echo '"http://image.tmdb.org/t/p/original/'.get_poster($showID1, false).'"' ?> alt=""  />
			</div>
			<div class="tile__details">
				<div class="tile__title">
				<?php echo get_title($showID1, false)?>
				</div>
			</div>
		</div>

		<div class="tile">
			<div class="tile__media">
				<img class="tile__img" src=<?php echo '"http://image.tmdb.org/t/p/original/'.get_poster($showID2, false).'"' ?> alt=""  />
			</div>
			<div class="tile__details">
				<div class="tile__title">
				<?php echo get_title($showID2, false)?>
				</div>
			</div>
		</div>

		<div class="tile">
			<div class="tile__media">
				<img class="tile__img" src=<?php echo '"http://image.tmdb.org/t/p/original/'.get_poster($showID3, false).'"' ?> alt=""  />
			</div>
			<div class="tile__details">
				<div class="tile__title">
				<?php echo get_title($showID3, false)?>
				</div>
			</div>
		</div>

	</div>
</div>

	

</div>
    </div>
    <div class="col-md-1">
    </div>
	</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
  </body>
</html>