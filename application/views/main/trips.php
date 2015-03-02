<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 3:57 PM
 */
?>
<script src="<?php echo base_url().'assets/js/trips.js'?>"></script>

<div class="col-md-8 content-div">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default"  data-toggle="modal" data-target="#genericModal"><i class="fa fa-cab"></i> New Trip</button>
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

<!-- Modal -->
<div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-labelledby="genericModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="row hidden-print">
                <div class="notification-container new-trip-alert" style="display: none">
                    <div class="notification-message">
                        <button type="button" class="close btn-close-alert hidden-print" ><span aria-hidden="true">&times;</span></button>
                        <span class='message'></span>
                    </div>
                </div>
            </div>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="genericModalLabel"> New Trip </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <input type="text" class="form-control" id="tripName" placeholder="Trip Name">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <input type="text" id="tripDate" class="form-control" placeholder="Trip Date">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save">Save changes</button>
            </div>
        </div>
    </div>
</div>