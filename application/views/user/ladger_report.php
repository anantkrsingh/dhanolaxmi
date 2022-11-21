<div class="row">

    <div class="col-12">
        <div class="card">
        <div  style="display: flex;margin-left: auto;margin-right: 26px;margin-top: 15px;">
   
   <lable class="font-14" style="padding: 0px 10px;font-weight:bold">Wallet:</lable> <?= !empty($AllReports[0]->user_wallet)?$AllReports[0]->user_wallet:0 ?>
</div>
            <div class="card-body">

                <table class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Source</th>
                            <th>Game Id</th>
                            <!-- <th>Before Wallet</th> -->
                            <!-- <th>Amount</th> -->
                            <th>Wallet</th>
                            <th>Added Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                              
                              $total = !empty($AllReports[0]->user_wallet)?$AllReports[0]->user_wallet:0;
                              $i = 0;
                                foreach ($AllReports as $key => $record) {
                                    $amount = $record->user_amount-$record->amount;
                                      
                                    $i++;
                                ?>
                                <tr>

                                    <td><?= $i ?></td>
                                    <td><?= $record->game ?></td>
                                    <td><?= '#'.$record->reff_id ?></td>
                                    <!-- <td><?= $total-$amount ?></td> -->
                                    <!-- <td><?= ($amount<0)?'<span style="color:red">'.$amount.'</span>':'<span style="color:green">'.$amount.'</span>'; ?></td> -->
                                    <td>&#x20B9 <?= $total."(".(($amount<0)?'<span style="color:red">'.$amount.'</span>':'<span style="color:green">+'.$amount.'</span>').")" ?></td>
                                    <td><?= date("d-m-Y h:i A", strtotime($record->added_date)) ?></td>
                                </tr>
                                <?php 
                                $total=$total-$amount;}
                                ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<script>
function ChangeStatus(id, status) {
    jQuery.ajax({
        url: "<?= base_url('backend/user/ChangeStatus') ?>",
        type: "POST",
        data: {
            'id': id,
            'status': status
        },
        success: function(data) {
            if (data) {
                alert('Successfully Change status');
            }
            location.reload();
        }
    });
}



$(document).ready(function() {
    $(".table").DataTable({
        "bPaginate": false
    //     pageLength: 10,
    //     dom: 'Bfrtip',
    //     "buttons": [
    //         'excel'
    //     ]

    // });
    // $.fn.dataTable.ext.errMode = 'throw';
    // $(".table").DataTable({
    //     // stateSave: true,
    //     searchDelay: 1000,
    //     processing: true,
    //     serverSide: true,
    //     scrollX: true,
    //     serverMethod: 'post',
    //     ajax: {
    //         url: "<?= base_url('backend/user/GetLadgerReports/'.$id) ?>"
    //     },
    //     columns: [{
    //             data: 'id',

    //         },
    //         {
    //             data: 'game'
    //         },
    //         {
    //             data: 'amount'
    //         },
    //         // {
    //         //     data: 'winning_amount'
    //         // },
           
    //         {
    //             data: 'wallet'
    //         },
    //         {
    //             data: 'added_date'
    //         },
    //     ],

    //     lengthMenu: [
    //         [10, 50, 100, 200, -1],
    //         [10, 50, 100, 200, "All"]
    //     ],
    //     pageLength: 10,
    //     dom: 'Bfrtip',
    //     "buttons": [
    //         'excel'
    //     ]

    });
});
</script>