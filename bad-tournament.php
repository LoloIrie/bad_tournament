<?php

/*
Plugin Name: Bad Tournament
Plugin URI: http://etalkers.org/what/wordpress-development/bad-tournament-wp-plugin
Description: Badminton / Tennis / Table tennis Tournament Plugin
Author: Laurent Dorier
Version: 1.0
Author URI: http://etalkers.org
Text Domain: bad-tournament
Domain Path: /languages
*/

if ( !defined( 'ABSPATH' ) ) die();


add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

class badt_Bad_Tournament
{
    function __construct(){
        load_plugin_textdomain( 'bad-tournament' );

        add_action( 'admin_menu', array( $this, 'bad_tournament_menu' ) );

        // Ajax
        add_action( 'wp_ajax_change_players_match', array( $this, 'change_players_match' ) );
        add_action( 'wp_ajax_player_tooltip', array( $this, 'player_tooltip' ) );
        add_action( 'wp_ajax_player_remove', array( $this, 'player_remove_from_tournament' ) );
        add_action( 'wp_ajax_player_edit_field', array( $this, 'player_edit_field' ) );
        add_action( 'wp_ajax_set_club_default', array( $this, 'set_club_default' ) );
        add_action( 'wp_ajax_set_player_form_default', array( $this, 'set_player_form_default' ) );


        add_action( 'admin_head', array( $this, 'bvg_head_javascript_object' ) );


        add_shortcode( 'bad_tournament_table', array( $this, 'bad_tournament_table_shortcode' ) );
        add_shortcode( 'bad_tournament_matches', array( $this, 'bad_tournament_matches_shortcode' ) );
        add_shortcode( 'bad_tournament_summary', array( $this, 'bad_tournament_summary_shortcode' ) );
    }

    function bvg_head_javascript_object(){
        ?>
        <script>
            var bvg_tournament_constants = {
                "badTournamentURI": '<?php echo plugin_dir_url( __FILE__ ); ?>',
                "badTournamentMale": '<?php echo __( 'Male' , 'bad-tournament' ); ?>',
                "badTournamentFemale": '<?php echo __( 'Female' , 'bad-tournament' ); ?>',
                "confirmRemoveTournament": '<?php echo __( 'Are you sure you want to remove this tournament ?' , 'bad-tournament' ); ?>',
            }
            console.log( bvg_tournament_constants );
        </script>
        <?php
    }

    function bad_tournament_menu(){
        add_menu_page(
            'Bad Tournament',
            __('Bad Tournament', 'bad-tournament'),
            'edit_pages',
            'bad_tournament',
            array( $this, 'bad_tournament_admin' ),
            plugin_dir_url( __FILE__ ).'icons/bad-tournament-icon.png',
            20
        );

        //add_submenu_page( 'bad_tournament', 'Tournament', __('Tournament', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=tournament');
        add_submenu_page( 'bad_tournament', 'Clubs', __('Clubs', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=clubs');
        add_submenu_page( 'bad_tournament', 'Players', __('Players', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=players');
        add_submenu_page( 'bad_tournament', 'Table', __('Table', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=table');
        add_submenu_page( 'bad_tournament', 'Matches', __('Matches', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=matches');

    }

    function bad_tournament_admin(){

        /* jQuery UI for datepicker
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
        wp_register_script('addons_script', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), '');
        wp_enqueue_script('addons_script');
        */
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('jquery-ui-datepicker');

        /* Datetime Picker Plugin */
        wp_enqueue_style( 'addons2_style', plugin_dir_url(__FILE__).'admin/jquery-ui-timepicker-addon.css');
        wp_register_script('addons2_script', plugins_url( 'admin/jquery-ui-timepicker-addon.js', __FILE__ ), array('jquery'), '');
        wp_enqueue_script('addons2_script');



        wp_enqueue_style( 'bad_tournament_admin_style', plugin_dir_url(__FILE__).'admin/bad-tournament-admin.css');
        wp_register_script( 'bad_tournament_admin', plugins_url( 'admin/bad-tournament-admin.js', __FILE__ ) );
        $translation_array = array(
            'save_now' => __( 'Save now ?..', 'bad-tournament' )
        );
        wp_localize_script( 'bad_tournament_admin', 'bad_tournament_admin', $translation_array );
        wp_enqueue_script( 'bad_tournament_admin'  );

        if ( current_user_can('edit_pages') ) {

            $bad_tournament_version = '1.0';
            include plugin_dir_path(__FILE__).'admin/install.php';

            $bad_tournament_current_version = get_option( 'bad_tournament_installed' );
            if( $bad_tournament_current_version !== $bad_tournament_version ){

                /* Not yet installed ? */
                $bvg_admin_msg = badt_install( $bad_tournament_version, $bad_tournament_current_version );
                update_option('bad_tournament_installed', $bad_tournament_version  );

            }

            include plugin_dir_path(__FILE__).'admin/index.php';
        }else{
            die( __('You are not allowed to access here...', 'bad-tournament') );
        }


        return true;
    }

    // Ajax: Return player infos for tootip
    function player_tooltip( $atts ){
        $html_ajax = '';
        include plugin_dir_path(__FILE__).'admin/action/player-info.php';

        echo $html_ajax;
        wp_die();
    }

    // Ajax: Remove player from tournament
    function player_remove_from_tournament( $atts ){
        $html_ajax = '';
        include plugin_dir_path(__FILE__).'admin/action/player-remove-from-tournament.php';

        echo $html_ajax;
        wp_die();
    }

    // Ajax: Edit player infos
    function player_edit_field(){
        $html_ajax = '';
        include plugin_dir_path(__FILE__).'admin/action/player-edit-field.php';

        echo $html_ajax;
        wp_die();
    }



    // Ajax: Set club as default
    function set_club_default(){
        $html_ajax = '';
        include plugin_dir_path(__FILE__).'admin/action/club-set-default.php';

        echo $html_ajax;
        wp_die();
    }

    // Ajax: Set player form view as default
    function set_player_form_default(){
        $html_ajax = '';
        include plugin_dir_path(__FILE__).'admin/action/player-form-set-default.php';

        echo $html_ajax;
        wp_die();
    }


    function change_players_match(){
        $html_ajax = '';
        include plugin_dir_path(__FILE__).'admin/action/change-player-match.php';
        //var_dump( $_POST );
        echo $html_ajax;
        wp_die();
    }

    // Add Shortcodes
    function bad_tournament_table_shortcode( $atts ) {

        wp_enqueue_style( 'bad_tournament_admin_style', plugin_dir_url(__FILE__).'bad-tournament.css');

        $html_shortcode = '';
        include plugin_dir_path( __FILE__ ).'shortcodes/shortcode-table.php';

        return $html_shortcode;
    }

    function bad_tournament_matches_shortcode( $atts ) {

        wp_enqueue_style( 'bad_tournament_admin_style', plugin_dir_url(__FILE__).'bad-tournament.css');
        wp_enqueue_script( 'bad_tournament', plugins_url( 'bad-tournament.js', __FILE__ ) );

        $html_shortcode = '';
        include plugin_dir_path( __FILE__ ).'shortcodes/shortcode-matches.php';

        return $html_shortcode;
    }

    function bad_tournament_summary_shortcode( $atts ) {

        $html_shortcode = '';
        include plugin_dir_path( __FILE__ ).'shortcodes/shortcode-summary.php';

        return $html_shortcode;
    }

}

new badt_Bad_Tournament();