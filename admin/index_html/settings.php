<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */

if ( !defined( 'ABSPATH' ) ) die();

$html .= '<div class="admin_block nav_settings" id="block_settings" '.( $ADMIN_VIEW == 'settings' ? 'style="display: block;"' : '' ).'>';


$html .= '<form method="post" action="options.php" >';
    ob_start();
    settings_fields('badt');
    $html .= ob_get_contents();
    ob_end_clean();

    $html .= '<input type="hidden" name="form_action" value="import-data" />';

    $html .= '<table class="form-table">';

    $html .= '<tr class="form-field form-required">';
    $html .= '<th scope="row">';
    $html .= '<label>'.__('Activate debug', 'bad-tournament').'</label>';
    $html .= '</th>';
    $html .= '<td>';
    $html .= '<div><input type="checkbox" value="1" name="badt_debug" id="badt_debug" class="export_checkbox" '.(get_option('badt_debug') == 1 ? 'checked="checked"' : '' ).' /></div>';
    $html .= '</td>';
    $html .= '</tr>';


    $html .= '</table>';

    $html .= '<input type="submit" value="'.__('Save settings', 'bad-tournament').'" class="button-primary button" />';


    $html .= '</form>';


$html .= '</div>';