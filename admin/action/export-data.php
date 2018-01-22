<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */
global $wpdb;
$csv = '';

if( isset( $_POST['export'] ) ){
    $_GET['type_data'] = implode( ',' , $_POST['export'] );
}
/*
var_dump( $_POST['export'] );
var_dump( $_GET['type_data'] );
*/

$tables = array(
    'bvg_clubs',
    'bvg_matches',
    'bvg_players',
    'bvg_players_tournament',
    'bvg_tournaments');


if( $_GET['type_data'] == 1 || substr( $_GET['type_data'] , 0, 2 ) == '1,' ){
    /* EVERYTHING */

    foreach( $tables as $table ){
        $csv .= "#".$table."\n";

        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix.$table;

        //echo $query;
        $results = $wpdb->get_results( $query, ARRAY_A );
        //$results .= print_r( $data, 1 );

        if( !empty( $results ) ){
            $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

            foreach ($results as $row) {
                $csv_table .= '"'.implode('";"',$row).'";'."\n";
            }
        }

        $csv_table .= "\n";
        $csv .= $csv_table;
    }
}else if( $_GET['type_data'] == 2 || substr( $_GET['type_data'] , 0, 2 ) == '2,' ){
    /* CURRENT TOURNAMENT */
    if( isset( $_SESSION[ 't_id' ] ) ){
        $t_id = $_SESSION['t_id'];


        /* Get tournament */
        $csv .= "#tournaments\n";

        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_tournaments
        
        WHERE
        id=".$t_id."
        
        LIMIT
        0,1
        ";
        $results = $wpdb->get_results( $query, ARRAY_A );

        if( !empty( $results ) ){
            $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

            foreach ($results as $row) {
                $csv_table .= '"'.implode('";"',$row).'";'."\n";
            }
        }

        $csv_table .= "\n";
        $csv .= $csv_table;
        unset( $results );
        /* Tournament END */

        if( !empty( $results ) && $results[0]['club_restriction'] > 0 ){
            /* Get Club if club restriction */
            $csv .= "#clubs\n";

            $query = "SELECT
            *
            
            FROM
            ".$wpdb->prefix."bvg_clubs
            
            WHERE
            id=".$results[0]['club_restriction']."
            
            LIMIT
            0,1
            ";
            $results = $wpdb->get_results( $query, ARRAY_A );

            if( !empty( $results ) ){
                $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

                foreach ($results as $row) {
                    $csv_table .= '"'.implode('";"',$row).'";'."\n";
                }
            }

            $csv_table .= "\n";
            $csv .= $csv_table;
            unset( $results );

            /* Club END */
        }


        /* Get tournament players */
        $csv .= "#bvg_players_tournament\n";

        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_players_tournament
        
        WHERE
        tournament_id=".$t_id."

        ORDER BY
        id
        ASC";
        $results = $wpdb->get_results( $query, ARRAY_A );

        if( !empty( $results ) ){
            $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

            $players_id_str = '';
            foreach ($results as $row) {
                $csv_table .= '"'.implode('";"',$row).'";'."\n";
                $players_id .= $row['players_id'].',';
            }
            $players_id = substr( $players_id , 0, -1 );
        }

        $csv_table .= "\n";
        $csv .= $csv_table;
        unset( $results );
        /* Tournament players END */



        /* Get players */
        $csv .= "#bvg_players\n";

        $query = "SELECT
        *
        
        FROM
        ".$wpdb->prefix."bvg_players
        
        WHERE
        id IN (".$players_id.")

        ORDER BY
        id
        ASC";
        $results = $wpdb->get_results( $query, ARRAY_A );

        if( !empty( $results ) ){
            $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

            foreach ($results as $row) {
                $csv_table .= '"'.implode('";"',$row).'";'."\n";
            }
        }

        $csv_table .= "\n";
        $csv .= $csv_table;
        unset( $results );
        /* Players END */


        /* Get matches */
        $csv .= "#bvg_matches\n";

        $query = "SELECT
        *

        FROM
        ".$wpdb->prefix."bvg_matches

        WHERE
        tournament_id=".$t_id."

        ORDER BY
        id
        ASC";
        $results = $wpdb->get_results( $query, ARRAY_A );

        if( !empty( $results ) ){
            $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

            foreach ($results as $row) {
                $csv_table .= '"'.implode('";"',$row).'";'."\n";
            }
        }

        $csv_table .= "\n";
        $csv .= $csv_table;
        unset( $results );
        /* Matches END */
    }



}


if( isset( $asFile ) && $asFile === true){

    $filename = "bad_tournament_".date( "Ymd_Hi" );
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header("Content-type: text/csv");
    header("Content-disposition: attachment; filename=".$filename.".csv");
    header('Pragma: no-cache');
    echo $csv;
    exit;
}



$bvg_admin_msg .= __( 'Data exported !', 'bad-tournament' );