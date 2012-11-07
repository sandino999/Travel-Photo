
var error=0

// name validation

	$("#name").change( function() {
		var value = $('#name').val();
	
		if(jQuery.trim(value) == '')
		{
			error =1;
			error_message = 'This Field is required';
			$('#return_name').html(error_message);
		}
		else if(value.length < 2)
		{
			error =1;
			error_message = 'Please enter atleast 2 characters';
			$('#return_name').html(error_message);
		}
		else
		{
			error =0;
			error_message = '';
			$('#return_name').html(error_message);
		}
	});
	
//username validation
  
	$("#username").change( function() {
		var value = $('#username').val();
	
		if(jQuery.trim(value) == '')
		{
			error =1;
			error_message = 'This Field is required';
			$('#return_username').html(error_message);
		}
		else if(value.length < 2)
		{
			error =1;
			error_message = 'Please enter atleast 2 characters';
			$('#return_username').html(error_message);
		}
		else
		{
			error =0;
			error_message = '';
			$('#return_username').html(error_message);
		}
	});

//password validation  
  
	$("#password").change( function() {
		var value = $('#password').val();
		
		if(jQuery.trim(value) == '')
		{
			error =1;
			error_message = 'This Field is required';
			$('#return_password').html(error_message);
		}
		else if(value.length < 8)
		{
			error =1;
			error_message = 'Password must be 8 characters long';
			$('#return_password').html(error_message);
		}
		else if($('#retype').val() == '')
		{
			error =1;
			error_message = 'Enter retype password';
			$('#return_password').html(error_message);
		}	
		else if(value != $('#retype').val())
		{
			error =1;
			error_message = 'Password does not match';
			$('#return_password').html(error_message);
		}
		else
		{
			error =0;
			error_message = '';
			error_message2 = ''
			$('#return_password').html(error_message);
			$('#return_retype').html(error_message2);
		}
	});
	
// retype password validation

	$("#retype").change( function() {
		var value = $('#retype').val();
		
		if($('#retype').val().length < 8)	// added code: whole if statement from 148 to 153  10/15/12
		{
			error =1;
			error_message = 'retype password must be 8 characters long';
			$('#return_retype').html(error_message);
		}			
		else if(value != $('#password').val())
		{
			error =1;
			error_message = 'Password does not match';
			$('#return_password').html(error_message);
		}
		else
		{
			error =0;
			error_message = '';					
			error_message2 = ''								// added code 10/15/12
			$('#return_password').html(error_message);
			$('#return_retype').html(error_message2);		// added code 10/15/12
		}
	});	
	
	
//validate email address
	
	$("#email").change( function() {
		
		var value = $('#email').val();
		var email_check = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i;
		
		if(jQuery.trim(value) == '')
		{
			error =1;
			error_message = 'This Field is required';
			$('#return_email').html(error_message);
		}	
		else if(!email_check.test(value))
		{	
			error =1;
			error_message = 'Not a valid email';
			$('#return_email').html(error_message);
		}
		else
		{
			error =0;
			error_message = '';
			$('#return_email').html(error_message);
		}
	});	
	
// validate submit

	$('#register').submit(function() {
		
		if(error!=0)
		{
			error_message = 'There were problems in creating your accounts, check all the details in the input field';
				$('#return_error').html(error_message);
			return false;
		}
		else if(jQuery.trim($('#username').val()) == '' || jQuery.trim($('#password').val()) == '' || jQuery.trim($('#retype').val()) == ''
				 || jQuery.trim($('#email').val()) == '' || jQuery.trim($('#name').val()) == '')
		{
			if(jQuery.trim($('#name').val()) == '')
			{
				error_message = 'This field is required';
				$('#return_name').html(error_message);
			}
				
			if(jQuery.trim($('#username').val()) == '')
			{
				error_message = 'This field is required';
				$('#return_username').html(error_message);
			}
			
			if(jQuery.trim($('#password').val()) == '')
			{
				error_message = 'This field is required';
				$('#return_password').html(error_message);
			}
			
			if(jQuery.trim($('#retype').val()) == '')
			{
				error_message = 'This field is required';
				$('#return_retype').html(error_message);
			}
						
			if(jQuery.trim($('#email').val()) == '')
			{
				error_message = 'This field is required';
				$('#return_email').html(error_message);
			}
			
			return false;
		}
		else
		{
			return true;
		}
	});

// validate update profile

$('#update').submit(function() {

		if( jQuery.trim($('#email').val()) == '' || jQuery.trim($('#name').val()) == '')
		{
			if(jQuery.trim($('#name').val()) == '')
			{
				error_message = 'This Field is required';
				$('#return_name').html(error_message);
			}
										
			if(jQuery.trim($('#email').val()) == '')
			{
				error_message = 'This Field is required';
				$('#return_email').html(error_message);
			}
			
			return false;
		}
		else
		{
			return true;
		}

});

