<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */

//var_dump( $all_players );

/* Players */
//$html .= '<div class="admin_block_label">Spieler</div>';
$html .= '<div class="admin_block nav_player" id="block_add_players" '.( $ADMIN_VIEW == 'players' ? 'style="display: block;"' : '' ).'>';

$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add-existing-players" />';
//$html .= '<input type="hidden" id="swiss_system_point" name="schweizer_system_punkte" value="0" />';

$html .= '<label>'.__('Player:', 'bad-tournament').'</label>';
$html .= '<select type="text" value="" name="player_select[]" id="player_select" multiple="multiple" >';
//$html .= '<option value="0">'.__('Choose', 'bad-tournament').'</option>';
foreach( $all_players as $k => $all_player ){
    foreach( $players as $player ){
        if( $player->players_id == $k ){
            continue 2;
        }
    }

    $html .= '<option value="'.$all_player->player_id.'" data_level="'.$all_player->player_level.'">'.$all_player->player_firstname.' '.$all_player->player_lastname.'</option>';
}
$html .= '</select>';

$html .= '<hr />';
$html .= '<input type="submit" value="'.__('Add player(s) to the tournament', 'bad-tournament').'" />';
$html .= '<input type="submit" value="'.__('Add all players', 'bad-tournament').'" id="all_players" name="all_players" />';
$html .= '<input type="submit" value="'.__('Remove all players for this Tournament', 'bad-tournament').'" id="player_tournament_remove" name="player_tournament_remove" />';
$html .= '<input type="submit" value="'.__('Set player(s) as inactive', 'bad-tournament').'" id="player_down" name="player_down" />';

$html .= '</form>';
$html .= '<hr />';

$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add-players" />';



$html .= '<label>'.__('Firstname:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Firstname', 'bad-tournament').'" name="firstname" />';
$html .= '<label>'.__('Lastname:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Lastname', 'bad-tournament').'" name="lastname" />';

$html .= '<div class="plus_icon"></div><br />';

$html .= '<div id="player_infos_extended" class="admin_block_extended">';

    $html .= '<label>'.__('Club:', 'bad-tournament').'</label>';

    $club_name = 'BVG Goldbach/Laufach';
    $club_id = 1;
    $html .= '<select name="club_id">';
    $html .= '<option value="'.$club_id.'" >'.$club_name.'</option>';
    $html .= '</select>';

    $html .= '<label>'.__('Player ID:', 'bad-tournament').'</label>';
    $html .= '<input type="text" value="" placeholder="'.__('XXXXXXXXX', 'bad-tournament').'" name="player_id" />';

    $html .= '<label>'.__('Birthdate:', 'bad-tournament').'</label>';
    $html .= '<input type="text" value="" placeholder="'.__('DD/MM/YYYY', 'bad-tournament').'" name="birthdate" class="datepicker" />';

    $html .= '<label>'.__('Sex:', 'bad-tournament').'</label>';
    $html .= '<div class="radio_block">';
    $html .= '<span><input type="radio" value="1" placeholder="'.__('Man', 'bad-tournament').'" name="sex" id="sex1" /><label for="sex1" class="radio">'.__('Male', 'bad-tournament').'</label></span>';
    $html .= '<span><input type="radio" value="2" placeholder="'.__('Woman', 'bad-tournament').'" name="sex" id="sex2" /><label for="sex2" class="radio">'.__('Female', 'bad-tournament').'</label></span>';
    $html .= '</div>';

    $html .= '<label>'.__('Value (for swiss system):', 'bad-tournament').'</label>';
    $html .= '<input type="text" value="" placeholder="'.__('Points', 'bad-tournament').'" name="swiss_system_point" />';

$html .= '</div>';



$html .= '<hr />';
$html .= '<input type="submit" value="'.__('Add player to the tournament', 'bad-tournament').'" />';
$html .= '<hr />';

$html .= '</form>';


$html .= '</div>';
