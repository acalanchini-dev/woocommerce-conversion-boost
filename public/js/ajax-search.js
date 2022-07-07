(function( $ ) {
	'use strict';
})( jQuery );


/* Ajax Serch */
function fetchResults(){
  var keyword = jQuery('#searchInput').val();

  if(keyword == ""){

    jQuery('#datafetch').html("");

  } else {

    jQuery.ajax({

      url: ajax_params.ajax_url,

      type: 'post',

      data: { action: 'data_fetch', keyword: keyword  },

      success: function(data) {

        jQuery('#datafetch').html( data );

      }
      
    });
  }
}