<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 3:57 PM
 */
?>
<script src="<?php echo base_url().'assets/js/trips.js'?>"></script>

<div class="col-md-8 content-div" ng-app="tripManager" ng-controller="trip">
    <div class="row hidden-print">
        <div class="notification-container" ng-show="alert.show">
            <div class="notification-message">
                <button type="button" class="close" ng-click="hideAlert()" ><span aria-hidden="true">&times;</span></button>
                <span class='message'>{{alert.message}}</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default"  data-toggle="modal" data-target="#tripModal" ng-click="getTripOb(1,-1)"><i class="fa fa-cab"></i> New Trip</button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table" id="trips-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Trip Name</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="trip in trips">
                    <td>{{$index+1}}</td>
                    <td>{{trip.tripDate}}</td>
                    <td>{{trip.tripName}}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tripModal" ng-click="getTripOb(2,trip.tripId)">
                            <span class="glyphicon glyphicon-list-alt"></span>
                        </button>
                        <button class="btn btn-danger btn-sm remove" ng-click="deleteTrip( trip.tripId )">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tripModal" tabindex="-1" role="dialog" aria-labelledby="tripModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="row hidden-print">
                    <div class="notification-container" ng-show="tripModalAlert.show">
                        <div class="notification-message">
                            <button type="button" class="close" ng-click="hideTripModalAlert()" ><span aria-hidden="true">&times;</span></button>
                            <span class='message'>{{tripModalAlert.message}}</span>
                        </div>
                    </div>
                </div>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="tripModalLabel"> Trip </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="text" class="form-control" ng-model="tripOb.tripName" placeholder="Trip Name">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="text" class="form-control" id="tripDate" ng-model="tripOb.tripDate" placeholder="Trip Date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" ng-click="saveTrip()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>