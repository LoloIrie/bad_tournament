<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */



/* Matches */


//$html .= '<div class="admin_block_label">Spiele</div>';
$html .= '<div class="admin_block nav_match" id="block_game'.$ROUND.'">';

if( !$ROUND && ($ROUND_MAX - $ROUND) > 2 ){
    $html .= '<div class="round_select_div">';
        $html .= 'Round: <select data-round="'.$ROUND.'" id="round_select">';
        $html .= '<option value="0">Alles</option>';
        for( $i=1; $i<=$ROUND_MAX; $i++){
                $html .= '<option value="'.$i.'">'.$i.'</option>';
            }
        $html .= '</select>';
    $html .= '</div>';
}

//var_dump( $players );
if( !empty( $matches ) ){
    $round = 0;
    foreach( $matches as $match ){
        if( $match->round > $round ){
            $round = $match->round;
            $html .= '<div class="match_round_header" data-round="'.$round.'">';
            $html .= 'Round: '.$round;
            $html .= '</div>';
        }
        $html .= '<div class="match_row" data-round="'.$round.'">';
            $html .= '<div class="match_row1">';
                $html .= '<div class="match_pl1_name '.( $match->winner == $match->player1_id ? 'winner' : 'loser' ).( $match->player1_id_bis > 0 ? ' double' : 'simple ' ).'">';
                    $html .= $players[ $match->player1_id ]->player_firstname.' '.$players[ $match->player1_id ]->player_lastname;
                    if( $match->player1_id_bis > 0 ){
                        $html .= ' / '.$players[ $match->player1_id_bis ]->player_firstname.' '.$players[ $match->player1_id_bis ]->player_lastname;
                    }
                $html .= '</div>';
                $html .= '<div class="match_pl1_score">';
                    $html .= '<span class="set_score">'.$match->pl1_set1.'</span><span class="set_score">'.$match->pl1_set2.'</span>';
                    if( $match->pl1_set3 > 0 || $match->pl2_set3 > 0 ){
                        $html .= '<span class="set_score">'.$match->pl1_set3.'</span>';
                    }
                    if( $match->pl1_set4 > 0 || $match->pl2_set4 > 0 ){
                        $html .= '<span class="set_score">'.$match->pl1_set4.'</span>';
                    }
                    if( $match->pl1_set5 > 0 || $match->pl2_set5 > 0 ){
                        $html .= '<span class="set_score">'.$match->pl1_set5.'</span>';
                    }
                $html .= '</div>';
            $html .= '</div>';

            $html .= '<div class="match_row2">';
                $html .= '<div class="match_pl2_name '.( $match->winner == $match->player2_id ? 'winner' : 'loser' ).( $match->player1_id_bis > 0 ? ' double' : 'simple ' ).'">';
                    $html .= $players[ $match->player2_id ]->player_firstname.' '.$players[ $match->player2_id ]->player_lastname;
                    if( $match->player2_id_bis > 0 ){
                        $html .= ' / '.$players[ $match->player2_id_bis ]->player_firstname.' '.$players[ $match->player2_id_bis ]->player_lastname;
                    }
                $html .= '</div>';
                $html .= '<div class="match_pl2_score">';
                    $html .= '<span class="set_score">'.$match->pl2_set1.'</span><span class="set_score">'.$match->pl2_set2.'</span>';
                    if( $match->pl2_set3 > 0 || $match->pl2_set3 > 0 ){
                        $html .= '<span class="set_score">'.$match->pl2_set3.'</span>';
                    }
                    if( $match->pl2_set4 > 0 || $match->pl1_set4 > 0 ){
                        $html .= '<span class="set_score">'.$match->pl2_set4.'</span>';
                    }
                    if( $match->pl2_set5 > 0 || $match->pl1_set5 > 0 ){
                        $html .= '<span class="set_score">'.$match->pl2_set5.'</span>';
                    }
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';

    }
    //$html .= '<pre>';
    //$html .= print_r( $matches, 1 );
    //$html .= '</pre>';

}else{

    $html .= 'Noch kein Spiel !';

}




$html .= '</div>';

