<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>No. of Participant</th>
                            <th>Registration Fee</th>
                            <th>First Price</th>
                            <th>Second Price</th>
                            <th>Third Price</th>
                            <th>Start Time</th>
                            <th>Added Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($AllTournaments as $key => $Tournament) {
                            $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $Tournament->name ?></td>
                            <td><?= $Tournament->no_of_participant ?></td>
                            <td><?= $Tournament->registration_fee ?></td>
                            <td><?= $Tournament->first_price ?></td>
                            <td><?= $Tournament->second_price ?></td>
                            <td><?= $Tournament->third_price ?></td>
                            <td><?= $Tournament->start_time ?></td>
                            <td><?= date("d-m-Y", strtotime($Tournament->added_date)) ?></td>
                            <td>
                                <a href="<?= base_url('backend/RummyTournaMent/edit/' . $Tournament->id) ?>"
                                    class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Edit"><span
                                        class="fa fa-edit"></span></a>
                                | <a href="<?= base_url('backend/RummyTournaMent/delete/' . $Tournament->id) ?>"
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