<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

if( !is_numeric( $_POST[ 'tournament_cleanup_select' ] ) ){
    $bvg_admin_msg .= __( 'Error to cleanup this tournament, please try again...', 'bad-tournament' );
}else{
    $t_id = $_POST[ 'tournament_cleanup_select' ];

    // Table bvg_matches
    $wp_table = $wpdb->prefix.'bvg_matches';

    $query = "DELETE FROM
    ".$wp_table."

    WHERE
    tournament_id = ".$t_id;

    $wpdb->query( $query );
    $bvg_admin_msg .= __( 'Matches removed for this tournament !', 'bad-tournament' ).'<br />';



    // Table bvg_players_tournament
    $wp_table = $wpdb->prefix.'bvg_players_tournament';

    $query = "DELETE FROM
    ".$wp_table."

    WHERE
    tournament_id = ".$t_id;

    $wpdb->query( $query );
    $bvg_admin_msg .= __( 'Players removed for this tournament !', 'bad-tournament' ).'<br />';



    // Table bvg_tournaments
    $wp_table = $wpdb->prefix.'bvg_tournaments';

    $query = "UPDATE
    ".$wp_table."

    SET
    round=1

    WHERE
    id = ".$t_id;

    $wpdb->query( $query );
    $bvg_admin_msg .= __( 'Reinitialized to first round.', 'bad-tournament' ).'<br />';


    // Update session values if required
    if( $_SESSION[ 't_id' ] == $t_id ){
        $_SESSION[ 'round' ] = 1;
    }

    $bvg_admin_msg .= __( 'Tournament cleaned !', 'bad-tournament' );
}






