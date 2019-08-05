(function ($) {

	$.fn.yka_sendy_form = function( options ){

		return this.each(function(){
			
			var $form 	= $( this ),
			$submit	= $form.find('[type=submit]'),
			$status = $form.find('.sendy-status');
			$loader = $form.find('.sendy-sub-btn .fa');


			//disable first option from getting select
			var selectItem = $form.find('select option:first');

			if( selectItem.length ) {
				selectItem.attr("disabled", "disabled");
			}
			

			function subscribe() {

				var fields = $form.find('input[name="fields"]').val();

				var name = $form.find('input[name="name"]').val(),
				email = $form.find('input[name="email"]').val(),
				url = $form.data('url'),
				token = $form.data('token'),
				listId = $form.find('input[name="list"]').val();

				
				var data = { 
					name:name, 
					email:email, 
					list:listId,
					fields: fields,
					token: token
				};


				var cf = fields.split(',');

				
				if ( $.inArray('state', cf) != -1)  {

					var state = $form.find('select[name="state"]').children("option:selected").val();
					
					data.state = state;
				}

				if ($.inArray('language', cf) != -1) {
					//get prefered language as comma seperated values
					var lang = $form.find('input[name="language[]"]:checked').map(function (i, el){
									return $(el).val();
								}).get().join(', ');	
				
					data.lang = lang
				}


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

	$.fn.yka_sendy_city = function( options ){

		return this.each(function(){
			var $state = $('form[data-behaviour~=yka-sendy-form] select[name="state"]');
			var $city = $('form[data-behaviour~=yka-sendy-form] select[name="city"]');

			$state.on('change', function() {
			    var selectedState = $(this).find(":selected").val();

			    var url = $state.data('location') + "&place=" + selectedState;

			    $.ajax({
					type:'get',
					url	: url,
				}).done(function(response){
					if( response.length ) {
						var districts =  JSON.parse(response);

						var cities = [];
						$.each(districts, function(index, value) {
							cities.push('<option value="' + value + '">' + value + "</option>");
						} );

						$city.html(cities.join(""));
					}
					

				});

			});

		});
	};	
	

}(jQuery));


jQuery(document).ready(function(){
		
	jQuery( 'form[data-behaviour~=yka-sendy-form]' ).yka_sendy_form();	
	jQuery( '[data-behaviour~=sendy-city]' ).yka_sendy_city();
});

/*$('body').on('sjax:init', function(event, el) { 

} );*/
