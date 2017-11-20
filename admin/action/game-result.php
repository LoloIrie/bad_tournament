<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

//$wpdb->show_errors();

if( !is_numeric( $_POST['match_id'] ) ){
    $bvg_admin_msg .= 'Fehler: Match ID ist falsch...';
}else{
    $winner = 0;

    $m_id = $_POST['match_id'];

    $pl1_id = $_POST['pl1_id'];
    $pl2_id = $_POST['pl2_id'];
    $pl1_id_bis = $_POST['pl1_id_bis'];
    $pl2_id_bis = $_POST['pl2_id_bis'];

    $pl1_set1 = $_POST['pl1_m'.$m_id.'_set1'];
    $pl2_set1 = $_POST['pl2_m'.$m_id.'_set1'];
    $pl1_set2 = $_POST['pl1_m'.$m_id.'_set2'];
    $pl2_set2 = $_POST['pl2_m'.$m_id.'_set2'];
    $pl1_set3 = $_POST['pl1_m'.$m_id.'_set3'];
    $pl2_set3 = $_POST['pl2_m'.$m_id.'_set3'];
    $pl1_set4 = $_POST['pl1_m'.$m_id.'_set4'];
    $pl2_set4 = $_POST['pl2_m'.$m_id.'_set4'];
    $pl1_set5 = $_POST['pl1_m'.$m_id.'_set5'];
    $pl2_set5 = $_POST['pl2_m'.$m_id.'_set5'];

    $s1 = 0;
    $s2 = 0;
    if( $pl1_set1 > $pl2_set1 ){
        $s1++;
    }elseif( $pl1_set1 < $pl2_set1 ){
        $s2++;
    }
    if( $pl1_set2 > $pl2_set2 ){
        $s1++;
    }elseif( $pl1_set2 < $pl2_set2 ){
        $s2++;
    }
    if( $pl1_set3 > $pl2_set3 ){
        $s1++;
    }elseif( $pl1_set3 < $pl2_set3 ){
        $s2++;
    }
    if( $pl1_set4 > $pl2_set4 ){
        $s1++;
    }elseif( $pl1_set4 < $pl2_set4 ){
        $s2++;
    }
    if( $pl1_set5 > $pl2_set5 ){
        $s1++;
    }elseif( $pl1_set5 < $pl2_set5 ){
        $s2++;
    }

    if( is_numeric( $_POST['match_winner_'.$m_id] ) && $_POST['match_winner_'.$m_id] > 0 ){
        $winner = $_POST['match_winner_'.$m_id];
    }else{
        /* Try to set winner */
        $bvg_admin_msg .= 'Try to set winner...<br />';
        $nb_sets_completed = 0;
        $nb_sets_pl1 = 0;
        $nb_sets_pl2 = 0;

        if( $pl1_set1 > ($_SESSION['t_points_set']-1) || $pl2_set1 > ($_SESSION['t_points_set']-1) ){
            # First set
            $nb_sets_completed++;
            if( $pl1_set1 > $pl2_set1 ){
                $nb_sets_pl1++;
            }else{
                $nb_sets_pl2++;
            }
        }
        if( $pl1_set2 > ($_SESSION['t_points_set']-1) || $pl2_set2 > ($_SESSION['t_points_set']-1) ){
            # First set
            $nb_sets_completed++;
            if( $pl1_set2 > $pl2_set2 ){
                $nb_sets_pl1++;
            }else{
                $nb_sets_pl2++;
            }
        }
        if( $pl1_set3 > ($_SESSION['t_points_set']-1) || $pl2_set3 > ($_SESSION['t_points_set']-1) ){
            # First set
            $nb_sets_completed++;
            if( $pl1_set3 > $pl2_set3 ){
                $nb_sets_pl1++;
            }else{
                $nb_sets_pl2++;
            }
        }
        if( $pl1_set4 > ($_SESSION['t_points_set']-1) || $pl2_set4 > ($_SESSION['t_points_set']-1) ){
            # First set
            $nb_sets_completed++;
            if( $pl1_set4 > $pl2_set4 ){
                $nb_sets_pl1++;
            }else{
                $nb_sets_pl2++;
            }
        }
        if( $pl1_set5 > ($_SESSION['t_points_set']-1) || $pl2_set5 > ($_SESSION['t_points_set']-1) ){
            # First set
            $nb_sets_completed++;
            if( $pl1_set5 > $pl2_set5 ){
                $nb_sets_pl1++;
            }else{
                $nb_sets_pl2++;
            }
        }

        //echo 'NB Sets: '.$_SESSION['t_nb_sets'];
        if( $nb_sets_completed >= $_SESSION['t_nb_sets'] ){
            $winner = $pl1_id;
            if( $nb_sets_pl2 > $nb_sets_pl1 ){
                $winner = $pl2_id;
            }
        }
    }

    $bvg_admin_msg .= 'Winner: '.$winner.'<br />';

    if( $winner > 0 ){
        $pl1_level_current_change = 0;
        $pl2_level_current_change = 0;

        /* Update tournament table */
        $pl1_level_current_change = ( $winner == $pl1_id ? 1 : 0 );
        $pl2_level_current_change = ( $winner == $pl2_id ? 1 : 0 );
        $p = ( $winner == $pl1_id ? 1 : 0 );
        $w = ( $winner == $pl1_id ? 1 : 0 );
        $d = 0;
        $l = ( $winner == $pl2_id ? 1 : 0 );
        $s = $s1;
        $s_opp = $s2;
        $pt = ( $pl1_set1+ $pl1_set2 +$pl1_set3 + $pl1_set4 + $pl1_set5 );
        $pt_opp = ( $pl2_set1+ $pl2_set2 +$pl2_set3 + $pl2_set4 + $pl2_set5 );
        $wpdb->query( $wpdb->prepare(
            "UPDATE
            ".$wpdb->prefix . 'bvg_players_tournament'."
            
            SET
            player_level_current=player_level_current+".$pl1_level_current_change.",
            played=played+1,
            victory=victory+%d,
            draw=draw+%d,
            loss=loss+%d,
            points_major=points_major+%d,
            sets=sets+%d,
            sets_against=sets_against+%d,
            points=points+%d,
            points_against=points_against+%d
            
            WHERE
            id=".$pl1_id,

            $w, $d, $l, $p, $s, $s_opp, $pt, $pt_opp
            )
        );

        if( $_SESSION['t_system'] == 4 ){
            // Grinding Tournament => Partner
            $wpdb->query( $wpdb->prepare(
                "UPDATE
                ".$wpdb->prefix . 'bvg_players_tournament'."
                
                SET
                player_level_current=player_level_current+".$pl1_level_current_change.",
                played=played+1,
                victory=victory+%d,
                draw=draw+%d,
                loss=loss+%d,
                points_major=points_major+%d,
                sets=sets+%d,
                sets_against=sets_against+%d,
                points=points+%d,
                points_against=points_against+%d
                
                WHERE
                id=".$pl1_id_bis,

                    $w, $d, $l, $p, $s, $s_opp, $pt, $pt_opp
                )
            );
        }

        $p = ( $winner == $pl2_id ? 1 : 0 );
        $w = ( $winner == $pl2_id ? 1 : 0 );
        $d = 0;
        $l = ( $winner == $pl1_id ? 1 : 0 );
        $s_opp = $s1;
        $s = $s2;
        $pt_opp = ( $pl1_set1+ $pl1_set2 +$pl1_set3 + $pl1_set4 + $pl1_set5 );
        $pt = ( $pl2_set1+ $pl2_set2 +$pl2_set3 + $pl2_set4 + $pl2_set5 );
        $wpdb->query( $wpdb->prepare(
            "UPDATE
            ".$wpdb->prefix . 'bvg_players_tournament'."
            
            SET
            player_level_current=player_level_current+".$pl2_level_current_change.",
            played=played+1,
            victory=victory+%d,
            draw=draw+%d,
            loss=loss+%d,
            points_major=points_major+%d,
            sets=sets+%d,
            sets_against=sets_against+%d,
            points=points+%d,
            points_against=points_against+%d
            
            WHERE
            id=".$pl2_id,

            $w, $d, $l, $p, $s, $s_opp, $pt, $pt_opp
            )
        );

        if( $_SESSION['t_system'] == 4 ){
            // Grinding Tournament => Partner
            $wpdb->query( $wpdb->prepare(
                "UPDATE
                ".$wpdb->prefix . 'bvg_players_tournament'."
                
                SET
                player_level_current=player_level_current+".$pl2_level_current_change.",
                played=played+1,
                victory=victory+%d,
                draw=draw+%d,
                loss=loss+%d,
                points_major=points_major+%d,
                sets=sets+%d,
                sets_against=sets_against+%d,
                points=points+%d,
                points_against=points_against+%d
                
                WHERE
                id=".$pl2_id_bis,

                $w, $d, $l, $p, $s, $s_opp, $pt, $pt_opp
                )
            );
        }
    }

    //$wpdb->print_error();

    $data = array(
        'pl1_set1' => ( is_numeric( $_POST['pl1_m'.$m_id.'_set1'] ) ? $_POST['pl1_m'.$m_id.'_set1'] : 0 ),
        'pl2_set1' => ( is_numeric( $_POST['pl2_m'.$m_id.'_set1'] ) ? $_POST['pl2_m'.$m_id.'_set1'] : 0 ),
        'pl1_set2' => ( is_numeric( $_POST['pl1_m'.$m_id.'_set2'] ) ? $_POST['pl1_m'.$m_id.'_set2'] : 0 ),
        'pl2_set2' => ( is_numeric( $_POST['pl2_m'.$m_id.'_set2'] ) ? $_POST['pl2_m'.$m_id.'_set2'] : 0 ),
        'pl1_set3' => ( is_numeric( $_POST['pl1_m'.$m_id.'_set3'] ) ? $_POST['pl1_m'.$m_id.'_set3'] : 0 ),
        'pl2_set3' => ( is_numeric( $_POST['pl2_m'.$m_id.'_set3'] ) ? $_POST['pl2_m'.$m_id.'_set3'] : 0 ),
        'pl1_set4' => ( is_numeric( $_POST['pl1_m'.$m_id.'_set4'] ) ? $_POST['pl1_m'.$m_id.'_set4'] : 0 ),
        'pl2_set4' => ( is_numeric( $_POST['pl2_m'.$m_id.'_set4'] ) ? $_POST['pl2_m'.$m_id.'_set4'] : 0 ),
        'pl1_set5' => ( is_numeric( $_POST['pl1_m'.$m_id.'_set5'] ) ? $_POST['pl1_m'.$m_id.'_set5'] : 0 ),
        'pl2_set5' => ( is_numeric( $_POST['pl2_m'.$m_id.'_set5'] ) ? $_POST['pl2_m'.$m_id.'_set5'] : 0 ),
        'winner' => $winner
    );
    $wpdb->update( $wpdb->prefix . 'bvg_matches',
        $data,
        array( 'id' => $_POST['match_id'] ) );


    //$wpdb->print_error();
    $bvg_admin_msg .= 'Match aktualisiert...'.print_r( $_POST , 1 );
}

