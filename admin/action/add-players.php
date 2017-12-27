<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

$dates = explode( '/', $_POST['birthdate'] );
$birthdate = $dates[2].'-'.$dates[1].'-'.$dates[0];

$data = array(
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'player_level' => $_POST['swiss_system_point'],
    'status' => 1,
    'club_id' => $_POST['club_id'],
    'player_id' => $_POST['player_id'],
    'birthdate' => $birthdate,
    'sex' => $_POST['sex']
);
$wpdb->insert( $wpdb->prefix . 'bvg_players', $data );


$data = array(
    'tournament_id' => $_SESSION['t_id'],
    'players_id' => $wpdb->insert_id,
    'player_level_init' => $_POST['swiss_system_point']
);
$wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );


$bvg_admin_msg .= __( 'New player added...', 'bad-tournament' );