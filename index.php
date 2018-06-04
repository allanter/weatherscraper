<?php
    
    error_reporting(E_ERROR | E_PARSE);

    //used to curb UNDEFINED INDEX notice

    $weather = "";

    $error = "";

if ($_GET['city']) {
    
    $city = str_replace(' ', '', $_GET['city']);
    
        $handle = curl_init("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
    
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE); 
        
    //used to curb error message of URL

        if($httpCode >= 200 && $httpCode < 400) {
            $weather = "";
        } else {
            $error = "That city could not be found.";
        }

        curl_close($handle);
    }
    

    
    $forecastPage = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
    
    $pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecastPage);

    if (sizeof ($pageArray) > 1) {
    
    $secondPageArray = explode('</span></span></span>', $pageArray[1]);
        
    if (sizeof ($secondPageArray) > 1) {
    
    $weather = $secondPageArray[0];
    
    } else {
        
        $error = "That city could not be found.";
        
    }
    
        } 
    


?>

<!DOCTYPE html>
<html lang="en"
      xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      
      
      <title>Weather Scraper</title>
      
      <meta property="og:title" content="The Weather Scraper"/>
    <meta property="og:type" content="Weather"/>
    <meta property="og:url" content="http://exodusdev.net/"/>
    <meta property="og:image" content="http://exodusdev.net/thunderlighting.jpg"/>


    <meta property="og:description"
          content="A friendly, easy to user Weather Forecast website that shows the weather from cities around the world! - Done by Allan Ter"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <style type="text/css">
      
          html {
              
            background: url(thunderlighting.jpg) no-repeat center center fixed;
            -webkit-background-repeat: cover;
            -moz-background-position: center;
            background-size: cover;
              height: 100%;
              width: 100%;
                  
          }
          
          body {
              
              background: none;
              color: white;
          }
          
          .container {
              
              text-align: center;
              margin-top: 100px;
              width: 450px;
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
      
    <h1>What's The Weather</h1>
          

      
      <form>
  <div class="form-group">
    <label for="city">Enter the name of a city</label>
    <input type="text" class="form-control" name="city" id="city" aria-describedby="emailHelp" placeholder="Eg. Singapore, London, New York" value = "<?php echo $_GET['city']; ?>">

  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
          
            <div id="weather"><?php 
                
                if ($weather) {
                    
                    echo '<div class="alert alert-success" role="alert">'.$weather.'
</div>';
                } else if ($error) {
                    
                    echo '<div class="alert alert-danger" role="alert">'.$error.'
</div>';
                    
                }
                
                
                ?></div>
          </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>