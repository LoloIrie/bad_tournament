<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

$new_t_id = 1;
$new_t_name = 'BVG Tournament 2027';

if( empty( $_POST['tournament_name'] ) && is_numeric( $_POST['tournament_select'] ) ){

    // SELECT EXISTING TOURNAMENT

    $new_t_id = $_POST['tournament_select'];

    $query = "SELECT
*

FROM
".$wpdb->prefix."bvg_tournaments

WHERE
id=".$new_t_id."

LIMIT
0,1";
    $tournaments = $wpdb->get_results( $query );
    $new_t_name = $tournaments[0]->name;
    $new_t_system = $tournaments[0]->system;
    $_SESSION['round'] = $tournaments[0]->round;
    $_SESSION['current_tournament'] = get_object_vars( $tournaments[0] );
}else{

    // CREATE NEW TOURNAMENT

    $parent_id = 0;
    if( $_POST['tournament_select_id'] > 0 ){
        $parent_id = $_POST['tournament_select_id'];
    }

    $nb_sets = 2;
    if( isset( $_POST['tournament_nb_sets'] ) && is_numeric( $_POST['tournament_nb_sets'] ) ){
        $nb_sets = $_POST['tournament_nb_sets'];
    }

    $points_sets = 21;
    if( isset( $_POST['tournament_points_set'] ) && is_numeric( $_POST['tournament_points_set'] ) ){
        $points_sets = $_POST['tournament_points_set'];
    }

    $tournament_max_points_set = 30;
    if( isset( $_POST['tournament_max_points_set'] ) && is_numeric( $_POST['tournament_max_points_set'] ) ){
        $tournament_max_points_set = $_POST['tournament_max_points_set'];
    }

    $data = array(
        'parent_id' => $parent_id,
        'name' => $_POST['tournament_name'],
        'round' => 1,
        'system' => $_POST['tournament_system'],
        'nb_sets' => $nb_sets,
        'points_set' => $points_sets,
        'max_points_set' => $tournament_max_points_set
    );
    //$wpdb->show_errors();
    $wpdb->insert( $wpdb->prefix . 'bvg_tournaments', $data );

    $new_t_id = $wpdb->insert_id;
    $data['id'] = $new_t_id;
    $_SESSION['current_tournament'] = $data;
    $new_t_name = $_POST['tournament_name'];
    $new_t_system = $_POST['tournament_system'];
    $_SESSION['round'] = 1;
}

/*
$wpdb->show_errors();
$wpdb->print_error();
*/
$_SESSION['t_id'] = $new_t_id;
$_SESSION['t_name'] = $new_t_name;
$_SESSION['t_system'] = $new_t_system;
$bvg_admin_msg .= 'Aktives Turnier: '.$_SESSION['t_name'].' !!!';