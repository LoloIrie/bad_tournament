<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */



$json_data = $_POST[ 'json_data' ];
$matches = json_decode( stripslashes( $json_data ) );

/*
echo '<pre>';
var_dump( $matches );
die();
*/

foreach( $matches as $match ){
    $bvg_admin_msg .= badt_delete_match( $match );
}

$bvg_admin_msg .= __( 'Selected matches successfully deleted.' , 'bad-tournament' ).'<br />';
return $bvg_admin_msg;

function badt_delete_match( $match ){
    //var_dump( $match[6] ); echo '<hr />';
    $match_id = 0;
    $pl1_id = 0;
    $pl2_id = 0;
    foreach( $match as $m){
        if( $m->name == 'match_id' ){
            if( !is_numeric( $m->value ) || $m->value < 1 ){
                return false;
            }
            $match_id = $m->value;
        }
        if( $m->name == 'pl1_id' ){
            $pl1_id = $m->value;
        }
        if( $m->name == 'pl2_id' ){
            $pl2_id = $m->value;
        }
    }

    if( $match_id > 0 ){
        global $wpdb;
        $bvg_admin_msg = '';

        $wpdb->query( $wpdb->prepare(
            "DELETE FROM
            ".$wpdb->prefix . 'bvg_matches'."

            WHERE
            id=%d

            LIMIT
            1",

            $match_id
        )
        );

        $bvg_admin_msg .= __( 'Match ID deleted: '.$match_id);

        if( $bvg_admin_msg .= badt_remove_opponent( $pl1_id, $pl2_id) ){
            $bvg_admin_msg .= '<br />'.__( 'Opponents for this match deleted: '.$match_id);
        }
    }


    return $bvg_admin_msg.'<br />';
}

function badt_remove_opponent( $pl1_id = 0, $pl2_id = 0){
    $bvg_admin_msg = '';

    global $wpdb;

    if( $pl1_id == 0 ){
        return false;
    }

    // Get opponents for the first player
    $query = "SELECT
    *

    FROM
    ".$wpdb->prefix."bvg_players_tournament

    WHERE
    id = ".$pl1_id;
    $match = $wpdb->get_results( $query );

    $bvg_admin_msg .= '<br />Need to remove: '.$pl1_id .' '.$query;
    $bvg_admin_msg .= '<br />Opponents before: '.$match[0]->opponents.' Remove:'.$pl2_id.'-';
    if( strpos( $match[0]->opponents , $pl2_id.'-' ) > -1 ){
        // Remove opponents for the first player

        $match[0]->opponents = str_replace( $pl2_id.'-', '', $match[0]->opponents );
        $bvg_admin_msg .= '<br />Opponents after: '.$match[0]->opponents;
        $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = '". $match[0]->opponents ."'

                    WHERE
                    id=".$pl1_id
        );

        // Remove opponents for the second player
        $query = "SELECT
        *

        FROM
        ".$wpdb->prefix."bvg_players_tournament

        WHERE
        id = ".$pl2_id;
        $match = $wpdb->get_results( $query );

        $match[0]->opponents = str_replace( $pl1_id.'-', '', $match[0]->opponents );

        $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = '". $match[0]->opponents ."'

                    WHERE
                    id=".$pl2_id
        );
    }

    return $bvg_admin_msg;
}
