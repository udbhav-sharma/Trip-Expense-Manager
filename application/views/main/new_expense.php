<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/2/2015
 * Time: 11:52 AM
 */
?>
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
            <?php foreach($members as $member){ ?>
            <tr>
                <td><?php echo $member['memberName']; ?></td>
                <td class="text-center">
                    <input type="checkbox" value="" checked>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-7">
        <div class="radio">
            <label>
                <input type="radio" name="expenseOption" value="1" checked>
                Total Expense
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="expenseOption" value="2">
                For Each Selected Member
            </label>
        </div>
        <hr>

        <div class="row form-group">
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Expense Name">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Amount">
            </div>
        </div>

    </div>
</div>