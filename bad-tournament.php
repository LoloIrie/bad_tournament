<?php

/*
Plugin Name: Bad Tournament
Plugin URI: http://etalkers.org
Description: Badminton / Tennis / Table tennis Tournament Plugin
Author: Laurent Dorier
Version: 1.0
Author URI: http://etalkers.org
Text Domain: bad-tournament
Domain Path: /languages
*/
define( 'bad_tournament_DEBUG', true );
if ( !defined( 'ABSPATH' ) ) die();

if( bad-tournament_DEBUG ){
    $wpdb->show_errors();
}

add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

class bad_tournament
{
    function __construct(){
        load_plugin_textdomain( 'bad-tournament' );

        add_action( 'admin_menu', array( $this, 'bad_tournament_menu' ) );

        add_action( 'wp_ajax_change_players_match', array( $this, 'change_players_match' ) );

        add_shortcode( 'bad_tournament_table', array( $this, 'bad_tournament_table_shortcode' ) );
        add_shortcode( 'bad_tournament_matches', array( $this, 'bad_tournament_matches_shortcode' ) );
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

        add_submenu_page( 'bad_tournament', 'Tournament', __('Tournament', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=tournament');
        add_submenu_page( 'bad_tournament', 'Players', __('Players', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=players');
        add_submenu_page( 'bad_tournament', 'Table', __('Table', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=table');
        add_submenu_page( 'bad_tournament', 'Matches', __('Matches', 'bad-tournament'), 'manage_options', 'admin.php?page=bad_tournament&admin_view=matches');

    }

    function bad_tournament_admin(){

        wp_enqueue_style( 'bad_tournament_admin_style', plugin_dir_url(__FILE__).'admin/bad-tournament-admin.css');
        wp_enqueue_script( 'bad_tournament_admin', plugins_url( 'admin/bad-tournament-admin.js', __FILE__ ) );

        if ( current_user_can('edit_pages') ) {

            if( get_option( 'bad_tournament_installed' ) !== 'ok' ){
                /* Not yet installed ? */
                include plugin_dir_path(__FILE__).'admin/install.php';
                add_option('bad_tournament_installed', 'ok'  );
            }

            include plugin_dir_path(__FILE__).'admin/index.php';
        }else{
            die( __('You are not allowed to access here...', 'bad-tournament') );
        }


        return true;
    }

    function change_players_match(){
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
}

new bad_tournament();