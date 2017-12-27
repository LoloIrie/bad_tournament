<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */

$html .= '<nav id="main_nav">';
$html .= '<ul>';
$html .= '<li class="nav_item'.( $ADMIN_VIEW == 'tournament' ? ' active"' : '' ).'" id="nav_tournament">';
$html .= __('Tournament', 'bad-tournament');
$html .= '</li>';

$html .= '<li class="nav_item'.( $ADMIN_VIEW == 'clubs' ? ' active"' : '' ).'" id="nav_club">';
$html .= __('Clubs', 'bad-tournament');
$html .= '</li>';

$html .= '<li class="nav_item'.( $ADMIN_VIEW == 'players' ? ' active"' : '' ).'" id="nav_player">';
$html .= __('Players', 'bad-tournament');
$html .= '</li>';

$html .= '<li class="nav_item'.( $ADMIN_VIEW == 'table' ? ' active"' : '' ).'" id="nav_table">';
$html .= __('Table', 'bad-tournament');
$html .= '</li>';

$html .= '<li class="nav_item'.( $ADMIN_VIEW == 'matches' ? ' active"' : '' ).'" id="nav_match">';
$html .= __('Matches', 'bad-tournament');
$html .= '</li>';
$html .= '</ul>';
$html .= '</nav>';

/* Msg */
if( !empty( trim( $bvg_admin_msg ) ) ){
    $html .= '<div id="bvg_admin_msg"><span id="bvg_admin_msg_close"></span>'.$bvg_admin_msg.'</div>';
    /*
        echo '<div><pre>';
        var_dump( $_POST );
        echo '</pre></div>';
    */
}


if( $_SESSION['current_tournament'] !== false ){
    /* Title */
    if( $_SESSION['current_tournament']['id'] != $_SESSION['current_tournament']['parent_id'] ){
        foreach( $tournaments as $k => $t ){
            if( $t->id == $_SESSION['current_tournament']['parent_id'] ){
                $tournament_parent = $tournaments[ $k ];
                $html .= '<h2 class="tournament_name">'.$tournament_parent->name.' (ID:'.$tournament_parent->id.')</h2>';
                break;
            }
        }

    }
    $html .= '<h1 id="bad_tournament_maintitle" class="subtournament_name">'.$_SESSION['t_name'].' (ID:'.$_SESSION['current_tournament']['id'].')' .' ( '.__( 'Round', 'bad-tournament').': '.$_SESSION['round'].')</h1>';
    $html .= __('Matches played: ', 'bad-tournament').$nb_matchs;

    $html .= '<h4>'.$t_system[ $_SESSION['current_tournament']['system'] ].'</h4>';
    $html .= '<h4>'.__( 'Sets to win:', 'bad-tournament').' '.$_SESSION['current_tournament']['nb_sets'].' '.__( 'Points/Set:', 'bad-tournament').' '.$_SESSION['current_tournament']['points_set'].' '.__( 'Max. points per set:', 'bad-tournament').' '.$_SESSION['current_tournament']['max_points_set'].'</h4>';

}




/*
echo '<pre>';
var_dump( $players );
echo '<hr />';
var_dump( $all_players );
echo '</pre>';
*/