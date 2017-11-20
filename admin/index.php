<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */

if ( !defined( 'ABSPATH' ) ) die();
global $wpdb;
$bvg_admin_msg = '';


/* Actions */
if( isset($_POST['form_action']) ){
    include plugin_dir_path(__FILE__). 'action/'.$_POST['form_action'].'.php';
}
//echo 'XXX'.$_SESSION['round'];
if( !isset( $_SESSION['t_id'] ) ){
    $_SESSION['t_id'] = 1;
    $_SESSION['t_system'] = 1;
    $_SESSION['t_name'] = 'BVG Turnier';
}
if( !isset( $_SESSION['round'] ) ){
    $round = $wpdb->get_results( "SELECT round FROM ".$wpdb->prefix."bvg_tournaments WHERE id=".$_SESSION['t_id']." LIMIT 0,1" );
    $_SESSION['round'] = $round[0]->round;
}

/* Get DB content */
include plugin_dir_path(__FILE__). 'db-get-content.php';
$tournaments = db_get_tournaments();
$all_players = db_get_all_players();
$players = db_get_players();
$matches = db_get_matches( $_SESSION['t_id'], $_SESSION['round'] );


/* Generate matches if required */
if( empty($matches) || isset( $_POST['regenerate_matchs_now'] ) ){
    //echo $query;
    //var_dump( $players );
    include_once plugin_dir_path(__FILE__). 'action/generate-matches.php';
}



/* HTML */
$html = '';

/* Header */
include plugin_dir_path(__FILE__). 'index_html/header.php';

/* Tournament */
include plugin_dir_path(__FILE__). 'index_html/tournament-config.php';

/* Players */
include plugin_dir_path(__FILE__). 'index_html/player-config.php';

/* Table */
include plugin_dir_path(__FILE__). 'index_html/tournament-table.php';

/* Matches */
include plugin_dir_path(__FILE__). 'index_html/matches.php';


echo $html;


