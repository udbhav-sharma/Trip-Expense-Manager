<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/3/2015
 * Time: 2:58 PM
 */
?>

<script src="<?php echo base_url().'assets/js/trip_stats.js'?>"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>

<div class="col-md-10 content-div" ng-app="tripStatsManager" ng-controller="tripStats">
    <div class="row hidden-print">
        <div class="notification-container" ng-show="alert.show">
            <div class="notification-message">
                <button type="button" class="close" ng-click="hideAlert()" ><span aria-hidden="true">&times;</span></button>
                <span class='message'>{{alert.message}}</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <select class="form-control" ng-model="tripId">
                <option value>-- Select Trip --</option>
                <?php foreach($trips as $trip){?>
                    <option value=<?php echo $trip['tripId']?> > <?php echo $trip['tripName']?>  </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-primary" ng-click="fetchTripStats()" ><i class="fa fa-refresh"></i> Refresh</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 text-center" >
            <h4> {{trip.tripName}} Expenses Graph </h4>
            <div id="status-bar">
            </div>
        </div>
    </div>
</div>