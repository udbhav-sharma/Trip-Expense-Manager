<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 3:57 PM
 */
?>
<?php
//print_r($trips);
?>
<div class="col-md-9 content-div">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default"><i class="fa fa-cab"></i> New Trip</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Trip Name</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach($trips as $trip ){
                ?>
                <tr>
                    <td scope="row"><?php echo ++$i; ?></td>
                    <td><?php echo $trip['date']; ?></td>
                    <td><?php echo $trip['tripName']; ?></td>
                    <td class="text-center">
                        <?php
                        $data = array();
                        $data['tripId'] = $trip['tripId'];
                        ?>
                        <button class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-list-alt"></span>
                        </button>
                        <button class="btn btn-danger btn-sm" data-data=<?php echo json_encode($data)?> >
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>