console.log( 'bad-tournament-admin.js included...' );

/*
jQuery('.admin_block_label').on( 'click', function(){
    jQuery('.admin_block').hide();
    jQuery( this ).next().slideDown();
});
*/

jQuery('.nav_item').on( 'click', function(){
    id_nav = jQuery( this ).attr( 'id' );
    id_block = '.admin_block.' + id_nav;
    jQuery('.admin_block').hide();
    jQuery( id_block ).slideDown( 'slow' );
});

jQuery('.match_winner').on( 'click', function(){
    jMatchId = '#match_winner_' + jQuery( this ).attr('data_m_id');
    jFormId = '#form_match_' + jQuery().attr('data_m_id');
    jQuery( jMatchId ).val( jQuery( this ).attr( 'data' ) );
    jQuery( jFormId ).submit();
});

jQuery('#tournament_select_button').on( 'click', function(){
    jQuery( '#tournament_name').val( '' );
    jQuery( '#tournament_select_id' ).val( jQuery( '#tournament_select' ).val() );
});

jQuery('#player_select').on( 'change', function(){
    console.log( jQuery('#player_select option:selected').attr( 'data_level' ) );
    jQuery( '#schweizer_system_punkte').val( jQuery('#player_select option:selected').attr( 'data_level' ) );
});

jQuery( 'select.player_name' ).on('change', function() {
        if (confirm('Wollen Sie wirklich die Spieleinstellung ändern ? ')) {
            the_form = jQuery(this).closest('form');
            pl_select = the_form.find( '.player_name' );
            players_id = [];
            pl_select.each(function(i){
                players_id[i] = jQuery( this ).val();
                jSelector = 'input[name="'+jQuery( this).attr( 'data_pl_id' )+'"]';
                the_form.find( jSelector).val( jQuery( this ).val() );
            });

            match_id = the_form.find( '.match_id' ).val();
            console.log( players_id );
            console.log( match_id );
            var data = {
                action: 'change_players_match',
                match_id: match_id,
                players_id: players_id
            };

            jQuery.ajax({
                type: "POST",
                data : data,
                async: true,
                cache: false,
                url: ajaxurl,
                success: function(data) {
                    console.log(data);

                }
            });

        }
    }
);