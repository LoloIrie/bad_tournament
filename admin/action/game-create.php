<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */
//$wpdb->show_errors();

//var_dump( $_POST );
$players_forMatch = array(
    $_POST[ 'pl1_m_name' ],
    $_POST[ 'pl2_m_name' ]
);
if( isset( $_POST[ 'pl1_m_name_bis' ] ) ){
    $players_forMatch[2] = $_POST[ 'pl1_m_name_bis' ];
    $players_forMatch[3] = $_POST[ 'pl2_m_name_bis' ];
}

$players = badt_db_get_players( $_SESSION['t_id'], $players_forMatch );


/* Create matches in DB */
if( isset( $_POST[ 'pl1_m_name_bis' ] ) ){
    $data = array(
        'player1_id' => $_POST['pl1_m_name'],
        'player2_id' => $_POST['pl2_m_name'],
        'player1_id_bis' => $_POST['pl1_m_name_bis'],
        'player2_id_bis' => $_POST['pl2_m_name_bis'],
        'tournament_id' => $_SESSION['t_id'],
        'round' => $_SESSION['round']
    );
}else{
    $data = array(
        'player1_id' => $_POST['pl1_m_name'],
        'player2_id' => $_POST['pl2_m_name'],
        'tournament_id' => $_SESSION['t_id'],
        'round' => $_SESSION['round']
    );
}
$wpdb->insert( $wpdb->prefix . 'bvg_matches', $data );
$match_id = $wpdb->insert_id;

if( isset( $_POST[ 'pl1_m_name_bis' ] ) ){
    $matches[] = array(
        'id' => $match_id,
        'player1_id' => $_POST['pl1_m_name'],
        'player2_id' => $_POST['pl2_m_name'],
        'player1_name' => '',
        'player2_name' => '',
        'player1_id_bis' => $_POST['pl1_m_name_bis'],
        'player2_id_bis' => $_POST['pl2_m_name_bis'],
        'player1_name_bis' => '',
        'player2_name_bis' => '',
        'tournament_id' => 1,
        'round' => $_SESSION['round'],
        'pl1_set1' => 0,
        'pl2_set1' => 0,
        'pl1_set2' => 0,
        'pl2_set2' => 0,
        'pl1_set3' => 0,
        'pl2_set3' => 0,
        'pl1_set4' => 0,
        'pl2_set4' => 0,
        'pl1_set5' => 0,
        'pl2_set5' => 0,
        'parent_id' => 0
    );
}else{
    $matches[] = array(
        'id' => $match_id,
        'player1_id' => $_POST['pl1_m_name'],
        'player2_id' => $_POST['pl2_m_name'],
        'player1_name' => '',
        'player2_name' => '',
        'tournament_id' => 1,
        'round' => $_SESSION['round'],
        'pl1_set1' => 0,
        'pl2_set1' => 0,
        'pl1_set2' => 0,
        'pl2_set2' => 0,
        'pl1_set3' => 0,
        'pl2_set3' => 0,
        'pl1_set4' => 0,
        'pl2_set4' => 0,
        'pl1_set5' => 0,
        'pl2_set5' => 0,
        'parent_id' => 0
    );
}


/* Add players opponents in DB */
$wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$_POST[ 'pl1_m_name' ]."', '-' )

                    WHERE
                    id=".$_POST[ 'pl2_m_name' ]
);

$wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$_POST[ 'pl2_m_name' ]."', '-' )

                    WHERE
                    id=".$_POST[ 'pl1_m_name' ]
);

$bvg_admin_msg .= '<br />Neuer Match angelegt... ID:' .$match_id;


