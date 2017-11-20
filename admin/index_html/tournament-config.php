<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */


/* Tournament */
//$html .= '<div class="admin_block_label">Tournament</div>';
$html .= '<div class="admin_block nav_tournament" id="block_tournament_select">';
$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="tournament-select" />';
$html .= '<input type="hidden" name="tournament_select_id" value="'.$_SESSION['t_id'].'" />';



$html .= '<label>Choose tournament: </label>';
$html .= '<select type="text" value="" name="tournament_select">';
$html .= '<option value="0">Auswählen</option>';
foreach( $tournaments as $tournament ){
    $html .= '<option value="'.$tournament->id.'" '.( $tournament->id == $_SESSION['t_id'] ? 'selected="selected"' : '' ).'>'.$tournament->name.'</option>';
    if( $tournament->id == $_SESSION['t_id'] ){
        $_SESSION['t_name'] = $tournament->name;
        $_SESSION['t_round'] = $tournament->round;
        $_SESSION['t_system'] = $tournament->system;
        $_SESSION['t_nb_sets'] = $tournament->nb_sets;
        $_SESSION['t_points_set'] = $tournament->points_set;
        $_SESSION['t_max_points_set'] = $tournament->max_points_set;
    }
}
$html .= '</select>';
$html .= '<input type="submit" value="Choose tournament" id="tournament_select_button" />';
$html .= '<br />';
$html .= '<br />';
$html .= '<label>New tournament: </label>';
$html .= '<input type="text" value="" placeholder="Tournament Name" name="tournament_name" />';
$html .= '<br />';




$html .= '<input type="hidden" name="form_action" value="tournament-select" />';

$html .= '<label>Tournament System: </label>';
$html .= '<div class="radio_block">';
$html .= '<span><input type="radio" id="tournament_system1" name="tournament_system" value="1" checked="checked" /> <label for="tournament_system1" class="radio">Swiss System</label></span>';
$html .= '<span><input type="radio" id="tournament_system2" name="tournament_system" value="2" disabled="disabled" /> <label for="tournament_system1" class="radio">League</label></span>';
$html .= '<span><input type="radio" id="tournament_system3" name="tournament_system" value="3" disabled="disabled" /> <label for="tournament_system1" class="radio">KO System</label></span>';
$html .= '<span><input type="radio" id="tournament_system4" name="tournament_system" value="4" /> <label for="tournament_system1" class="radio">Grinding Tournament</label></span>';
$html .= '</div>';


$html .= '<label>Gewinnsätze: </label>';
$html .= '<input type="number" value="" name="tournament_nb_sets" min="1" max="3" />';
$html .= '<br />';

$html .= '<label>Punkte pro Satz: </label>';
$html .= '<input type="number" value="" name="tournament_points_set" min="11" max="21" />';
$html .= '<br />';

$html .= '<label>Max Punkte pro Satz: </label>';
$html .= '<input type="number" value="" name="tournament_max_points_set" min="11" max="30" />';
$html .= '<br />';


$html .= '<input type="submit" value="Create tournament" />';

$html .= '</form>';

$html .= '</div>';

