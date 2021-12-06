<?php

class Data
{
    public function saveAPIKeyData()
    { //method to delete
        global $wpdb;
        $apiKey =  $_POST['APIKey'];
        $sql = "INSERT INTO " . $wpdb->prefix . "options(option_name, option_value, autoload )VALUES ('APIKey','" . $apiKey . "','yes')";
        $wpdb->query($sql);
    }

    public function getAPIKey()
    {
        //Retourne l'a clé d'API enregistrée dans la base
        //Ajouter les tests
        $apiKey = get_option('meteo-cleAPI');
        return $apiKey;
    }
    
    public function getwheatherOf($what)
    {  
        //renvoie la réponse du curl contenant les infos météo avec nos paramètres
        $apiKey = $this->getAPIKey();
        //var_dump($apiKey);

        $curl = curl_init("https://api.openweathermap.org/data/2.5/weather?lang=fr&units=metric&q=" . $what . "&appid=".$apiKey);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true
        ]);

        $meteo_json = curl_exec($curl);
        $meteo_json = json_decode($meteo_json, true);

        curl_close($curl);
        //var_dump($meteo_json);
        return $meteo_json;
    }

    public function getwheatherForecastOf($what)
    {  
        //renvoie la réponse du curl contenant les infos météo avec nos paramètres
        $apiKey = $this->getAPIKey();
        //var_dump($apiKey);

        $curl = curl_init("https://api.openweathermap.org/data/2.5/forecast?lang=fr&units=metric&q=" . $what . "&appid=".$apiKey);
        echo ("https://api.openweathermap.org/data/2.5/forecast?lang=fr&units=metric&q=" . $what . "&appid=".$apiKey);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true
        ]);

        $meteo_json = curl_exec($curl);
        $meteo_json = json_decode($meteo_json, true);

        curl_close($curl);
        //var_dump($meteo_json);
        return $meteo_json;
    }
}