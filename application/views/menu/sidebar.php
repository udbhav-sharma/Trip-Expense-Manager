<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 3:31 PM
 */
?>
<div class="col-md-2">
    <ul class="list-group">
        <li class="list-group-item <?php if($tab=="my trips") echo 'active';?>"><a href="<?php echo base_url()?>">My Trips</a></li>
        <li class="list-group-item <?php if($tab=="trip details") echo 'active';?>"><a href="<?php echo base_url('main/tripDetails')?>">Trip Details</a></li>
        <li class="list-group-item <?php if($tab=="trip stats") echo 'active';?>"><a href="<?php echo base_url('main/tripStats')?>">Trip Stats</a></li>
    </ul>
</div>