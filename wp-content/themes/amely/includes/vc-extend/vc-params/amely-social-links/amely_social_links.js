if ( _.isUndefined( window.vc ) ) {
	var vc = { atts: {} };
}
(function( $ ) {
	var TMSocialLinks = Backbone.View.extend( {
		events: {},
		initialize: function() {
		},
		render: function() {
			return this;
		},
		save: function() {
			var data = [];
			this.$el.find( '.tm-social-links-table tr' ).each( function() {
				var $tr = $( this );
				var $key = $tr.attr( 'data-social' );
				if ( $key != '' ) {
					var $val = '';
					$tr.find( '.social_links_field' ).each( function() {
						var $field = $( this );
						if ( $field.is( ':text' ) && $field.val() != '' ) {
							$val += $key + '|' + $field.val();
						}
					} );
					data.push( $val );
				}
			} );
			return data;
		}
	} );
	vc.atts.social_links = {
		parse: function( param ) {
			var $field = this.content().find( 'input.wpb_vc_param_value.' + param.param_name + '' ),
				social_links = $field.data( 'tmSocialLinks' ),
				result = social_links.save();
			return result.join( ' ' );
		},
		init: function( param, $field ) {
			$( '[data-social-links="true"]', $field ).each( function() {
				var $this = $( this ),
					$field = $this.find( '.wpb_vc_param_value' );
				$field.data( 'tmSocialLinks', new TMSocialLinks( { el: $this } ).render() );
			} );
		}
	};
})( window.jQuery );
