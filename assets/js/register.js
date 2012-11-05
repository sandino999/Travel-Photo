
// validates submit button in register

$(document).ready(function(){
	
	$('#submit').click(function(){
    
	var reg_username = $('#reg_username').val()
	var reg_password = $('#reg_password').val()
	var reg_password2 = $('#password2').val()
	var reg_name = $('#name').val()
	var reg_email = $('#email').val()
		
	$.post('accounts/register_validate',{reg_username:reg_username,reg_password:reg_password,
			reg_password2:reg_password2,reg_name:reg_name,reg_email:reg_email}, function(reg_data){
		$('#reg_error_message').html(reg_data);
	});	
	
	return false;
	});

	//refresh all fields	
		
	$('#sign-up').click(function(){
			
		
		$('#reg_error_message').html('')
		$('#reg_username').val('') 
		$('#reg_password').val('')
		$('#password2').val('') 
		$('#name').val('')
		$('#email').val('') 
	});
	
});