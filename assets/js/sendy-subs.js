(function ($) {

	$.fn.yka_sendy_form = function( options ){

		return this.each(function(){
			var $form 	= $( this ),
				$submit	= $form.find('[type=submit]'),
				$status = $form.find('.sendy-status');


			function subscribe() {
				console.log('form sunmitted!');
			}	


			$form.submit( function( ev ){
				ev.preventDefault();
				
				subscribe();
				
			});


		});

	};
	

}(jQuery));


jQuery(document).ready(function(){
	
	jQuery( 'form[data-behaviour~=yka-sendy-form]' ).yka_sendy_form();	
	
});