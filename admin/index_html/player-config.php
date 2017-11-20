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
$html .= '<div class="admin_block nav_player" id="block_add_players">';

$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add-existing-players" />';
$html .= '<input type="hidden" id="schweizer_system_punkte" name="schweizer_system_punkte" value="0" />';

$html .= '<label>Spieler: </label>';
$html .= '<select type="text" value="" name="player_select" id="player_select">';
$html .= '<option value="0">Auswählen</option>';
foreach( $all_players as $k => $all_player ){
    foreach( $players as $player ){
        if( $player->players_id == $k ){
            continue 2;
        }
    }

    $html .= '<option value="'.$all_player->player_id.'" data_level="'.$all_player->player_level.'">'.$all_player->player_firstname.' '.$all_player->player_lastname.'</option>';
}
$html .= '</select>';

$html .= '<input type="submit" value="Add player to the tournament" />';
$html .= '<input type="submit" value="Add alls players" id="all_players" name="all_players" />';
$html .= '<input type="submit" value="Remove all players for this Tournament" id="player_tournament_remove" name="player_tournament_remove" />';
$html .= '<input type="submit" value="Set player as inactive" id="player_down" name="player_down" />';

$html .= '</form>';

$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="add-players" />';



$html .= '<label>Vorname: </label>';
$html .= '<input type="text" value="" placeholder="Vorname" name="firstname" />';
$html .= '<label>Nachname: </label>';
$html .= '<input type="text" value="" placeholder="Nachname" name="lastname" />';
$html .= '<label>Werte (Schweizer System): </label>';
$html .= '<input type="text" value="" placeholder="Punkte" name="schweizer_system_punkte" />';

$html .= '<input type="submit" value="Neuer Spieler anlegen" />';


$html .= '</form>';


$html .= '</div>';
