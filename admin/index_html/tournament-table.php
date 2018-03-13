<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 13.11.2017
 * Time: 09:12
 */


/* Table */

//$html .= '<div class="admin_block_label">Tabelle</div>';
$html .= '<div class="admin_block nav_table" id="block_table" '.( $ADMIN_VIEW == 'table' ? 'style="display: block;"' : '' ).'>';
$html .= '<form method="post">';
$html .= '<input type="hidden" name="form_action" value="next-round" />';

$html .= '<ul class="table">';
    $html .= '<li class="table_header">';
        $html .= '<span class="pl_name">';
            $html .= __('Player', 'bad-tournament');
        $html .= "</span>";
        $html .= '<span class="pl_played">';
            $html .= __('Games', 'bad-tournament');
        $html .= "</span>";
        $html .= '<span class="pl_victory">';
            $html .= __('W', 'bad-tournament');
        $html .= "</span>";
        $html .= '<span class="pl_draw">';
            $html .= __('D', 'bad-tournament');
        $html .= "</span>";
        $html .= '<span class="pl_loss">';
            $html .= __('L', 'bad-tournament');
        $html .= "</span>";
        $html .= '<span class="pl_points_major">';
            $html .= __('Main Points', 'bad-tournament');
        $html .= "</span>";
        $html .= '<span class="pl_sets">';
            $html .= __('Sets', 'bad-tournament');
        $html .= "</span>";
        $html .= '<span class="pl_points">';
            $html .= __('Total points', 'bad-tournament');
        $html .= "</span>";
    $html .= '</li>';


foreach( $players as $k => $player ){

    if( $player->status != 2 ){
        $html .= '<li class="table_row">';
        $html .= '<span class="pl_name">';
            $html .= $player->player_firstname.' '.$player->player_lastname;
            if( $_SESSION['t_system'] == 1 ){
                $html .= '<span class="pl_level_init"> ('.$player->player_level_init.')</span>';
            }
            $html .= '<span class="pl_options">';
                $html .= '<img src="'.plugin_dir_url( __FILE__ ).'../../icons/bad-tournament-close-icon.png'.'" class="pl_remove" data-pl_id="'.$player->players_id.'" />';
                $html .= '<img src="'.plugin_dir_url( __FILE__ ).'../../icons/bad-tournament-info-icon.png'.'" class="pl_infos" data-pl_id="'.$player->players_id.'" />';
            $html .= "</span>";
        $html .= "</span>";

        $html .= '<span class="pl_played">';
        $html .= $player->played;
        $html .= "</span>";

        $html .= '<span class="pl_victory">';
        $html .= $player->victory;
        $html .= "</span>";

        $html .= '<span class="pl_draw">';
        $html .= $player->draw;
        $html .= "</span>";

        $html .= '<span class="pl_loss">';
        $html .= $player->loss;
        $html .= "</span>";

        $html .= '<span class="pl_points_major">';
        $html .= $player->points_major;
        $html .= "</span>";

        $html .= '<span class="pl_sets">';
        $html .= $player->sets;
        $html .= ' - ';
        $html .= $player->sets_against;
        $html .= "</span>";

        $html .= '<span class="pl_points">';
        $html .= $player->points;
        $html .= ' - ';
        $html .= $player->points_against;
        $html .= "</span>";
        $html .= '</li>';
    }

}
$html .= '</ul>';

if( $_SESSION[ 'current_tournament' ][ 'round_max' ] <= $_SESSION['round'] ){
    $html .= '<p class="topspace badt_alert">'.__('Be careful to the defined maximum round number... Sure to want to create a new round ?', 'bad-tournament').'</p>';
}
$html .= '<p>
<input type="submit" value="'.__('Next round', 'bad-tournament').'" class="next_round button-primary button" style="float: none;" />';
$html .= '<input type="submit" value="'.__('Next round and create matches', 'bad-tournament').'" name="generate_matchs_now" class="submit2 next_round button-primary button" style="float: none;" />
</p>';

$html .= '<h1 class="topspace">'.__('Shortcodes', 'bad-tournament').'</h1>';
$html .= '<div class="shortcode_bvg"><h2>'.__('Full table', 'bad-tournament').'</h2><input type="text" class="wp_style" value="[bad_tournament_table t_id='.$_SESSION['t_id'].' view=full]" /></div>';
$html .= '<div class="shortcode_bvg"><h2>'.__('Table with only first XX players', 'bad-tournament').'</h2><input type="text" class="wp_style" value="[bad_tournament_table t_id='.$_SESSION['t_id'].' view=XX]" /></div>';




$html .= '</form>';
$html .= '</div>';

$html .= '<script>
jQuery(\'.wp_style\').on(\'click\', function(){
    jQuery( this ).select();
});
</script>';