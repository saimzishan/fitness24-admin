<?php
foreach ($days as $day) {
    ?>
    <tr class="odd gradeX">
        <td>
            <?php echo $day['day']; ?>
        </td>
        <td>
            <?php
            if ($day['archive'] == 0) {
                echo $day['time']['start_time'];
            } else {
                echo '<span style="color:red;">Not Available</span>';
            }
            ?>
        </td>
        <td>
            <?php
            if ($day['archive'] == 0) {
                echo $day['time']['end_time'];
            } else {
                echo '<span style="color:red;">Not Available</span>';
            }
            ?>
        </td>
        <td>
            &nbsp;&nbsp;&nbsp;
            <?php
            if ($day['archive'] == 0) {
                echo '$' . $day['price_per_hour'];
            } else {
                echo '$0';
            }
            ?>
        </td>
        <td>
            <a style="text-decoration:none" href="<?php echo route("edit_availability", array('id' => $day['id'], 'user_id' => $user_id, 'spot_id' => $spot_id)); ?>" title="Change">
                <div class="fa fa-edit"></div>
            </a>
            &nbsp;&nbsp;&nbsp;
            <a style="text-decoration:none" href="javascript:;" >
                <?php
                if ($day['archive'] == 0) {
                    $staus = '<span id="day' . $day['id'] . '" day_id="' . $day['id'] . '" spot_id="' . $spot_id . '" user_id="' . $user_id . '" status="1" class="icon fa fa-power-off day_status" title="Deactivate"></span>';
                    echo $staus;
                } else {
                    $staus = '<span id="day' . $day['id'] . '" day_id="' . $day['id'] . '" spot_id="' . $spot_id . '" user_id="' . $user_id . '" status="0" class="icon fa fa-rotate-right day_status" title="Activate"></span>';
                    echo $staus;
                }
                ?>
            </a>
        </td>
    </tr>
<?php }
?>