<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */

$localization = str_replace( ' ', '+', $tournament->localization);

/* Summary */
$html = '';

//$html .= '<div class="admin_block_label">Spiele</div>';
$html .= '<div class="bad_tournament_block" id="tournament_summary">';

    $html .= '<div class="bad_tournament_maintitle" id="tournament_summary_title">';
        $html .= $tournament->name;
    $html .= '</div>';

    $html .= '<div class="bad_tournament_localization" id="tournament_summary_localization">';
        $html .= '<a href="https://maps.google.com//maps/place/'.$localization.'" target="_blank" >'.__( 'Localize the tournament ?' , 'bad-tournament' ).'</a>';
    $html .= '</div>';

$html .= '</div>';

//var_dump( $tournament );

