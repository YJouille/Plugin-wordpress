<?php
require_once  (__DIR__ . '/../Models/Data.php');

$data = new Data();

 function saveAPIKey(){
     global $data;
     $data->saveAPIKeyData();
 }

 function getWheather($atts){

     $data = new Data();
     $datas = $data->getwheatherOf($atts);
    $desc = $datas['weather'][0]['description'];
    $tmp = $datas['main']['temp'];

     $url_icon = "http://openweathermap.org/img/wn/".$datas['weather'][0]['icon']."@2x.png";

     require_once(__DIR__ . '/../Views/wheatherView.php');
     return $html;
     exit();    
 }

 function getWheatherForecast($atts){
    $data = new Data();

    $datas = $data->getwheatherForecastOf($atts);
    //echo '<pre>';var_dump($datas);exit;

    $desc = $datas['list'][0]['weather'][0]['description'];
    $tmp = $datas['list'][0]['main']['temp'];
    $url_icon = "http://openweathermap.org/img/wn/".$datas['list'][0]['weather'][0]['icon']."@2x.png";

    require_once(__DIR__ . '/../Views/wheatherForecastView.php');
    return $html;
    exit(); 
 }