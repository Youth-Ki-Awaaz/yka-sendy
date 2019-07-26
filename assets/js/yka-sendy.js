(function ($) {

	$.fn.yka_sendy_form = function( options ){

		return this.each(function(){
			
			var $form 	= $( this ),
			$submit	= $form.find('[type=submit]'),
			$status = $form.find('.sendy-status');
			$loader = $form.find('.sendy-sub-btn .fa');


			//disable first option from getting select
			$form.find('select option:first').attr("disabled", "disabled");


			function subscribe() {

				var name = $form.find('input[name="name"]').val(),
				email = $form.find('input[name="email"]').val(),
				state = $form.find('select[name="state"]').children("option:selected").val(),
				url = $form.data('url'),
				listId = $form.find('input[name="list"]').val();

				
				//get comma seperated language choice
				var lang = $form.find('input[name="language[]"]:checked').map(function (i, el){
					return $(el).val();
				}).get().join(', ');
				

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

						disableLoader();

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
						      	msg = "You're subscribed to our mailing list. Thank You!";
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
				
				enableLoader();

				subscribe();				
			
			});


			function enableLoader() {
				$loader.css('display', 'inline-block');
			}

			function disableLoader() {
				$loader.css('display', 'none');
			}

		}); 

	};
	

}(jQuery));


jQuery(document).ready(function(){
		
	jQuery( 'form[data-behaviour~=yka-sendy-form]' ).yka_sendy_form();	
	
});