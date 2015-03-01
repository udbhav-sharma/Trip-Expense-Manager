<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 9:42 PM
 */
?>
<div class="col-md-10 content-div">
    <div class="row">
        <div class="col-md-5">
            <select class="form-control">
                <option value>-- Select Trip --</option>
                <option value="2">Trip to Goa | 2015-03-01</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="text-center">
        <h4>Trip Name</h4>
    </div>
    <br>
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-default"><i class="fa fa-user-plus"></i> New Member</button>
                </div>
            </div>
            <br>
            <div class="table-responsive" style="overflow-y: scroll; height: 500px">
                <table class="table" >
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Members</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody >
                    <tr>
                        <td>1</td>
                        <td>Udbhav</td>
                        <td class="text-center" >
                            <button class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </button>
                            <button class="btn btn-danger btn-sm">
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
                    Total Members : <b>1</b>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-default"><i class="fa fa-rupee"></i> New Expense</button>
                </div>
            </div>
            <br>
            <div class="table-responsive" style="overflow-y: scroll; height: 500px">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Expenses</th>
                        <th>Amount</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for($i=0;$i<100;$i++){?>
                    <tr>
                        <td>1</td>
                        <td>Bus Ticket</td>
                        <td>157</td>
                        <td class="text-center" >
                            <button class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    Total Trip Expense : <b>Rs 2000</b>
                </div>
            </div>
        </div>
    </div>
</div>