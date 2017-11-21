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
$html .= '<input type="hidden" id="swiss_system_point" name="schweizer_system_punkte" value="0" />';

$html .= '<label>'.__('Player:', 'bad-tournament').'</label>';
$html .= '<select type="text" value="" name="player_select" id="player_select">';
$html .= '<option value="0">'.__('Choose', 'bad-tournament').'</option>';
foreach( $all_players as $k => $all_player ){
    foreach( $players as $player ){
        if( $player->players_id == $k ){
            continue 2;
        }
    }

    $html .= '<option value="'.$all_player->player_id.'" data_level="'.$all_player->player_level.'">'.$all_player->player_firstname.' '.$all_player->player_lastname.'</option>';
}
$html .= '</select>';

$html .= '<input type="submit" value="'.__('Add player to the tournament', 'bad-tournament').'" />';
$html .= '<input type="submit" value="'.__('Add all players', 'bad-tournament').'" id="all_players" name="all_players" />';
$html .= '<input type="submit" value="'.__('Remove all players for this Tournament', 'bad-tournament').'" id="player_tournament_remove" name="player_tournament_remove" />';
$html .= '<input type="submit" value="'.__('Set player as inactive', 'bad-tournament').'" id="player_down" name="player_down" />';

$html .= '</form>';

$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add-players" />';



$html .= '<label>'.__('Firstname:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Firstname', 'bad-tournament').'" name="firstname" />';
$html .= '<label>'.__('Lastname:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Lastname', 'bad-tournament').'" name="lastname" />';
$html .= '<label>'.__('Value (for swiss system):', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Points', 'bad-tournament').'" name="swiss_system_point" />';

$html .= '<input type="submit" value="'.__('Add player to the tournament', 'bad-tournament').'" />';


$html .= '</form>';


$html .= '</div>';
