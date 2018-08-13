<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 * Ajax action: Save double for a tournament
 *
 */

if( !is_numeric( $_POST['pl1_id'] ) || !is_numeric( $_POST['pl2_id'] ) ){

    $html_ajax .= 'Fehler: etwas stimmt hier nicht mit dem pl1_id variable...';
}else{
    global $wpdb;
    //$wpdb->show_errors();

    $players = badt_db_get_players();
    var_dump( $players[ $_POST[ 'pl1_id' ] ] );

    $data = array(
        'tournament_id' => $_SESSION[ 't_id' ],
        'player1_id' => $_POST['pl1_id'],
        'player2_id' => $_POST['pl2_id']
    );

    if( $_SESSION['t_system'] == 1 ){
        /* Swiss tournament
        */
        $data[ 'player_level_init' ] = (int) $players[ $_POST[ 'pl1_id' ] ]->player_level_init + (int) $players[ $_POST[ 'pl2_id' ] ]->player_level_init;

    }
    var_dump( $data );

    $wpdb->insert( $wpdb->prefix . 'bvg_players_double', $data );

    $html_ajax .= __( 'This players couple is now saved', 'bad-tournament' );

}