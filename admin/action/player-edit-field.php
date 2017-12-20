<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

if( !is_numeric( $_POST['pl_id'] ) ){

    $html_ajax .= 'Fehler: etwas stimmt hier nicht...';
}else{
    global $wpdb;

    $data = array(
        $_POST['pl_field_name'] => $_POST['pl_field_value']
    );
    $wpdb->update( $wpdb->prefix . 'bvg_players',
        $data,
        array( 'id' => $_POST['pl_id'] ) );

    $html_ajax .= __('Player value "'. $_POST['pl_field_name'] .'" updated with '. $_POST['pl_field_value'], 'bad-tournament' );

}