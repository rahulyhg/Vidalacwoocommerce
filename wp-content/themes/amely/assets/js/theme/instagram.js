// Calculate overlay for instagram image
(function() {

	amely.instagram = function() {

		var overlaySize = function() {
			[].slice.call( document.querySelectorAll( '.tm-instagram-pics' ) ).forEach( function( _instagram ) {

				[].slice.call( _instagram.querySelectorAll( '.item' ) ).forEach( function( _item ) {

					var _overlay = _item.querySelector( '.overlay' ),
						_img     = _item.querySelector( '.item-image' );

					setTimeout( function() {

						_overlay.style.width = _img.getBoundingClientRect().width + 'px';
						_overlay.style.height = _img.getBoundingClientRect().height + 'px';
					}, 500 );
				} );
			} );
		}

		overlaySize();

		window.addEventListener('resize', function() {
			overlaySize();
		});
	};
})( jQuery );
