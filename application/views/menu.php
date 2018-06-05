<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $title;?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>fs/css/bootstrap.min.css">
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url();?>fs/css/style.css">

	<script src="<?php echo base_url();?>fs/js/html5shiv.min.js"></script>
	<script src="<?php echo base_url();?>fs/js/fontawesome-all.js"></script>
</head>
<body>

<section class="menu-section">
<div class="menu">

	<ul class="nav nav-pills nav-stacked">
        <?php
        if ($this->uri->segment(1) == "Ges" || $this->uri->segment(1) == "Da")
        { ?>
            <li id="hm">
                <a href="<?php echo base_url();?>Ges/"> <img src="<?php echo base_url();?>/fs/img/home5.png" alt="" class="img-home"></a>
            </li>
        <?php }
        if ($this->uri->segment(1) == "Res")
        { ?>
            <li id="hm">
                <a href="<?php echo base_url();?>Res/"> <img src="<?php echo base_url();?>/fs/img/home5.png" alt="" class="img-home"></a>
            </li>
        <?php }
        if ($this->uri->segment(1) == "Rep")
        { ?>
            <li id="hm">
                <a href="<?php echo base_url();?>Rep"> <img src="<?php echo base_url();?>/fs/img/home5.png" alt="" class="img-home"></a>
            </li>
            <?php
        }
        ?>
		<?php
		foreach ($fonc as $k => $v) {
			if ( ! is_array($v))
			{?>
				<li role="presentation"><a href="<?php echo base_url().$v; ?>"><?php echo $k; ?></a></li>
				<?php
			}else {
				?>
				<li role="presentation"><a href="<?php echo base_url().$v[1]; ?>"><?php echo $k; ?><span class="badge badge<?php echo $v[0]; ?>"></span></a>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
</section>

<script src="<?php echo base_url();?>fs/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url();?>fs/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        setInterval(function (view = '') {
            $.ajax({
                url : "<?php echo base_url();?>Ges/fetch_notif",
                method:"POST",
                data: {view:view},
                dataType:"json",
                success: function (data) {
                    if (data.unseen_notificationges1 >0)
                    {
                        $('.badgeges1').html(data.unseen_notificationges1);
                    }
                    if (data.unseen_notificationges2 >0)
                    {
                        $('.badgeges2').html(data.unseen_notificationges2);
                    }
                }
            })
        }, 1000);
    });
</script>
<script>
	$(document).ready(function () {
		setInterval(function (view = '') {
			$.ajax({
				url : "<?php echo base_url();?>Res/fetch_notif",
				method:"POST",
				data: {view:view},
				dataType:"json",
				success: function (data) {
					if (data.unseen_notification >0)
					{
						$('.badgeres1').html(data.unseen_notification);
					}
					if (data.unseen_notification2 >0)
					{
						$('.badgeres2').html(data.unseen_notification2);
					}
					if (data.unseen_notification3 >0)
					{
						$('.badgeres3').html(data.unseen_notification3);
					}
                    if (data.unseen_notification4 >0)
                    {
                        $('.badgeres4').html(data.unseen_notification4);
                    }
				}
			})
		}, 1000);
		/*function load_unseen_notification(view = '') {
			$.ajax({
				url : "Res/fetch_notif",
				method:"POST",
				data: {view:view},
				dataType:"json",
				success: function (data) {
					if (data.unseen_notification >0)
					{
						$('.badgeres1').html(data.unseen_notification);
					}
					if (data.unseen_notification2 >0)
					{
						$('.badgeres2').html(data.unseen_notification2);
					}
				}
			})
		}
		load_unseen_notification();*/
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
</script>
<script>

	$(document).ready(function () {
		setInterval(function (view = '') {
			$.ajax({
				url : "<?php echo base_url();?>Rep/fetch_notif",
				method:"POST",
				data: {view:view},
				dataType:"json",
				success: function (data) {

					if (data.unseen_notificationrep1 >0)
					{
						$('.badgerep1').html(data.unseen_notificationrep1);
					}
					if (data.unseen_notificationrep2 >0)
					{
						$('.badgerep2').html(data.unseen_notificationrep2);
					}
                    if (data.unseen_notificationrep3 >0)
                    {
                        $('.badgerep3').html(data.unseen_notificationrep3);
                    }
				}
			})
		}, 1000);
		/*function load_unseen_notification(view = '') {
			$.ajax({
				url : "Rep/fetch_notif",
				method:"POST",
				data: {view:view},
				dataType:"json",
				success: function (data) {

					if (data.unseen_notificationrep1 >0)
					{
						$('.badgerep1').html(data.unseen_notificationrep1);
					}
					if (data.unseen_notificationrep2 >0)
					{
						$('.badgerep2').html(data.unseen_notificationrep2);
					}
				}
			})
		}
		load_unseen_notification();*/
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
</script>
</body>
</html>

