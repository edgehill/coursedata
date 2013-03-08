// Set up form validation for the <presentation> admin page


// Documentation at http://bassistance.de/jquery-plugins/jquery-plugin-validation/

// Initialise the validator
jQuery(function(){

	jQuery('#post').validate({
		rules: {
			required: {
				required: true
			},
			post_title: {
				required: true
			}
		}
	});
	
	jQuery.validator.addClassRules({
	  	max_50: {
			 maxlength: 50
		},
		max_100: {
			 maxlength: 100
		},
		max_255: {
			 maxlength: 255
		},
		max_4000: {
			maxlength: 4000
		},
		number: {
			number: true
		}
	
	});
	
	
	
	
	
	
	/*
	jQuery(".max_100").rules("add", {
	 	maxlength: 20
		required: true
		/*
		max: 100,
		 messages: {
		 	max: jQuery.format("Less than {0} characters are necessary")
		}
	*/

	/*
	jQuery(".test").rules("add"), {
		required: true,
		messages: { 
		   required: "Required input",
		}
	}
	*/
	
	/*
	jQuery(".url").rules("add"), {
		url: true
	}
	*/
	
	/*
	jQuery(".myinput").rules("add", {
	 	 url: true
	});
	*/
	
	/*
	jQuery(".myinput").rules("add", {
	 	 required: true,
		 minlength: 2,
		 messages: { 
		   required: "Required input",
		   minlength: jQuery.format("Please, at least {0} characters are necessary")
		 }
	});
	*/
	
	
});