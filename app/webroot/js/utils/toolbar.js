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
        $('#UserPassword, label[for="data[User][password]"]').slideUp(300, function() {  
            $('label[for="data[User][username]"]').html('Email');
            $('input[type=submit]').val('Send reset link');
            $('input[name="data[User][forgot_password]"]').val('true');
            $('#forgot-explain').show();
        });
    });
});