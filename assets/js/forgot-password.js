
// validates submit button in login

$(document).ready(function(){
	
	$('#Send').click(function(){
    
	var forgot_username = $('#forgot_username').val()
	var forgot_email = $('#forgot_email').val()

	$.post('accounts/recover', {forgot_username:forgot_username,forgot_email:forgot_email}, function(forgot_message){
		$('#forgot_error_message').html(forgot_message);
	});	
	
	return false;
	});

	//refresh all fields	
		
	$('#login').click(function(){
				
		$('#forgot_error_message').html('')
		$('#forgot_username').val('') 
		$('#forgot_password').val('') 
	});

});