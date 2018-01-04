<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */


/* Summary */
$html = '';

//$html .= '<div class="admin_block_label">Spiele</div>';
$html .= '<div class="bad_tournament_block" id="tournament_summary">';

    $html .= '<div class="bad_tournament_maintitle" id="tournament_summary_title">';
        $html .= $tournament->name;
    $html .= '</div>';

    $html .= '<div class="bad_tournament_localization" id="tournament_summary_localization">';
        $html .= '<a href="" target="_blank" >'.__( 'Where ?' , 'bad-tournament' ).'</a>';
    $html .= '</div>';

$html .= '</div>';

//var_dump( $tournament );

