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
        $csv .= badt_generate_csv( $table );
    }

}else if( $_GET['type_data'] == 2 || substr( $_GET['type_data'] , 0, 2 ) == '2,' ){

    /* CURRENT TOURNAMENT */
    if( isset( $_SESSION[ 't_id' ] ) ){
        $t_id = $_SESSION['t_id'];


        /* Get Tournament */
        $sql_extended = " WHERE
        id=".$t_id."
        
        LIMIT
        0,1";
        $csv .= badt_generate_csv( 'bvg_tournaments', $sql_extended );
        unset( $sql_extended );
        /* Tournament END */

        if( !empty( $results ) && $results[0]['club_restriction'] > 0 ){
            /* Get Club if club restriction */
            $sql_extended = " WHERE
            id=".$results[0]['club_restriction']."
            
            LIMIT
            0,1";
            $csv .= badt_generate_csv( 'bvg_clubs', $sql_extended );
            unset( $sql_extended );
            /* Club END */
        }


        /* Get tournament players */
        $sql_extended = " WHERE
        tournament_id=".$t_id."

        ORDER BY
        id
        ASC";
        $tmp = badt_generate_csv( 'bvg_players_tournament', $sql_extended, 'players_id' );
        $csv .= $tmp[0];
        $players_id = $tmp[1];
        unset( $sql_extended, $tmp );
        /* Tournament players END */

        /* Get players */
        $sql_extended = " WHERE
        id IN (".$players_id.")

        ORDER BY
        id
        ASC";
        $csv .= badt_generate_csv( 'bvg_players', $sql_extended );
        unset( $sql_extended );
        /* Players END */


        /* Get matches */
        $sql_extended = "WHERE
        tournament_id=".$t_id."

        ORDER BY
        id
        ASC";
        $csv .= badt_generate_csv( 'bvg_matches', $sql_extended );
        unset( $sql_extended );
        /* Matches END */
    }

}else{
    /* Custom tables choice */
    /* TOURNAMENTS */
    if( $_GET['type_data'] == 3 || substr( $_GET['type_data'] , 0, 2 ) == '3,' || strpos( $_GET['type_data'] , ',3,' ) !== false || substr( $_GET['type_data'] , -2 ) == ',3' ){
        /* Get Tournaments */
        $csv .= badt_generate_csv( 'bvg_tournaments' );
        /* Tournaments END */
    }

    /* CLUBS */
    if( $_GET['type_data'] == 4 || substr( $_GET['type_data'] , 0, 2 ) == '4,' || strpos( $_GET['type_data'] , ',4,' ) !== false || substr( $_GET['type_data'] , -2 ) == ',4' ){
        /* Get Clubs */
        $csv .= badt_generate_csv( 'bvg_clubs' );
        /* Clubs END */
    }

    /* PLAYERS */
    if( $_GET['type_data'] == 5 || substr( $_GET['type_data'] , 0, 2 ) == '5,' || strpos( $_GET['type_data'] , ',5,' ) !== false || substr( $_GET['type_data'] , -2 ) == ',5' ){
        /* Get Players */
        $csv .= badt_generate_csv( 'bvg_players' );
        /* Players END */

        /* Get Players/Tournament */
        $csv .= badt_generate_csv( 'bvg_players_tournament' );
        /* Players/Tournament END */
    }

    /* MATCHES */
    if( $_GET['type_data'] == 6 || substr( $_GET['type_data'] , 0, 2 ) == '6,' || strpos( $_GET['type_data'] , ',6,' ) !== false || substr( $_GET['type_data'] , -2 ) == ',6' ){
        /* Get Matches */
        $csv .= badt_generate_csv( 'bvg_matches' );
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

function badt_generate_csv( $table , $sql_extended = false, $field_to_inString = false ){

    global $wpdb;

    $str = "#".$table."\n";
    $inStr = '';

    $query = "SELECT
    *
    
    FROM
    ".$wpdb->prefix.$table;

    if( badt_generate_csv !== false ){
        $query .= " 
        ".$sql_extended;
    }

    $results = $wpdb->get_results( $query, ARRAY_A );

    if( !empty( $results ) ){
        $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

        foreach ($results as $row) {
            $csv_table .= '"'.implode('";"',$row).'";'."\n";
            if( $field_to_inString !== false ){
                $inStr .= $row[ $field_to_inString ].',';
            }
        }
        $inStr = substr( $inStr , 0, -1 );
    }

    $csv_table .= "\n";

    $str .= $csv_table;

    if( $field_to_inString !== false ) {
        return array( $str , $inStr );
    }else{
        return $str;
    }
}