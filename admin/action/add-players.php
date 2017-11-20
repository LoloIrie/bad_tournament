<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */


$data = array(
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'player_level' => $_POST['schweizer_system_punkte'],
    'status' => 1
);
$wpdb->insert( $wpdb->prefix . 'bvg_players', $data );


$data = array(
    'tournament_id' => $_SESSION['t_id'],
    'players_id' => $wpdb->insert_id,
    'player_level_init' => $_POST['schweizer_system_punkte']
);
$wpdb->insert( $wpdb->prefix . 'bvg_players_tournament', $data );


$bvg_admin_msg .= 'Neuer Spieler gespeichert...';