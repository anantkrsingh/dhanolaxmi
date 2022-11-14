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
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/user"),strpos($final_url, "backend/usercategory"),strpos($final_url, "backend/table"),strpos($final_url, "tablemaster/add"),strpos($final_url, "tablemaster/edit"),strpos($final_url, "backend/robotcards"),strpos($final_url, "backend/table")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ion ion-md-contact"></i>
                        <span>Users Management</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/user")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/user') ?>" class="waves-effect">
                                <span>Users</span></a>
                        </li>
                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/usercategory")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/UserCategory') ?>" class="waves-effect">
                                <span>User Category</span></a>
                        </li>


                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/kyc")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/Kyc') ?>" class="waves-effect"></i>
                                <span>Kyc</span></a>
                        </li>
                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/BankDetails")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/BankDetails') ?>" class="waves-effect"> <span>Bank
                                    Details</span></a>
                        </li>
                    </ul>
                </li>

                <!-- <li><a href="<?= base_url('backend/user') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>User Management</span></a></li> -->
                <?php } ?>

                <?php if (WITHDRAWL_DASHBOARD==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "withdrawldashboard")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="<?= base_url('backend/WithdrawlDashboard') ?>" class="waves-effect"><i class="ti-home"></i>
                        <span>Withdrawl Dashboard</span></a>
                </li>
                <?php } ?>

                <!-- <?php if (USER_CATEGORY==true) { ?>
              
                <?php } ?> -->


                <?php if (BANNER==true) { ?>
                <li><a href="<?= base_url('backend/banner') ?>" class="waves-effect"><i class="ion ion-md-contact"></i>
                        <span>Banner</span></a></li>
                <?php } ?>

                <?php if (TEENPATTI==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "tablemaster"),strpos($final_url, "backend/game"),strpos($final_url, "backend/table"),strpos($final_url, "tablemaster/add"),strpos($final_url, "tablemaster/edit"),strpos($final_url, "backend/robotcards"),strpos($final_url, "backend/table")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Teen Patti Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "tablemaster"),strpos($final_url, "tablemaster/add"),strpos($final_url, "tablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/tableMaster') ?>">Teen Patti Table Master</a>
                        </li>

                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/game")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/Game') ?>" class="waves-effect">
                                <span>Teenpatti History</span></a>
                        </li>
                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/table")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/table') ?>" class="waves-effect"></i>
                                <span>Watch Table Teenpatti</span></a>
                        </li>
                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/table")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/Jackpot') ?>" class="waves-effect"> <span>Jackpot
                                    History</span></a>
                        </li>
                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/robotcards")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/RobotCards') ?>" class="waves-effect"></i>
                                <span>Robot Cards</span></a>
                        </li>
                    </ul>
                </li>



                <?php } ?>

                <?php if (LUDO==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "ludotablemaster"),strpos($final_url, "ludohistory"),strpos($final_url, "ludotablemaster/add"),strpos($final_url, "ludotablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Ludo Management</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "ludotablemaster"),strpos($final_url, "ludotablemaster/add"),strpos($final_url, "ludotablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/ludoTableMaster') ?>">Ludo Table Master</a>
                        </li>

                        <li
                            class="<?= (array_filter([strpos($final_url, "ludohistory"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/LudoHistory') ?>">Ludo History</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (RUMMY_POOL==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/rummypool"),strpos($final_url, "backend/rummypool"),strpos($final_url, "pooltablemaster/add"),strpos($final_url, "pooltablemaster/edit")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Rummy Pool Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "backend/rummypool")], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/RummyPool') ?>" class="waves-effect"><i
                                    class="ion ion-md-contact"></i>
                                <span>Pool Table Master</span></a>
                        </li>

                        <li
                            class="<?= (array_filter([strpos($final_url, "rummypool"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/RummyPool') ?>" class="waves-effect"><i
                                    class="ion ion-md-list-box"></i>
                                <span>Rummy Pool History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (POINT_RUMMY==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/rummy")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Rummy Management</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "rummy"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/Rummy') ?>" class="waves-effect">
                                <span>Rummy Point History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (RUMMY_DEAL==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/rummydeal")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Rummy Deal Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "rummydeal"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/RummyDeal') ?>" class="waves-effect">
                                <span>Rummy Deal History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (ANDER_BAHAR==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/andarbahar")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Andar Bahar Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "andarbahar"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/AnderBahar') ?>" class="waves-effect">
                                <span>Andar Bahar History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (BACCARAT==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/baccarat")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Baccarat Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "baccarat"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/Baccarat') ?>" class="waves-effect">
                                <span>Baccarat History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (DRAGON_TIGER==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/dragontiger")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Dragon Tiger Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "dragontiger"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/DragonTiger') ?>" class="waves-effect">
                                <span>Dragon Tiger History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (SEVEN_UP_DOWN==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/sevenup")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Seven Up Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "sevenup"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/SevenUp') ?>" class="waves-effect">
                                <span>Seven Up History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (CAR_ROULETTE==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/carroulette")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Car Roulette Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "carroulette"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/CarRoulette') ?>" class="waves-effect">
                                <span>Car Roulette History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (COLOR_PREDICTION==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/colorprediction")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Color Prediction Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "colorprediction"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/ColorPrediction') ?>" class="waves-effect">
                                <span>Color Prediction History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (ANIMAL_ROULETTE==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/animalroulette")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Animal Roulette Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "animalroulette"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/AnimalRoulette') ?>" class="waves-effect">
                                <span>Animal Roulette History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (HEAD_TAILS==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/headtails")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Head & Tail Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "headtails"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/HeadTails') ?>" class="waves-effect">
                                <span>Head & Tail History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (RED_VS_BLACK==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/redblack")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Red Vs Black Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "redblack"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/RedBlack') ?>" class="waves-effect">
                                <span>Red Vs Black History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (JHANDI_MUNDA==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/jhandimunda")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Jhandi Munda Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "jhandimunda"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/JhandiMunda') ?>" class="waves-effect">
                                <span>Jhandi Munda History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (ROULETTE==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/roulette")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Roulette Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "roulette"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/Roulette') ?>" class="waves-effect">
                                <span>Roulette History</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (POKER==true) { ?>
                <li
                    class="<?= (array_filter([strpos($final_url, "backend/poker")], 'is_numeric')) ? 'mm-active' : '' ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-layout-grid2-alt"></i>
                        <span>Poker Mgmt.</span>
                    </a>
                    <ul class="sub-menu mm-collapse">
                        <li
                            class="<?= (array_filter([strpos($final_url, "poker"),], 'is_numeric')) ? 'mm-active' : '' ?>">
                            <a href="<?= base_url('backend/Pokers') ?>" class="waves-effect">
                                <span>Poker History</span></a>
                        </li>
                    </ul>
                </li>
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

                <!-- <?php if (COMISSION==true) { ?>
                <li><a href="<?= base_url('backend/Comission') ?>" class="waves-effect"><i
                            class="ion ion-md-list-box"></i> <span>Comission</span></a></li>
                <?php } ?> -->

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