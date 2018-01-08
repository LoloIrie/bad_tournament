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

    if( $tournament->club_restriction > 0 ){
        $club_name = badt_db_get_clubs( $tournament->club_restriction )[0]->name;
        $html .= '<div class="bad_tournament_club_restriction" id="tournament_club_restriction">';
            $html .= '<span>'.__( 'Tournament restricted to players from:' , 'bad-tournament' ).'</span>';
            $html .= $club_name;
        $html .= '</div>';
    }


    $html .= '<div class="bad_tournament_system" id="tournament_summary_system">';
        $html .= '<span>'.__( 'System: ' , 'bad-tournament' ).'</span>';
        switch( $tournament->system ){
            case 1:
                $html .= __('Swiss System', 'bad-tournament');
                break;

            case 4:
                $html .= __('Grinding Tournament', 'bad-tournament');
                break;

            default:
                $html .= __('Swiss System', 'bad-tournament');
                break;

        }
    $html .= '</div>';


    $html .= '<div class="bad_tournament_typ" id="tournament_summary_typ">';
        $html .= '<span>'.__( 'Tournament typ:' , 'bad-tournament' ).'</span>'.$tournament->tournament_typ;
    $html .= '</div>';


    $html .= '<div class="bad_tournament_nb_sets" id="tournament_summary_nb_sets">';
        $html .= '<span>'.__( 'Nb sets to win:' , 'bad-tournament' ).'</span>'.$tournament->nb_sets;
    $html .= '</div>';


    $html .= '<div class="bad_tournament_points_set" id="tournament_summary_points_set">';
        $html .= '<span>'.__( 'Points/Set:' , 'bad-tournament' ).'</span>'.$tournament->points_set;
    $html .= '</div>';


    $html .= '<div class="bad_tournament_max_points_set" id="tournament_summary_max_points_set">';
        $html .= '<span>'.__( 'Max points per set:' , 'bad-tournament' ).'</span>'.$tournament->max_points_set;
    $html .= '</div>';

    if( !empty( $tournament->date_start ) ){
        $html .= '<div class="bad_tournament_localization" id="tournament_summary_date_start">';
        $html .= '<span>'.__( 'Date:' , 'bad-tournament' ).'</span>'.$tournament->date_start;


        if( $tournament->date_start != $tournament->date_end ){
            $html .= ' - '.$tournament->date_end;
        }
        $html .= '</div>';
    }

    if( !empty( $localization ) ){
        $html .= '<div class="bad_tournament_localization" id="tournament_summary_localization">';
            $html .= '<span>'.__( 'Where: ' , 'bad-tournament' ).'</span><a href="https://maps.google.com//maps/place/'.$localization.'" target="_blank" >'.$tournament->localization.'</a>';
        $html .= '</div>';
    }

$html .= '</div>';

//var_dump( $tournament );

