<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */

/*
echo '<pre>';
var_dump( $all_players );
var_dump( $players );
echo '</pre>';
*/

/* Clubs */
//$html .= '<div class="admin_block_label">Clubs</div>';
$html .= '<div class="admin_block nav_club" id="block_add_clubs" '.( $ADMIN_VIEW == 'clubs' ? 'style="display: block;"' : '' ).'>';


if( !empty( $clubs) ) {
    $html .= '<div id="existing_clubs">';
        $html .= '<h2>'.__( 'Existing clubs' , 'bad-tournament' ).'</h2>';
        $html .= '<ul id="existing_clubs_list">';
        foreach( $clubs as $club){
            $html .= '<li>'.$club->name.'</li>';
        }
        $html .= '</ul>';
    $html .= '</div>';
}



$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add-clubs" />';



$html .= '<label>'.__('Name:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Name', 'bad-tournament').'" name="club_name" />';

$html .= '<label>'.__('Club ID:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('XXXXXXXXX', 'bad-tournament').'" name="club_id" />';

$html .= '<label>'.__('Club URL:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('https://', 'bad-tournament').'" name="club_url" />';


$html .= '<label>'.__('Contact:', 'bad-tournament').'</label>';

$html .= '<select name="contact_id">';
$html .= '<option value="0" >'.__( 'Choose...' , 'bad-tournament' ).'</option>';
foreach( $all_players as $player ) {
    $html .= '<option value="'.$player->id.'" >'.$player->player_firstname.' '.$player->player_lastname.'</option>';
}

$html .= '</select>';


$html .= '<label>'.__('Set as default:', 'bad-tournament').'</label>';
$html .= '<input type="checkbox" value="1" name="club_as_default" />';


$html .= '<hr />';
$html .= '<input type="submit" value="'.__('Add club', 'bad-tournament').'" />';
$html .= '<hr />';

$html .= '</form>';


$html .= '</div>';
