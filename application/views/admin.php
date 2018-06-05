<?php
echo '<div class="container" id="cont" style="margin-top: 4%;">';
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
                    <span class="badge badge<?php echo $v[2]; ?>"></span>
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
echo '</div>';
?>