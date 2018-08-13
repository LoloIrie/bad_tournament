<?php
/**
 * Created by PhpStorm.
 * User: Lolo Irie
 * Date: 03/06/2018
 * Time: 14:49
 */

class badt_Bad_Debug {

    public $debug_time_start = 0;
    public $debug_time_end = 0;
    public $debug_content = array();

    function __construct(){
        $this -> debug_content[] = array(
            'label' => 'Debug start...',
            'msg' => 'object with the class badt_Bad_Debug initialized and constructor method works !',
            'backtrace' => debug_backtrace()[0]
        );
        $this -> debug_time_start = microtime( true );
        return true;
    }

    public function store_debug( $debug = array( 'No label' , 'No message' ) ){
        $this -> debug_content[] = array(
            'label' => $debug[0],
            'msg' => $debug[1],
            'backtrace' => debug_backtrace()[0]
            );
        return true;
    }

    public function display_debug(){

        $this -> debug_time_end = microtime( true );

        $html = '';
        $html .= '<div id="badt_debug_panel" '.( BADT_DEBUG_MODE === true ? 'style="display: block;"' : '' ).'>';

        $html .= 'Debug start: ' . $this -> debug_time_start .'<br />';

        foreach( $this -> debug_content as $debug_content ) {
            $html .= '<div class="badt_debug_block"><span id="badt_debug_panel_close" style="cursor: pointer; float: right;">Close debug</span><br />';

                $html .= '<div class="badt_debug_label">'.$debug_content[ 'label' ].'</div>';
                unset( $debug_content[ 'label' ] );
                foreach( $debug_content as $debug ) {
                    if( is_string( $debug ) ){
                        $html .= $debug;
                    }else if( is_array( $debug ) ){
                        $html .= '<pre>'.print_r( $debug ,1 ).'</pre>';
                    }

                }
            $html .= '</div>';
        }

        $html .= '<div class="badt_debug_block">';
            $html .= '<div class="badt_debug_label">Debug end !</div>';
            $html .= 'Debug end: ' . $this -> debug_time_end .'<br />';
            $html .= 'Debug time: ' . ( $this -> debug_time_end - $this -> debug_time_start ) .' sec.';
            $html .= '<pre>'.print_r( debug_backtrace()[0] ,1 ).'</pre>';
        $html .= '</div>';

        $html .= '</div>
        <script>
            jQuery( \'#badt_debug_panel_close\' ).on( \'click\', function(){
                jQuery( \'#badt_debug_panel\' ).fadeOut();
            });
            jQuery( \'#badt_debug_panel\' ).on( \'dblclick\', function(){
                jQuery( \'#badt_debug_panel\' ).fadeOut();
            });
            jQuery( document ).on( \'click\', \'#display_debug_infos\', function(e){
                jQuery( \'#badt_debug_panel\' ).fadeIn();
            });
        </script>';

        echo $html;
        return true;
    }
}