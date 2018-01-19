<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */


if ( !defined( 'ABSPATH' ) ) die();

$ADMIN_VIEW = false;
if( isset( $_GET['admin_view'] ) ){
    $ADMIN_VIEW = $_GET['admin_view'];
}

/* GET/SET CONTENT */
include_once plugin_dir_path(__FILE__). 'db-get-content.php';

/* ACTIONS */
if( isset($_POST['form_action']) ){
    include plugin_dir_path(__FILE__). 'action/'.$_POST['form_action'].'.php';
}


if( !$ADMIN_VIEW ){
    $ADMIN_VIEW = 'export';
}

/* HTML */
$html = '';

/* Header */
include plugin_dir_path(__FILE__). 'index_html/header-export.php';

/* Import */
include plugin_dir_path(__FILE__). 'index_html/import.php';

/* Export */
include plugin_dir_path(__FILE__). 'index_html/export.php';


echo $html;


