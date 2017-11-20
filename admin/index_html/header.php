<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */



/* Msg */
if( !empty( trim( $bvg_admin_msg ) ) ){
    $html .= '<div id="bvg_admin_msg">'.$bvg_admin_msg.'</div>';
    /*
        echo '<div><pre>';
        var_dump( $_POST );
        echo '</pre></div>';
    */
}

$html .= '<h1>Administration !!!</h1>';

/* Title */
$html .= '<h3>'.$_SESSION['t_name'].' (ID:'.$_SESSION['current_tournament']['id'].')' .' ( Round: '.$_SESSION['round'].')</h3>';
$html .= '<h4>Gewinnsätze: '.$_SESSION['current_tournament']['nb_sets'].' Punkte pro Satz: '.$_SESSION['current_tournament']['points_set'].' Max. Punkte pro Satz: '.$_SESSION['current_tournament']['max_points_set'].'</h4>';


$html .= '<nav id="main_nav">';
    $html .= '<ul>';
        $html .= '<li class="nav_item" id="nav_tournament">';
        $html .= 'Turnier';
        $html .= '</li>';

        $html .= '<li class="nav_item" id="nav_player">';
        $html .= 'Players';
        $html .= '</li>';

        $html .= '<li class="nav_item" id="nav_table">';
        $html .= 'Tabelle';
        $html .= '</li>';

        $html .= '<li class="nav_item" id="nav_match">';
        $html .= 'Matches';
        $html .= '</li>';
    $html .= '</ul>';
$html .= '</nav>';
/*
echo '<pre>';
var_dump( $players );
echo '<hr />';
var_dump( $all_players );
echo '</pre>';
*/