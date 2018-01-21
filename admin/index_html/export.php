<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */


if ( !defined( 'ABSPATH' ) ) die();

$html .= '<div class="admin_block nav_export" id="block_export" '.( $ADMIN_VIEW == 'export' ? 'style="display: block;"' : '' ).'>';


    $html .= '<form method="post">';
        $html .= '<input type="hidden" name="form_action" value="export-data" />';

        $html .= '<table class="form-table">';

            $html .= '<tr class="form-field form-required">';
                $html .= '<th scope="row">';
                    $html .= '<label>'.__('Data to export ?:', 'bad-tournament').'</label>';
                $html .= '</th>';
                $html .= '<td>';
                    $html .= '<div class="radio_block_vertical">';
                        $html .= '<div><input type="checkbox" value="1" name="export[]" id="export1" class="export_checkbox" /><label for="export1" class="radio">'.__('Everything', 'bad-tournament').'</label></div>';
                        $html .= '<div><input type="checkbox" value="2" name="export[]" id="export2" class="export_checkbox" /><label for="export2" class="radio">'.__('Current tournament', 'bad-tournament').'</label></div>';
                        $html .= '<div><input type="checkbox" value="3" name="export[]" id="export3" class="export_checkbox" /><label for="export3" class="radio">'.__('Tournaments', 'bad-tournament').'</label></div>';
                        $html .= '<div><input type="checkbox" value="4" name="export[]" id="export4" class="export_checkbox" /><label for="export4" class="radio">'.__('Clubs', 'bad-tournament').'</label></div>';
                        $html .= '<div><input type="checkbox" value="5" name="export[]" id="export5" class="export_checkbox" /><label for="export5" class="radio">'.__('Players', 'bad-tournament').'</label></div>';
                        $html .= '<div><input type="checkbox" value="6" name="export[]" id="export6" class="export_checkbox" /><label for="export6" class="radio">'.__('Matches', 'bad-tournament').'</label></div>';
                    $html .= '</div>';
                $html .= '</td>';
            $html .= '</tr>';

        $html .= '</table>';

        $html .= '<input type="submit" value="'.__('Export data', 'bad-tournament').'" class="button-primary button" />';
        $html .= '<input id="export_file" type="button" value="'.__('Export as file', 'bad-tournament').'" class="button-primary button submit2" />';


    $html .= '</form>';


$html .= '</div>';