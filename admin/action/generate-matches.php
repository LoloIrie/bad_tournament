<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */
//$wpdb->show_errors();

function badt_get_free_opponent( $players_match, $k_pl1, $opponents ){
    $key = 0;

    foreach( $players_match as $k => $player_match ){
        if( $k != $k_pl1 ){
            if( !in_array( $player_match[$k]->id , $opponents ) ){
                $key = $k;
                break;
            }
        }
    }

    return $key;
}

if( isset( $_POST['regenerate_matchs_now'] ) ){
    /* Remove current matchs... */
    $matches = array();
    $query = "DELETE FROM
                    ".$wpdb->prefix . 'bvg_matches'."

                    WHERE
                    tournament_id=".$_SESSION['t_id']."
                    AND
                    round=".$_SESSION['round']."
                    AND
                    winner=0";
    $wpdb->query( $query );

    /* Create new matches */
    $generate_matchs_now = true;

    $bvg_admin_msg .= '<br />Matches gelöscht...<br />'.$query.'<br />';
}



if( isset( $_POST['generate_matchs_now'] ) || $generate_matchs_now === true ){

    $nb_players = count( $players );
    //echo 'NB Players: '.$nb_players.'<br />';;
    $players_match = $players;


    /*
    if( $nb_players%2 == 1 ){
        shuffle( $players );
        $player_notplaying = reset( $players );
        //var_dump( $player_notplaying );

        if( $_SESSION['t_system'] == 1 ){
            // Swiss system: dont' play ? => Get a point
            $pl_id = $players_match[0]->players_id;
            $wpdb->query(
                "UPDATE
            ".$wpdb->prefix . 'bvg_players_tournament'."

            SET
            player_level_current=player_level_current+1

            WHERE
            id=".$player_notplaying->id
            );
        }
        $players_match = array_slice( $players, 1);
        $nb_players--;
    }
    */

    $players_match_backup = $players_match;

    //echo 'NB Matches: '.$nb_matches.'<br />';
    if( $_SESSION['t_system'] == 1 ){
        $nb_matches = floor( $nb_players / 2 );
        /* Schweizer system */
//echo __LINE__;
        if( $_SESSION['round'] < 2 ){

            /* First round */

            usort($players_match, function($a, $b) {
                return $b->player_level_init - $a->player_level_init;
            });

            for( $i=0; $i<$nb_matches; $i++ ){
                $k_pl1 = $i;
                $k_pl2 = $i + $nb_matches;

                /* Create matches in DB */
                $data = array(
                    'player1_id' => $players_match[ $k_pl1 ]->id,
                    'player2_id' => $players_match[ $k_pl2 ]->id,
                    'tournament_id' => $_SESSION['t_id'],
                    'round' => $_SESSION['round']
                );
                $wpdb->insert( $wpdb->prefix . 'bvg_matches', $data );

                $matches[] = array(
                    'id' => $wpdb->insert_id,
                    'player1_id' => $players_match[ $k_pl1 ]->id,
                    'player2_id' => $players_match[ $k_pl2 ]->id,
                    'player1_name' => $players_match[ $k_pl1 ]->player_firstname.' '.$players_match[ $k_pl1 ]->player_lastname,
                    'player2_name' => $players_match[ $k_pl2 ]->player_firstname.' '.$players_match[ $k_pl2 ]->player_lastname,
                    'tournament_id' => 1,
                    'round' => $_SESSION['round'],
                    'pl1_set1' => 0,
                    'pl2_set1' => 0,
                    'pl1_set2' => 0,
                    'pl2_set2' => 0,
                    'pl1_set3' => 0,
                    'pl2_set3' => 0,
                    'pl1_set4' => 0,
                    'pl2_set4' => 0,
                    'pl1_set5' => 0,
                    'pl2_set5' => 0,
                    'parent_id' => 0
                );

                /* Add players opponents in DB */
                $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl2 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl1 ]->id
                );

                $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl1 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl2 ]->id
                );

                //echo '<pre>';
                //print_r( $data );
            }
        }else {

            usort($players_match, function($a, $b) {
                return $b->player_level_current - $a->player_level_current;
            });

            for ($i = 0; $i < $nb_matches; $i+2) {

                echo '$I: '.$i.' ...<br />';
                $already_played = true;
                $k_pl1 = $i;
                $bvg_admin_msg .= '<h3>Spieler(i:'.$i.') ID: '.$players_match[$k_pl1]->id.'</h3>';
                $k_pl2 = $i + 1;
                $opponents = explode( '-', $players_match[ $k_pl1 ]->opponents );
                foreach($opponents as $k => $opp){
                    if( empty( $opp ) ){
                        unset( $opponents[$k] );
                    }
                }
                /* Trying the 1st player */
                if( !in_array( $players_match[$k_pl2]->id , $opponents ) ){
                    $already_played = false;
                    $bvg_admin_msg .= 'Not played yet: '.$players_match[$k_pl1]->id.'-'.$players_match[$k_pl2]->id.'<br />';
                    //var_dump( $players_match );
                }else{
                    $bvg_admin_msg .= 'Game played: '.$players_match[$k_pl1]->id.'-'.$players_match[$k_pl2]->id.'<br />';
                    $k_pl2 = $i + 2;
                    /* Trying the 2nd player */
                    if( !in_array( $players_match[$k_pl2]->id , $opponents ) ){
                        $already_played = false;
                    }else{
                        $bvg_admin_msg .= 'Game played: '.$players_match[$k_pl1]->id.'-'.$players_match[$k_pl2]->id.'<br />';
                        $k_pl2 = $i + 3;
                        /* Trying the 3rd player */
                        if( !in_array( $players_match[$k_pl2]->id , $opponents ) ){
                            $already_played = false;
                        }else{
                            $bvg_admin_msg .= 'Game played: '.$players_match[$k_pl1]->id.'-'.$players_match[$k_pl2]->id.'<br />';
                            $k_pl2 = $i + 3;
                            /* Trying the 4th player */
                            if( !in_array( $players_match[$k_pl2]->id , $opponents ) ){
                                $already_played = false;
                            }else{
                                $bvg_admin_msg .= 'Game played: '.$players_match[$k_pl1]->id.'-'.$players_match[$k_pl2]->id.'<br />';
                                /* Get an opponent in the rest of available players */
                                $k_pl2 = badt_get_free_opponent( $players_match, $k_pl1, $opponents );
                                if( $k_pl2 > 0 ){
                                    $already_played = false;
                                }
                            }
                        }
                    }
                }


                /* No way to organize this match, continue with next player and inform admin */
                if( $already_played ){
                    /* Already played */
                    $bvg_admin_msg .= 'Das System könnte kein Spiel für der Spieler mit ID: '.$players_match[$k_pl1]->id.' diese Rounde anlegen.';
                    $i--;
                    continue;
                }else{
                    /* New allowed game */


                    $data = array(
                        'player1_id' => $players_match[$k_pl1]->id,
                        'player2_id' => $players_match[$k_pl2]->id,
                        'tournament_id' => $_SESSION['t_id'],
                        'round' => $_SESSION['round']
                    );
                    $wpdb->insert($wpdb->prefix . 'bvg_matches', $data);

                    $matches[] = array(
                        'id' => $wpdb->insert_id,
                        'player1_id' => $players_match[$k_pl1]->id,
                        'player2_id' => $players_match[$k_pl2]->id,
                        'player1_name' => $players_match[$k_pl1]->player_firstname . ' ' . $players_match[$k_pl1]->player_lastname,
                        'player2_name' => $players_match[$k_pl2]->player_firstname . ' ' . $players_match[$k_pl2]->player_lastname,
                        'tournament_id' => 1,
                        'round' => $_SESSION['round'],
                        'pl1_set1' => 0,
                        'pl2_set1' => 0,
                        'pl1_set2' => 0,
                        'pl2_set2' => 0,
                        'pl1_set3' => 0,
                        'pl2_set3' => 0,
                        'pl1_set4' => 0,
                        'pl2_set4' => 0,
                        'pl1_set5' => 0,
                        'pl2_set5' => 0,
                        'parent_id' => 0
                    );

                    /* Add players opponents in DB */
                    $wpdb->query( "UPDATE

                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl2 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl1 ]->id
                    );

                    $wpdb->query( "UPDATE
                    ".$wpdb->prefix . 'bvg_players_tournament'."

                    SET
                    opponents = concat( opponents, '".$players_match[ $k_pl1 ]->id."', '-' )

                    WHERE
                    id=".$players_match[ $k_pl2 ]->id
                    );

                    unset( $players_match[$k_pl1] , $players_match[$k_pl2]);
                    $players_match = array_values($players_match);
                    $nb_matches--;
                    $i=0;
                }

            }
        }
    }
    else if( $_SESSION['t_system'] == 4 ){
        /* Grinding Tournament */
        $nb_matches = floor( $nb_players / 4);

        $too_many_players = $nb_players%4;
        if( $too_many_players > 0 ){


            /* Too much players => Remove users with most played games */
            usort($players_match, function($a, $b) {
                return $b->played - $a->played;
            });

            //echo '<pre>';
            //var_dump($players_match);

            for( $i=0; $i<$too_many_players; $i++ ){
                unset( $players_match[$i] );
            }
            //var_dump($players_match);
        }

        shuffle( $players_match );
        //echo 'NB Matches: '.$nb_matches.'<br />';
        /* Set teams */
        for( $i = 0; $i<$nb_matches; $i++ ){
            $k_pl1 = 0;
            $k_pl1_bis = 1;
            $k_pl2 = 2;
            $k_pl2_bis = 3;

            /* Create matches in DB */
            $data = array(
                'player1_id' => $players_match[ $k_pl1 ]->id,
                'player2_id' => $players_match[ $k_pl2 ]->id,
                'player1_id_bis' => $players_match[ $k_pl1_bis ]->id,
                'player2_id_bis' => $players_match[ $k_pl2_bis ]->id,
                'tournament_id' => $_SESSION['t_id'],
                'round' => $_SESSION['round']
            );
            $wpdb->insert( $wpdb->prefix . 'bvg_matches', $data );

            $matches[] = array(
                'id' => $wpdb->insert_id,
                'player1_id' => $players_match[ $k_pl1 ]->id,
                'player2_id' => $players_match[ $k_pl2 ]->id,
                'player1_name' => $players_match[ $k_pl1 ]->player_firstname.' '.$players_match[ $k_pl1 ]->player_lastname,
                'player2_name' => $players_match[ $k_pl2 ]->player_firstname.' '.$players_match[ $k_pl2 ]->player_lastname,
                'player1_id_bis' => $players_match[ $k_pl1_bis ]->id,
                'player2_id_bis' => $players_match[ $k_pl2_bis ]->id,
                'player1_name_bis' => $players_match[ $k_pl1_bis ]->player_firstname.' '.$players_match[ $k_pl1_bis ]->player_lastname,
                'player2_name_bis' => $players_match[ $k_pl2_bis ]->player_firstname.' '.$players_match[ $k_pl2_bis ]->player_lastname,
                'tournament_id' => 1,
                'round' => $_SESSION['round'],
                'pl1_set1' => 0,
                'pl2_set1' => 0,
                'pl1_set2' => 0,
                'pl2_set2' => 0,
                'pl1_set3' => 0,
                'pl2_set3' => 0,
                'pl1_set4' => 0,
                'pl2_set4' => 0,
                'pl1_set5' => 0,
                'pl2_set5' => 0,
                'parent_id' => 0
            );

            unset( $players_match[ $k_pl1 ], $players_match[ $k_pl2 ], $players_match[ $k_pl1_bis ], $players_match[ $k_pl2_bis ] );
            $players_match = array_values($players_match);
        }
    }

    $players_match = $players_match_backup;
    unset( $players_match_backup );



//echo '<pre>';
//print_r( $players_match );




    $bvg_admin_msg .= '<br />Neue Matches angelegt...';
}


