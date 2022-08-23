<!-- Top Bar End -->
<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu" style="background-image: url('<?= base_url('assets/images/sp_bg.png') ?>');">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">

                <li><a href="<?= base_url('backend/dashboard/admin') ?>" class="waves-effect"><i class="ti-home"></i>
                        <span>Dashboard</span></a></li>
                <li class="menu-title">Content</li>
                <?php if (USER_MANAGEMENT==true) { ?>
                <li><a href="<?= base_url('backend/user') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>User Management</span></a></li>
                <?php } ?>

                <?php if (WATCH_TABLE_TEEN_PATTI==true) { ?>
                <li><a href="<?= base_url('backend/table') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>Watch Table Teenpatti</span></a></li>
                <?php } ?>

                <?php if (BANNER==true) { ?>
                <li><a href="<?= base_url('backend/banner') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>Banner</span></a></li>
                <?php } ?>

                <?php if (USER_MANAGEMENT==true) { ?>
                <li><a href="<?= base_url('backend/tableMaster') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Teen Patti Table Master</span></a></li>
                <?php } ?>

                <?php if (POINT_TABLE_MASTER==true) { ?>
                <li><a href="<?= base_url('backend/rummyTableMaster') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Point Table Master</span></a></li>
                <?php } ?>

                <?php if (POOL_TABLE_MASTER==true) { ?>
                <li><a href="<?= base_url('backend/poolTableMaster') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Pool Table Master</span></a></li>
                <?php } ?>

                <?php if (DEAL_TABLE_MASTER==true) { ?>
                <li><a href="<?= base_url('backend/dealTableMaster') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Deal Table Master</span></a></li>
                <?php } ?>

                <?php if (ANDER_BAHAR_TABLE_MASTER==true) { ?>
                <!-- <li><a href="<?= base_url('backend/anderbaharTableMaster') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Ander Bahar Table Master</span></a></li> -->
                <?php } ?>

                <?php if (CHIPS_MANAGEMENT==true) { ?>
                <li><a href="<?= base_url('backend/chips') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>Chips Management</span></a></li>
                <?php } ?>

                <?php if (GIFT_MANAGEMENT==true) { ?>
                <li><a href="<?= base_url('backend/gift') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i><span>Gift Management</span></a></li>
                <?php } ?>

                <?php if (PURCHASE_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/Purchase') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i> <span>Purchase History</span></a></li>
                <?php } ?>

                <?php if (LEAD_BOARD==true) { ?>
                <li><a href="<?= base_url('backend/Game/Leaderboard') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i> <span>Leadboard</span></a></li>
                <?php } ?>

                <?php if (NOTIFICATION==true) { ?>
                <li><a href="<?= base_url('backend/notification') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Notification</span></a></li>
                <?php } ?>

                <?php if (WELCOME_BONUS==true) { ?>
                <li><a href="<?= base_url('backend/welcomebonus') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Welcome Bonus</span></a></li>
                <?php } ?>

                <?php if (SETTING==true) { ?>
                <li><a href="<?= base_url('backend/setting') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Setting</span></a></li>
                <?php } ?>

                <?php if (REEDEM_MANAGEMENT==true) { ?>
                <li><a href="<?= base_url('backend/WithdrawalLog/ReedemNow') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Reedem Management</span></a></li>
                <?php } ?>

                <?php if (WITHDRAWAL_LOG==true) { ?>
                <li><a href="<?= base_url('backend/WithdrawalLog') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Withdrawal Log</span></a></li>
                <?php } ?>

                <?php if (COMISSION==true) { ?>
                <li><a href="<?= base_url('backend/Comission') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Comission</span></a></li>
                <?php } ?>

                <?php if (ANDER_BAHAR_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/AnderBahar') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Ander Bahar History</span></a></li>
                <?php } ?>

                <?php if (DRAGON_TIGER_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/DragonTiger') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Dragon Tiger History</span></a></li>
                <?php } ?>

                <?php if (SEVEN_UP_DOWN_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/SevenUp') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Seven Up History</span></a></li>
                <?php } ?>

                <?php if (CAR_ROULETTE_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/CarRoulette') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Car Roulette History</span></a></li>
                <?php } ?>

                <?php if (COLOR_PREDICTION_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/ColorPrediction') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Color Prediction History</span></a></li>
                <?php } ?>

                <?php if (JACKPOT_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/Jackpot') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Jackpot History</span></a></li>
                <?php } ?>

                <?php if (ANIMAL_ROULETTE_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/AnimalRoulette') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Animal Roulette History</span></a></li>
                <?php } ?>

                <?php if (TEENPATTI_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/Game') ?>" class="waves-effect"><i class="ion ion-md-list-box"></i>
                        <span>Teenpatti History</span></a></li>
                <?php } ?>

                <?php if (RUMMY_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/Rummy') ?>" class="waves-effect"><i class="ion ion-md-list-box"></i>
                        <span>Rummy Point History</span></a></li>
                <?php } ?>

                <?php if (RUMMY_POOL_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/RummyPool') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i>
                        <span>Rummy Pool History</span></a></li>
                <?php } ?>

                <?php if (RUMMY_DEAL_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/RummyDeal') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i>
                        <span>Rummy Deal History</span></a></li>
                <?php } ?>

            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title"><?= $title ?></h4>

                    </div>
                    <div class="col-sm-6">
                        <div class="float-right d-md-block">
                            <?php

                     if (isset($SideBarbutton) && isset($SideBarbutton[1])) {
                         ?>

                            <a href="<?= base_url($SideBarbutton[0]) ?>"
                                class="btn btn-primary btn-lg btn-dashboard custom-btn">
                                <?= $SideBarbutton[1] ?></a>

                            <?php
                     } ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->