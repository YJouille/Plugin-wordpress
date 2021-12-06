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


function bootstrapStyle(){
    wp_enqueue_style('bootstrap',"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css");

}
add_action('wp_enqueue_scripts' , 'bootstrapStyle');


require_once (__DIR__. '/Models/Data.php');
require_once (__DIR__ . '/Controllers/meteoController.php');



// //A l'activation du plugin on crée 2 tables dans la base de données
// // Une table shortcode (id, shortcode) et la table communes (id, code, nom)
register_activation_hook(__FILE__, 'initialisation');


function initialisation(){

    
    global $wpdb;       
    $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."shortcode (
         id_shortcode INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         shortcode VARCHAR(30) NOT NULL
    )";
    $wpdb->query($sql);   
    $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."communes (
        id_comm INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        code_comm VARCHAR(6) NOT NULL,
        nom_comm VARCHAR(30) NOT NULL
         )"; 
     $wpdb->query($sql);

     

    

      //Remplissage de la table communes depuis l'api https://geo.api.gouv.fr/communes
      $sql = "DELETE FROM ".$wpdb->prefix."communes";
      $wpdb->query($sql);
      $curl = curl_init("https://geo.api.gouv.fr/communes");
      curl_setopt_array($curl, [
         CURLOPT_CAINFO         => __DIR__ . DIRECTORY_SEPARATOR . 'geo.cer',
         CURLOPT_RETURNTRANSFER => true
     ]);
      $communes = curl_exec($curl);
      $communes = json_decode($communes, true);
      //faire en sorte d'iterer sur la construction de la requête et non sur l'execution de la requête
     $sql = "INSERT INTO ".$wpdb->prefix."communes (code_comm, nom_comm) VALUES ";
     $params = array();
     $values = array();
      foreach ($communes as $commune) {
          $cp = implode(",", $commune['codesPostaux']);
          array_push($params,"(%d, %s)");
          array_push($values, $cp, $commune['nom']);        
         }
     $sql .= implode(" , ", $params);
 
     $wpdb->query($wpdb->prepare($sql , $values));

      curl_close($curl); 
      
      
      //Creation de la page
      //Création d'un tableau contenu toutes les caractéristiques nécessaires à la création d'un contenu
    $page_array = array(
        'post_title' => 'Météo',
        'post_content' => '',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => get_current_user_id(),
    );
    $id_page = wp_insert_post($page_array);
    add_option('meteo-pageID',$id_page);
   


    // afficher nouvelle page en page d'accueil??
    // modifier option 'page_on_front' avec pageID
    // modifier option 'show_on_front' avec 'page'
}
 
     ///////////////////////////
        



// A la suppression du plugin, supprimer : 
// les deux tables
// la clé d'API dans la table wp_options


//register_uninstall_hook(__FILE__, 'delete_database_table');
register_deactivation_hook(__FILE__, 'delete_database_table');

function delete_database_table(){
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."shortcode , ".$wpdb->prefix."communes";
    $wpdb->query($sql);
    
    //Suppression de la clé d'API
    // $sql = "DELETE FROM wp_options WHERE wp_options.option_name LIKE 'option-cleAPI'";
    // $wpdb->query($sql); //Agir directement sur les options
    delete_option('meteo-cleAPI');

    // Suppression de la page et ensuite supprimer delete_option
    wp_delete_post(get_option('meteo-pageID'),true);
    delete_option('meteo-pageID');
    }

 //Ajout de lien de notre plugin dans le menu latéral
add_action('admin_menu','lienDeMenu');

function lienDeMenu(){
    add_menu_page(
        'Administration du plugin Météo', //titre de la page
        'Meteo', //Lien devant être affiché dans la barre latérale
        'manage_options',
        
        plugin_dir_path(__FILE__).'admin/plugin-page.php'//l'adresse cible du lien menu
    );
}

/* WordPress Settings API */
function display_options()
{
    // section name, display name, callback to print description of section, page to which section is attached.
    add_settings_section("meteo_section", "Paramètres du plugin Météo", "display_header_options_content", "theme-options");
    // setting name, display name, callback to print form element, page in which field is displayed, section to which it belongs.
    // last field section is optional.
    add_settings_field("meteo-cleAPI", "Clé de l'API météo", "display_cleAPI_form_element", "theme-options", "meteo_section");
    // section name, form element name, callback for sanitization
    register_setting("meteo_section", "meteo-cleAPI");
}
// this action is executed after loads its core, after registering all actions, finds out what page to execute and before producing the actual output(before calling any action callback)
add_action("admin_init", "display_options");

function display_header_options_content()
{
    echo "Renseignez ici les paramètres du plugin Météo.";
}

function display_cleAPI_form_element()
{
    // id and name of form element should be same as the setting name.
    ?>
<input type="text" name="meteo-cleAPI" id="meteo-cleAPI"
	value="<?php echo get_option('meteo-cleAPI'); ?>" />
	<span id="meteo-msg"></span>
<script>
	var cleAPI = document.getElementById("meteo-cleAPI");
	cleAPI.addEventListener("click", copyToClipboard);
	function copyToClipboard () {
		var cleAPI = document.getElementById("meteo-cleAPI");
		/* Select the text field */
		cleAPI.select();
		cleAPI.setSelectionRange(0, 99999); /* For mobile devices */
		/* Copy the text inside the text field */
		navigator.clipboard.writeText(cleAPI.value);
		document.getElementById("meteo-msg").textContent = "copié !";
	}
</script>
<?php
}

/* Shortcode pour afficher la météo */

function meteo_shortcode($atts){

    $s = isset($atts['ville']) ? $atts['ville'] : ''; // si isset($atts['ville']) est true alors l'affecter à $s sinon affecter chaine vide à $s  
    $wheatherView = getWheather($s); //methode du controller
    return $wheatherView;
}

add_shortcode('meteo','meteo_shortcode');

/* Shortcode pour afficher la météo sur 5 jours*/
function meteo_forecast_shortcode($atts){

   
    $s = isset($atts['ville']) ? $atts['ville'] : ''; // si isset($atts['ville']) est true alors l'affecter à $s sinon affecter chaine vide à $s  
   
    $wheatherForecastView = getWheatherForecast($s); //methode du controller
    return $wheatherForecastView; 
}

add_shortcode('meteoForecast','meteo_forecast_shortcode');

