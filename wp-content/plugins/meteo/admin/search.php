<?php
require( '../../../../wp-load.php' );

if (isset($_GET['commune']) && !empty($_GET['commune'])) {
    
    //$debutcommune = $_GET['commune'];
    //echo 'debut champ ' .$debutcommune;
    //faire la recherche dans la base ici
    global $wpdb;
    
        
    $sql = "SELECT nom_comm , code_comm FROM ".$wpdb->prefix."communes WHERE nom_comm LIKE '".$_GET['commune']."%' || code_comm LIKE '".$_GET['commune']."%'" ;
    //var_dump($sql);
    $result = $wpdb->get_results($sql); 
    

    echo json_encode($result);  

} 
