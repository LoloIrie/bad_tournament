<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */


/* Matches */


//$html .= '<div class="admin_block_label">Spiele</div>';
$html .= '<div class="admin_block nav_match" id="block_game" '.( $ADMIN_VIEW == 'matches' ? 'style="display: block;"' : '' ).'>';


//var_dump( $players );
if( !empty( $matches ) ){

    //echo '<pre>';
    //var_dump( $players );
    uasort($players, function($a, $b) {
        return strcmp( $a->player_lastname , $b->player_lastname);
    });
    //var_dump( $players );
    //echo '</pre>';

    /* Allow to regenerate all games ? */
    $winner_exists = false;
    $tabindex = 0;
    foreach( $matches as $match ){
        $winner = 0;
        $pl1_set1 = 0;
        $pl1_set2 = 0;
        $pl1_set3 = 0;
        $pl1_set4 = 0;
        $pl1_set5 = 0;
        $pl2_set1 = 0;
        $pl2_set2 = 0;
        $pl2_set3 = 0;
        $pl2_set4 = 0;
        $pl2_set5 = 0;

        if( !is_array( $match ) ){
            //var_dump($players[ $match->player1_id ]);
            $player1_name = $players[ $match->player1_id ]->player_firstname.' '.$players[ $match->player1_id ]->player_lastname;
            $player2_name = $players[ $match->player2_id ]->player_firstname.' '.$players[ $match->player2_id ]->player_lastname;
            $player1_name_bis = $players[ $match->player1_id_bis ]->player_firstname.' '.$players[ $match->player1_id_bis ]->player_lastname;
            $player2_name_bis = $players[ $match->player2_id_bis ]->player_firstname.' '.$players[ $match->player2_id_bis ]->player_lastname;
            $m_id = $match->id;
            $pl1_id = $match->player1_id;
            $pl2_id = $match->player2_id;
            $pl1_id_bis = $match->player1_id_bis;
            $pl2_id_bis = $match->player2_id_bis;
            $winner = $match->winner;

            $pl1_set1 = $match->pl1_set1;
            $pl1_set2 = $match->pl1_set2;
            $pl1_set3 = $match->pl1_set3;
            $pl1_set4 = $match->pl1_set4;
            $pl1_set5 = $match->pl1_set5;
            $pl2_set1 = $match->pl2_set1;
            $pl2_set2 = $match->pl2_set2;
            $pl2_set3 = $match->pl2_set3;
            $pl2_set4 = $match->pl2_set4;
            $pl2_set5 = $match->pl2_set5;
        }else{
            $player1_name = $match['player1_name'];
            $player2_name = $match['player2_name'];
            $pl1_id = $match['player1_id'];
            $pl2_id = $match['player2_id'];
            $player1_name_bis = $match['player1_name_bis'];
            $player2_name_bis = $match['player2_name_bis'];
            $pl1_id_bis = $match['player1_id_bis'];
            $pl2_id_bis = $match['player2_id_bis'];
            $winner = $match['winner'];
            $m_id = $match['id'];
        }

        if( $winner > 0 ){
            $winner_exists = true;
        }

        if( !isset( $players[ $match->player1_id ] ) && $match->player1_id > 0 ){
            $player1_name = 'Inaktiv';
        }
        if( !isset( $players[ $match->player2_id ] ) && $match->player2_id > 0 ){
            $player2_name = 'Inaktiv';
        }
        if( !isset( $players[ $match->player1_id_bis ] ) && $match->player1_id_bis > 0 ){
            $player1_name_bis = 'Inaktiv';
        }
        if( !isset( $players[ $match->player2_id_bis ] ) && $match->player2_id_bis > 0 ){
            $player2_name_bis = 'Inaktiv';
        }


        //var_dump( $match );
        $html .= '<form method="post" id="match_form_'.$m_id.'" action="admin.php?page=bad_tournament&admin_view=matches">';
        $html .= '<input type="hidden" name="form_action" value="game-result" />';
        $html .= '<input type="hidden" name="match_id" class="match_id" value="'.$m_id.'" />';
        $html .= '<input type="hidden" name="pl1_id" value="'.$pl1_id.'" />';
        $html .= '<input type="hidden" name="pl2_id" value="'.$pl2_id.'" />';
        $html .= '<input type="hidden" name="pl1_id_bis" value="'.$pl1_id_bis.'" />';
        $html .= '<input type="hidden" name="pl2_id_bis" value="'.$pl2_id_bis.'" />';
        $html .= '<input type="hidden" id="match_winner_'.$m_id.'" name="match_winner_'.$m_id.'" value="" />';

        $html .= '<div>';
        $html .= '<div>'.__( 'Match' , 'bad-tournament').' '.$m_id.': '.$players[$pl1_id]->player_firstname.' '.$players[$pl1_id]->player_lastname.( $_SESSION['t_system'] == 1 ? '('.$players[$pl1_id]->player_level_init.')' : '' ).' - '.$players[$pl2_id]->player_firstname.' '.$players[$pl2_id]->player_lastname.( $_SESSION['t_system'] == 1 ? '('.$players[$pl2_id]->player_level_init.')' : '' ).'</div>';

        $html .= '<select name="pl1_m'.$m_id.'_name" id="pl1_m'.$m_id.'_name" data_pl_id="pl1_id" class="player_name '.( $winner == $pl1_id ? 'winner' : '' ).' '.( $winner == $pl2_id ? 'loser' : '' ).'" />';
        if( $player1_name == 'Inaktiv' ){
            $html .= '<option value="0" selected="selected">'.$player1_name.'</option>';
        }
        foreach( $players as $k => $player ){
            $html .= '<option value="'.$player->id.'" '.( $k == $pl1_id ? 'selected="selected"' : '' ).'>'.$player->player_firstname.' '.$player->player_lastname.'</option>';
        }
        $html .= '</select>';

        //$html .= '<input type="text" value="'.$player1_name.'" name="pl1_m'.$m_id.'_name" class="player_name '.( $winner == $pl1_id ? 'winner' : '' ).' '.( $winner == $pl2_id ? 'loser' : '' ).'" />';
        if( !empty( trim( $player1_name_bis ) ) ){
            //$html .= '<input type="text" value="'.$player1_name_bis.'" name="pl1_m'.$m_id.'_name_bis" class="player_name '.( $winner == $pl1_id ? 'winner' : '' ).' '.( $winner == $pl2_id ? 'loser' : '' ).'" />';

            $html .= '<select name="pl1_m'.$m_id.'_name_bis" id="pl1_m'.$m_id.'_name_bis" data_pl_id="pl1_id_bis" class="player_name '.( $winner == $pl1_id ? 'winner' : '' ).' '.( $winner == $pl2_id ? 'loser' : '' ).'" />';
            if( $player1_name_bis == 'Inaktiv' ){
                $html .= '<option value="0" selected="selected">'.$player1_name_bis.'</option>';
            }
            foreach( $players as $k => $player ){
                $html .= '<option value="'.$player->id.'" '.( $k == $pl1_id_bis ? 'selected="selected"' : '' ).'>'.$player->player_firstname.' '.$player->player_lastname.'</option>';
            }
            $html .= '</select>';
        }
        $html .= '<input type="number" value="'.$pl1_set1.'" name="pl1_m'.$m_id.'_set1" class="set_score" min="0" max="'.$_SESSION['current_tournament']['max_points_set'].'" tabindex='.($tabindex+1).' />';
        $html .= '<input type="number" value="'.$pl1_set2.'" name="pl1_m'.$m_id.'_set2" class="set_score" min="0" max="'.$_SESSION['current_tournament']['max_points_set'].'" tabindex='.($tabindex+3).' />';
        $html .= '<input type="number" value="'.$pl1_set3.'" name="pl1_m'.$m_id.'_set3" class="set_score" min="0" max="'.$_SESSION['current_tournament']['max_points_set'].'" tabindex='.($tabindex+5).' />';
        $html .= '<input type="number" value="'.$pl1_set4.'" name="pl1_m'.$m_id.'_set4" class="set_score" '.( $_SESSION['current_tournament']['nb_sets'] < 3 ? 'disabled="disabled"' : '' ).'tabindex='.($tabindex+7).' />';
        $html .= '<input type="number" value="'.$pl1_set5.'" name="pl1_m'.$m_id.'_set5" class="set_score" '.( $_SESSION['current_tournament']['nb_sets'] < 3 ? 'disabled="disabled"' : '' ).'tabindex='.($tabindex+9).' />';
        $html .= '<input type="submit" value="'.__('Winner', 'bad-tournament').'" class="match_winner" data="'.$pl1_id.'" data_m_id="'.$m_id.'" />';
        $html .= '</div>';




        $html .= '<div>';

        $html .= '<select name="pl2_m'.$m_id.'_name" id="pl2_m'.$m_id.'_name" data_pl_id="pl2_id" class="player_name '.( $winner == $pl2_id ? 'winner' : '' ).' '.( $winner == $pl1_id ? 'loser' : '' ).'" />';
        if( $player2_name == 'Inaktiv' ){
            $html .= '<option value="0" selected="selected">'.$player2_name.'</option>';
        }
        foreach( $players as $k => $player ){
            $html .= '<option value="'.$player->id.'" '.( $k == $pl2_id ? 'selected="selected"' : '' ).'>'.$player->player_firstname.' '.$player->player_lastname.'</option>';
        }
        $html .= '</select>';

        //$html .= '<input type="text" value="'.$player2_name.'" name="pl2_m'.$m_id.'_name" class="player_name '.( $winner == $pl2_id ? 'winner' : '' ).' '.( $winner == $pl1_id ? 'loser' : '' ).'" />';
        if( !empty( trim( $player2_name_bis ) ) ){
            //$html .= '<input type="text" value="'.$player2_name_bis.'" name="pl2_m'.$m_id.'_name_bis" class="player_name '.( $winner == $pl2_id ? 'winner' : '' ).' '.( $winner == $pl1_id ? 'loser' : '' ).'" />';

            $html .= '<select name="pl2_m'.$m_id.'_name_bis" id="pl2_m'.$m_id.'_name_bis" data_pl_id="pl2_id_bis" class="player_name '.( $winner == $pl2_id ? 'winner' : '' ).' '.( $winner == $pl1_id ? 'loser' : '' ).'" />';
            if( $player2_name_bis == 'Inaktiv' ){
                $html .= '<option value="0" selected="selected">'.$player2_name_bis.'</option>';
            }
            foreach( $players as $k => $player ){
                $html .= '<option value="'.$player->id.'" '.( $k == $pl2_id_bis ? 'selected="selected"' : '' ).'>'.$player->player_firstname.' '.$player->player_lastname.'</option>';
            }
            $html .= '</select>';
        }
        $html .= '<input type="number" value="'.$pl2_set1.'" name="pl2_m'.$m_id.'_set1" class="set_score" min="0" max="'.$_SESSION['current_tournament']['max_points_set'].'" tabindex='.($tabindex+2).' />';
        $html .= '<input type="number" value="'.$pl2_set2.'" name="pl2_m'.$m_id.'_set2" class="set_score" min="0" max="'.$_SESSION['current_tournament']['max_points_set'].'" tabindex='.($tabindex+4).' />';
        $html .= '<input type="number" value="'.$pl2_set3.'" name="pl2_m'.$m_id.'_set3" class="set_score" min="0" max="'.$_SESSION['current_tournament']['max_points_set'].'" tabindex='.($tabindex+6).' />';
        $html .= '<input type="number" value="'.$pl2_set4.'" name="pl2_m'.$m_id.'_set4" class="set_score" '.( $_SESSION['current_tournament']['nb_sets'] < 3 ? 'disabled="disabled"' : '' ).'tabindex='.($tabindex+8).' />';
        $html .= '<input type="number" value="'.$pl2_set5.'" name="pl2_m'.$m_id.'_set5" class="set_score" '.( $_SESSION['current_tournament']['nb_sets'] < 3 ? 'disabled="disabled"' : '' ).'tabindex='.($tabindex+10).' />';
        $html .= '<input type="submit" value="'.__('Winner', 'bad-tournament').'" class="match_winner" data="'.$pl2_id.'" data_m_id="'.$m_id.'" />';
        $html .= '</div>';


        $html .= '<br />';

        $html .= '<input type="submit" value="'.__('Update match', 'bad-tournament').'" />';

        $html .= '<br /><br /><hr />';


        
        $html .= '</form>';

        $tabindex = $tabindex + 100;
    }

    if( !$winner_exists ){
        $html .= '<form method="post" action="admin.php?page=bad_tournament&admin_view=matches">';
        $html .= '<input name="regenerate_matchs_now" type="submit" value="'.__('Regenerate matches', 'bad-tournament').'" />';
        $html .= '</form>';
    }

    $html .= '<h1 class="topspace">'.__('Shortcodes', 'bad-tournament').'</h1>';
    $html .= '<div class="shortcode_bvg"><h2>'.__('Matches', 'bad-tournament').'</h2><input type="text" class="wp_style" value="[bad_tournament_matches t_id='.$_SESSION['t_id'].' round=0]" /></div>';
    $html .= '<div class="shortcode_bvg"><h2>'.__('Matches only for 3rd round', 'bad-tournament').'</h2><input type="text" class="wp_style" value="[bad_tournament_matches t_id='.$_SESSION['t_id'].' round=3]" /></div>';
    $html .= '<div class="shortcode_bvg"><h2>'.__('Matches only for the current round', 'bad-tournament').'</h2><input type="text" class="wp_style" value="[bad_tournament_matches t_id='.$_SESSION['t_id'].' round=!]" /></div>';

}else{

    $html .= '<form method="post" action="admin.php?page=bad_tournament&admin_view=matches">';
    $html .= '<input name="generate_matchs_now" type="submit" value="'.__('Create matches', 'bad-tournament').'" />';
    $html .= '</form>';
}




$html .= '</div>';

