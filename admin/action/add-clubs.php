<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */


$data = array(
    'name' => $_POST['club_name'],
    'club_id' => $_POST['club_id'],
    'url' => $_POST['club_url'],
    'contact_id' => $_POST['contact_id']
);
$wpdb->insert( $wpdb->prefix . 'bvg_clubs', $data );

$_SESSION[ 'cl_id' ] = $wpdb->insert_id;

$bvg_admin_msg .= __( 'New club added...', 'bad-tournament' );