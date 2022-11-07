<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>User Name</th>
                            <th>Bank Name</th>
                            <th>IFSC Code</th>
                            <th>Account Holder Name</th>
                            <th>Account Number</th>
                            <th>Passbook</th>
                            <th>Added Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($AllBankDetails as $key => $bank) {
                            $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $bank->user_name ?></td>
                            <td><?= $bank->bank_name ?></td>
                            <td><?= $bank->ifsc_code ?></td>
                            <td><?= $bank->acc_holder_name ?></td>
                            <td><?= $bank->acc_no ?></td>
                            <td><img src="<?= base_url('data/post/' . strtolower($bank->passbook_img)); ?>" height="160px" width="300px"></td>
                            <td><?= date("d-m-Y h:i A", strtotime($bank->added_date)) ?></td>
                             <td>
                                | <a href="<?= base_url('backend/BankDeatails/delete/' . $bank->id) ?>"
                                    class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                    title="Delete"><span class="fa fa-times"></span></a>
                            </td>
                         
                        </tr>
                        <?php }
                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>

<script>

function ChangeWithDrawalStatus(id, status) {
    jQuery.ajax({
        url: "<?= base_url('backend/Kyc/ChangeStatus') ?>",
        type: "POST",
        data: {
            'id': id,
            'status': status
        },
        success: function(data) {
            var response = JSON.parse(data)
            if (response == true) {
                toastr.success("Status Updated Successfully");
            } else {
                toastr.error("Something Went Wrnog.");
            }

            setTimeout(function() {
                location.reload()
            }, 1000);
        }
    });
}

    $(".back").on("click", function(event) {
        location.reload()
    })
</script>