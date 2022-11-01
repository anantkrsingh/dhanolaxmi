<?php
$actual_link = (($this->input->server('HTTPS') === 'on') ? "https" : "http") . "://" . $this->input->server('HTTP_HOST') . $this->input->server('REQUEST_URI');
$final_url = str_replace(strtolower(base_url()), '', strtolower($actual_link));
?>
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

                <?php if (WITHDRAWL_DASHBOARD==true) { ?>
                <li class="<?= (array_filter([strpos($final_url, "withdrawldashboard")], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/WithdrawlDashboard') ?>" class="waves-effect"><i class="ti-home"></i>
                        <span>Withdrawl Dashboard</span></a></li>
                <?php } ?>

                <?php if (USER_CATEGORY==true) { ?>
                <li><a href="<?= base_url('backend/UserCategory') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>User Category</span></a></li>
                <?php } ?>

              
                <?php if (BANNER==true) { ?>
                <li><a href="<?= base_url('backend/banner') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>Banner</span></a></li>
                <?php } ?>

                <?php if (TEENPATTI==true) { ?>
                <li class="<?= (array_filter([strpos($final_url, "tablemaster"),strpos($final_url, "backend/game"),strpos($final_url, "backend/table"),strpos($final_url, "tablemaster/add"),strpos($final_url, "tablemaster/edit"),strpos($final_url, "backend/robotcards")], 'is_numeric')) ? 'mm-active' : '' ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect" >
                                    <i class="ti-menu"></i>
                                    <span>Teen Patti Mgmt.</span>
                                </a>
                                <ul class="sub-menu mm-collapse">
                                    <li class="<?= (array_filter([strpos($final_url, "tablemaster"),strpos($final_url, "tablemaster/add"),strpos($final_url, "tablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/tableMaster') ?>">Teen Patti Table Master</a></li>
                                   
                <li class="<?= (array_filter([strpos($final_url, "backend/game")], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/Game') ?>" class="waves-effect">
                        <span>Teenpatti History</span></a></li>
                        <li class="<?= (array_filter([strpos($final_url, "backend/table")], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/table') ?>" class="waves-effect"></i>
                        <span>Watch Table Teenpatti</span></a></li>
                        <li class="<?= (array_filter([strpos($final_url, "backend/robotcards")], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/RobotCards') ?>" class="waves-effect"></i>
                        <span>Robot Cards</span></a></li>
                                </ul>
                            </li>
                          
               
             
                            <?php } ?>
                
                <?php if (LUDO==true) { ?>
                <li class="<?= (array_filter([strpos($final_url, "ludotablemaster"),strpos($final_url, "ludohistory"),strpos($final_url, "ludotablemaster/add"),strpos($final_url, "ludotablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect" >
                                    <i class="ti-layout-grid2-alt"></i>
                                    <span>Ludo Management</span>
                                </a>
                                <ul class="sub-menu mm-collapse">
                                    <li class="<?= (array_filter([strpos($final_url, "ludotablemaster"),strpos($final_url, "ludotablemaster/add"),strpos($final_url, "ludotablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/ludoTableMaster') ?>">Ludo Table Master</a></li>
                                   
                                    <li class="<?= (array_filter([strpos($final_url, "ludohistory"),], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/LudoHistory') ?>">Ludo History</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                
                            <?php if (RUMMY_POOL==true) { ?>
                <li class="<?= (array_filter([strpos($final_url, "backend/rummypool"),strpos($final_url, "backend/rummypool"),strpos($final_url, "pooltablemaster/add"),strpos($final_url, "pooltablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect" >
                                    <i class="ti-layout-grid2-alt"></i>
                                    <span>Rummy Pool Mgmt.</span>
                                </a>
                                <ul class="sub-menu mm-collapse">
                                <li class="<?= (array_filter([strpos($final_url, "backend/rummypool")], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/RummyPool') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Pool Table Master</span></a></li>
                                   
                <li class="<?= (array_filter([strpos($final_url, "rummypool"),], 'is_numeric')) ? 'mm-active' : '' ?>"><a href="<?= base_url('backend/RummyPool') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i>
                        <span>Rummy Pool History</span></a></li>
                                </ul>
                            </li>
                            <?php } ?>
                <!-- <?php if (POINT_TABLE_MASTER==true) { ?>
                <li><a href="<?= base_url('backend/rummyTableMaster') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Point Table Master</span></a></li>
                <?php } ?> -->
                <?php if (DEAL_TABLE_MASTER==true) { ?>
                <!-- <li><a href="<?= base_url('backend/dealTableMaster') ?>" class="waves-effect"><i
                            class="ion ion-md-contact"></i>
                        <span>Deal Table Master</span></a></li> -->
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

                <?php if (BACCARAT_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/Baccarat') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Baccarat History</span></a></li>
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

             

                <?php if (RUMMY_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/Rummy') ?>" class="waves-effect"><i class="ion ion-md-list-box"></i>
                        <span>Rummy Point History</span></a></li>
                <?php } ?>

              

                <?php if (RUMMY_DEAL_HISTORY==true) { ?>
                <li><a href="<?= base_url('backend/RummyDeal') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i>
                        <span>Rummy Deal History</span></a></li>
                <?php } ?>
                <?php if (SETTING==true) { ?>
                <li><a href="<?= base_url('backend/setting') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Setting</span></a></li>
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