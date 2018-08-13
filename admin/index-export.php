<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:14
 */


if ( !defined( 'ABSPATH' ) ) die();

require_once plugin_dir_path(__FILE__). 'badt_functions.php';

if( defined('BADT_DEBUG_MODE') && BADT_DEBUG_MODE > 0 ){
    /* DEBUG ACTIVATED
    */
    global $badt_debug_obj;
    $badt_debug_obj = new badt_Bad_Debug;

}

$ADMIN_VIEW = false;
if( isset( $_GET['admin_view'] ) ){
    $ADMIN_VIEW = $_GET['admin_view'];
}

global $wpdb;

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

/* Import */
include plugin_dir_path(__FILE__). 'index_html/cleanup.php';

/* Settings */
include plugin_dir_path(__FILE__). 'index_html/settings.php';

/* Footer */
include plugin_dir_path(__FILE__). 'index_html/footer.php';

echo $html;

if( isset( $csv ) ){
    echo '<div id="csv_view"><pre>'.$csv.'</pre></div>';
}

if( defined('BADT_DEBUG_MODE') && BADT_DEBUG_MODE > 0 ){
    /* DEBUG DISPLAYED
    */
    if( BADT_DEBUG_MODE == 1 ){
        $badt_debug_obj -> display_debug();
    }

}