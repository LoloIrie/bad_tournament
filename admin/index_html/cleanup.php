<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */
$tournaments = badt_db_get_tournaments();

if ( !defined( 'ABSPATH' ) ) die();

$html .= '<div class="admin_block nav_cleanup" id="block_cleanup" '.( $ADMIN_VIEW == 'cleanup' ? 'style="display: block;"' : '' ).'>';


    $html .= '<form method="post" id="form_cleanup">';
        $html .= '<input type="hidden" name="form_action" value="cleanup" />';

        $html .= '<h2>'.__('Be careful, you will delete all matches and players for the selected tournament, reset to first round.', 'bad-tournament').'</h2>';

        $html .= '<table class="form-table">';

        if( !empty( $tournaments ) ){
            $html .= '<tr class="form-field form-required">';
                $html .= '<th scope="row">';
                    $html .= '<label>'.__('Choose tournament:', 'bad-tournament').'</label>';
                $html .= '</th>';
                $html .= '<td>';
                    $html .= '<select type="text" value="" name="tournament_cleanup_select" id="tournament_cleanup_select">';
                    $html .= '<option value="0">'.__('Choose', 'bad-tournament').'</option>';
                    foreach( $tournaments as $tournament ){
                        $html .= '<option value="'.$tournament->id.'" >'.$tournament->name.'</option>';
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
                $html .= '</td>';
            $html .= '</tr>';

            $html .= '<tr class="form-field form-required">';
                $html .= '<th scope="row">';
                    $html .= '<label>'.__('Are you sure ?', 'bad-tournament').'</label>';
                $html .= '</th>';
                $html .= '<td>';
                    $html .= '<div><input type="checkbox" value="1" name="allow_cleanup" id="allow_cleanup" class="export_checkbox" /></div>';
                $html .= '</td>';
            $html .= '</tr>';

            $html .= '<tr class="form-field form-required">';
                $html .= '<td colspan="2" >';
                $html .= '<input type="button" class="button button-primary" value="'.__('Clean up this tournament', 'bad-tournament').'" id="tournament_select_button" name="tournament_select_button" />';
                $html .= '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        $html .= '<script>
            jQuery(\'#tournament_select_button\').on(\'click\', function(){
                console.log(\'clean...\');
                if( jQuery(\'#allow_cleanup\').is(\':checked\')){
                    jQuery(\'#form_cleanup\').submit();
                }
            });
        </script>';

    $html .= '</form>';


$html .= '</div>';