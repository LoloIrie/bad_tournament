<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 10.11.2017
 * Time: 11:42
 */

/* Get all tournaments */
function badt_db_get_tournaments( $tournament_id = false, $get_last = false ){

    global $wpdb;

    if( !$tournament_id ){
        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_tournaments";
    }else if( !$get_last ){
        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_tournaments
        
        WHERE
        id=".$tournament_id;
    }else{
        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_tournaments
        
        ORDER BY
        id DESC
        
        LIMIT
        0,1";
    }

    $tournaments = $wpdb->get_results( $query  );

    return $tournaments;
}

/* Get all tournaments */
function badt_db_get_clubs( $club_id = false ){

    global $wpdb;

    if( !$club_id ){
        $query = "SELECT
        *

        FROM
        ".$wpdb->prefix."bvg_clubs

        ORDER BY
        name ASC";
    }else{
        $query = "SELECT
        *

        FROM
        ".$wpdb->prefix."bvg_clubs

        WHERE
        id=".$club_id;
    }


    $clubs = $wpdb->get_results( $query );

    return $clubs;
}

/* Get all players */
function badt_db_get_all_players( $club_restriction = false ){

    global $wpdb;

    $where = '';
    if( is_numeric( $club_restriction ) ){
        $where = 'AND
        club_id = '.$club_restriction;
    }
    $query = "SELECT
    pl.id as player_id,
    pl.firstname as player_firstname,
    pl.lastname as player_lastname,
    pl.player_level as player_level,
    pl.sex as player_sex,
    pl.status as status
    
    FROM
    ".$wpdb->prefix."bvg_players as pl
    
    WHERE
    pl.status=1
    ".$where."
    
    ORDER BY
    pl.lastname ASC, pl.firstname ASC
    ";
    $all_players = $wpdb->get_results( $query, OBJECT_K  );
    //echo $query;

    return $all_players;
}

/* Get all players for the current tournament */
function badt_db_get_players( $tournament_id = false ){

    global $wpdb;

    if( !$tournament_id ){
        $tournament_id = $_SESSION['t_id'];
    }

    $query = "SELECT
    pl_t.id as id,
    pl.id as player_id,
    pl.firstname as player_firstname,
    pl.lastname as player_lastname,
    pl.sex as player_sex,
    pl_t.*
    
    FROM
    ".$wpdb->prefix."bvg_players as pl
    JOIN
    ".$wpdb->prefix."bvg_players_tournament as pl_t
    ON
    pl.id = pl_t.players_id
    
    WHERE
    pl_t.tournament_id = ".$tournament_id."
    
    ORDER BY
    pl_t.points_major DESC, pl_t.played ASC, pl_t.sets DESC, pl_t.sets_against ASC, pl_t.points DESC, pl_t.points_against ASC, pl_t.player_level_init DESC
    ";
    //$wpdb->show_errors();
    //echo $query;
    $players = $wpdb->get_results( $query, OBJECT_K  );
    //var_dump( $players );
    return $players;
}

/* Get played matches for the current tournament */
function badt_db_nb_matches( $tournament_id = false, $round = false, $completed = false ){

    global $wpdb;

    if( $completed === true ){
        $query = "SELECT
        count(*) as nb

        FROM
        ".$wpdb->prefix."bvg_matches

        WHERE
        tournament_id = ".$tournament_id."
        AND
        winner != 0";
    }else{
        $query = "SELECT
        count(*) as nb

        FROM
        ".$wpdb->prefix."bvg_matches

        WHERE
        tournament_id = ".$tournament_id;
    }



    $nb_matches = $wpdb->get_results( $query );

    return $nb_matches[0]->nb;
}

/* Get matches */
function badt_db_get_matches( $tournament_id = false, $round = false, $match_id = false ){

    global $wpdb;

    if( $match_id ){
        $query = "SELECT
            *
    
            FROM
            ".$wpdb->prefix."bvg_matches
    
            WHERE
            id = ".$match_id."
    
            LIMIT
            0,1
            ";
    }else{

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
    }




    $matches = $wpdb->get_results( $query );

return $matches;
}