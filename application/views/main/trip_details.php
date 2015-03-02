<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 9:42 PM
 */
?>

<script src="<?php echo base_url().'assets/js/trip_details.js'?>"></script>

<div class="col-md-10 content-div" ng-app="tripManager" ng-controller="trip">
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
            <button type="button" class="btn btn-primary" ng-click="fetchTripData()" ><i class="fa fa-refresh"></i> Refresh</button>
        </div>
    </div>
    <hr>
    <div class="text-center" ng-show="showDetails">
        <h4>{{trip.tripName}}</h4>
    </div>
    <br>
    <div class="row" ng-show="showDetails">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-default" disabled><i class="fa fa-user-plus"></i> New Member</button>
                </div>
            </div>
            <br>
            <div class="table-responsive" style="overflow-y: scroll; height: 500px">
                <table class="table table-striped" >
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Members</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody >
                    <tr ng-repeat="member in members">
                        <td>{{$index+1}}</td>
                        <td>{{member.memberName}}</td>
                        <td class="text-center" >
                            <button type="button" class="btn btn-primary btn-sm" disabled>
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" disabled>
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    Total Members : <b>{{members.length}}</b>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#expenseModal" ng-click="getExpenseOb(1,-1)">
                        <i class="fa fa-rupee"></i> New Expense
                    </button>
                </div>
            </div>
            <br>
            <div class="table-responsive" style="overflow-y: scroll; height: 500px">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Expenses</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="expense in expenses">
                        <td>{{$index+1}}</td>
                        <td>{{expense.expenseName}}</td>
                        <td>{{expense.date}}</td>
                        <td>{{expense.amount}}</td>
                        <td class="text-center" >
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#expenseModal" ng-click="getExpenseOb(2, expense.expenseId)">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" disabled>
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    Total Trip Expense : <b ng-bind="calculateTotalExpense()"></b>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="row hidden-print">
                    <div class="notification-container" ng-show="expenseModalAlert.show">
                        <div class="notification-message">
                            <button type="button" class="close" ng-click="hideExpenseModalAlert()" ><span aria-hidden="true">&times;</span></button>
                            <span class='message'>{{expenseModalAlert.message}}</span>
                        </div>
                    </div>
                </div>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="expenseModalLabel"> New Expense </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5" style="overflow-y: scroll; height:400px">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Member</th>
                                    <th class="text-center">Selected</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="member in expenseOb.members">
                                        <td>{{member.memberName}}</td>
                                        <td class="text-center">
                                            <input type="checkbox" ng-model="member.flag">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="expenseOption" ng-model="expenseOb.expenseOption" value="1">
                                    Total Expense
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="expenseOption" ng-model="expenseOb.expenseOption" value="2">
                                    For Each Selected Member
                                </label>
                            </div>
                            <hr>
                            <div class="row form-group">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" ng-model="expenseOb.expenseName" placeholder="Expense Name">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-10">
                                    <input type="text" id="expenseDate" class="form-control" ng-model="expenseOb.expenseDate" placeholder="Enter Date">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" ng-model="expenseOb.amount" placeholder="Amount">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" ng-click="saveExpense()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
</div>
<script>
    $("#expenseDate").datepicker();
</script>