// toggles menu button
$(document).ready(function(){
	$( '#menu' ).hover(function(){
		$( '.pointerDown' ).addClass( 'pointerUp' ),
		$( '#droppedMenu' ).show();
	}, function() {
		$( '.pointerDown' ).removeClass( 'pointerUp' ),
		$( '#droppedMenu' ).hide();
	});
});

// highlights current page in blue
$(document).ready(function(){
	var pathname = window.location.pathname;

	if (pathname.includes( 'upload' )) {
		$( '#upload' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'resources' )) {
		$( '#resources' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'about' )) {
		$( '#about' ).addClass( 'btn-blue' ); 
	} else if (pathname.includes( 'collections' )) {
		$( '#collections' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'search' )) {
		$( '#search' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'help' )) {
		$( '#help' ).addClass( 'btn-blue' );
	}
});

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
//Validation for register
$(document).ready(function() {

	$("#register").click(function(e) {
		var empty_fields = false;
		var short_password = false;
		var invalid_email = false;
		var taken_username = false;
		$("#registerModal .required > input").each(function() {
			if($(this).val().length === 0) {
				e.preventDefault();
				empty_fields = true;
			} 
			if($(this).hasClass("unfocused")) {
				e.preventDefault();
				empty_fields = true;
			}
			
		});
		if(empty_fields) {
			e.preventDefault();
			//$("#password-error").html("All fields required");
			alert("All fields are required!");
		}
		else if($("#registerModal #UserPasswd").val().length < 6) {
			e.preventDefault();
			short_password = true;
			if(!empty_fields) {
				//$("#password-error").html("Password must be at least 6 characters");
				alert("Password must be at least 6 characters!");
			}
		}
		else if(!IsEmail($("#registerModal #UserEmail").val())) {
			e.preventDefault();
			invalid_email = true;
			//$("#email-error").html("Invalid Email");
			alert("Invalid Email");
		}
		else { //ajax check of available username and email
			var username = $("#UserUsernameReg").val();
			console.log(username);
			data = {'username' : username};
			$.ajax({
				type: 'POST',
				async: 'false',
				url: $("#getUsername").html(),
				data: data,
				success: function(response) {
					if(response == '1') {
						e.preventDefault();
						taken_username = true;
						alert("Username already Exists!");
					}
				},
				error: function(error) {
				
				}
			});
		
			var email = $("#UserEmail").val();
			console.log(email);
			data = {'email' : email};
			$.ajax({
				type: 'POST',
				async: 'false',
				url: $("#getEmail").html(),
				data: data,
				success: function(response) {
					if(response == '1') {
						e.preventDefault();
						alert("Email already Exists!");
					}
				},
				error: function(error) {
				
				}
			});
		}	
	});
	$(".exit").click(function(e) {
		empty_fields = false;
		short_password = false;
		invalid_email = false;
		$("#email-error").html("&nbsp;");
		$("#username-error").html("&nbsp;");
	});
});

// triggers login modal
$(document).ready(function() {
    // Focus the username field on load.
    $('#UserUsername').focus();
    // Make sure a tab within username goes to password.
    // (There's a help tip in between)
    $('#UserUsername').keydown(function(e) {
        if (e.which == 9) {
            $('#UserPassword').focus();
            e.preventDefault();
            return false;
        }                                                                                                           
    });

    // Replace the password field with reset password instructions.
    $('#forgot-password').click(function(e) {
        if ($('#forgot-password').text() == "Forgot your password?") {
            $('#UserPassword, label[for="data[User][password]"]').slideUp(300, function() {  
                $('label[for="data[User][username]"]').html('Email');
                $('input[type=submit]').val('Send reset link');
                $('input[name="data[User][forgot_password]"]').val('true');
                $('#loginHeader').text("Reset Password");
                $('#forgot-password').text("Login");
                $('#loginInfo').text("Enter your email address, and we'll send you a link to reset your password.");
            });
       } else if ($('#forgot-password').text() == "Login") {
            $('#UserPassword, label[for="data[User][password]"]').slideDown(300, function() {
                $('input[type=submit]').val('Login');
                $('input[name="data[User][forgot_password]"]').val('');
                $('#loginHeader').text("Login");
                $('#forgot-password').text("Forgot your password?");
                $('#loginInfo').text("");
            });
       }
    });
});