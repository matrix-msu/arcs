
var viewportScale = 1 / window.devicePixelRatio;
$("#viewport").attr("content","user-scalable=no, initial-scale="+viewportScale+", minimum-scale=0.2, maximum-scale=2, width=device-width");

function checkMobile(){
    if(window.matchMedia("(max-width: 960px)").matches){
        return true;
    }
    return false;

}
$(document).ready(function(){

	//mobile display drop down
	function toggleMobileToolbar (){

			if($( '.toolbar-btn' ).css('display') === 'none'){

				//switch to blue hamburger
				$('#hamburger').toggleClass('hamburgerActive');
				$('#hamburger').toggleClass('hamburger');
				$( '.toolbar-btn' ).css('display', 'block');
			}
			else{
				//switch to grey hamburger
				$('#hamburger').toggleClass('hamburgerActive');
				$('#hamburger').toggleClass('hamburger');
				$( '.toolbar-btn' ).css('display', 'none');
			}

			$( '#log' ).css('top',$('#belowProjects').height()+"px");
	}

  $( '#hamburger' ).click(toggleMobileToolbar)
  $( '#log #menu[href="#loginModal"]' ).click(toggleMobileToolbar)

  var mouseoverHandler = function(){
		$('#dropArrow').addClass( 'pointerUp' );
		$( '.projects-menu' ).css('display', 'block');

	}
	var mouseoutHandler = function(){
		$('#dropArrow').removeClass( 'pointerUp' );
		$( '.projects-menu' ).css('display', 'none');
	}
	var logMouseover = function(){
		$( '#logDrop' ).addClass( 'pointerUp' ),
		$( '#droppedMenu' ).show();
	}
	var logMouseout = function(){
		$('#logDrop').removeClass( 'pointerUp' ),
		$( '#droppedMenu' ).hide();
	}


	$('#projects').on('click',function(event){
		console.log($('#projectsMenu').css('height'));
		var belowProjectsMove = parseInt($( '#belowProjects' ).css('top')) + parseInt($('#projectsMenu').css('height'));
		// var logMove =  parseInt($( '#log' ).css('top')) + parseInt($('#projectsMenu').css('height'));
		// console.log(logMove);
		if(checkMobile()) {
			console.log($('#belowProjects'));
			if(!$( '#projectsMenu' ).is(":visible")){
				$('#dropArrow').addClass( 'pointerUp' );
				// var logMove =  parseInt($( '#log' ).css('top')) + parseInt($('#projectsMenu').css('height'));
				// console.log(logMove);
				// $( '#log' ).css('top',logMove+'px');
				$( '#belowProjects' ).css('top',belowProjectsMove+'px');
				$( '.projects-menu' ).css('display', 'block');
				$( '#log' ).css('top',$('#belowProjects').height()+$('#projectsMenu').height()+"px");
			}
			else{
				$('#dropArrow').removeClass( 'pointerUp' );
				// var logMove =  parseInt($( '#log' ).css('top')) - parseInt($('#projectsMenu').css('height'));
				// console.log(logMove);
				// $( '#log' ).css('top',logMove+'px');
				// $( '#log' ).css('top','208px');
				$( '#belowProjects' ).css('top','-40px');
				$( '.projects-menu' ).css('display', 'none');
				$( '#log' ).css('top',$('#belowProjects').height()+"px");
			}
		}
	});
	$('#menu').on('click',function(event){
		if(checkMobile()){
			if(($( '#droppedMenu' ).css('display') === 'none')){
				$( '#logDrop' ).addClass( 'pointerUp' ),
				$( '#droppedMenu' ).show();
			}
			else{
				$( '#logDrop' ).removeClass( 'pointerUp' ),
				$( '#droppedMenu' ).hide();
			}
		}
	});
	$('#projectsHeader').on('click',function(event){
		var helpSearchMove = parseInt($( '#helpSearch' ).css('top')) + parseInt($('#projectsMenu').css('height'));
		if(checkMobile()){
      $('#searchHeader').toggle();
      $('#log').css({
        top: $('#searchHeader').css('display') === 'none' ? '244px' : '208px'
      })
			if(($('#helpSearch').css('top') == '22px')){
				$('#dropArrow').addClass( 'pointerUp' );
				$( '#helpSearch' ).css('top', helpSearchMove+'px');
				$( '.projects-menu' ).css('display', 'block');
			}
			else{
				$('#dropArrow').removeClass( 'pointerUp' );
				$( '#helpSearch' ).css('top', '22px');
				$( '.projects-menu' ).css('display', 'none');
			}
		}

	});

	$( window ).load(function(){
		if(!checkMobile()){
			// $( '.toolbar-btn' ).css('display', 'block');
			$( '.projects-menu' ).css('display', 'none');
			$('#projects').bind('mouseover', mouseoverHandler);
			$('#projects').bind('mouseout', mouseoutHandler);
			$('#projectsHeader').bind('mouseover', mouseoverHandler);
			$('#projectsHeader').bind('mouseout', mouseoutHandler);
			$('#menu').bind('mouseover', logMouseover);
			$('#menu').bind('mouseout', logMouseout);

		}
		else{
			// $( '.toolbar-btn' ).css('display', 'none');
			$( '.projects-menu' ).css('display', 'none');
			// $( '#log' ).css('top','208px');
			$( '#belowProjects' ).css('top','-40px');
			$( '#helpSearch').css('top','22px');
			$('#projects').unbind('mouseout mouseover');
			$('#projectsHeader').unbind('mouseout mouseover');
			$('#menu').unbind('mouseover', logMouseover);
			$('#menu').unbind('mouseout', logMouseout);
			$('#dropArrow').removeClass( 'whiteArrow' );
		    $('#dropArrow').removeClass( 'whiteArrow' );
			$('#logDrop').removeClass( 'whiteArrow' );
		    $('#logDrop').removeClass( 'whiteArrow' );
			$( '#menu' ).css('background', '')
			$( '#menu' ).css('color', '')
		}

	});



	$( window ).resize(function(){
		if(!checkMobile()){
			$( '.toolbar-btn' ).css('display', 'block');
			$( '.projects-menu' ).css('display', 'none');
			$('#projects').bind('mouseover', mouseoverHandler);
			$('#projects').bind('mouseout', mouseoutHandler);
			$('#projectsHeader').bind('mouseover', mouseoverHandler);
			$('#projectsHeader').bind('mouseout', mouseoutHandler);
			$('#menu').bind('mouseover', logMouseover);
			$('#menu').bind('mouseout', logMouseout);
			$('#dropArrow').removeClass( 'pointerUp' );
			if(window.location.pathname.includes( 'arcs/projects/single_project' )){
				$('#dropArrow').addClass( 'whiteArrow' );
				$('#dropArrow').addClass( 'whiteArrow' );
			}
			if(window.location.pathname.includes( 'user' || 'admin' )){
				$('#logDrop').addClass( 'whiteArrow' );
				$('#logDrop').addClass( 'whiteArrow' );
				$( '#menu' ).css('background', '#0093be')
				$( '#menu' ).css('color', 'white')
			}
			$( '#logDrop' ).removeClass( 'pointerUp' ),
			$( '#droppedMenu' ).hide();
		}
		else{
			if($( '.toolbar-btn' ).css('display') === 'block'){
				$('#hamburger').removeClass('hamburgerActive');
				$('#hamburger').addClass('hamburger');
			}
			$( '.toolbar-btn' ).css('display', 'none');
			$( '.projects-menu' ).css('display', 'none');
			// $( '#log' ).css('top','208px');
			$( '#belowProjects' ).css('top','-40px');
			$( '#helpSearch').css('top','22px');
			$('#projects').unbind('mouseout mouseover');
			$('#projectsHeader').unbind('mouseout mouseover');
			$('#menu').unbind('mouseover', logMouseover);
			$('#menu').unbind('mouseout', logMouseout);
			$('#dropArrow').removeClass( 'whiteArrow' );
		    $('#dropArrow').removeClass( 'whiteArrow' );
			$('#logDrop').removeClass( 'whiteArrow' );
		    $('#logDrop').removeClass( 'whiteArrow' );
			$( '#menu' ).css('background', '')
			$( '#menu' ).css('color', '')
			$('#dropArrow').removeClass( 'pointerUp' );
			$( '#logDrop' ).removeClass( 'pointerUp' ),
			$( '#droppedMenu' ).hide();
		}
	});

	var pathname = window.location.pathname;
	if (pathname.includes( 'arcs/upload' )) {
		$( '#upload' ).addClass( 'btn-blue' );
	} else if (pathname.includes( '/resource' )) {
		$( '#resources' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'arcs/about' )) {
		$( '#about' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'arcs/collections' )) {
		$( '#collections' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'arcs/search' )) {
		$( '#search' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'arcs/help/' )) {
		$( '#help' ).addClass( 'btn-blue' );
	} else if (pathname.includes( 'user' ) || pathname.includes( 'admin' )) {
		console.log("admin/user");
		$( '#menu' ).addClass( 'btn-blue' );
		$( '#menu' ).css('background', '#0093be')
		$( '#menu' ).css('color', 'white')
		$('#logDrop').addClass( 'whiteArrow' );
		$('#logDrop').addClass( 'whiteArrow' );
	} else if (pathname.includes( 'arcs/projects/single_project' )){
		$( '#projects' ).addClass( 'btn-blue' );
		$('#dropArrow').addClass( 'whiteArrow' );
		$('#dropArrow').addClass( 'whiteArrow' );
	}


	//$("#register").click(function(e) {
	$("#UserRegisterForm").on('submit', function(e) {
		var form = this;
		var empty_fields = false;
		var short_password = false;
		var invalid_email = false;
		var taken_username = false;
		var noSubmit = false;
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
			e.preventDefault();
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
						taken_username = true;
						alert("Username already Exists!");
						noSubmit = true;
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
					if(response == '1' && !taken_username) {
						alert("Email already Exists!");
						noSubmit = true;
					}
					else if(!noSubmit && !taken_username) {
						form.submit();
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
    // Note: make sure to change the text in the opposite if/else statement and $('#forgot-password').text("..");
    $('#forgot-password').click(function(e) {
        if ($('#forgot-password').text() == "Forgot your password?") {
            $('#UserPassword, label[for="data[User][password]"]').slideUp(300, function() {
                $('#UserUsername').attr('placeholder', 'Email').val("").focus().blur();
                $('input[type=submit]').val('Send reset link');
                $('input[name="data[User][forgot_password]"]').val('true');
                $('#loginHeader').text("Reset Password");
                $('#forgot-password').text("Go back!");
                $('#loginInfo').text("Enter your email address, and we'll send you a link to reset your password.");
            });
       } else if ($('#forgot-password').text() == "Go back!") {
            $('#UserPassword, label[for="data[User][password]"]').slideDown(300, function() {
				$('#UserUsername').attr('placeholder', 'Username').val("").focus().blur();
                $('input[type=submit]').val('Login');
                $('input[name="data[User][forgot_password]"]').val('');
                $('#loginHeader').text("Login");
                $('#forgot-password').text("Forgot your password?");
                $('#loginInfo').text("");
            });
       }
    });

});


function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
//Validation for register


// triggers login modal
