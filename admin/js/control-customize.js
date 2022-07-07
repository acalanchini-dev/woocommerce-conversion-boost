( function( $ ) {
// open section customize live search
wp.customize.control( 'active_live_search', function( control ) {
    control.container.find( '#_customize-input-active_live_search' ).on( 'click', function() {
$('#customize-control-wccb_customize_search_bar').toggle();
    } );
} );





} )( jQuery );
