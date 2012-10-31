
<?php $post = Session::get('server').uri::base();
	  $user_id = Session::get('user_id');
		?>

<input type='button' value='Follow' id='btnfollow'>
<input type='hidden' value='dino999' id='follow-username'>
<input type='hidden' value='<?php echo $user_id; ?>' id='userid'>
<input type='hidden' value='<?php echo $post;  ?>' id='post'>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script type='text/javascript'>

	$("#btnfollow").click( function() {
	
	var post = $('#post').val()
		
	if($('#btnfollow').val() == 'Follow')
	{
	
		var follow_username = $('#follow-username').val()
		var follow_user_id = $('#userid').val()
	
		$.post(post + 'accounts/follow_db', {follow_username:follow_username,follow_user_id:follow_user_id});
		
		$('#btnfollow').val('Unfollow')
		
	}
	else if($('#btnfollow').val() == 'Unfollow')
	{
		var unfollow_username = $('#follow-username').val()
		var unfollow_user_id = $('#userid').val()
		
		$.post(post + 'accounts/follow_db', {unfollow_username:unfollow_username,unfollow_user_id:unfollow_user_id});
		$('#btnfollow').val('Follow')	
	}
});
</script>