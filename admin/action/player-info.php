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
    // Can only change a game not yet started
    /* Get match infos to be sure match is not yet started/completed */
    $query = "SELECT
    *
    
    FROM
    ".$wpdb->prefix."bvg_players
    
    WHERE
    id = ".$_POST['pl_id'];
    $player = $wpdb->get_results( $query );

    $html_ajax .= '<div class="pl_tooltip_name">';
        $html_ajax .= '<label class="pl_tooltip_label">';
            $html_ajax .= __('Name: ', 'bad-tournament');
        $html_ajax .= '</label>';
        $html_ajax .= '<span class="label_row">'.$player[0]->firstname.' '.$player[0]->lastname.'</span>';
    $html_ajax .= '</div>';
    $html_ajax .= '<div class="pl_tooltip_player_id">';
        $html_ajax .= '<label class="pl_tooltip_label">';
            $html_ajax .= __('ID: ', 'bad-tournament');
        $html_ajax .= '</label>';
        $html_ajax .= '<span class="label_row">'.( $player[0]->player_id == '' ? '&nbsp;' : $player[0]->player_id ).'</span>';
    $html_ajax .= '</div>';
    $html_ajax .= '<div class="pl_tooltip_sex">';
        $html_ajax .= '<label class="pl_tooltip_label">';
            $html_ajax .= __('Sex: ', 'bad-tournament');
        $html_ajax .= '</label>';
        $html_ajax .= '<span class="label_row">'.$player[0]->sex.'</span>';
    $html_ajax .= '</div>';
    $html_ajax .= '<div class="pl_tooltip_birthdate">';
        $html_ajax .= '<label class="pl_tooltip_label">';
            $html_ajax .= __('Birthdate: ', 'bad-tournament');
        $html_ajax .= '</label>';
            $html_ajax .= '<span class="label_row">'.$player[0]->birthdate.'</span>';
    $html_ajax .= '</div>';

}