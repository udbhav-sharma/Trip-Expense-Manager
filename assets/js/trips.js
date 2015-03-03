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

    $scope.getTripOb = function getTripOb(obType,tripId){
        $scope.alert = alert.successAlert( $scope.CONSTANTS.LOADING );
        $scope.showGraph = false;
        $scope.tripOb = {tripId:'',tripName:'',tripDate:''};

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

    $scope.hideAlert=function hideAlert(){
        $scope.alert.show=false;
    }

});