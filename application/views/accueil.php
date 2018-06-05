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
<?php
if(isset($style))
{
	echo "<div class=\"container\" id=\"cont\" style=\"$style\">";
}
else echo '<div class="container" id="cont" style="margin-top: 4%;">';
?>

	  <?php
      if ($this->uri->segment(2) == "modifie")
      {
          echo '<div class="alert alert-success"><i class="fas fa-check fa-2x"></i>Matériel modifié</div>';
      }
      else
      {
          if ($this->uri->segment(2) == "supprime")
          {
              echo '<div class="alert alert-success"><i class="fas fa-check fa-2x"></i>Matériel supprimé</div>';
          }
      }
	  if ($this->uri->segment(2) == "famajout")
	  {
		  echo '<div class="alert alert-success"><i class="fas fa-check fa-2x"></i>La famille ajoutée</div>';
	  }
	  if ($this->uri->segment(2) == "DAajoute")
	  {
		  echo '<div class="alert alert-success"><i class="fas fa-check fa-2x"></i>Demande d\'achat ajouté</div>';
	  }

        ?>

	<?php
	if ($this->uri->segment(1) == "Res")
    {
    $count =1; $m=1;
    echo '<div class ="row" >';
    foreach ($fonction as $k => $v)
    {
    if ($count ==4 || $count ==7 ) {
        echo '</div>';
        echo '<div class ="row">';
    }
    ?>
        <div class=" col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a href="<?php echo base_url().$v[1]; ?>" class="mate">
                <div class="mt">
                    <?php echo $v[0].$k;
                    if (isset($v[2])) {
                        ?>
                        <span class="badge badge<?php echo $v[2]; ?>" <?php if ($count == 2 || $count == 3) echo 'style="color: black;width: 10%;	height: 30px;
	border-radius: 50% 50%;margin-left: 65%; margin-top: -50%; padding-top: 3%; bottom: 0;"';?>></span>
                        <!-- <span class="label label-pill label-danger count"></span> -->
                        <?php
                    }
                    ?>
                </div>
            </a>
        </div>
        <?php
        $count++;
        $m++;
    }
        echo '</div>';

    }else
    {
        if ($this->uri->segment(1) == "Ges")
        {
            $count =1; $m=1;
            echo '<div class ="row" >';
            foreach ($fonction as $k => $v)
            {
                if ($count == 4 || $count == 6 || $count == 8) {
                    echo '</div>';
                    echo '<div class ="row">';
                }
                ?>
                <div class=" col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url().$v[1]; ?>" class="mate">
                        <?php
                        if ($count == 4)
                        { ?>
                            <div class="mt">
                                <?php echo "<span style='font-size: 0.91em;'>".$v[0].$k."</span>";
                              ?>
                            </div>
                        <?php   if (isset($v[2])) {
                                    ?>
                                <span class="badge badge<?php echo $v[2]; ?>" style="color: black;width: 10%;	height: 30px;
	border-radius: 50% 50%;margin-left: 85%; margin-top: -75%; padding-top: 3%; bottom: 0;"></span>
                                <?php
                                }
                                }else
                        { ?>
                            <div class="mt">
                                <?php echo $v[0].$k;
                                if (isset($v[2])) {
                                    ?>
                                    <span class="badge badge<?php echo $v[2]; ?>"></span>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php }
                        ?>
                    </a>
                </div>
                <?php

                    $count++;
                $m++;
            }
            echo '</div>';
        }
        else
        {
            $count =1; $m=1;
            echo '<div class ="row" >';
            foreach ($fonction as $k => $v)
            {
                if ($count > 3) {
                    echo '</div>';
                    echo '<div class ="row">';
                }
                ?>
                <div class=" col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url().$v[1]; ?>" class="mate">
                        <div class="mt">
                            <?php echo $v[0].$k;
                            if (isset($v[2])) {
                                ?>
                                <span class="badge badge<?php echo $v[2]; ?>"></span>
                                <!-- <span class="label label-pill label-danger count"></span> -->
                                <?php
                            }
                            ?>
                        </div>
                    </a>
                </div>
                <?php
                if ($count > 3) {
                    $count = 2;
                }
                else
                {
                    $count++;
                }
                $m++;
            }
            echo '</div>';
        }

    }
	?>



</div>


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
	/*	function load_unseen_notification(view = '') {
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
				}
			})
		}
		load_unseen_notification('');*/

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
			});

		} , 1000);
	/*	function load_unseen_notification(view = '') {
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
				}
			});

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

