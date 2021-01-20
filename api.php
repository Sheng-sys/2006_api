<?php

// header('Access-Control-Allow-Origin:*');
 $city = $_GET['cityName'];
 
 $key = '5bdeb03999fa4024a54b5fb9754a4dab';

 $code = file_get_contents("https://devapi.qweather.com/v7/weather/now?location={$city}&key={$key}&gzip=n");
 
 echo $code;  
?>