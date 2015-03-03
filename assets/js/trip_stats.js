/**
 * Created by UDBHAV on 3/3/2015.
 */

var app = angular.module('tripStatsManager',['alert_module']).
    constant(
    "CONSTANTS",{
        SUCCESS_CODE: 1,
        ERROR_CODE: 0,
        NETWORK_ERROR: 'Some Error occurred! Please reload/refresh the page and try again.',
        DELETE_CONFIRMATION: 'Do you really want to delete this?',
        LOADING: 'Loading...'
    }
);

app.controller('tripStats',function($scope, CONSTANTS, $http, alert){
    $scope.CONSTANTS=CONSTANTS;
    $scope.alert=alert.initializeAlert();

    $scope.fetchTripStats = function fetchTripStats(){

        $scope.alert = alert.successAlert( $scope.CONSTANTS.LOADING );
        $scope.showGraph = false;
        $scope.trip = {tripId:'',tripName:'',tripDate:''};

        $http({
            method:'POST',
            url:'getTripExpensesStats',
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
                    $scope.trip = data.data.trip;
                    plotGraph(data.data.graphData);
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

    function plotGraph(data){
        $('status-bar').html('');
        Morris.Line({
            element: 'status-bar',
            data: data,
            xkey: 'date',
            ykeys: ['amount'],
            labels: ['Expenses']
        });
    }

});