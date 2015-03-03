/**
 * Created by UDBHAV on 3/2/2015.
 */

$(document).ready(function() {
    $("#tripDate").datepicker();
});

var app = angular.module('tripManager',['alert_module']).
    constant(
    "CONSTANTS",{
        SUCCESS_CODE: 1,
        ERROR_CODE: 0,
        NETWORK_ERROR: 'Some Error occurred! Please reload/refresh the page and try again.',
        DELETE_CONFIRMATION: 'Do you really want to delete this?',
        LOADING: 'Loading...'
    }
);

app.controller('trip',function($scope, CONSTANTS, $http, alert){
    $scope.CONSTANTS=CONSTANTS;
    $scope.alert=alert.initializeAlert();
    $scope.tripModalAlert=alert.initializeAlert();
    $scope.trips=[];

    function fetchTrips(){
        $scope.alert = alert.successAlert( $scope.CONSTANTS.LOADING );
        $http({
            method:'POST',
            url:'main/getTrips',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            transformRequest: function(obj) {
                var str = [];
                for(var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            },
            data:{tripId:$scope.tripId}
        })
            .success(function(data, status) {
                if(data.code ==  $scope.CONSTANTS.SUCCESS_CODE ){
                    //$scope.alert=alert.successAlert( data.message );
                    $scope.hideAlert();
                    $scope.trips = data.data;
                }
                else{
                    $scope.alert=alert.errorAlert( data.message );
                }
            })
            .error(function(data, status) {
                $scope.alert=alert.errorAlert( $scope.CONSTANTS.NETWORK_ERROR );
            });
    }

    $scope.getTripOb = function getTripOb(obType,tripId){
        $scope.alert = alert.successAlert( $scope.CONSTANTS.LOADING );

        $http({
            method:'POST',
            url:'main/getTripOb',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            transformRequest: function(obj) {
                var str = [];
                for(var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            },
            data:{obType:obType,tripId:tripId}
        })
            .success(function(data, status) {
                if(data.code ==  $scope.CONSTANTS.SUCCESS_CODE ){
                    //$scope.alert=alert.successAlert( data.message );
                    $scope.hideAlert();
                    $scope.tripOb = data.data;
                }
                else{
                    $scope.alert=alert.errorAlert( data.message );
                }
            })
            .error(function(data, status) {
                $scope.alert=alert.errorAlert( $scope.CONSTANTS.NETWORK_ERROR );
            });
    }

    $scope.saveTrip = function saveTrip(){
        $scope.tripModalAlert = alert.successAlert( $scope.CONSTANTS.LOADING );
        $http({
            method:'POST',
            url:'main/addTrip',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            transformRequest: function(obj) {
                var str = [];
                for(var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            },
            data:{trip:JSON.stringify($scope.tripOb)}
        })
            .success(function(data, status) {
                if(data.code ==  $scope.CONSTANTS.SUCCESS_CODE ){
                    if($scope.tripOb.obType==1){
                        addNewTrip(data.data);
                    }
                    else if($scope.tripOb.obType==2){
                        updateTrip(data.data);
                    }
                    $scope.tripModalAlert=alert.successAlert( data.message );
                }
                else{
                    $scope.tripModalAlert=alert.errorAlert( data.message );
                }
            })
            .error(function(data, status) {
                $scope.tripModalAlert=alert.errorAlert( $scope.CONSTANTS.NETWORK_ERROR );
            });
    }

    $scope.deleteTrip = function deleteTrip(tripId){
        $scope.alert = alert.successAlert( $scope.CONSTANTS.LOADING );
        $http({
            method:'POST',
            url:'main/deleteTrip',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            transformRequest: function(obj) {
                var str = [];
                for(var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            },
            data:{tripId:tripId}
        })
            .success(function(data, status) {
                if(data.code ==  $scope.CONSTANTS.SUCCESS_CODE ){
                    deleteExistingTrip(tripId);
                    $scope.alert=alert.successAlert( data.message );
                }
                else{
                    $scope.alert=alert.errorAlert( data.message );
                }
            })
            .error(function(data, status) {
                $scope.alert=alert.errorAlert( $scope.CONSTANTS.NETWORK_ERROR );
            });
    }

    $scope.hideAlert=function hideAlert(){
        $scope.alert.show=false;
    }

    $scope.hideTripModalAlert=function hideTripModalAlert(){
        $scope.tripModalAlert.show=false;
    }

    function addNewTrip(trip){
        $scope.trips.push(trip);
    }

    function updateTrip(trip){
        for(i=0;i<$scope.trips.length;i++){
            if($scope.trips[i].tripId == trip.tripId){
                $scope.trips[i]=JSON.parse(JSON.stringify(trip));
            }
        }
    }

    function deleteExistingTrip(tripId){
        var index = -1;
        for(var i=0;i<$scope.trips.length;i++){
            if($scope.trips[i].tripId == tripId){
                index = i;
                break;
            }
        }
        $scope.trips.splice(index,1);
    }

    fetchTrips();
});