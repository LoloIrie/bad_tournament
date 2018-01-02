<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */


/* Tournament */
//$html .= '<div class="admin_block_label">Tournament</div>';
$html .= '<div class="admin_block nav_tournament" id="block_tournament_select" '.( $ADMIN_VIEW == 'tournament' ? 'style="display: block;"' : '' ).'>';
$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="tournament-select" />';
$html .= '<input type="hidden" name="tournament_select_id" value="'.$_SESSION['t_id'].'" />';



$html .= '<label>'.__('Choose tournament:', 'bad-tournament').'</label>';
$html .= '<select type="text" value="" name="tournament_select" id="tournament_select">';
$html .= '<option value="0">'.__('Choose', 'bad-tournament').'</option>';
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
$html .= '<input type="submit" value="'.__('Choose tournament', 'bad-tournament').'" id="tournament_select_button" />';
$html .= '<br />';
$html .= '<br />';




$html .= '<label>'.__('Parent tournament:', 'bad-tournament').'</label>';
$html .= '<select type="text" value="" name="tournament_parent_select" id="tournament_parent_select">';
$html .= '<option value="0" selected="selected">'.__('Choose', 'bad-tournament').'</option>';
$html .= '<option value="0">'.__('No parent', 'bad-tournament').'</option>';
foreach( $tournaments as $tournament ){
    $html .= '<option value="'.$tournament->id.'" '.( $tournament->id == $_SESSION['t_id'] ? 'selected="selected"' : '' ).'>'.$tournament->name.'</option>';
}
$html .= '</select>';

$html .= '<label>'.__('Tournament name:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Tournament Name', 'bad-tournament').'" name="tournament_name" id="tournament_name" />';
$html .= '<br />';

$html .= '<label>'.__('Localization:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('Tournament Name', 'bad-tournament').'" name="tournament_localization" id="tournament_localization" />';
$html .= '<br />';

$html .= '<label>'.__('Date:', 'bad-tournament').'</label>';
$html .= '<input type="text" value="" placeholder="'.__('from...', 'bad-tournament').'" name="tournament_date_start" id="tournament_date_start" class="datetimepicker" />';
$html .= '<input type="text" value="" placeholder="'.__('...to', 'bad-tournament').'" name="tournament_date_end" id="tournament_date_end" class="datetimepicker" />';
$html .= '<br />';


$html .= '<input type="hidden" name="form_action" value="tournament-select" />';

$html .= '<label>'.__('Tournament System:', 'bad-tournament').'</label>';
$html .= '<div class="radio_block">';
$html .= '<span><input type="radio" id="tournament_typ1" name="tournament_typ" value="1" checked="checked" /> <label for="tournament_typ1" class="radio">'.__('Simple Men', 'bad-tournament').'</label></span>';
$html .= '<span><input type="radio" id="tournament_typ2" name="tournament_typ" value="2" /> <label for="tournament_typ2" class="radio">'.__('Simple Women', 'bad-tournament').'</label></span>';
$html .= '<span><input type="radio" id="tournament_typ3" name="tournament_typ" value="3" /> <label for="tournament_typ3" class="radio">'.__('Double Men', 'bad-tournament').'</label></span>';
$html .= '<span><input type="radio" id="tournament_typ4" name="tournament_typ" value="4" /> <label for="tournament_typ4" class="radio">'.__('Double Women', 'bad-tournament').'</label></span>';
$html .= '<span><input type="radio" id="tournament_typ5" name="tournament_typ" value="5" /> <label for="tournament_typ5" class="radio">'.__('Mixte', 'bad-tournament').'</label></span>';
$html .= '</div>';

$html .= '<label>'.__('Tournament System:', 'bad-tournament').'</label>';
$html .= '<div class="radio_block">';
$html .= '<span><input type="radio" id="tournament_system1" name="tournament_system" value="1" checked="checked" /> <label for="tournament_system1" class="radio">'.__('Swiss System', 'bad-tournament').'</label></span>';
//$html .= '<span><input type="radio" id="tournament_system2" name="tournament_system" value="2" disabled="disabled" /> <label for="tournament_system2" class="radio">'.__('League', 'bad-tournament').'</label></span>';
//$html .= '<span><input type="radio" id="tournament_system3" name="tournament_system" value="3" disabled="disabled" /> <label for="tournament_system3" class="radio">'.__('KO System', 'bad-tournament').'</label></span>';
$html .= '<span><input type="radio" id="tournament_system4" name="tournament_system" value="4" /> <label for="tournament_system4" class="radio">'.__('Grinding Tournament', 'bad-tournament').'</label></span>';
$html .= '</div>';


$html .= '<label>'.__('Nb sets to win:', 'bad-tournament').'</label>';
$html .= '<input type="number" value="" name="tournament_nb_sets" id="tournament_nb_sets" min="1" max="3" />';

$html .= '<label>'.__('Points/Set:', 'bad-tournament').'</label>';
$html .= '<input type="number" value="" name="tournament_points_set" id="tournament_points_set" min="11" max="21" />';

$html .= '<label>'.__('Max points per set:', 'bad-tournament').'</label>';
$html .= '<input type="number" value="" name="tournament_max_points_set" id="tournament_max_points_set" min="11" max="30" />';

$html .= '<label>'.__('Club restriction:', 'bad-tournament').'</label>';

$html .= '<select name="club_restriction" id="club_restriction">';
$html .= '<option value="0" >'.__( 'Open' , 'bad-tournament' ).'</option>';
foreach( $clubs as $club ){
    $html .= '<option value="'.$club->id.'" '.$selected.'>'.$club->name.'</option>';
}
$html .= '</select>';

$html .= '<input type="submit" value="'.__('Create tournament', 'bad-tournament').'" />';
$html .= '<input type="submit" value="'.__('Edit tournament', 'bad-tournament').'" name="tournament_edit" id="tournament_edit" />';

$html .= '</form>';

$html .= '</div>';

$html .= '<script>
tournament = [];
';
    foreach( $tournaments as $tournament ){
        $html .= 'tournament['.$tournament->id.'] = \''.json_encode( $tournament ).'\';';
    };
$html .= '</script>';

