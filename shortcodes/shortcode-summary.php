<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 17.11.2017
 * Time: 13:04
 */

$html_shortcode = '';


// Attributes
$atts = shortcode_atts(
    array(
        't_id' => '1',
        't_view' => 'full',
    ),
    $atts
);

include_once plugin_dir_path(__FILE__). '../admin/db-get-content.php';
$tournament = db_get_tournaments( $atts['t_id'] )[0];
$t_view = $atts[ 't_view' ];



$html = '';

include plugin_dir_path(__FILE__). 'sc_html/tournament-summary.php';

$html_shortcode .= $html;