$(document).ready(function () {
	function load_unseen_notification(view = '') {
		$.ajax({
			url : "<?php echo base_url();?>Res/fetch_notif",
			method:"POST",
			data: {view:view},
			dataType:"json",
			success: function (data) {
				/*$('.dropdown-menu').html(data.notification);*/
				if (data.unseen_notification >0)
				{
					$('.badge1').html(data.unseen_notification);
				}
			}
		})
	}
	load_unseen_notification();
	$('#comment_form').on('submit',function (event) {
		event.preventDefault();
		if ($('#subject').val() != '' && $('#comment').val() != '')
		{
			var form_data = $(this).serialize();
			$.ajax({
				url : "<?php echo base_url();?>Notification/insert",
				method:"POST",
				data: form_data,
				success: function (data) {
					$('#comment_form')[0].reset();
					load_unseen_notification();
				}
			})
		}
		else
		{
			alert("both fields are required");
		}
	});
});
