<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */


if ( !defined( 'ABSPATH' ) ) die();

$html .= '<div class="admin_block nav_import" id="block_import" '.( $ADMIN_VIEW == 'import' ? 'style="display: block;"' : '' ).'>';


    $html .= '<form method="post" enctype="multipart/form-data">';
        $html .= '<input type="hidden" name="form_action" value="import-data" />';

        $html .= '<table class="form-table">';

            $html .= '<tr class="form-field form-required">';
                $html .= '<th scope="row">';
                    $html .= '<label>'.__('Replace existing values', 'bad-tournament').'</label>';
                $html .= '</th>';
                $html .= '<td>';
                    $html .= '<div><input type="checkbox" value="1" name="replace_existing" id="replace_existing" class="export_checkbox" /></div>';
                $html .= '</td>';
            $html .= '</tr>';

            $html .= '<tr class="form-field form-required">';
                $html .= '<th scope="row">';
                    $html .= '<label>'.__('File to import:', 'bad-tournament').'</label>';
                $html .= '</th>';
                    $html .= '<td>';
                        $html .= '<input type="file" value="" name="import_file" />';
                    $html .= '</td>';
            $html .= '</tr>';

        $html .= '</table>';

        $html .= '<input type="submit" value="'.__('Import data', 'bad-tournament').'" class="button-primary button" />';


    $html .= '</form>';


$html .= '</div>';