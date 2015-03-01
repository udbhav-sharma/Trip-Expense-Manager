/**
 * Created by UDBHAV on 3/1/2015.
 */
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
    $scope.showDetails = false;
    $scope.CONSTANTS=CONSTANTS;
    $scope.alert=alert.initializeAlert();

    $scope.trip = {tripId:'', tripName:'', date:''};
    $scope.members = [];
    $scope.expenses = [];

    $scope.fetchTripData = function fetchTripData(){

        $scope.alert = alert.successAlert( $scope.CONSTANTS.LOADING );
        $http({
            method:'POST',
            url:'getTripData',
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
                console.log(data);
                if(data.code ==  $scope.CONSTANTS.SUCCESS_CODE ){
                    //$scope.alert=alert.successAlert( data.message );
                    $scope.hideAlert();
                    $scope.showDetails=true;
                    $scope.trip = data.data.trip;
                    $scope.members = data.data.members;
                    $scope.expenses = data.data.expenses;
                }
                else{
                    $scope.alert=alert.errorAlert( data.message );
                }
            })
            .error(function(data, status) {
                $scope.alert=alert.errorAlert( $scope.CONSTANTS.NETWORK_ERROR );
            });
        };
    $scope.hideAlert=function hideAlert(){
        $scope.alert.show=false;
    }
});