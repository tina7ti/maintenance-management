<div class="boutons" style="margin-left: 20%; margin-top: 1.5%;">
	<?php
    if (isset($f) ) {
        for ($i = 0; $i < 3; $i++) {
            ?>
            <button id="bt<?php echo $i; ?>" style="width: 25%; margin-left: 2%; border-radius: 12px 12px;"><?php echo $boutons[$i]; ?></button>
            <?php
        }
    }else{
        for ($i = 0; $i < 3; $i++) {
            ?>
            <button id="bts<?php echo $i; ?>" style="width: 25%; margin-left: 2%; border-radius: 12px 12px;"><?php echo $boutons[$i]; ?></button>
            <?php
        }
    }
	?>
</div>
<div id="ttinf"></div>
<script>
	$(document).ready(function () {
		$("#bt0").click(function() {
			$.ajax({
				url: "<?php echo base_url();?>Res/ajoutFam",
				cache : false,
				success: function (html) {
					afficher(html);
				}
			});
			return false;
		});
	});
	$(document).ready(function () {
		$("#bt1").click(function() {
			$.ajax({
				url: "<?php echo base_url();?>Res/modif_f",
				cache : false,
				success: function (html) {
					afficher(html);
				}
			});
			return false;
		});
	});
	$(document).ready(function () {
		$("#bt2").click(function() {
			$.ajax({
				url: "<?php echo base_url();?>Res/supp_f",
				cache : false,
				success: function (html) {
					afficher(html);
				}
			});
			return false;
		});
	});
    $("#bts0").click(function() {
        $.ajax({
            url: "<?php echo base_url();?>Res/ajoutSF",
            cache : false,
            success: function (html) {
                afficher(html);
            }
        });
        return false;
    });
    $(document).ready(function () {
        $("#bts1").click(function() {
            $.ajax({
                url: "<?php echo base_url();?>Res/modifSF",
                cache : false,
                success: function (html) {
                    afficher(html);
                }
            });
            return false;
        });
    });
    $(document).ready(function () {
        $("#bts2").click(function() {
            $.ajax({
                url: "<?php echo base_url();?>Res/supp_SF",
                cache : false,
                success: function (html) {
                    afficher(html);
                }
            });
            return false;
        });
    });

	function afficher(data) {
		$('#ttinf').slideUp(200,function () {
			$('#ttinf').empty();
			$('#ttinf').append(data);
			$('#ttinf').slideDown(200);
		})
	}
</script>

