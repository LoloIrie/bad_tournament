<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */
global $wpdb;
$csv = '';

/* Default query: EVERYTHING */
if( $_POST['type_data'] == 1 ){

    $tables = array(
        'bvg_clubs',
        'bvg_matches',
        'bvg_players',
        'bvg_players_tournament',
        'bvg_tournaments');

    foreach( $tables as $table ){

        $query = "SELECT
*

FROM
".$wpdb->prefix.$table;

        //echo $query;
        $results = $wpdb->get_results( $query, ARRAY_A );
        //$results .= print_r( $data, 1 );

        $csv_table = '"'.implode('";"',array_keys($results[0])).'";'."\n";

        foreach ($results as $row) {
            $csv_table .= '"'.implode('";"',$row).'";'."\n";
        }
        $csv_table .= "\n";
        $csv .= $csv_table;
    }

}


if( isset( $asFile ) && $asFile === true){

    $filename = "bad_tournament";
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header("Content-type: text/csv");
    header("Content-disposition: attachment; filename=".$filename.".csv");
    header('Pragma: no-cache');
    echo $csv;
    exit;
}



$bvg_admin_msg .= __( 'Data exported !', 'bad-tournament' );