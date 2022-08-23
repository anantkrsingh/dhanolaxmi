<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Game Id</th>
                            <th>Time</th>
                            <th>Users</th>
                            <th>Total Bet</th>
                            <th>Winnig Amount</th>
                            <th>User Amount</th>
                            <th>Commission Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($AllGames as $key => $Games) {
                                $bet=0;
                                $users=0;
                                $amt=0;
                                if (!empty($Games->details)) {
                                    foreach ($Games->details as $key1 => $game) {
                                        $bet+= $game->amount;
                                        $users++;
                                        $amt+= $game->winning_amount;
                                    }
                                } ?>
                        <tr>
                            <td><?= $Games->id ?></td>
                            <td><?= date("H:i", strtotime($Games->added_date)) ?></td>
                            <td><u><a href="<?= base_url('backend/AnderBahar/ander_baher_bet/'.$Games->id)?>">
                                        <?= $users ?> </a></u></td>
                            <td><?= $bet ?></td>
                            <td><?= $amt ?></td>
                            <td><?= $Games->user_amount ?></td>
                            <td><?= $Games->comission_amount ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>