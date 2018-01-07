<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */

/* Use css from theme if existing */
$theme_uri = get_theme_file_path();
if( file_exists( $theme_uri.'/bad-tournament.css' ) && !defined( 'BAD_TOURNAMENT_THEME_CSS' ) ){
    wp_enqueue_style( 'bad_tournament', get_theme_file_uri() . '/bad-tournament.css' );
    define( 'BAD_TOURNAMENT_THEME_CSS' , true );
}

/* Format data */
$localization = str_replace( ' ', '+', $tournament->localization);

if( !empty( $tournament->date_start ) ){
    $datetime_start_arr = explode( ' ', $tournament->date_start );
    $date_start_arr = explode( '-', $datetime_start_arr[0] );
    $tournament->date_start = $date_start_arr[2].'/'.$date_start_arr[1].'/'.$date_start_arr[0].' '.$datetime_start_arr[1];
    $tournament->date_start = substr( $tournament->date_start, 0, -3 );

    $datetime_end_arr = explode( ' ', $tournament->date_end );
    $date_end_arr = explode( '-', $datetime_end_arr[0] );
    $tournament->date_end = $date_end_arr[2].'/'.$date_end_arr[1].'/'.$date_end_arr[0].' '.$datetime_end_arr[1];
    $tournament->date_end = substr( $tournament->date_end, 0, -3 );
}



/* Summary */
$html = '';

//$html .= '<div class="admin_block_label">Spiele</div>';
$html .= '<div class="bad_tournament_block" id="tournament_summary">';

    $html .= '<div class="bad_tournament_maintitle" id="tournament_summary_title">';
        $html .= $tournament->name;
    $html .= '</div>';

    if( !empty( $localization ) ){
        $html .= '<div class="bad_tournament_localization" id="tournament_summary_localization">';
            $html .= '<a href="https://maps.google.com//maps/place/'.$localization.'" target="_blank" >'.$tournament->localization.'</a>';
        $html .= '</div>';
    }

    if( !empty( $tournament->date_start ) ){
        $html .= '<div class="bad_tournament_localization" id="tournament_summary_date_start">';
            $html .= $tournament->date_start;


        if( $tournament->date_start != $tournament->date_end ){
            $html .= ' - '.$tournament->date_end;
        }
        $html .= '</div>';
    }

$html .= '</div>';

//var_dump( $tournament );

