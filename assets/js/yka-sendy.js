(function ($) {

	$.fn.yka_sendy_form = function( options ){

		return this.each(function(){
			
			var $form 	= $( this ),
			$submit	= $form.find('[type=submit]'),
			$status = $form.find('.sendy-status');


			function subscribe() {

				var name = $form.find('input[name="name"]').val(),
				email = $form.find('input[name="email"]').val(),
				state = $form.find('select[name="State"]').children("option:selected").val(),
				lang = $form.find('input[name="Preferredlanguage"]:checked').val(),
				url = $form.data('url'),
				listId = $form.find('input[name="list"]').val();
				

				var data = { 
					name:name, 
					email:email, 
					state:state, 
					lang:lang,
					list:listId
				};


				$.post(
					url, 
					data, 
					function(response) {

				      	if(response) {
				      		var msg = "";
					      	if(response=="Some fields are missing.") {
						      	msg = "Please fill in your name and email.";
					      	}
					      	else if(response=="Invalid email address.") {
						      	msg = "Your email address is invalid.";
					      	}
					      	else if(response=="Invalid list ID.") {
						      	msg = "Your list ID is invalid.";
					      	}
					      	else if(response=="Already subscribed.") {
						      	msg = "You're already subscribed!";
						    }
					      	else {
						      	msg = "You're subscribed!";
					      	}
					      	
					      	$status.html(msg);
					    }
					    else {
					      	$status.html("Sorry, unable to subscribe. Please try again later!");
					    }
				  }
				);
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