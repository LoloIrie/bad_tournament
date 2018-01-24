<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 15:32
 */

global $wpdb;

if( isset( $_POST['replace_existing'] ) ){
    define( 'BADT_REPLACE' , true );
}else{
    define( 'BADT_REPLACE' , false );
}

$fieldseparator = ";";
$lineseparator = "\\n";
$enclosedby = "\"";

// FUNCTION TO GET FULL FILE PATH
function dabt_csv_filepath( $table ){
    $filename = plugin_dir_path( __FILE__  ).'../tmp/csv_file_'.$table.".csv";

    // Cleanup Path
    $filename = (DIRECTORY_SEPARATOR === '\\')
        ? str_replace('/', '\\', $filename)
        : str_replace('\\', '/', $filename);

    // For Windows
    $filename = str_replace('\\', '\\\\', $filename);

    return $filename;
}

if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

$uploadedfile = $_FILES['import_file'];

$upload_overrides = array( 'test_form' => false );

$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

if ( $movefile && !isset( $movefile['error'] ) ) {
    // FILE IS "VALID", AND WAS SUCCESSFULLY UPLOADED

    // Cleanup Path
    $movefile['file'] = (DIRECTORY_SEPARATOR === '\\')
        ? str_replace('/', '\\', $movefile['file'])
        : str_replace('\\', '/', $movefile['file']);

    // For Windows
    $movefile['file'] = str_replace('\\', '\\\\', $movefile['file']);

    // Split file
    if(!$handle = fopen($movefile['file'], "rb")) {
        $bvg_admin_msg .= __( 'Unable to open the csv file', 'bad-tournament' );
    }else{
        if ($handle) {
            $sql_filecontent = '';
            if( BADT_REPLACE ){
                $id_str = '';
            }
            while (($line = fgets($handle)) !== false) {
                if( substr( $line, '0', 1) === '#' ){
                    // Save file with content
                    if( !empty( $sql_filecontent ) ){
                        $csv_file = dabt_csv_filepath( $db_table );
                        if( !$fw = fopen( $csv_file ,"w") ){
                            $bvg_admin_msg .= __( 'Unable to create or open the part file: '.$csv_file.'<br />', 'bad-tournament' );
                        }else{
                            file_put_contents( $csv_file , $sql_filecontent );

                            $wp_table = $wpdb->prefix.$db_table;

                            if( BADT_REPLACE && trim( $id_str ) != '' ){
                                /* DROP PREVIOUS VALUES */
                                $id_str = substr( $id_str ,0, -1);
                                $query = "DELETE FROM ".$wp_table." WHERE id IN (".$id_str.")";
                                $wpdb->query( 'SET foreign_key_checks = 0;' );
                                $wpdb->query( $query );
                                $wpdb->query( 'SET foreign_key_checks = 1;' );
                                $id_str = '';
                            }

                            $query = "LOAD DATA LOCAL INFILE '".$csv_file."' INTO TABLE ".$wp_table." FIELDS TERMINATED BY '".$fieldseparator."' ENCLOSED BY '".$enclosedby."' LINES TERMINATED BY '".$lineseparator."'";
                            $wpdb->query( $query );
                        }

                        $sql_filecontent = '';
                        if( BADT_REPLACE ){
                            $id_str = '';
                        }
                    }
                    // New Table name
                    $db_table = trim( substr( $line , 1) );
                }else if( trim( $line ) != '' && substr( $line , 0, 4) != '"id"' ){
                    $sql_filecontent .= $line;
                    if( BADT_REPLACE ){
                        $line_parts = explode( $enclosedby , $line );
                        $id_str .= $line_parts[1].',';
                    }

                }
            }
            if( !empty( $sql_filecontent ) ){

                file_put_contents( dabt_csv_filepath( $db_table ) , $sql_filecontent );

                $wp_table = $wpdb->prefix.$db_table;

                if( BADT_REPLACE && trim( $id_str ) != '' ){
                    /* DROP PREVIOUS VALUES */
                    $id_str = substr( $id_str ,0, -1);
                    $query = "DELETE FROM ".$wp_table." WHERE id IN (".$id_str.")";
                    $wpdb->query( 'SET foreign_key_checks = 0;' );
                    $wpdb->query( $query );
                    $wpdb->query( 'SET foreign_key_checks = 1;' );
                    $id_str = '';
                }

                $query = "LOAD DATA LOCAL INFILE '".$csv_file."' INTO TABLE ".$wp_table." FIELDS TERMINATED BY '".$fieldseparator."' ENCLOSED BY '".$enclosedby."' LINES TERMINATED BY '".$lineseparator."'";
                $wpdb->query( $query );
                $sql_filecontent = '';
            }
            fclose($handle);
        }
    }


}

$bvg_admin_msg .= __( 'Data imported !', 'bad-tournament' );