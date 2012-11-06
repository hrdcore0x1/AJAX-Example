
// File : loginModal.js
//
// This file adds content to the divs on the menu page, and when the
// login button is clicked it displays a modal dialog that requests the
// user to either login or register.
//
// Form validation is performed, and missing or incorrect data fields are
// flagged as errors and must be corrected before the form submission takes
// place.
//
// Once the form is submitted, the loginBackEnd.php file provides logic for
// database access, and new register insertion.


// var loggedIn is set on index.php
jQuery(function() {
    jQuery().ajaxError(function(a, b, e) {
        throw e;
    });

        // Add Error Div Content To Page
        addDivContent("client-script-return-msg", getErrorDivContent());

        // Add Form Content To Login Form
        addDivContent("my-modal-form", getLoginDivContent());

        // Add Form Content To Registration Form
        addDivContent("my-modal-registration-form", getRegistrationDivContent());

        // Populate State Selection List
        populateStateSelectionList();


	// Login form submit and valiation
	var aform = $("#modal-form-test").validate({

		//  make sure we show/hide both blocks
		errorContainer: "#errorblock-div1, #errorblock-div2",

		//  put all error messages in a UL
		errorLabelContainer: "#errorblock-div2 ul",

		//  wrap all error messages in an LI tag
		wrapper: "li",

		//  rules/messages are for the validation
		rules: {
	        firstname: "required",
	        lastname: "required",
	        email: {
	            required: true,
	            email: true
	                },
	        password: "required"
	    },
	    messages: {
	        firstname: "Please enter your FIRST NAME.",
	        lastname: "Please enter your LAST NAME.",
	        email: {
	            required: "Please enter your EMAIL address.",
	            email: "Please enter a valid EMAIL address."
	                },
	        password: "Please enter your PASSWORD"
	    },

		//  our form submit
	    submitHandler: function(form) {
	        jQuery(form).ajaxSubmit({
				//  the return target block
	            target: '#client-script-return-data',

				//  what to do on form submit success
	            success: function() { $('#my-modal-form').dialog('close'); successEvents('#client-script-return-msg'); 
				if (document.getElementById('client-script-return-msg-rtn').innerHTML.indexOf('NOT') == -1){
					document.getElementById('login').innerHTML='Logout'; loggedIn = true;
				}
			}
	         });
	     }
	});

	//  our modal dialog setup
	var amodal = $("#my-modal-form").dialog({
	   bgiframe: true,
	   autoOpen: false,
	   height: 350,
	   width: 300,
	   modal: true,
	   buttons: {
	      'Login': function()
		  {
		  	//  submit the form
		  	$("#modal-form-test").submit();
		  },
	      Cancel: function()
		  {
		  	//  close the dialog, reset the form
		    $(this).dialog('close'); aform.resetForm();
		  },
		  'New Users Must Register' : function()
		  {
		    // register button
		    $('#my-modal-registration-form').dialog('open');

		  	//  close the dialog, reset the form
		    $(this).dialog('close'); aform.resetForm();

		  }
	   }
	});


        // Add the phone validation method.
        jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
             phone_number = phone_number.replace(/\s+/g, ""); 
	     return this.optional(element) || phone_number.length > 9 &&
	 	    phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
        }, "Please specify a valid phone number");


	// Registration form submit and valiation
        // rules and error message setup.

	var regform = $("#modal-registration-form-test").validate({

		//  make sure we show/hide both blocks
		errorContainer: "#errorblock-div12, #errorblock-div22",

		//  put all error messages in a UL
		errorLabelContainer: "#errorblock-div22 ul",

		//  wrap all error messages in an LI tag
		wrapper: "li",

		//  rules/messages are for the validation
		rules: {
	        firstname: "required",
	        lastname: "required",
	        email: {
	            required: true,
	            email: true
	                },
	        password:  "required",
	        street:    "required",
	        city:      "required",
	        state:     "required",
	        zipcode:   {
                     required: true,
                     digits: true,
                     maxlength: 5,
                     number: true
                           },
	        phonenumber: {
                     required: true,
                     phoneUS: true
                           }
	    },
	    messages: {
	        firstname: "Please enter your FIRST NAME.",
	        lastname: "Please enter your LAST NAME.",
	        email: {
	            required: "Please enter your EMAIL address.",
	            email: "Please enter a valid EMAIL address."
	                },
	        password: "Please enter your PASSWORD.",
	        street: "Please enter your STREET.",
	        city: "Please enter your CITY.",
	        state: "Please enter your STATE.",
	        zipcode: {
                     required: "Please enter your ZIP CODE.",
                     digits:   "Zip code must be digits only.",
                     maxlength: "Zip code max length is 5.",
                     number:    "Zip code must contain numbers only."
                         },
                phonenumber: {
                     required: "Please enter your Phone Number.",
                     phoneUS:  "Please enter a VALID Phone Number."
                         }
	    },

	// Registration form submit
	submitHandler: function(form) {
	    jQuery(form).ajaxSubmit({
                //  the return target block
	        target: '#client-script-return-data',

		//  what to do on form submit success
	            success: function() { $('#my-modal-registration-form').dialog('close'); successEvents('#client-script-return-msg'); }
	         });
	    }
	});



	// Registration modal dialog setup.
	var regmodal = $("#my-modal-registration-form").dialog({
	   bgiframe: true,
	   autoOpen: false,
	   height: 650,
	   width: 300,
	   modal: true,
	   buttons: {
	      'Register': function()
		  {
		  	//  submit the form
		  	$("#modal-registration-form-test").submit();
		  },
	      Cancel: function()
		  {
		  	//  close the dialog, reset the form
		    $(this).dialog('close'); aform.resetForm();
		  }
	   }
	});


	//  onclick action for our login button

	var abutton = $('#login').click(function() {
            
	   if (loggedIn == false) $('#my-modal-form').dialog('open');
	   else{
	 	//call logout
		$.ajax({url: 'logout.php'});
		loggedIn = false;
		document.getElementById('login').innerHTML='Login';
		document.getElementById('client-script-return-msg-rtn').innerHTML = '<p>User logged out.</p>';
		successEvents('#client-script-return-msg');
	  }
	
	});

	//  this sets up a hover effect for all buttons
        var abuttonglow = $(".ui-button:not(.ui-state-disabled)")
	.hover(
		function() {
		    $(this).addClass("ui-state-hover");
		},
		function() {
		    $(this).removeClass("ui-state-hover");
		}
	).mousedown(function() {
	    $(this).addClass("ui-state-active");
	})
	.mouseup(function() {
	    $(this).removeClass("ui-state-active");
	});

        
}); //  end main jQuery function start


// Sets characteristics of the returned message with fadeout.
function successEvents(msg) {

    //  milliseconds to show return message block
    var defaultmessagedisplay = 5000;

    //  fade in our return message block
    $(msg).fadeIn('slow');

    //  remove return message block
    setTimeout(function() { $(msg).fadeOut('slow'); }, defaultmessagedisplay);
};

// This populates the state selection list on the registration
// form.  The abbreviation is stored in the database.
function populateStateSelectionList() {
    var newOptions = {
	    'NO  ' : '     ',
	    'AL' : 'Alabama',
	    'AK' : 'Alaska',
	    'AZ' : 'Arizona',
	    'AR' : 'Arkansas',
	    'CA' : 'California',
	    'CO' : 'Colorado',
	    'CT' : 'Connecticut',
	    'DE' : 'Delaware',
	    'FL' : 'Florida',
	    'GA' : 'Georgia',
	    'HI' : 'Hawaii',
	    'ID' : 'Idaho',
	    'IL' : 'Illinois',
	    'IN' : 'Indiana',
	    'IA' : 'Iowa',
	    'KS' :  'Kansas',
	    'KY' :  'Kentucky',
	    'LA' :  'Louisiana',
	    'ME' :  'Maine',
	    'MD' :  'Maryland',
	    'MA' :  'Massachusetts',
	    'MI' :  'Michigan',
	    'MN' :  'Minnesota',
	    'MS' :  'Mississippi',
	    'MO' :  'Missouri',
	    'MT' :  'Montana',
	    'NE' :  'Nebraska',
	    'NV' :  'Nevada',
	    'NH' :  'New Hampshire',
	    'NJ' :  'New Jersey',
	    'NM' :  'New Mexico',
	    'NY' :  'New York',
	    'NC' :  'North Carolina',
	    'ND' :  'North Dakota',
	    'OH' :  'Ohio',
	    'OK' :  'Oklahoma',
	    'OR' :  'Oregon',
	    'PA' :  'Pennsylvania',
	    'RI' :  'Rhode Island',
	    'SC' :  'South Carolina',
	    'SD' :  'South Dakota',
	    'TN' :  'Tennessee',
	    'TX' :  'Texas',
	    'UT' :  'Utah',
	    'VT' :  'Vermont',
	    'VA' :  'Virginia',
	    'WA' :  'Washington',
	    'WV' :  'West Virginia',
	    'WI' :  'Wisconsin',
	    'WY' :  'Wyoming'
	};
	var selectedOption = 'green';

        // Check browser support for .prop
	var select = $('#state');
	if(select.prop) {
	  var options = select.prop('options');
	}
	else {
	  var options = select.attr('options');
	}
        
        // Remove all items from the current selection
        // list if any are present.
	$('option', select).remove();

        // Cycle thru the array and add the new option to the list.
	$.each(newOptions, function(val, text) {
	    options[options.length] = new Option(text, val);
	});

        // Set the selected option.
	select.val(selectedOption);
}


// This is a wrapper function to add content to a named DIV.
// Sets div's innerHTML to the caller supplied STRING.

function addDivContent(divName, content) {
     document.getElementById(divName).innerHTML = content;
}


// This function sets the Login Div's content.

function getLoginDivContent() {
    var loginContentToAdd = 
	'<!--  our modal window -->' +
	'<div id="my-modal-form" title="Login / Registration">' +
	
	'<!--  form validation error container -->' +
        '<div class="ui-widget ui-helper-hidden" id="errorblock-div1">' +
		'<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;" id="errorblock-div2" style="display:none;">' +
		   '<p>'+
		   '<!--  fancy icon -->' +
		   '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span>' +
	                '<strong>Alert:</strong> Errors detected!' +
		        '</p>' +
			'<!--  validation plugin will target this UL for error messages -->' +
			'<ul></ul>' +
			'</div>' +
		'</div>' +
		'<!--  our form, no buttons (buttons generated by jQuery UI dialog() function) -->' +
	    '<form action="loginBackEnd.php" name="modal-form-test" id="modal-form-test" method="POST">' +
	    '<fieldset>' +
		    '<label for="email">Email</label>' +
		    '<input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all" />' +
		    '<label for="password">Password</label>' +
		    '<input type="password" name="password" id="password" class="text ui-widget-content ui-corner-all" />' +
	    '</fieldset>' +
	    '</form>' +
	'</div>'
	return(loginContentToAdd);
}


// Function to set the Registration Div's content.

function getRegistrationDivContent() {
    var registrationContentToAdd = 
		'<!--  form validation error container -->' +
        '<div class="ui-widget ui-helper-hidden" id="errorblock-div12">' +
	    '<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;" id="errorblock-div22" style="display:none;">' +
		'<p>' +
		'<!--  fancy icon -->' +
		'<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span>' +
	               '<strong>Alert:</strong> Errors detected!' +
			'</p>' +
			'<!--  validation plugin will target this UL for error messages -->' +
			'<ul></ul>' +
	    '</div>' +
	'</div>' +

	'<!--  our form, no buttons (buttons generated by jQuery UI dialog() function) -->' +
	    '<form action="loginBackEnd.php" name="modal-registration-form-test" id="modal-registration-form-test" method="POST">' +
	    '<fieldset>' +
		    '<label for="email">Email</label>' +
		    '<input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all" />' +

		    '<label for="password">Password</label>' +
		    '<input type="password" name="password" id="password" class="text ui-widget-content ui-corner-all" />' +

		    '<label for="firstname"> First Name</label>' +
		    '<input type="text" name="firstname" id="firstname" class="text ui-widget-content ui-corner-all" />' +

		    '<label for="lastname">Last Name</label>' +
		    '<input type="text" name="lastname" id="lastname" class="text ui-widget-content ui-corner-all" />' +

		    '<label for="street">Street</label>' +
		    '<input type="text" name="street" id="street" class="text ui-widget-content ui-corner-all" />' +

		    '<label for="city">City</label>' +
		    '<input type="text" name="city" id="city" class="text ui-widget-content ui-corner-all" />' +

		    '<label for="state">State  </label>' +
		    '<select name="state" id="state">' +
            '</select>' +

		    '<label for="zipcode">Zip Code</label>' +
		    '<input type="number" name="zipcode" id="zipcode" class="text ui-widget-content ui-corner-all" maxlength="5" size="5"/>' +

		    '<label for="phonenumber">Phone Number</label>' +
		    '<input type="tel" name="phonenumber" id="phonenumber" class="text ui-widget-content ui-corner-all" />' +
	    '</fieldset>' +
	    '</form>'

	return(registrationContentToAdd);
}


// Function defines initial Error div content.

function getErrorDivContent() {

    var errorDivContentToAdd = 
        '<div class="ui-state-highlight ui-corner-all" style="padding: 0pt 0.7em; margin-top: 20px;">' +
            '<p><span class="ui-icon ui-icon-circle-check" style="float: left; margin-right: 0.3em;"></span>' +
             '<!--  our return message will go in the following span -->' +
             '<span id="client-script-return-msg-rtn"></span></p>' +
        '</div>'

    return errorDivContentToAdd;
}

