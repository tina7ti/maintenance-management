    <div class="container" id="demAchat">
        <h2 align="center">Demande d'achat</h2>
        <div id="succes"></div>
        <form method="post" action="" id="formu">
			<div class="form-group">
				<label for="">Famille :</label>
				<select name="idF" id="idF" class="form-control" >
					<?php
					if ($fam->num_rows() > 0)
					{?>
						<option value="">............</option>
						<?php
						foreach ($fam->result() as $v)
						{
							?>
							<option value="<?php echo $v->idF;?>"><?php echo $v->libF;?></option>
					<?php
						}
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="">Sous Famille : </label>
				<select name="idSF" id="idSF" class="form-control" >
					<option value="">Select Famille first</option>
				</select>
			</div>
            <div class="form-group">
                <label for="">Marque : </label>
                <select name="idMarque" id="idMarque" class="form-control" >
                    <option value="">Select all previous informations</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Modèle : </label>
                <select name="idModele[]" id="idModele" class="form-control" multiple>
                    <option value="">Select all previous informations</option>
                </select>
            </div>
			<div class="form-group">
                <div id="error"></div>
				<table class="table table-bordered table-responsive" id="tbpr">
					<tr>
						<th>Marque</th>
						<th>Modele</th>
						<th>Quantité</th>
						<th hidden></th>
					</tr>
                    <?php
                    if (isset($matAacheter))
                    { ?>
                            <?php
                            if ($matAacheter->num_rows() > 0)
                            {
                                foreach ($matAacheter->result() as $v)
                                {
                                    echo "<tr>
						<td><input type='text' name='mar[]' value='$v->libMarque' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='marq[]' value=\"$v->idMarque\"></td>
						<td><input type='text' name='mode[]' value='$v->libModele' disabled class=\"form-control\" style='border: none;'>
						<input type='hidden' name='model[]' value=\"$v->idModele\"></td>
						<td><input type='text' name='qte[]' class=\"form-control\" id='qte'>
						</td>
						<td><a href='#'>Delete</a></td>
						</tr>";
                                }
                            }
                            ?>
                    <?php }
                    ?>

				</table>
			</div>
			<div class="form-group">
				<input type="submit" value="Ajouter" name="ajouter" class="form-control ajouter" id="ajouter">
			</div>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#idF').on('change',function () {
                    var fid = $(this).val();
                    if (fid){
                        $.ajax({
                            type:'POST',
                            url: '<?php echo base_url();?>Da/fetch_sousF',
                            data: 'idF='+fid,
                            success: function (html) {
                                $('#idSF').html(html);
                                $('#idMarque').html('<option value="">Select all previous informations</option>');
                                $('#idModele').html('<option value="">Select all previous informations</option>');
                                $('#succes').html("");
                            }
                        });
                    }else {
                        $('#idSF').html('<option value="">Select Famille first</option>');
                        $('#idMarque').html('<option value="">Select all previous informations</option>');
                        $('#idModele').html('');
                        $('#succes').html("");
                    }
                }

            );

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#idSF').on('change',function () {
                    var idsf = $(this).val();
                    if (idsf){
                        $.ajax({
                            url: '<?php echo base_url();?>Da/fetch_marque',
                            method: "POST",
                            data: {idsf:idsf},
                            success: function (data) {
                                $('#idMarque').html(data);
                                $('#idModele').html('<option value="">Select all previous informations</option>');
                                $('#succes').html("");
                            }
                        });
                    }else {
                        $('#idMarque').html('<option value="">Select all previous informations</option>');
                        $('#idModele').html('<option value="">Select all previous informations</option>');
                        $('#succes').html("");
                    }
                }

            );

        });
    </script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#idMarque').on('change',function () {
				var fid = $(this).val();
				if (fid && fid != ""){
					$.ajax({
						type:'POST',
						url: '<?php echo base_url();?>Da/fetch_modele',
						data: $('#formu').serialize(),
						success: function (html) {
							$('#idModele').html(html);
                            $('#succes').html("");
						}
					});
				}else {
					$('#idModele').html('<option value="">Select all previous informations</option>');
                    $('#succes').html("");
				}
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#idModele').on('change',function (view ='') {
					var id = $('#idModele').val();
					if (id != '')
                    {
                        $.ajax({
                            url : "<?php echo base_url();?>Da/tab2/"+id,
                            method:"POST",
                            data: $('#formu').serialize(),
                            dataType:"json",
                            success: function (data) {
                                if (data.erreur == '')
                                {
                                    document.getElementById('tbpr').innerHTML += data.pr;
                                    $('#error').html("");
                                    $('#succes').html("");
                                }else
                                    $('#error').html("<div class=\"alert alert-danger\" style='font-weight: bold;'>"+data.erreur+"</div>");
                                $('#succes').html("");

                            }
                        });
                    }
                    else
                    {
                        alert("undefined modele");
                    }

				}

			);

		});
	</script>
    <script type="text/javascript">
        $(document).ready(function () {
          $(document).on('submit','#formu',function (event) {
              event.preventDefault();
              $.ajax({
                  url : '<?php echo base_url();?>Da/da_validation',
                  method:"POST",
                  data: $(this).serialize(),
                  dataType:"json",
                  success: function (data) {
                      if(data.er =='OK')
                      {
                          $('#error').html("");
                          $('#succes').html("<div class=\"alert alert-success\" style='font-weight: bold;'>Demande d'achat envoyée</div>");
                          $('#formu')[0].reset();
                          $('#idModele').html('<option value="">Select Marque first</option>');
                          document.getElementById('tbpr').innerHTML ="<tr>" +
                              "<th>Marque</th>" +
                              "<th>Modele</th>" +
                              "<th>Quantité</th>" +
                              "<th hidden></th>" +
                              "</tr>";
                      }else
                      {
                          $('#error').html("<div class=\"alert alert-danger\" style='font-weight: bold;'>"+data.er+"</div>");
                          $('#succes').html("");
                      }

                  }
              });
          });
        });
    </script>
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


