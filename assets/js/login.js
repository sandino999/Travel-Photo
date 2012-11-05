
// validates submit button in login

$(document).ready(function(){
	
	$('#Login').click(function(){
    
	var username = $('#username').val()
	var password = $('#password').val()

	$.post('accounts/login', {username:username,password:password}, function(data){
		$('#error_message').html(data);
	});	
	
	return false;
	});

	//refresh all fields	
		
	$('#login').click(function(){
				
		$('#error_message').html('')
		$('#username').val('') 
		$('#password').val('') 
	});

});