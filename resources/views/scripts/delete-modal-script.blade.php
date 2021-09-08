<script type="text/javascript">

	var user_id;

$(document).on('click', '.delete', function(){
 user_id = $(this).attr('data-id');
 $('#confirmModal').modal('show');
});

$('#ok_button').click(function(){
 $.ajax({
  url:"users/destroy/"+user_id,
  beforeSend:function(){
   $('#ok_button').text('Deleting...');
  },
  success:function(data)
  {
   
	$('#confirmModal').modal('hide');
	window.location.reload();  }
 });
});


</script>