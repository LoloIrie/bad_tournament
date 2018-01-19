<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */

/* MENU */
$html .= '<nav id="main_nav">';
$html .= '<ul>';
$html .= '<li class="nav_item'.( $ADMIN_VIEW == 'tournament' ? ' active"' : '' ).'" id="nav_tournament">';
$html .= __('Export', 'bad-tournament');
$html .= '</li>';

$html .= '<li class="nav_item'.( $ADMIN_VIEW == 'clubs' ? ' active"' : '' ).'" id="nav_club">';
$html .= __('Import', 'bad-tournament');
$html .= '</li>';
$html .= '</ul>';
$html .= '</nav>';

/* MESSAGES */
if( !empty( $bvg_admin_msg ) ){
    $html .= '<div id="bvg_admin_msg"><span id="bvg_admin_msg_close"></span>'.$bvg_admin_msg.'</div>';
}


$html .= '<h1 id="bad_tournament_maintitle" class="subtournament_name">'.__( 'Import / Export', 'bad-tournament').'</h1>';
