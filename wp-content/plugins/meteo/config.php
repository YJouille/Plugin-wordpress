<?php
/**
 * @package Meteo
 * @version 1.0.0
 */
/*
Plugin Name: Meteo
Plugin URI: http://acs.com
Description: PLugin méteo utilisant les information de l'api depuis le site https://openweathermap.org/ .Ce plugin utilise également l'api https://geo.api.gouv.fr/communes
Version: 1.0.0
Author URI: http://acs.com
*/
add_action('admin_menu','lienDeMenu');

function lienDeMenu(){
    add_menu_page(
        'La page de plugin', //titre de ma page
        'Meteo', //lien vers la page admin
        'manage_options',
        plugin_dir_path(__FILE__).'includes/plugin-page.php'//l'adresse cible du lien menu
    );
}

