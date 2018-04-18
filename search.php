<!DOCTYPE html>
<html lang="en">
  <head>
  <style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans);
    .content {
        border: 4px;
        padding: 10px;
        overflow: hidden;
    }
    .content input[type=image] {
        margin-right: 15px;
        float: left;
        -moz-box-shadow: 1px 1px 5px #3d6fc1 ;
        -webkit-box-shadow: 1px 1px 5px #3d6fc1 ;
        box-shadow: 1px 1px 5px #3d6fc1 ;
    }
    .content input[type=image]:hover {
        border: solid 1px #CCC;
        -moz-box-shadow: 1px 1px 5px #5391f6;
        -webkit-box-shadow: 1px 1px 5px #5391f6;
        box-shadow: 1px 1px 5px #5391f6;
    }
    hr {
        height: 12px;
        top: 0;
        left: 0;
        border: 0;
        box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
    }
    h3 {
        position: relative;
        left: 0pt;
    }
    .container{
        background: blue;
	    width: 100%;
        height: 10%;
	    display: flex;
    }
    .container img {
        height: 50%;
        align-self: center;
        margin-left: 2%;
        margin-right: auto;
    }
    .search {
        align-self: center;
        display: inline;
        float: right;
        display: block;
        margin-left: auto;
        margin-right: 2%;
    }
    .search input[type=text] {
        width: 300px;
        height: 30px;
        font-size: 30px; 
        font-size: 1vw;
        float: right;
    }
    .search button {
        height: 30px;
        font-size: 16px; 
        font-size: 1vw;
        background: white;
        float: right;
    }
    .search button:hover {
        box-shadow: 0 5px 15px 2px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>trilado</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">

  </head>
  <body>

  <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4" id = "clear">
                <img src="logo.png" alt="Trilado" style="width:200px;height:75px;">
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

<?php
function truncateToWord($content,$length=300){ 
  if(strlen($content)>=$length){ 
      $spaceAtPos = strpos($content,' ',$length); 
      $content = substr($content,0,$spaceAtPos)."..."; 
  } 
  return $content; 
} 

$inputs = $_POST["search"];
$inputs = str_replace(' ', '+', $inputs);

$film_url = "https://api.themoviedb.org/3/search/movie?api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US&query=".$inputs."&include_adult=false";
$film_data = file_get_contents($film_url);
$film_encod = json_decode($film_data);
$films_count = count($film_encod->results);

$show_url = "https://api.themoviedb.org/3/search/tv?page=1&language=en-US&api_key=a102baed1b574a80b147daa9e0bfbee3&language=en-US&query=".$inputs."&include_adult=false";
$show_data = file_get_contents($show_url);
$show_encod = json_decode($show_data);
$shows_count = count($show_encod->results);
?>

	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
    <?php 
        //..... Films .....//
        if ($film_encod->results[0]) echo '<h3>'.$films_count.' results for films found';
        if ($films_count > 5) echo ', displaying the top 5</h3><br>';
        else echo '</h3>';

        for ($i = 0; $i <= 4; $i++) {
          if ($film_encod->results[$i]) {
              echo '<div class="content">';
              echo '<form action="mediapage.php" method="POST" accept-charset=utf-8>';
              echo '<input type="image" name="film_name" value="'.$film_encod->results[$i]->original_title.'" src="http://image.tmdb.org/t/p/original/'.$film_encod->results[$i]->poster_path.'" height = "150">';
              echo '<input type="hidden" name="film_id" value="'.$film_encod->results[$i]->id.'">';
              echo '<h4>'.$film_encod->results[$i]->original_title.'</h4><br>';
              echo truncateToWord($film_encod->results[$i]->overview).'<br>';
              echo '</form>';
              echo '</div>';
              echo '<hr>';
          }
        }
        //..... TV Shows .....//
        if ($show_encod->results[0]) echo '<h3>'.$shows_count.' results for TV shows found';
        if ($shows_count > 5) echo ', displaying the top 5</h3><br>';
        else echo '</h3>';

        for ($j = 0; $j <= 4; $j++) {
          if ($show_encod->results[$j]) {
              echo '<div class="content">';
              echo '<form action="mediapage.php" method="POST" accept-charset=utf-8>';
              echo '<input type="image" name="show_name" value="'.$show_encod->results[$j]->name.'" src="http://image.tmdb.org/t/p/original/'.$show_encod->results[$j]->poster_path.'" height = "150">';
              echo '<input type="hidden" name="show_id" value="'.$show_encod->results[$j]->id.'">';
              echo '<h4>'.$show_encod->results[$j]->name.'</h4><br>';
              echo truncateToWord($show_encod->results[$j]->overview).'<br>';
              echo '</form>';
              echo '</div>';
              echo '<hr>';
          }
        }
      ?>
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