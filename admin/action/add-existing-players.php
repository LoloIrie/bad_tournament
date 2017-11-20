<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

/*
echo '<pre>';
var_dump( $all_players );
echo '</pre>';
*/
//$wpdb->show_errors();
if( isset( $_POST['player_tournament_remove'] ) ){


    $query = "DELETE FROM
    ".$wpdb->prefix."bvg_matches

    WHERE
    tournament_id=".$_SESSION['t_id'];
    $wpdb->query( $query );

    $query = "DELETE FROM
    ".$wpdb->prefix."bvg_players_tournament

    WHERE
    tournament_id=".$_SESSION['t_id'];
    $wpdb->query( $query );


    $bvg_admin_msg .= 'Alle Spieler für das Turnier gelöscht...';

}else if( isset( $_POST['player_down'] ) ){

    if( is_numeric( $_POST['player_select'] ) ){
        $query = "UPDATE
        ".$wpdb->prefix."bvg_players

        SET
        status=2

        WHERE
        id=".$_POST['player_select'];
        $wpdb->query( $query );

        // Get player ID for this tournament if existing
        /* Get all players for the current tournament */
        $query = "SELECT
        pl_t.id

        FROM
        ".$wpdb->prefix."bvg_players_tournament as pl_t


        WHERE
        players_id=".$_POST['player_select'];
        $player_tournaments = $wpdb->get_results( $query, OBJECT_K  );
        foreach( $player_tournaments as $pl_t ){
            $pl_t_ids[] = $pl_t->id;
        }
        if( is_array( $pl_t_ids ) ){
            $pl_t_ids_sql = implode( $pl_t_ids, ',' );
        }else{
            $pl_t_ids_sql = -25;
        }

        //var_dump( $pl_t_ids_sql );

        $query = $query = "UPDATE
        ".$wpdb->prefix."bvg_matches

        SET
        winner=player2_id

        WHERE
        winner=0
        AND
        (
            player1_id IN (".$pl_t_ids_sql.")
            OR
            player1_id_bis IN (".$pl_t_ids_sql.")
        )";
        //echo $query;
        $all_players = $wpdb->query( $query );

        $query = $query = "UPDATE
        ".$wpdb->prefix."bvg_matches

        SET
        winner=player1_id

        WHERE
        winner=0
        AND
        (
            player2_id IN (".$pl_t_ids_sql.")
            OR
            player2_id_bis IN (".$pl_t_ids_sql.")
        )";
        $all_players = $wpdb->query( $query );


    }


    $bvg_admin_msg .= 'Spieler als inaktiv für alle Turniere gesetzt, seine noch offene Spiele sind denn als verloren markiert...';

}else if( isset( $_POST['all_players'] ) ){

    $query = "SELECT
    pl.id as player_id,
    pl.player_level as player_level_init
    
    FROM
    ".$wpdb->prefix."bvg_players as pl

    WHERE
    pl.status=1";
    $all_players = $wpdb->get_results( $query, OBJECT_K  );

    foreach( $all_players as $pl ){
        $data = array(
            'tournament_id' => $_SESSION['t_id'],
            'players_id' => $pl->player_id,
            'player_level_init' => $pl->player_level_init
        );
        $wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );
    }
    unset( $all_players );


    $bvg_admin_msg .= 'Alle Spieler für das Turnier gespeichert...';

}else if( is_numeric( $_POST['player_select'] ) ){
    $data = array(
        'tournament_id' => $_SESSION['t_id'],
        'players_id' => $_POST['player_select'],
        'player_level_init' => $_POST['schweizer_system_punkte']
    );
    $wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );


    $bvg_admin_msg .= 'Spieler für das Turnier gespeichert...';
}

