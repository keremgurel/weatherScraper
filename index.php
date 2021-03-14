<?php

    $weather = "";
    $error = "";

    if ($_GET['city']) {

        $city = str_replace(' ', '', $_GET['city']);

        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $error ="That city could not be found.";
        } 
        
        else {
        $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        $pageArray = explode('(1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);

        if (sizeof ($pageArray) > 1) {
          $secondpageArray = explode('</span></p></td><td', $pageArray[1]);
          if (sizeof($secondpageArray) > 1) {
            $weather = $secondpageArray[0];
          }
          else {
            $error = "That city could not be found.";
          }
        } 
        else {
          $error = "That city could not be found.";
        }

        
        }
        
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Weather Scraper</title>

    <style type="text/css">
    html { 
        background: url(imageBackground.jpg) no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        }  
    
    body {
        background: none;
    }

    .container {
        text-align: center;
        color: white;
        margin-top: 210px;
        width: 500px;
    }

    input {
        margin: 20px 0;
    }

    #weather {
        margin-top: 15px;
    }
    
    </style>
    
  </head>
  <body>
     
    <div class="container">
        <h1>What's the weather? </h1>
        <form>
            <div class="form-group">
              <label for="city">Enter the name of a city.</label>
              <input type="text" class="form-control" name="city" id="city" 
              placeholder="Eg. London" value="<?php 

                if (array_key_exists('city', $_GET)) {
                  echo $_GET['city'];
                }              
              
               ?>">
            
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>

          <div id="weather"><?php

            if ($weather) {
                echo '<div class="alert alert-primary" role="alert">
                '.$weather.'
              </div>';
            }

            else if ($error) {
                echo '<div class="alert alert-danger" role="alert">
                '.$error.'
              </div>';
            }

          ?></div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>