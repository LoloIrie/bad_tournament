<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */


/* Table */

//$html .= '<div class="admin_block_label">Tabelle</div>';
$html .= '<div class="admin_block nav_table" id="block_table">';
$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="next-round" />';

$html .= '<ul class="table">';
$html .= '<li class="table_header">';
$html .= '<span class="pl_name">';
$html .= "Spieler";
$html .= "</span>";
$html .= '<span class="pl_played">';
$html .= "Spiele";
$html .= "</span>";
$html .= '<span class="pl_victory">';
$html .= "S";
$html .= "</span>";
$html .= '<span class="pl_draw">';
$html .= "U";
$html .= "</span>";
$html .= '<span class="pl_loss">';
$html .= "N";
$html .= "</span>";
$html .= '<span class="pl_points_major">';
$html .= "Punkte";
$html .= "</span>";
$html .= '<span class="pl_sets">';
$html .= "Sätze";
$html .= "</span>";
$html .= '<span class="pl_points">';
$html .= "Spielpunkte";
$html .= "</span>";
$html .= '</li>';

if( !is_numeric($table_view) || $table_view == 0 ){
    $table_view = 10000;
}
$nb_row = 0;
foreach( $players as $k => $player ){
    $nb_row++;
    if( $nb_row > $table_view ){
        break;
    }

    $html .= '<li class="table_row">'.$nb_row.'. ';
    $html .= '<span class="pl_name">';
    $html .= $player->player_firstname.' '.$player->player_lastname;
    $html .= "</span>";

    $html .= '<span class="pl_played">';
    $html .= $player->played;
    $html .= "</span>";

    $html .= '<span class="pl_victory">';
    $html .= $player->victory;
    $html .= "</span>";

    $html .= '<span class="pl_draw">';
    $html .= $player->draw;
    $html .= "</span>";

    $html .= '<span class="pl_loss">';
    $html .= $player->loss;
    $html .= "</span>";

    $html .= '<span class="pl_points_major">';
    $html .= $player->points_major;
    $html .= "</span>";

    $html .= '<span class="pl_sets">';
    $html .= $player->sets;
    $html .= ' - ';
    $html .= $player->sets_against;
    $html .= "</span>";

    $html .= '<span class="pl_points">';
    $html .= $player->points;
    $html .= ' - ';
    $html .= $player->points_against;
    $html .= "</span>";
    $html .= '</li>';
}
$html .= '</ul>';


$html .= '</form>';
$html .= '</div>';

