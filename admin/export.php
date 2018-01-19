<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */


if ( !defined( 'ABSPATH' ) ) die();

/* GET/SET CONTENT */
include_once plugin_dir_path(__FILE__). 'db-get-content.php';

/* ACTIONS */
if( isset($_POST['form_action']) ){
    include plugin_dir_path(__FILE__). 'action/'.$_POST['form_action'].'.php';
}


/* HTML */
$html = '';

/* Header */
include plugin_dir_path(__FILE__). 'index_html/header_export.php';

/* Tournament */
//include plugin_dir_path(__FILE__). 'index_html/export.php';

/* Clubs */
//include plugin_dir_path(__FILE__). 'index_html/import.php';


echo $html;


