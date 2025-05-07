( function($) {
	"use strict";

		var scntDiv = $('#yoast_seo_tags');
		//Default set value
		var counter = 1;
		$( "p .seotags" ).each(function(  ) {
			$(this).attr('data-seoid', counter);

			var newClass = 'lblError' + (counter);
	        $(this).parent().parent().find( ".lblError").removeClass('lblError1').addClass(newClass);

			counter++;
		});

		var i = $('#yoast_seo_tags p').size() + 1;
		$(document).on('click','#addScnt', function() {
			$('<p><label for="p_scnts"> <b>Seo Tag Name :</b> <input type="text" size="20" name="yoast[t_name][]" class="seotags" data-seoid="'+i+'" required value="" placeholder="Tag Name" /></label><label for="p_scnts"> <b>Tag Value :</b> <input type="text" size="20" required name="yoast[t_value][]" value="" placeholder="Tag Value" /></label> <button id="remScnt">Remove</button><span class="lblError lblError'+i+'" style="color: red; display:block;"></span></p>').appendTo(scntDiv);
			$('.tag_count').val(i);
			i++;
			return false;
		});

		//Check if String has special Character
		var x = $('#yoast_seo_tags p').size() + 1;
		$(document).on("keypress",'.seotags',function(e){
			var id = $(this).attr("data-seoid");

            var keyCode = e.keyCode || e.which;

            $('.lblError'+id+'').html("");

            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z0-9_]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $('.lblError'+id+'').html("Only Alphabets and Numbers allowed.");
                $("#addScnt").attr('disabled', true);
				$("#save").attr('disabled', true);
            } else {
                $("#addScnt").removeAttr('disabled');
				$("#save").removeAttr('disabled');
            }

            return isValid;
        });

		//remove 
		$(document).on('click', '#remScnt', function() {
			$(this).parents('p').remove();
			i--;
			$('.tag_count').val(i-1);

			$("#addScnt").removeAttr('disabled');
			$("#save").removeAttr('disabled');
			return false;
		});

} )( jQuery )
