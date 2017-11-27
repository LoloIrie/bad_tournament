console.log( 'bad-tournament.js included...' );

/*
jQuery('.admin_block_label').on( 'click', function(){
    jQuery('.admin_block').hide();
    jQuery( this ).next().slideDown();
});
*/

jQuery('.table_row').on( 'click', function(){
    player_name_tosearch = jQuery( this ).find( '.pl_name').html();
    if( jQuery( '#block_game' ).length > 0 ){
        jQuery( '#block_game .match_pl1_name').each( function(){
            var text = jQuery(this).html();
            jQuery(this).html(text.replace( '<span style="color: #ff0; background-color: rgba( 0, 0, 0, 0.4); padding-right: 4px; padding-left: 4px;">(.*)</span>' , '$1'));
            text = jQuery(this).text();
            jQuery(this).html(text.replace( player_name_tosearch , '<span style="color: #ff0; background-color: rgba( 0, 0, 0, 0.4); padding-right: 4px; padding-left: 4px;">'+player_name_tosearch+'</span>'));
        });
        jQuery( '#block_game .match_pl2_name').each( function(){
            var text = jQuery(this).html();
            jQuery(this).html(text.replace( '<span style="color: #ff0; background-color: rgba( 0, 0, 0, 0.4); padding-right: 4px; padding-left: 4px;">(.*)</span>' , '$1'));
            text = jQuery(this).text();
            jQuery(this).html(text.replace( player_name_tosearch , '<span style="color: #ff0; background-color: rgba( 0, 0, 0, 0.4); padding-right: 4px; padding-left: 4px;">'+player_name_tosearch+'</span>'));
        });

    }
});

jQuery('#round_select').on( 'change', function(){
    console.log('Change round...');
    round_display = jQuery( this ).val();
    if( round_display == 0 ){
        jQuery('.match_round_header').fadeIn();
        jQuery('.match_row').fadeIn();
    }else{
        jQuery('.match_round_header').each(function(){
            jQuery( this ).fadeOut();
            jQuery( '.match_row' ).fadeOut();
        });
        jQuery('.match_round_header').each(function(){
            if( jQuery( this).attr( 'data-round' ) == round_display ){
                jQuery( this ).slideDown();
                jQuery('.match_row').each(function(){
                    if( jQuery( this).attr( 'data-round' ) == round_display ){
                        jQuery( this ).slideDown( 'slow' );
                    }
                });
            }

        });
    }

});
