<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 10.11.2017
 * Time: 11:42
 */

/* Get all tournaments */
function db_get_tournaments( $tournament_id = false ){

    global $wpdb;

    if( !$tournament_id ){
        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_tournaments";
    }else{
        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_tournaments
        
        WHERE
        id=".$tournament_id;
    }


    $tournaments = $wpdb->get_results( $query  );

    return $tournaments;
}

/* Get all players */
function db_get_all_players(){

    global $wpdb;

    $query = "SELECT
    pl.id as player_id,
    pl.firstname as player_firstname,
    pl.lastname as player_lastname,
    pl.player_level as player_level,
    pl.status as status
    
    FROM
    ".$wpdb->prefix."bvg_players as pl
    
    WHERE
    pl.status=1
    
    ORDER BY
    pl.lastname ASC, pl.firstname ASC
    ";
    $all_players = $wpdb->get_results( $query, OBJECT_K  );

    return $all_players;
}

/* Get all players for the current tournament */
function db_get_players( $tournament_id = false ){

    global $wpdb;

    if( !$tournament_id ){
        $tournament_id = $_SESSION['t_id'];
    }

    $query = "SELECT
    pl_t.id as id,
    pl.id as player_id,
    pl.firstname as player_firstname,
    pl.lastname as player_lastname,
    pl_t.*
    
    FROM
    ".$wpdb->prefix."bvg_players as pl
    JOIN
    ".$wpdb->prefix."bvg_players_tournament as pl_t
    ON
    pl.id = pl_t.players_id
    
    WHERE
    pl_t.tournament_id = ".$tournament_id."
    AND
    pl.status=1
    
    ORDER BY
    pl_t.points_major DESC, pl_t.played ASC, pl_t.sets DESC, pl_t.sets_against ASC, pl_t.points DESC, pl_t.points_against ASC, pl_t.player_level_init DESC
    ";
    //$wpdb->show_errors();
    //echo $query;
    $players = $wpdb->get_results( $query, OBJECT_K  );
    //var_dump( $players );
    return $players;
}

/* Get matches */
function db_get_matches( $tournament_id = false, $round = false ){

    global $wpdb;

    if( !$tournament_id ){
        $tournament_id = $_SESSION['t_id'];
    }

    if( !$round ){
        $query = "SELECT
        *

        FROM
        ".$wpdb->prefix."bvg_matches

        WHERE
        tournament_id = ".$tournament_id."

        ORDER BY
        round, id ASC
        ";
    }else{
        $query = "SELECT
        *

        FROM
        ".$wpdb->prefix."bvg_matches

        WHERE
        tournament_id = ".$tournament_id."
        AND
        round = ".$round."

        ORDER BY
        id ASC
        ";
    }


    $matches = $wpdb->get_results( $query );

return $matches;
}