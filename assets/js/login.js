
// validates submit button in login

$(document).ready(function(){
	
	$('#Login').click(function(){
    
	var username = $('#username').val()
	var password = $('#password').val()

	$.post('accounts/login', {username:username,password:password}, function(data){
	
		if(data == '')
		{
			window.location = ''
		}
		else
		{       
                    var err_container = '#error_message';
                        $(err_container).addClass('label label-important');
			$(err_container).html(data);
		}
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