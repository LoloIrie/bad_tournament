console.log( 'bad-tournament-admin.js included...' );
console.log( bvg_tournament_constants );

/* Switching admin page */
jQuery('.nav_item').on( 'click', function(){
    jQuery('.nav_item').removeClass( 'active' );
    jQuery( this ).addClass( 'active' );
    id_nav = jQuery( this ).attr( 'id' );
    id_block = '.admin_block.' + id_nav;
    jQuery('.admin_block').hide();
    jQuery( id_block ).slideDown( 'slow' );
});

/* Menu opacity effect */
jQuery(document).ready(function() {
    jQuery(function () {
        jQuery(window).scroll(function () {
            if( jQuery(window).scrollTop() >= 35 ) {
                jQuery( 'nav#main_nav' ).addClass( 'transparent' );
            } else {
                jQuery( 'nav#main_nav' ).removeClass( 'transparent' );

            }
        });
    });
});

/* Set match winner */
jQuery('.match_winner').on( 'click', function(){
    jMatchId = '#match_winner_' + jQuery( this ).attr('data_m_id');
    jFormId = '#form_match_' + jQuery().attr('data_m_id');
    jQuery( jMatchId ).val( jQuery( this ).attr( 'data' ) );
    jQuery( jFormId ).submit();
});

/* Choose existing tournament */
jQuery('#tournament_select_button').on( 'click', function(){
    jQuery( '#tournament_name').val( '' );
    jQuery( '#tournament_select_id' ).val( jQuery( '#tournament_select' ).val() );
});

/* Fill tournament form with existing values */
jQuery('#tournament_select').on( 'change', function(){
    jQuery( '#tournament_edit').fadeIn();
    console.log( tournament[jQuery( '#tournament_select' ).val()] );
    selected_tournament = JSON.parse( tournament[jQuery( '#tournament_select' ).val()] );

    jQuery( '#tournament_name').val( selected_tournament.name );
    jQuery( 'input[name=tournament_system]' ).each( function(){
        if( jQuery( this).val() == selected_tournament.system ){
            jQuery( this).attr( 'checked', 'checked' );
        }
    } );
    jQuery( '#tournament_nb_sets').val( selected_tournament.nb_sets );
    jQuery( '#tournament_points_set').val( selected_tournament.points_set );
    jQuery( '#tournament_max_points_set').val( selected_tournament.max_points_set );
    jQuery( '#club_restriction option' ).each( function(){
        if( jQuery( this).val() == selected_tournament.club_restriction ){
            jQuery( this).attr( 'selected', 'selected' );
        }
    } );

    //jQuery( '#tournament_select_id' ).val( jQuery( '#tournament_select' ).val() );
});

/* Close admin message */
jQuery('#bvg_admin_msg_close').on( 'click', function(){
    console.log( 'Close admin msg...' );
    jQuery( '#bvg_admin_msg').animate({ height: 0, opacity: 0 }, 'slow');
});

/* Expand players list */
jQuery('#player_select').on( 'focus mouseover' , function(){
    if( jQuery( this ).children().length > 25 ){
        jQuery( this ).height( 400 );
    }else if( jQuery( this ).children().length > 8 ){
        jQuery( this ).height( 250 );
    }
});
jQuery('#player_select').on( 'blur mouseout' , function(){
   jQuery( this ).height( 150 );
});

/* Expand new player form */
jQuery('.plus_icon').on( 'click', function(){
    jQuery( this).next().next().slideDown();

    jQuery('#ajax_spinner_layer').fadeIn();
    data = {
        action: 'set_player_form_default'
    };
    jQuery.ajax({
        type: "POST",
        data : data,
        async: true,
        cache: false,
        url: ajaxurl,
        success: function(data) {
            console.log( 'Player form extended by default now...' );
            jQuery('#ajax_spinner_layer').fadeOut( 'slow' );
        }
    });
});

/* Change player for a match */
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
    } );

/* Expand player profile on table view */
jQuery('.pl_infos').on( 'click', function(){
    console.log('Display player infos');

    row_parent = jQuery( this).closest( 'li.table_row' );

    if( row_parent.find( '.player_infos').length > 0 ){
        console.log( 'Remove player infos' );
        row_parent.find( '.player_infos').fadeOut().remove();
    }else{
        jQuery('#ajax_spinner_layer').fadeIn();
        console.log( 'Display player infos' );
        pl_id = jQuery( this ).attr('data-pl_id');

        var data = {
            action: 'player_tooltip',
            pl_id: pl_id
        };

        jQuery.ajax({
            type: "POST",
            data : data,
            async: true,
            cache: false,
            url: ajaxurl,
            success: function(data) {
                console.log( 'Attach infos now...' );
                console.log(data);
                row_parent.append( '<div class="player_infos"></div>' );
                row_parent.find( '.player_infos').append( data );
                jQuery('#ajax_spinner_layer').fadeOut( 'slow' );
                /* add datepicker to forms */
                jQuery('.datepicker').datepicker( {dateFormat: "dd/mm/yy"} );

                jQuery( '.pl_edit_field' ).on('change keypress', function(e){
                    allow_to_edit = true;
                    if( jQuery('option:selected', this).hasClass( 'no_edit' ) ){
                        allow_to_edit = false;
                    }
                    if( jQuery( '#edit_field_valid' ).length < 1 && allow_to_edit === true ){
                        jQuery( this).after( '<img src="' + bvg_tournament_constants.badTournamentURI + 'icons/bad-tournament-ok-icon.png" id="edit_field_valid" class="edit_field_valid" />' );

                        jQuery( '#edit_field_valid' ).on( 'click', function(){
                            if( confirm( bad_tournament_admin.save_now )){
                                var pl_field = jQuery( this );
                                pl_field_name = jQuery( this ).prev().prop( 'id' );
                                pl_field_value = jQuery( this ).prev().val();
                                jQuery('#ajax_spinner_layer').fadeIn();
                                data = {
                                    action: 'player_edit_field',
                                    pl_id: pl_id,
                                    pl_field_name: pl_field_name,
                                    pl_field_value: pl_field_value
                                };
                                jQuery.ajax({
                                    type: "POST",
                                    data : data,
                                    async: true,
                                    cache: false,
                                    url: ajaxurl,
                                    success: function(data) {
                                        console.log('Field: ' + pl_field_name );
                                        if( pl_field_name == 'sex' ){
                                            if( pl_field_value == 1 ){
                                                pl_field_value = bvg_tournament_constants.badTournamentMale;
                                            }else{
                                                pl_field_value = bvg_tournament_constants.badTournamentFemale;
                                            }

                                        }
                                        pl_field.parent().find( 'span.player_current_value').html( pl_field_value );
                                        //console.log( pl_field.parent() );
                                        //console.log( pl_field.parent().find( 'span.player_current_value') );
                                        if( pl_field_name == 'player_level' ){
                                            pl_field.parent().closest( 'li').find( '.pl_level_init' ).html('(' + pl_field_value + ')');
                                        }
                                        if( jQuery( '#bvg_admin_msg' ).length > 0 ){
                                            jQuery( '#bvg_admin_msg').append( data );
                                        }else{
                                            jQuery( '#bad_tournament_maintitle' ).before( '<div id="bvg_admin_msg"><span id="bvg_admin_msg_close"></span>' + data + '</div>' );
                                            jQuery('#bvg_admin_msg_close').on( 'click', function(){
                                                console.log( 'Close admin msg...' );
                                                jQuery( '#bvg_admin_msg').animate({ height: 0, opacity: 0 }, 'slow');
                                            });
                                        }
                                        console.log(data);
                                        jQuery('#ajax_spinner_layer').fadeOut( 'slow' );
                                        pl_field.fadeOut(function(){
                                            pl_field.remove();
                                        });
                                    }
                                });
                            }

                        })

                    }
                    var key = e.which;
                    if( key == 13 ){
                        jQuery('#edit_field_valid').click();
                        return false;
                    }
                });
            }
        });
    }

} );

/* Remove player from tournament */
jQuery('.pl_remove').on( 'click', function(){
    jQuery('#ajax_spinner_layer').fadeIn();

    console.log('Remove player');

    row_parent = jQuery( this).closest( 'li.table_row' );

    pl_id = jQuery( this ).attr('data-pl_id');

    var data = {
        action: 'player_remove',
        pl_id: pl_id
    };

    jQuery.ajax({
        type: "POST",
        data : data,
        async: true,
        cache: false,
        url: ajaxurl,
        success: function(data) {
            row_parent.fadeOut();
            if( jQuery( '#bvg_admin_msg' ).length > 0 ){
                jQuery( '#bvg_admin_msg').append( data );
            }else{
                jQuery( '#bad_tournament_maintitle' ).before( '<div id="bvg_admin_msg"><span id="bvg_admin_msg_close"></span>' + data + '</div>' );
                jQuery('#bvg_admin_msg_close').on( 'click', function(){
                    console.log( 'Close admin msg...' );
                    jQuery( '#bvg_admin_msg').animate({ height: 0, opacity: 0 }, 'slow');
                });
            }
            console.log(data);
            jQuery('#ajax_spinner_layer').fadeOut( 'slow' );
        }
    });
} );

/* add datepicker to forms */
jQuery('.datepicker').datepicker( {dateFormat: "dd/mm/yy"} );

/* Set club as default */
jQuery( '#club_player, .clubs_name' ).on('change keypress click', function(e){
    if( jQuery( this ).val() > 0 ){
        if( jQuery( '#edit_field_valid' ).length > 0 ){
            jQuery( '#edit_field_valid' ).remove();
        }

        jQuery( this ).after( '<img src="' + bvg_tournament_constants.badTournamentURI + 'icons/bad-tournament-ok-icon.png" id="edit_field_valid" class="edit_field_valid" />' );

        var club_id = jQuery( this ).val();
        jQuery( '#edit_field_valid' ).on( 'click', function(){

                jQuery('#ajax_spinner_layer').fadeIn();
                data = {
                    action: 'set_club_default',
                    club_id: club_id
                };
                jQuery.ajax({
                    type: "POST",
                    data : data,
                    async: true,
                    cache: false,
                    url: ajaxurl,
                    success: function(data) {
                        console.log('Club ID: ' + club_id );

                        if( jQuery( '#bvg_admin_msg' ).length > 0 ){
                            jQuery( '#bvg_admin_msg').append( data );
                        }else{
                            jQuery( '#bad_tournament_maintitle' ).before( '<div id="bvg_admin_msg"><span id="bvg_admin_msg_close"></span>' + data + '</div>' );
                            jQuery('#bvg_admin_msg_close').on( 'click', function(){
                                console.log( 'Close admin msg...' );
                                jQuery( '#bvg_admin_msg').animate({ height: 0, opacity: 0 }, 'slow');
                            });
                        }
                        console.log(data);
                        jQuery('#ajax_spinner_layer').fadeOut( 'slow' );
                    }
                });


        })

    }else if( jQuery( this ).val() == 0 ){
        jQuery( '#edit_field_valid' ).remove();
    }
    var key = e.which;
    if( key == 13 ){
        jQuery('#edit_field_valid').click();
        return false;
    }
});