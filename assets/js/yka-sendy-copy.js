(function ($) {
  $.fn.serializeFormJSON = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
      if (o[this.name]) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || "");
      } else {
        o[this.name] = this.value || "";
      }
    });
    return o;
  };

  $.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();

    console.log(a);

    $.each(a, function (i, obj) {
      //console.log( i );

      if (o[obj.name] === undefined) {
        /*
        if (!o[obj.name] || !o[obj.name].push) {
          o[obj.name] = [o[obj.name]];
        }
				*/
        o[obj.name].push(obj.value || "");
      } else {
        //alert(obj.name);
        o[obj.name] = obj.value || "";
      }

      console.log("break");
    });

    /*
    $.each(a, function() {

    });
		*/

    return o;
  };

  $.fn.yka_sendy_form = function (options) {
    return this.each(function () {
      var $form = $(this),
        $submit = $form.find("[type=submit]"),
        $status = $form.find(".sendy-status");
      $loader = $form.find(".sendy-sub-btn .fa");

      //disable first option from getting select
      var selectItem = $form.find("select option:first");

      if (selectItem.length) {
        selectItem.attr("disabled", "disabled");
      }

      function subscribe() {
        /*
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
				if ( $.inArray('city', cf) != -1)  {
					var city = $form.find('select[name="city"]').children("option:selected").val();
					data.city = city;
				}

				if ($.inArray('language', cf) != -1) {
					//get prefered language as comma seperated values
					var lang = $form.find('input[name="language[]"]:checked').map(function (i, el){
									return $(el).val();
								}).get().join(', ');
					data.lang = lang;
				}

				if ($.inArray('beats', cf) != -1) {
					//get beats as comma seperated values
					var beats = $form.find('input[name="beats[]"]:checked').map(function (i, el){
									return $(el).val();
								}).get().join(', ');
					data.beats = beats;
				}

				if($.inArray('editor', cf) != -1) {
					var editor = $form.find('input[name="editor"]').val();
					data.editor = editor;
				}

				if ( $.inArray('gender', cf) != -1)  {
					var gender = $form.find('select[name="gender"]').children("option:selected").val();
					data.gender = gender;
				}
				console.log( data );
				*/

        var formData = $form.serializeFormJSON();

        //console.log( formData );
        //console.log('hello submit');

        $.post($form.data("url"), formData, function (response) {
          disableLoader();

          if (response) {
            var msg = "";
            if (response == "Some fields are missing.") {
              msg = "Please fill in your name and email.";
            } else if (response == "Invalid email address.") {
              msg = "Your email address is invalid.";
            } else if (response == "Invalid list ID.") {
              msg = "Your list ID is invalid.";
            } else if (response == "Already subscribed.") {
              msg = "You're already subscribed!";
            } else {
              msg = "You're subscribed to our mailing list. Thank You!";
            }

            $status.html(msg);
          } else {
            $status.html("Sorry, unable to subscribe. Please try again later!");
          }
        });
      }

      $form.submit(function (ev) {
        ev.preventDefault();
        enableLoader();
        subscribe();
      });

      function enableLoader() {
        $loader.css("display", "inline-block");
      }

      function disableLoader() {
        $loader.css("display", "none");
      }
    });
  };

  $.fn.yka_sendy_city = function (options) {
    return this.each(function () {
      var $state = $(
        'form[data-behaviour~=yka-sendy-form] select[name="state"]'
      );
      var $city = $('form[data-behaviour~=yka-sendy-form] select[name="city"]');

      $state.on("change", function () {
        var selectedState = $(this).find(":selected").val();

        var url = $state.data("location") + "&place=" + selectedState;

        $.ajax({
          type: "get",
          url: url,
        }).done(function (response) {
          if (response.length) {
            var districts = JSON.parse(response);

            var cities = [];
            $.each(districts, function (index, value) {
              cities.push(
                '<option value="' + value + '">' + value + "</option>"
              );
            });

            $city.html(cities.join(""));
          }
        });
      });
    });
  };
})(jQuery);

jQuery(document).ready(function () {
  jQuery("form[data-behaviour~=yka-sendy-form]").yka_sendy_form();
  jQuery("[data-behaviour~=sendy-city]").yka_sendy_city();
});
