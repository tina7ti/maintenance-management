<div class="tb1" style=" margin-left : 0%; width: 100%;margin-top: -41%;">
    <h2 style="margin-left: 20%; box-shadow: 4px 4px 4px gray;">Tableau de bord</h2>
    <div class="container" style=" margin-top: 2%; width: 90%;">

       <div style="background-color: white; padding-right:5%; padding-top: 1%; padding-bottom: 1%; border-radius: 10px/10px;
       box-shadow: 6px 6px 3px gray; margin-left: 25%; width: 70%;">
           <div style="margin-left: 20%;">
               <button name="marque" value="marque" class="btn btn-default" id="marque" onclick="showMarque()">Marque</button>
               <button id="idModele" name="modele" value="modele" class="btn btn-default">Modele</button>
               <button id="idFamille" name="idFamille" value="famille" class="btn btn-default">Famille</button>
               <button id="idSFamille" name="idSFamille" value="Sfamille" class="btn btn-default">Sous Famille</button>
               <input name="idDate" id="idDate" type="date" style="border-radius: 5px/5px;">

               <div style="display:none;" id="idMarque">
                   <select name="idMarq" id="idMarq" class="form-control"></select>
               </div>

               <div style="display:none;" id="idM">
                   <select name="idMod" id="idMod" class="form-control"></select>
               </div>

               <div style="display:none;" id="idF">
                   <select name="id_f" id="id_f" class="form-control"></select>
               </div>

               <div style="display:none;" id="idSF">
                   <select name="id_sf" id="id_sf" class="form-control"></select>
               </div>

           </div>
           <canvas id="myChart"></canvas>
       </div>
    </div>
    <div class="container"  style=" margin-top: 2%;  ">

        <div style="background-color: white; padding-right:0%; padding-top: 1%; padding-bottom: 1%; border-radius: 10px/10px;
       box-shadow: 6px 6px 3px gray; margin-left: 25%; width: 70%;">
            <div style="margin-left: 20%;">
                <button name="marque2" value="marque" class="btn btn-default" id="marque2" onclick="showMarque2()">Marque</button>
                <button id="idModele2" name="modele2" value="modele" class="btn btn-default">Modele</button>
                <button id="idFamille2" name="idFamille2" value="famille" class="btn btn-default">Famille</button>
                <button id="idSFamille2" name="idSFamille2" value="Sfamille" class="btn btn-default">Sous Famille</button>

                <div style="display:none;" id="idMarque2">
                    <select name="idMarq2" id="idMarq2" class="form-control"></select>
                </div>

                <div style="display:none;" id="idM2">
                    <select name="idMod2" id="idMod2" class="form-control"></select>
                </div>

                <div style="display:none;" id="idF2">
                    <select name="id_f2" id="id_f2" class="form-control"></select>
                </div>

                <div style="display:none;" id="idSF2">
                    <select name="id_sf2" id="id_sf2" class="form-control"></select>
                </div>
        <canvas id="myChart2"></canvas>
    </div>
        </div>
    </div>

        <div class="container"  style=" margin-top: 2%; width: 50%; float: left; margin-bottom: 2%;">

            <div style="background-color: white; padding-right:5%; padding-top: 1%; padding-bottom: 1%; border-radius: 10px/10px;
       box-shadow: 6px 6px 3px gray; width: 100%;">
        <input name="idDate" id="idDate2" type="date" style="border-radius: 5px/5px; margin-left: 2%;">
        <canvas id="myChart4"></canvas>
    </div>
        </div>
        <div class="container"  style=" margin-top: 2%; width: 50%; float: left; margin-bottom: 2%;">
            <div style="background-color: white; padding-right:5%; padding-top: 1%; padding-bottom: 1%; border-radius: 10px/10px;
       box-shadow: 6px 6px 3px gray; margin-left: 2px; width: 100%;">
        <input name="idDate" id="idDate3" type="date" style="border-radius: 5px/5px; margin-left: 2%;">
        <canvas id="myChart5"></canvas>
            </div>
        </div>

    <div class="container"  style="margin-top: 3%; width: 70%; clear: both;">

        <div style="background-color: white; padding-right:5%; padding-top: 1%; padding-bottom: 1%; border-radius: 10px/10px;
       box-shadow: 6px 6px 3px gray; margin-left: 8%; width: 100%;">
            <canvas id="myChart3"></canvas>
        </div>
    </div>
    </div>

<script>
    $("#idDate").on('change', function() {
        var date = $('#idDate').val();
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>Res/fetch_equip_panneDate',
            data: 'idDate=' + date,
            dataType: "json",
            success: function(data) {
                var myChart = document.getElementById('myChart').getContext('2d');
                myChart.canvas.width = 300;
                myChart.canvas.height = 110;
                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 14;
                Chart.defaults.global.defaultFontColor = '#777';

                var massPopChart = new Chart(myChart, {
                    type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                    data: {
                        labels: ['', 'Total d\'équipements en panne', 'Équipements en panne non encore affectés', 'Équipements en panne non encore maintenues', 'Équipements en panne non réparable', 'Équipements en cours de réparation',''],
                        datasets: [{
                            label: 'Nombre d\'équipements',
                            data: [
                                0,
                                data.equip_en_panne,
                                data.equip_en_panne_nn_affec,
                                data.equip_en_panne_nn_maint,
                                data.equip_en_panne_nn_rep,
                                // data.equip_en_panne_AN,
                                data.equip_en_panne_en_maint,
                                0
                            ],
                            //backgroundColor:'green',
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.0)',
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(54, 162, 235, 0.6)'
                            ],
                            borderWidth: 1,
                            borderColor: '#777',
                            hoverBorderWidth: 3,
                            hoverBorderColor: '#000'
                        }]
                    },
                    options: {
                        events : [],
                        title: {
                            display: true,
                            text: 'Nombre total d\'équipement en panne',
                            fontSize: 25
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        layout: {
                            padding: {
                                left: 115,
                                right: 0,
                                bottom: 0,
                                top: 0
                            }
                        },
                        tooltips: {
                            enabled: false
                        }
                    },
                    showTooltips: false

                });
            }
        })
    })

</script>

<script>
    function showMarque() {
        $("#idMarque").show();
        $("#idM").hide();
        $("#idF").hide();
        $("#idSF").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectMarque',
            success: function(html) {

                $('#idMarq').html(html);
                $('#idMarq').on('change', function() {
                    $("#idM").hide();
                    var idM = $('#idMarq').val();


                    function tb12(view = '') {
                        $.ajax({
                            type: "post",

                            url: '<?php echo base_url();?>Res/fetch_equip_panneMarque',

                            data: 'idMarq=' + idM,
                            dataType: "json",
                            success: function(data) {

                                var myChart = document.getElementById('myChart').getContext('2d');
                                myChart.canvas.width = 300;
                                myChart.canvas.height = 110;
                                // Global Options
                                Chart.defaults.global.defaultFontFamily = 'Lato';
                                Chart.defaults.global.defaultFontSize = 14;
                                Chart.defaults.global.defaultFontColor = '#777';

                                var massPopChart = new Chart(myChart, {
                                    type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                    data: {
                                        labels: ['', 'Total d\'équipements en panne', 'Équipements en panne non encore affectés', 'Équipements en panne non encore maintenues', 'Équipements en panne non réparable','Équipements en cours de réparation', ''],
                                        datasets: [{
                                            label: 'Nombre d\'équipements',
                                            data: [
                                                0,
                                                data.equip_en_panne,
                                                data.equip_en_panne_nn_affec,
                                                data.equip_en_panne_nn_maint,
                                                data.equip_en_panne_nn_rep,
                                                /*    data.equip_en_panne_AN,*/
                                                    data.equip_en_panne_en_maint,

                                                0
                                            ],
                                            //backgroundColor:'green',
                                            backgroundColor: [
                                                'rgba(54, 162, 235, 0.0)',
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)',
                                                'rgba(255, 206, 86, 0.6)',
                                                'rgba(75, 192, 192, 0.6)',
                                                'rgba(153, 102, 255, 0.6)',
                                                'rgba(54, 162, 235, 0.6)'
                                            ],
                                            borderWidth: 1,
                                            borderColor: '#777'
                                        }]
                                    },
                                    options: {
                                        events : [],
                                        title: {
                                            display: true,
                                            text: 'Nombre total d\'équipement en panne',
                                            fontSize: 25
                                        },
                                        legend: {
                                            display: true,
                                            position: 'top',
                                            labels: {
                                                fontColor: '#000'
                                            }
                                        },
                                        layout: {
                                            padding: {
                                                left: 115,
                                                right: 0,
                                                bottom: 0,
                                                top: 0
                                            }
                                        },
                                        tooltips: {
                                            enabled: false
                                        }
                                    },
                                    showTooltips: false

                                });
                            }
                        });
                    }
                    tb12();
                });

            }
        })
    }

</script>

<script>
    $('#idModele').click(function() {
        $("#idMarque").show();
        $("#idF").hide();
        $("#idSF").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectMarque',
            success: function(html) {
                $('#idMarq').html(html);
                $('#idMarq').on('change', function() {
                    $("#idM").show();
                    var mid = $('#idMarq').val();
                    //         alert(mid);

                    function tb13(view = '') {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url();?>Res/selectModele',
                            data: 'idMarq=' + mid,
                            success: function(html) {
                                $('#idMod').html(html);
                                $('#idMod').on('change', function() {
                                    var idM = $('#idMod').val();
                                    //alert(idM);
                                    /*il ne rentre pas dans tb13*/
                                    $.ajax({
                                        type: "post",
                                        url: '<?php echo base_url();?>Res/fetch_equip_panneModele',
                                        data: 'idMod=' + idM,
                                        dataType: "json",
                                        success: function(data) {

                                            var myChart = document.getElementById('myChart').getContext('2d');
                                            myChart.canvas.width = 300;
                                            myChart.canvas.height = 110;
                                            // Global Options
                                            Chart.defaults.global.defaultFontFamily = 'Lato';
                                            Chart.defaults.global.defaultFontSize = 14;
                                            Chart.defaults.global.defaultFontColor = '#777';

                                            var massPopChart = new Chart(myChart, {
                                                type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                                data: {
                                                    labels: ['', 'Total d\'équipements en panne', 'Équipements en panne non encore affectés', 'Équipements en panne non encore maintenues', 'Équipements en panne non réparable','Équipements en cours de réparation', ''],
                                                    datasets: [{
                                                        label: 'Nombre d\'équipements',
                                                        data: [
                                                            0,
                                                            data.equip_en_panne,
                                                            data.equip_en_panne_nn_affec,
                                                            data.equip_en_panne_nn_maint,
                                                            /* data.equip_en_panne_nn_rep, data.equip_en_panne_AN,*/
                                                             data.equip_en_panne_en_maint,
                                                            0
                                                        ],
                                                        //backgroundColor:'green',
                                                        backgroundColor: [
                                                            'rgba(54, 162, 235, 0.0)',
                                                            'rgba(255, 99, 132, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)',
                                                            'rgba(255, 206, 86, 0.6)',
                                                            'rgba(75, 192, 192, 0.6)',
                                                            'rgba(153, 102, 255, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)'
                                                        ],
                                                        borderWidth: 1,
                                                        borderColor: '#777',
                                                        hoverBorderWidth: 3,
                                                        hoverBorderColor: '#000'
                                                    }]
                                                },
                                                options: {
                                                    events : [],
                                                    title: {
                                                        display: true,
                                                        text: 'Nombre total d\'équipement en panne',
                                                        fontSize: 25
                                                    },
                                                    legend: {
                                                        display: true,
                                                        position: 'top',
                                                        labels: {
                                                            fontColor: '#000'
                                                        }
                                                    },
                                                    layout: {
                                                        padding: {
                                                            left: 115,
                                                            right: 0,
                                                            bottom: 0,
                                                            top: 0
                                                        }
                                                    },
                                                    tooltips: {
                                                        enabled: false
                                                    }
                                                },
                                                showTooltips: false

                                            });
                                        }
                                    });
                                });
                            }
                        });
                    }
                    tb13();
                    /*else {
                        $('#idMod').html('<option value="">Select Marque first </option>');
                    }*/
                });
            }

        });
    });

</script>

<script>
    $(document).ready(function() {
        function affTB1(view = '') {

            $.ajax({

                url: "<?php echo base_url();?>Res/fetch_equip_panne",
                method: "POST",
                data: {
                    view: view
                },
                dataType: "json",
                success: function(data) {
                    var myChart = document.getElementById('myChart').getContext('2d');
                    myChart.canvas.width = 300;
                    myChart.canvas.height = 110;
                    // Global Options
                    Chart.defaults.global.defaultFontFamily = 'Lato';
                    Chart.defaults.global.defaultFontSize = 14;
                    Chart.defaults.global.defaultFontColor = '#777';

                    var massPopChart = new Chart(myChart, {
                        type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                        data: {
                            labels: ['', 'Total d\'équipements en panne', 'Équipements en panne non encore affectés', 'Équipements en panne non encore maintenues', 'Équipements en panne non réparable','Équipements en cours de réparation',''],
                            datasets: [{
                                label: 'Nombre d\'équipements',
                                data: [
                                    0,
                                    data.equip_en_panne,
                                    data.equip_en_panne_nn_affec,
                                    data.equip_en_panne_nn_maint,
                                    data.equip_en_panne_nn_rep,
                                    data.equip_en_panne_ER,
                                    0
                                ],
                                //backgroundColor:'green',
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.0)',
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 206, 86, 0.6)',
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                    'rgba(54, 162, 235, 0.6)'
                                ],
                                borderWidth: 1,
                                borderColor: '#777'

                            }]
                        },
                        options: {
                            events: [],
                            title: {
                                display: true,
                                text: 'Nombre total d\'équipement en panne',
                                fontSize: 25
                            },
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    fontColor: '#000'
                                }
                            },
                            layout: {
                                padding: {
                                    left: 115,
                                    right: 0,
                                    bottom: 0,
                                    top: 0
                                }
                            },
                            tooltips: {
                                enabled: false
                            }
                        },
                        showTooltips: false
                    });
                }
            });
        }
        affTB1();
    });

</script>

<script>
    $('#idFamille').click(function() {
        $("#idF").show();
        $("#idSF").hide();
        $("#idMarque").hide();
        $("#idM").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectFamille',
            success: function(html) {

                $('#id_f').html(html);
                $('#id_f').on('change', function() {
                    $("#idSF").hide();
                    var idf = $('#id_f').val();


                    function tb14(view = '') {
                        $.ajax({
                            type: "post",

                            url: '<?php echo base_url();?>Res/fetch_equip_panneFamille',

                            data: 'idf=' + idf,
                            dataType: "json",
                            success: function(data) {

                                var myChart = document.getElementById('myChart').getContext('2d');
                                myChart.canvas.width = 300;
                                myChart.canvas.height = 110;
                                // Global Options
                                Chart.defaults.global.defaultFontFamily = 'Lato';
                                Chart.defaults.global.defaultFontSize = 14;
                                Chart.defaults.global.defaultFontColor = '#777';

                                var massPopChart = new Chart(myChart, {
                                    type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                    data: {
                                        labels: ['', 'Total d\'équipements en panne', 'Équipements en panne non encore affectés', 'Équipements en panne non encore maintenues', 'Équipements en panne non réparable','Équipements en cours de réparation', ''],
                                        datasets: [{
                                            label: 'Nombre d\'équipements',
                                            data: [
                                                0,
                                                data.equip_en_panne,
                                                data.equip_en_panne_nn_affec,
                                                data.equip_en_panne_nn_maint,
                                                data.equip_en_panne_nn_rep,
                                                /*     data.equip_en_panne_AN,*/
                                                     data.equip_en_panne_en_maint,
                                                0
                                            ],
                                            //backgroundColor:'green',
                                            backgroundColor: [
                                                'rgba(54, 162, 235, 0.0)',
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)',
                                                'rgba(255, 206, 86, 0.6)',
                                                'rgba(75, 192, 192, 0.6)',
                                                'rgba(153, 102, 255, 0.6)',
                                                'rgba(54, 162, 235, 0.6)'
                                            ],
                                            borderWidth: 1,
                                            borderColor: '#777',
                                            hoverBorderWidth: 3,
                                            hoverBorderColor: '#000'
                                        }]
                                    },
                                    options: {
                                        events: [],
                                        title: {
                                            display: true,
                                            text: 'Nombre total d\'équipement en panne',
                                            fontSize: 25
                                        },
                                        legend: {
                                            display: true,
                                            position: 'top',
                                            labels: {
                                                fontColor: '#000'
                                            }
                                        },
                                        layout: {
                                            padding: {
                                                left: 115,
                                                right: 0,
                                                bottom: 0,
                                                top: 0
                                            }
                                        },
                                        tooltips: {
                                            enabled: false
                                        }
                                    }

                                });
                            }
                        });
                    }
                    tb14();
                });

            }
        })

    })

</script>

<script>
    $('#idSFamille').click(function() {
        $("#idF").show();
        $("#idMarque").hide();
        $("#idM").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectFamille',
            success: function(html) {
                $('#id_f').html(html);
                $('#id_f').on('change', function() {
                    $("#idSF").show();
                    var mid = $('#id_f').val();
                    //         alert(mid);

                    function tb15(view = '') {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url();?>Res/selectSF',
                            data: 'idF=' + mid,
                            success: function(html) {
                                $('#id_sf').html(html);
                                $('#id_sf').on('change', function() {
                                    var idM = $('#id_sf').val();
                                    //alert(idM);

                                    $.ajax({
                                        type: "post",
                                        url: '<?php echo base_url();?>Res/fetch_equip_panneSF',
                                        data: 'id_sf=' + idM,
                                        dataType: "json",
                                        success: function(data) {

                                            var myChart = document.getElementById('myChart').getContext('2d');
                                            myChart.canvas.width = 300;
                                            myChart.canvas.height = 110;
                                            // Global Options
                                            Chart.defaults.global.defaultFontFamily = 'Lato';
                                            Chart.defaults.global.defaultFontSize = 14;
                                            Chart.defaults.global.defaultFontColor = '#777';

                                            var massPopChart = new Chart(myChart, {
                                                type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                                data: {
                                                    labels: ['', 'Total d\'équipements en panne', 'Équipements en panne non encore affectés', 'Équipements en panne non encore maintenues', 'Équipements en panne non réparable','Équipements en cours de réparation', ''],
                                                    datasets: [{
                                                        label: 'Nombre d\'équipements',
                                                        data: [
                                                            0,
                                                            data.equip_en_panne,
                                                            data.equip_en_panne_nn_affec,
                                                            data.equip_en_panne_nn_maint,
                                                            data.equip_en_panne_nn_rep,
                                                            /* data.equip_en_panne_AN,*/
                                                             data.equip_en_panne_en_maint,
                                                            0
                                                        ],
                                                        //backgroundColor:'green',
                                                        backgroundColor: [
                                                            'rgba(54, 162, 235, 0.0)',
                                                            'rgba(255, 99, 132, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)',
                                                            'rgba(255, 206, 86, 0.6)',
                                                            'rgba(75, 192, 192, 0.6)',
                                                            'rgba(153, 102, 255, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)'
                                                        ],
                                                        borderWidth: 1,
                                                        borderColor: '#777',
                                                        hoverBorderWidth: 3,
                                                        hoverBorderColor: '#000'
                                                    }]
                                                },
                                                options: {
                                                    events: [],
                                                    title: {
                                                        display: true,
                                                        text: 'Nombre total d\'équipement en panne',
                                                        fontSize: 25
                                                    },
                                                    legend: {
                                                        display: true,
                                                        position: 'top',
                                                        labels: {
                                                            fontColor: '#000'
                                                        }
                                                    },
                                                    layout: {
                                                        padding: {
                                                            left: 115,
                                                            right: 0,
                                                            bottom: 0,
                                                            top: 0
                                                        }
                                                    },
                                                    tooltips: {
                                                        enabled: false
                                                    }
                                                }

                                            });
                                        }
                                    });
                                });
                            }
                        });
                    }
                    tb15();
                    /*else {
                        $('#idMod').html('<option value="">Select Marque first </option>');
                    }*/
                });
            }

        });
    });

</script>

<!--  chart 2 -->
<script>
    $(document).ready(function() {
        /* function tb21() {*/
        //alert('hello');
        $.ajax({
            url: "<?php echo base_url();?>Res/fetch_temp",
            dataType: "json",
            //error: alert('hello'),
            success: function(data) {

                var myChart2 = document.getElementById('myChart2').getContext('2d');
                myChart2.canvas.width = 300;
                myChart2.canvas.height = 110;
                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 18;
                Chart.defaults.global.defaultFontColor = '#777';

                var massPopChart2 = new Chart(myChart2, {
                    type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                    data: {
                        labels: ['Temps d\'arrêt', 'Temps de marche'],
                        datasets: [{
                            label: 'Temp',
                            data: [
                                data.tA,
                                data.tM,
                                //  12, 23,

                            ],
                            //backgroundColor:'green',
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)'
                                /*,
                                                    'rgba(255, 206, 86, 0.6)',
                                                    'rgba(75, 192, 192, 0.6)',
                                                    'rgba(153, 102, 255, 0.6)',
                                                    'rgba(255, 159, 64, 0.6)',
                                                    'rgba(255, 99, 132, 0.6)'*/
                            ],
                            borderWidth: 1,
                            borderColor: '#777',
                            hoverBorderWidth: 3,
                            hoverBorderColor: '#000'
                        }]
                    },
                    options: {
                        events: [],
                        pieceLabel: {
                            render: 'value',
                            fontColor: '#000',
                            position: 'outside'
                        },
                        title: {
                            display: true,
                            text: 'Temps de marche et d\'arrêt',
                            fontSize: 25
                        },
                        legend: {
                            display: true,
                            position: 'left',
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                bottom: 0,
                                top: 0
                            }
                        },
                        tooltips: {
                            enabled: false
                        }
                    }
                });
            }
            /*     });

       }
        tb21();*/
        })
    })

</script>

<script>
    function showMarque2() {
        $("#idMarque2").show();
        $("#idM2").hide();
        $("#idF2").hide();
        $("#idSF2").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectMarque',
            success: function(html) {

                $('#idMarq2').html(html);
                $('#idMarq2').on('change', function() {
                    $("#idM2").hide();
                    var idM = $('#idMarq2').val();


                    function tb22(view = '') {
                        $.ajax({
                            type: "post",

                            url: '<?php echo base_url();?>Res/fetch_tempMarque',

                            data: 'idMarq=' + idM,
                            dataType: "json",
                            success: function(data) {

                                var myChart2 = document.getElementById('myChart2').getContext('2d');

                                // Global Options
                                Chart.defaults.global.defaultFontFamily = 'Lato';
                                Chart.defaults.global.defaultFontSize = 14;
                                Chart.defaults.global.defaultFontColor = '#777';

                                var massPopChart = new Chart(myChart2, {
                                    type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                    data: {
                                        labels: ['Temps d\'arrêt', 'Temps de marche'],
                                        datasets: [{
                                            label: 'Temp',
                                            data: [
                                                data.tA,
                                                data.tM,
                                                //  12, 23,

                                            ],
                                            //backgroundColor:'green',
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)'
                                                /*,
                                                                    'rgba(255, 206, 86, 0.6)',
                                                                    'rgba(75, 192, 192, 0.6)',
                                                                    'rgba(153, 102, 255, 0.6)',
                                                                    'rgba(255, 159, 64, 0.6)',
                                                                    'rgba(255, 99, 132, 0.6)'*/
                                            ],
                                            borderWidth: 1,
                                            borderColor: '#777',
                                            hoverBorderWidth: 3,
                                            hoverBorderColor: '#000'
                                        }]
                                    },
                                    options: {
                                        events: [],
                                        pieceLabel: {
                                            render: 'value',
                                            fontColor: '#000',
                                            position: 'outside'
                                        },
                                        title: {
                                            display: true,
                                            text: 'Temps de marche et d\'arrêt ',
                                            fontSize: 25
                                        },
                                        legend: {
                                            display: true,
                                            position: 'left',
                                            labels: {
                                                fontColor: '#000'
                                            }
                                        },
                                        layout: {
                                            padding: {
                                                left: 0,
                                                right: 0,
                                                bottom: 0,
                                                top: 0
                                            }
                                        },
                                        tooltips: {
                                            enabled: false
                                        }
                                    }

                                });
                            }
                        });
                    }
                    tb22();
                });

            }
        })
    }

</script>

<script>
    $('#idModele2').click(function() {
        $("#idMarque2").show();
        $("#idF2").hide();
        $("#idSF2").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectMarque',
            success: function(html) {
                $('#idMarq2').html(html);
                $('#idMarq2').on('change', function() {
                    $("#idM2").show();
                    var mid = $('#idMarq2').val();
                    //         alert(mid);

                    function tb23(view = '') {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url();?>Res/selectModele',
                            data: 'idMarq=' + mid,
                            success: function(html) {
                                $('#idMod2').html(html);
                                $('#idMod2').on('change', function() {
                                    var idM = $('#idMod2').val();
                                    //alert(idM);
                                    /*il ne rentre pas dans tb13*/
                                    $.ajax({
                                        type: "post",
                                        url: '<?php echo base_url();?>Res/fetch_tempMod',
                                        data: 'idMod=' + idM,
                                        dataType: "json",
                                        success: function(data) {
                                            var myChart2 = document.getElementById('myChart2').getContext('2d');
                                            myChart2.canvas.width = 300;
                                            myChart2.canvas.height = 110;
                                            // Global Options
                                            Chart.defaults.global.defaultFontFamily = 'Lato';
                                            Chart.defaults.global.defaultFontSize = 18;
                                            Chart.defaults.global.defaultFontColor = '#777';

                                            var massPopChart2 = new Chart(myChart2, {
                                                type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                                data: {
                                                    labels: ['Temps d\'arrêt', 'Temps de marche'],
                                                    datasets: [{
                                                        label: 'Temp',
                                                        data: [
                                                            data.tA,
                                                            data.tM,
                                                            //  12, 23,

                                                        ],
                                                        //backgroundColor:'green',
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)'
                                                            /*,
                                                                                'rgba(255, 206, 86, 0.6)',
                                                                                'rgba(75, 192, 192, 0.6)',
                                                                                'rgba(153, 102, 255, 0.6)',
                                                                                'rgba(255, 159, 64, 0.6)',
                                                                                'rgba(255, 99, 132, 0.6)'*/
                                                        ],
                                                        borderWidth: 1,
                                                        borderColor: '#777',
                                                        hoverBorderWidth: 3,
                                                        hoverBorderColor: '#000'
                                                    }]
                                                },
                                                options: {
                                                    events : [],
                                                    pieceLabel: {
                                                        render: 'value',
                                                        fontColor: '#000',
                                                        position: 'outside'
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'Temps de marche et d\'arrêt',
                                                        fontSize: 25
                                                    },
                                                    legend: {
                                                        display: true,
                                                        position: 'left',
                                                        labels: {
                                                            fontColor: '#000'
                                                        }
                                                    },
                                                    layout: {
                                                        padding: {
                                                            left: 0,
                                                            right: 0,
                                                            bottom: 0,
                                                            top: 0
                                                        }
                                                    },
                                                    tooltips: {
                                                        enabled: false
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    }
                    tb23();
                    /*else {
                        $('#idMod').html('<option value="">Select Marque first </option>');
                    }*/
                });
            }

        });
    });

</script>

<script>
    $('#idFamille2').click(function() {
        $("#idF2").show();
        $("#idSF2").hide();
        $("#idMarque2").hide();
        $("#idM2").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectFamille',
            success: function(html) {

                $('#id_f2').html(html);
                $('#id_f2').on('change', function() {
                    $("#idSF2").hide();
                    var idf = $('#id_f2').val();


                    function tb24(view = '') {
                        $.ajax({
                            type: "post",

                            url: '<?php echo base_url();?>Res/fetch_temp_F',

                            data: 'idf=' + idf,
                            dataType: "json",
                            success: function(data) {

                                var myChart2 = document.getElementById('myChart2').getContext('2d');
                                myChart2.canvas.width = 300;
                                myChart2.canvas.height = 110;
                                // Global Options
                                Chart.defaults.global.defaultFontFamily = 'Lato';
                                Chart.defaults.global.defaultFontSize = 18;
                                Chart.defaults.global.defaultFontColor = '#777';

                                var massPopChart2 = new Chart(myChart2, {
                                    type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                    data: {
                                        labels: ['Temps d\'arrêt', 'Temps de marche'],
                                        datasets: [{
                                            label: 'Temp',
                                            data: [
                                                data.tA,
                                                data.tM,
                                                //  12, 23,

                                            ],
                                            //backgroundColor:'green',
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)'
                                                /*,
                                                                    'rgba(255, 206, 86, 0.6)',
                                                                    'rgba(75, 192, 192, 0.6)',
                                                                    'rgba(153, 102, 255, 0.6)',
                                                                    'rgba(255, 159, 64, 0.6)',
                                                                    'rgba(255, 99, 132, 0.6)'*/
                                            ],
                                            borderWidth: 1,
                                            borderColor: '#777',
                                            hoverBorderWidth: 3,
                                            hoverBorderColor: '#000'
                                        }]
                                    },
                                    options: {
                                        events : [],
                                        pieceLabel: {
                                            render: 'value',
                                            fontColor: '#000',
                                            position: 'outside'
                                        },
                                        title: {
                                            display: true,
                                            text: 'Temps de marche et d\'arrêt',
                                            fontSize: 25
                                        },
                                        legend: {
                                            display: true,
                                            position: 'left',
                                            labels: {
                                                fontColor: '#000'
                                            }
                                        },
                                        layout: {
                                            padding: {
                                                left: 0,
                                                right: 0,
                                                bottom: 0,
                                                top: 0
                                            }
                                        },
                                        tooltips: {
                                            enabled: false
                                        }
                                    }
                                });
                            }
                        });
                    }
                    tb24();
                });

            }
        })

    })

</script>

<script>
    $('#idSFamille2').click(function() {
        $("#idF2").show();
        $("#idMarque2").hide();
        $("#idM2").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Res/selectFamille',
            success: function(html) {
                $('#id_f2').html(html);
                $('#id_f2').on('change', function() {
                    $("#idSF2").show();
                    var mid = $('#id_f2').val();
                    //         alert(mid);

                    function tb25(view = '') {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url();?>Res/selectSF',
                            data: 'idF=' + mid,
                            success: function(html) {
                                $('#id_sf2').html(html);
                                $('#id_sf2').on('change', function() {
                                    var idM = $('#id_sf2').val();
                                    //alert(idM);

                                    $.ajax({
                                        type: "post",
                                        url: '<?php echo base_url();?>Res/fetch_temp_SF',
                                        data: 'id_sf=' + idM,
                                        dataType: "json",
                                        success: function(data) {

                                            var myChart2 = document.getElementById('myChart2').getContext('2d');
                                            myChart2.canvas.width = 300;
                                            myChart2.canvas.height = 110;
                                            // Global Options
                                            Chart.defaults.global.defaultFontFamily = 'Lato';
                                            Chart.defaults.global.defaultFontSize = 18;
                                            Chart.defaults.global.defaultFontColor = '#777';

                                            var massPopChart2 = new Chart(myChart2, {
                                                type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                                                data: {
                                                    labels: ['Temps d\'arrêt', 'Temps de marche'],
                                                    datasets: [{
                                                        label: 'Temp',
                                                        data: [
                                                            data.tA,
                                                            data.tM,
                                                            // 12, 23,

                                                        ],
                                                        //backgroundColor:'green',
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.6)',
                                                            'rgba(54, 162, 235, 0.6)'
                                                            /*,
                                                                                'rgba(255, 206, 86, 0.6)',
                                                                                'rgba(75, 192, 192, 0.6)',
                                                                                'rgba(153, 102, 255, 0.6)',
                                                                                'rgba(255, 159, 64, 0.6)',
                                                                                'rgba(255, 99, 132, 0.6)'*/
                                                        ],
                                                        borderWidth: 1,
                                                        borderColor: '#777',
                                                        hoverBorderWidth: 3,
                                                        hoverBorderColor: '#000'
                                                    }]
                                                },
                                                options: {
                                                    events: [],
                                                    pieceLabel: {
                                                        render: 'value',
                                                        fontColor: '#000',
                                                        position: 'outside'
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'Temps de marche et d\'arrêt',
                                                        fontSize: 25
                                                    },
                                                    legend: {
                                                        display: true,
                                                        position: 'left',
                                                        labels: {
                                                            fontColor: '#000'
                                                        }
                                                    },
                                                    layout: {
                                                        padding: {
                                                            left: 0,
                                                            right: 0,
                                                            bottom: 0,
                                                            top: 0
                                                        }
                                                    },
                                                    tooltips: {
                                                        enabled: false
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    }
                    tb25();
                    /*else {
                        $('#idMod').html('<option value="">Select Marque first </option>');
                    }*/
                });
            }

        });
    });

</script>

<!-- chart 3 -->
<script>
    $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>Res/nbMatRep',

        dataType: "json",
        success: function(data) {
            var myChart3 = document.getElementById('myChart3').getContext('2d');
            myChart3.canvas.width = 300;
            myChart3.canvas.height = 110;
            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 18;
            Chart.defaults.global.defaultFontColor = '#777';

            var massPopChart3 = new Chart(myChart3, {
                type: 'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data: {
                    labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                    datasets: [{
                        label: 'Matérieux utilisés en reparation',
                        data: [
                            data.jan,
                            data.fev,
                            data.mars,
                            data.avril,
                            data.may,
                            data.juin,
                            data.jull,
                            data.aout,
                            data.sep,
                            data.oct,
                            data.nov,
                            data.dec
                        ],
                        //backgroundColor:'green',
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(54, 162, 235, 0.6)'
                        ],
                        borderWidth: 1,
                        borderColor: '#777',
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#000'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Total des matériaux utilisés en réparation',
                        fontSize: 25
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            fontColor: '#000'
                        }
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            bottom: 0,
                            top: 0
                        }
                    },
                    tooltips: {
                        enabled: true
                    }
                }
            });
        }
    })

</script>
<!-- chart 4 -->
<script>
    $(document).ready(function() {
        function nbMat(view = '') {
            $.ajax({
                data: {
                    view: view
                },
                url: '<?php echo base_url(); ?>Res/nbMatEs',
                dataType: "json",
                success: function(data) {
                    var myChart4 = document.getElementById('myChart4').getContext('2d');
                    // Global Options
                    Chart.defaults.global.defaultFontFamily = 'Lato';
                    Chart.defaults.global.defaultFontSize = 18;
                    Chart.defaults.global.defaultFontColor = '#777';

                    var massPopChart4 = new Chart(myChart4, {
                        type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                        data: {
                            labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                            datasets: [{
                                label: 'Pourcentage de nombre de matériaux entrés en stock',
                                data: [
                                    data.jan,
                                    data.fev,
                                    data.mars,
                                    data.avril,
                                    data.may,
                                    data.juin,
                                    data.jull,
                                    data.aout,
                                    data.sep,
                                    data.oct,
                                    data.nov,
                                    data.dec

                                ],
                                //backgroundColor:'green',
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 206, 86, 0.6)',
                                    'rgba(75, 192, 18, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                    'rgba(255, 159, 64, 0.6)',
                                    'rgba(255, 99, 12, 0.6)',
                                    'red',
                                    'gray',
                                    'rgba(75, 192, 192, 0.6)',
                                    'darkgreen',
                                    'rgba(25, 99, 132, 0.6)'
                                ],
                                borderWidth: 1,
                                borderColor: '#777',
                                hoverBorderWidth: 3,
                                hoverBorderColor: '#000'
                            }]
                        },
                        options: {
                            events: [],
                            pieceLabel: {
                                render: 'percentage',
                                fontColor: 'black',
                                precision: 2,
                                fontSize: 17,
                                position: 'border',
                                overlap: true
                            },
                            title: {
                                display: true,
                                text: 'Pourcentage de nombre de materieux entrés en stock',
                                fontSize: 25
                            },
                            legend: {
                                display: true,
                                position: 'right',
                                labels: {
                                    fontColor: '#000'
                                }
                            },
                            layout: {
                                padding: {
                                    left: 0,
                                    right: 0,
                                    bottom: 0,
                                    top: 0
                                }
                            },
                            tooltips: {
                                enabled: false
                            }
                        }
                    });
                }
            })
        }
        nbMat();
    })

</script>
<script>
    $(document).ready(function() {

        $.ajax({

            url: '<?php echo base_url(); ?>Res/nbMatSs',
            dataType: "json",

            success: function (data) {

                var myChart5 = document.getElementById('myChart5').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 18;
                Chart.defaults.global.defaultFontColor = '#777';

                var massPopChart5 = new Chart(myChart5, {
                    type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                    data: {
                        labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                        datasets: [{
                            label: 'Pourcentage de nombre de matériaux sorties de stock',
                            data: [
                                data.jan,
                                data.fev,
                                data.mars,
                                data.avril,
                                data.may,
                                data.juin,
                                data.jull,
                                data.aout,
                                data.sep,
                                data.oct,
                                data.nov,
                                data.dec
                            ],
                            //backgroundColor:'green',
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 18, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(255, 99, 12, 0.6)',
                                'red',
                                'gray',
                                'rgba(75, 192, 192, 0.6)',
                                'darkgreen',
                                'rgba(25, 99, 132, 0.6)'
                            ],
                            borderWidth: 1,
                            borderColor: '#777',
                            hoverBorderWidth: 3,
                            hoverBorderColor: '#000'
                        }]
                    },
                    options: {
                        events: [],
                        pieceLabel: {
                            render: 'percentage',
                            fontColor: 'black',
                            precision: 2,
                            fontSize: 17,
                            position: 'border',
                            overlap: true
                        },
                        title: {
                            display: true,
                            text: 'Poursentage de nombre de materieux sorties de stock',
                            fontSize: 25
                        },
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        layout: {
                            padding: {
                                left: 50,
                                right: 0,
                                bottom: 0,
                                top: 0
                            }
                        },
                        tooltips: {
                            enabled: false
                        }
                    }
                });
            }
        });
    });
</script>

<script>
    $("#idDate2").on('change', function() {
        var date = $('#idDate2').val();
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>Res/nbMat_ES_Annee',
            data: 'idDate=' + date,
            dataType: "json",
            success: function(data) {

                var myChart4 = document.getElementById('myChart4').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 18;
                Chart.defaults.global.defaultFontColor = '#777';

                var massPopChart4 = new Chart(myChart4, {
                    type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                    data: {
                        labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                        datasets: [{
                            label: 'Pourcentage de nombre de matériaux entrés en stock',
                            data: [
                                data.jan,
                                data.fev,
                                data.mars,
                                data.avril,
                                data.may,
                                data.juin,
                                data.jull,
                                data.aout,
                                data.sep,
                                data.oct,
                                data.nov,
                                data.dec

                            ],
                            //backgroundColor:'green',
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 18, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(255, 99, 12, 0.6)',
                                'red',
                                'gray',
                                'rgba(75, 192, 192, 0.6)',
                                'darkgreen',
                                'rgba(25, 99, 132, 0.6)'
                            ],
                            borderWidth: 1,
                            borderColor: '#777',
                            hoverBorderWidth: 3,
                            hoverBorderColor: '#000'
                        }]
                    },
                    options: {
                        events: [],
                        pieceLabel: {
                            render: 'percentage',
                            fontColor: 'black',
                            precision: 2,
                            fontSize: 17,
                            position: 'border',
                            overlap: true
                        },
                        title: {
                            display: true,
                            text: 'Pourcentage de nombre de matérieux entrés en stock',
                            fontSize: 25
                        },
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                bottom: 0,
                                top: 0
                            }
                        },
                        tooltips: {
                            enabled: false
                        }
                    }
                });
            }

        });
    })

</script>
<script>
    $("#idDate3").on('change', function() {
        var date = $('#idDate3').val();
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>Res/nbMat_SS_Annee',
            data: 'idDate=' + date,
            dataType: "json",
            success: function(data) {

                var myChart5 = document.getElementById('myChart5').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 18;
                Chart.defaults.global.defaultFontColor = '#777';

                var massPopChart5 = new Chart(myChart5, {
                    type: 'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                    data: {
                        labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                        datasets: [{
                            label: 'Pourcentage de nombre de matériaux sorties de stock',
                            data: [
                                data.jan,
                                data.fev,
                                data.mars,
                                data.avril,
                                data.may,
                                data.juin,
                                data.jull,
                                data.aout,
                                data.sep,
                                data.oct,
                                data.nov,
                                data.dec

                            ],
                            //backgroundColor:'green',
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 18, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(255, 99, 12, 0.6)',
                                'red',
                                'gray',
                                'rgba(75, 192, 192, 0.6)',
                                'darkgreen',
                                'rgba(25, 99, 132, 0.6)'
                            ],
                            borderWidth: 1,
                            borderColor: '#777',
                            hoverBorderWidth: 3,
                            hoverBorderColor: '#000'
                        }]
                    },
                    options: {
                        events: [],
                        pieceLabel: {
                            render: 'percentage',
                            fontColor: 'black',
                            precision: 2,
                            fontSize: 17,
                            position: 'border',
                            overlap: true
                        },
                        title: {
                            display: true,
                            text: 'Pourcentage de nombre de matérieux sorties de stock',
                            fontSize: 25
                        },
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        layout: {
                            padding: {
                                left: 50,
                                right: 0,
                                bottom: 0,
                                top: 0
                            }
                        },
                        tooltips: {
                            enabled: false
                        }
                    }
                });
            }

        });
    })

</script>
