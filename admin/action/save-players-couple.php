<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

if( !is_numeric( $_POST['pl1_id'] ) || !is_numeric( $_POST['pl2_id'] ) ){

    $html_ajax .= 'Fehler: etwas stimmt hier nicht mit dem pl1_id variable...';
}else{
    global $wpdb;
    //$wpdb->show_errors();

    $data = array(
        'tournament_id' => $_SESSION[ 't_id' ],
        'player1_id' => $_POST['pl1_id'],
        'player2_id' => $_POST['pl2_id']
    );

    $wpdb->insert( $wpdb->prefix . 'bvg_players_double', $data );

    $html_ajax .= __( 'This players couple is now saved', 'bad-tournament' );

}