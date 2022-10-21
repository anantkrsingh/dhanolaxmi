<?php

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Users_model',
            'Game_model',
            'Setting_model',
            'AnderBahar_model',
            'AnimalRoulette_model',
            'DragonTiger_model',
            'Jackpot_model',
            'CarRoulette_model',
            'ColorPrediction_model',
            'SevenUp_model',
            'RummyPool_model',
            'RummyDeal_model',
            'Rummy_model',
            'Poker_model',
            'HeadTail_model',
            'RedBlack_model'
        ]);
    }

    public function cron_draw()
    {
        $tables = $this->Game_model->getActiveTable();
        // print_r($tables);

        foreach ($tables as $val) {
            $chaal = 0;
            $game = $this->Game_model->getActiveGameOnTable($val->table_id);
            // print_r($game);
            if ($game) {
                $game_log = $this->Game_model->GameLog($game->id, 1);
                $time = time()-strtotime($game_log[0]->added_date);
                print_r($game_log);
                if ($time>35) {
                    $game_users = $this->Game_model->GameAllUser($game->id);


                    $element = 0;
                    foreach ($game_users as $key => $value) {
                        if ($value->user_id==$game_log[0]->user_id) {
                            $element = $key;
                            break;
                        }
                    }

                    $index = 0;
                    foreach ($game_users as $key => $value) {
                        $index = ($key+$element)%count($game_users);
                        if ($key>0) {
                            if (!$game_users[$index]->packed) {
                                $chaal = $game_users[$index]->user_id;
                                break;
                            }
                        }
                    }
                }
                // echo $chaal;
                if ($chaal!=0) {
                    $this->Game_model->PackGame($chaal, $game->id, 1);
                    $game_users = $this->Game_model->GameUser($game->id);

                    if (count($game_users)==1) {
                        $comission = $this->Setting_model->Setting()->admin_commission;
                        $this->Game_model->MakeWinner($game->id, $game->amount, $game_users[0]->user_id, $comission);

                        $user = $this->Users_model->UserProfile($game_users[0]->user_id);
                        if ($user[0]->user_type==1) {
                            $table_user_data = [
                                'table_id' => $val->table_id,
                                'user_id' => $user[0]->id
                            ];

                            $this->Game_model->RemoveTableUser($table_user_data);
                        }
                    }

                    $table_user_data = [
                        'table_id' => $val->table_id,
                        'user_id' =>$chaal
                    ];

                    $this->Game_model->RemoveTableUser($table_user_data);
                }
            }

            echo '<br>Success';
        }
    }

    public function cron_rummy_draw()
    {
        $tables = $this->Rummy_model->getActiveTable();
        // print_r($tables);

        foreach ($tables as $val) {
            $game = $this->Rummy_model->getActiveGameOnTable($val->rummy_table_id);
            if ($game) {
                $chaal = 0;
                $user_type = 0;
                $declare_count = 0;

                $game_log = $this->Rummy_model->GameLog($game->id, 1);
                $time = time()-strtotime($game_log[0]->added_date);

                $game_users = $this->Rummy_model->GameAllUser($game->id);

                $element = 0;
                foreach ($game_users as $key => $value) {
                    if ($value->user_id==$game_log[0]->user_id) {
                        $element = $key;
                        break;
                    }
                }

                $index = 0;
                foreach ($game_users as $key => $value) {
                    $index = ($key+$element)%count($game_users);
                    if ($key>0) {
                        if (!$game_users[$index]->packed) {
                            $chaal = $game_users[$index]->user_id;
                            $user_type = $game_users[$index]->user_type;
                            break;
                        }
                    }
                }
                $given_time = ($user_type==0) ? 65 : 10;

                if ($time>$given_time) {
                    if ($user_type==1) {
                        $bot_chaal = $this->Rummy_model->ChaalCount($game->id, $value->user_id);
                        if ($bot_chaal>3) {
                            $combination_json[] = '[{"card_group":"6","cards":["BLK","RSK","RP4_"]},{"card_group":"5","cards":["BP10_","BP9","BP8"]},{"card_group":"4","cards":["RS3_","RS2_","JKR2","RP4"]},{"card_group":"6","cards":["JKR1","RP8_","RS8"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS9_","BL9_","BP9"]},{"card_group":"4","cards":["RPA_","RP4_","RP3","RP2"]},{"card_group":"4","cards":["BLA","BLK_","BLQ_"]},{"card_group":"5","cards":["RPQ","RPJ","RP10_"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS6_","RP6_","BP6"]},{"card_group":"5","cards":["RPA_","RP4_","RP3","RP2"]},{"card_group":"4","cards":["BP4_","BP3_","JKR2"]},{"card_group":"5","cards":["BL8_","BL7_","BL6_"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS2_","BL2_","BP2","RP2_"]},{"card_group":"6","cards":["RS4_","BP4","RP4_"]},{"card_group":"5","cards":["RP7_","RP6_","RP5_"]},{"card_group":"4","cards":["BL5","BL4_","BL3"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS2_","BL2_","BP2","RP2_"]},{"card_group":"6","cards":["RS4_","BP4","RP4_"]},{"card_group":"5","cards":["RP7_","RP6_","RP5_"]},{"card_group":"4","cards":["BL5","BL4_","BL3"]}]';
                            $bot_combination_json = $combination_json[array_rand($combination_json)];
                            // $combination = json_decode($combination_json);
                            $data_declare = [
                                'user_id' => $value->user_id,
                                'game_id' => $game->id,
                                'points' => 0,
                                'actual_points' => 0,
                                'json' => $bot_combination_json
                            ];
                            $this->Rummy_model->Declare($data_declare);
                            continue;
                        }
                    }

                    if ($game_log[0]->action==3) {
                        $game_active_users = $this->Rummy_model->GameUser($game->id);

                        foreach ($game_active_users as $key => $value) {
                            $json_arr = $this->Rummy_model->GameLog($game->id, 1, 2, $value->user_id);

                            if ($json_arr) {
                                $already_declare = $this->Rummy_model->GameLog($game->id, 1, 3, $value->user_id);

                                if (!$already_declare) {
                                    $json = $json_arr[0]->json;
                                    $arr = json_decode($json);
                                    $points = 40;
                                    // $wrong = 0;

                                    $table = $this->Rummy_model->isTableAvail($val->rummy_table_id);
                                    $actual_points = $points*round($table->boot_value/80, 2);

                                    $data_log = [
                                        'user_id' => $value->user_id,
                                        'game_id' => $game->id,
                                        'table_id' => $val->rummy_table_id,
                                        'points' => $points,
                                        'actual_points' => $actual_points,
                                        'json' => $json
                                    ];
                                    $this->Rummy_model->Declare($data_log);
                                }

                                $declare_log = $this->Rummy_model->GameLog($game->id, '', 3);
                                $declare_count = count($declare_log);
                                // $remain_game_users = $this->Rummy_model->GameUser($game->id);
                                if (count($game_active_users)<=$declare_count) {
                                    // $amount = 0;
                                    $game = $this->Rummy_model->getActiveGameOnTable($val->rummy_table_id);
                                    $comission = $this->Setting_model->Setting()->admin_commission;
                                    $this->Rummy_model->MakeWinner($game->id, $game->amount, $declare_log[$declare_count-1]->user_id, $comission);
                                }
                            }
                        }

                        continue;
                    }

                    $table = $this->Rummy_model->isTableAvail($val->rummy_table_id);
                    $boot_value = $table->boot_value;
                    $ChaalCount = $this->Rummy_model->ChaalCount($game->id, $chaal);

                    $percent = ($ChaalCount>0) ? CHAAL_PERCENT : NO_CHAAL_PERCENT;
                    $amount = round(($percent / 100) * $boot_value, 2);

                    $this->Rummy_model->PackGame($chaal, $game->id, 0, '', $amount, $percent);
                    $this->Rummy_model->MinusWallet($chaal, $amount);
                    $game_users = $this->Rummy_model->GameUser($game->id);

                    if (count($game_users)==1) {
                        $game = $this->Rummy_model->getActiveGameOnTable($val->rummy_table_id);
                        $comission = $this->Setting_model->Setting()->admin_commission;
                        $this->Rummy_model->MakeWinner($game->id, $game->amount, $game_users[0]->user_id, $comission);
                        // $this->Rummy_model->MakeWinner($game->id,$amount,$game_users[0]->user_id);
                    }

                    $table_user_data = [
                            'table_id' => $val->rummy_table_id,
                            'user_id' =>$chaal
                    ];

                    $this->Rummy_model->RemoveTableUser($table_user_data);

                    // // if ($declare_count>0) {
                    // $cards = $this->Rummy_model->getMyCards($game->id, $chaal);

                    // if (count($cards)<=13) {
                    //     $random_card = $this->Rummy_model->GetRamdomGameCard($game->id);

                    //     if ($random_card) {
                    //         $table_user_data = [
                    //                 'game_id' => $game->id,
                    //                 'user_id' => $chaal,
                    //                 'card' => $random_card[0]->cards,
                    //                 'added_date' => date('Y-m-d H:i:s'),
                    //                 'updated_date' => date('Y-m-d H:i:s'),
                    //                 'isDeleted' => 0
                    //             ];

                    //         $this->Rummy_model->GiveGameCards($table_user_data);
                    //     }
                    // }

                    // $user_card = $this->Rummy_model->GameUserCard($game->id, $chaal);
                    // if (!empty($user_card)) {
                    //     $json_arr = $this->Rummy_model->GameLog($game->id, 1, 2, $chaal);
                    //     $json = (empty($json_arr)) ? '' : $json_arr[0]->json;

                    //     // Joker Card Code
                    //     // $joker_num = substr(trim($game->joker,'_'), 2);
                    //     // $card_num = substr(trim($user_card->card,'_'), 2);
                    //     // $card = "";

                    //     // if($joker_num==$card_num)
                    //     // if ($user_card->card=='JKR1' || $user_card->card=='JKR2') {
                    //     //     $arr = json_decode($json);

                    //     //     $final_arr = array();

                    //     //     $card_json = array();
                    //     //     foreach ($arr as $key => $value) {
                    //     //         if (empty($card) && $value->card_group==0) {
                    //     //             $card = $value->cards[0];
                    //     //             //var_dump($value->cards);
                    //     //             $card_json['card_group'] = "0";
                    //     //             $card_json['cards'][0] = $user_card->card;
                    //     //             $final_arr[] = $card_json;
                    //     //             continue;
                    //     //         }

                    //     //         $final_arr[] = $value;
                    //     //     }
                    //     //     $json =  json_encode($final_arr);
                    //     // }

                    //     $card = (!empty($card)) ? $card : $user_card->card;

                    //     $table_user_data = [
                    //             'game_id' => $game->id,
                    //             'user_id' => $chaal,
                    //             'card' => $card
                    //         ];

                    //     $this->Rummy_model->DropGameCards($table_user_data, $json);
                    // }

                    // // $table = $this->Rummy_model->isTableAvail($val->rummy_table_id);
                    // // $boot_value = $table->boot_value;
                    // // $ChaalCount = $this->Rummy_model->ChaalCount($game->id, $chaal);

                    // // $percent = ($ChaalCount>0)?CHAAL_PERCENT:NO_CHAAL_PERCENT;
                    // // $amount = round(($percent / 100) * $boot_value,2);

                    // // $this->Rummy_model->PackGame($chaal,$game->id,0,'',$amount,$percent);
                    // // $this->Rummy_model->MinusWallet($chaal,$amount);
                    // // $game_users = $this->Rummy_model->GameUser($game->id);

                    // // if(count($game_users)==1)
                    // // {
                    //     //     $game = $this->Rummy_model->getActiveGameOnTable($val->rummy_table_id);
                    //     //     $comission = $this->Setting_model->Setting()->admin_commission;
                    //     //     $this->Rummy_model->MakeWinner($game->id,$game->amount,$game_users[0]->user_id,$comission);
                    //     //     // $this->Rummy_model->MakeWinner($game->id,$amount,$game_users[0]->user_id);
                    // // }

                    // // $table_user_data = [
                    //     //     'table_id' => $val->rummy_table_id,
                    //     //     'user_id' =>$chaal
                    // // ];

                    // // $this->Rummy_model->RemoveTableUser($table_user_data);
                    // // }
                }
            }

            echo '<br>Success';
        }
    }

    public function cron_rummy_pool_draw()
    {
        $tables = $this->RummyPool_model->getActiveTable();

        foreach ($tables as $val) {
            $game = $this->RummyPool_model->getActiveGameOnTable($val->rummy_pool_table_id);
            if ($game) {
                $chaal = 0;
                $isChaal = false;
                $game_log = $this->RummyPool_model->GameLog($game->id, 1);
                $time = time()-strtotime($game_log[0]->added_date);

                $game_users = $this->RummyPool_model->GameAllUser($game->id);

                $element = 0;
                foreach ($game_users as $key => $value) {
                    if ($value->user_id==$game_log[0]->user_id) {
                        $element = $key;
                        break;
                    }
                }

                $index = 0;
                foreach ($game_users as $key => $value) {
                    $index = ($key+$element)%count($game_users);
                    if ($key>0) {
                        if (!$game_users[$index]->packed) {
                            $chaal = $game_users[$index]->user_id;
                            $user_type = $game_users[$index]->user_type;
                            break;
                        }
                    }
                }
                $given_time = ($user_type==0) ? 32 : 1;

                if ($time>$given_time) {
                    $table_user_data = [
                        'table_id' => $val->rummy_pool_table_id,
                        'user_id' => $chaal
                    ];

                    $this->RummyPool_model->RemoveTableUser($table_user_data);
                    $this->RummyPool_model->PackGame($chaal, $game->id);
                    $game_users = $this->RummyPool_model->GameUser($game->id);

                    if (count($game_users)==1) {
                        $comission = $this->Setting_model->Setting()->admin_commission;

                        $TotalAmount = $this->RummyPool_model->TotalAmountOnTable($val->rummy_pool_table_id);

                        $admin_winning_amt = round($TotalAmount * round($comission/100, 2));
                        $user_winning_amt = round($TotalAmount - $admin_winning_amt, 2);

                        $this->RummyPool_model->MakeWinner($game->id, 0, $game_users[0]->user_id, $admin_winning_amt);
                        $this->RummyPool_model->updateTotalWinningAmtTable($TotalAmount, $user_winning_amt, $admin_winning_amt, $val->rummy_pool_table_id, $game_users[0]->user_id);
                        $this->RummyPool_model->AddToWallet($user_winning_amt, $game_users[0]->user_id);
                    }
                }
            }

            // echo '<br>Success';
        }
    }

    public function cron_rummy_deal_draw()
    {
        $tables = $this->RummyDeal_model->getActiveTable();

        foreach ($tables as $val) {
            $game = $this->RummyDeal_model->getActiveGameOnTable($val->rummy_deal_table_id);
            if ($game) {
                $chaal = 0;
                $isChaal = false;
                $game_log = $this->RummyDeal_model->GameLog($game->id, 1);
                $time = time()-strtotime($game_log[0]->added_date);

                $game_users = $this->RummyDeal_model->GameAllUser($game->id);

                $element = 0;
                foreach ($game_users as $key => $value) {
                    if ($value->user_id==$game_log[0]->user_id) {
                        $element = $key;
                        break;
                    }
                }

                $index = 0;
                foreach ($game_users as $key => $value) {
                    $index = ($key+$element)%count($game_users);
                    if ($key>0) {
                        if (!$game_users[$index]->packed) {
                            $chaal = $game_users[$index]->user_id;
                            $user_type = $game_users[$index]->user_type;
                            break;
                        }
                    }
                }
                $given_time = ($user_type==0) ? 32 : 1;

                if ($time>$given_time) {
                    $table_user_data = [
                        'table_id' => $val->rummy_deal_table_id,
                        'user_id' => $chaal
                    ];

                    $this->RummyDeal_model->RemoveTableUser($table_user_data);
                    $this->RummyDeal_model->PackGame($chaal, $game->id);
                    $game_users = $this->RummyDeal_model->GameUser($game->id);

                    if (count($game_users)==1) {
                        $comission = $this->Setting_model->Setting()->admin_commission;

                        $TotalAmount = $this->RummyDeal_model->TotalAmountOnTable($val->rummy_deal_table_id);

                        $admin_winning_amt = round($TotalAmount * round($comission/100, 2));
                        $user_winning_amt = round($TotalAmount - $admin_winning_amt, 2);

                        $this->RummyDeal_model->MakeWinner($game->id, 0, $game_users[0]->user_id, $admin_winning_amt);
                        $this->RummyDeal_model->updateTotalWinningAmtTable($TotalAmount, $user_winning_amt, $admin_winning_amt, $val->rummy_deal_table_id, $game_users[0]->user_id);
                        $this->RummyDeal_model->AddToWallet($user_winning_amt, $game_users[0]->user_id);
                    }
                }
            }

            echo '<br>Success';
        }
    }

    public function all()
    {
        echo 'Date '.date('Y-m-d H:i:s').PHP_EOL;
        $room_data = $this->AnderBahar_model->getRoom();
        // print_r($room_data);
        if ($room_data) {
            $limit = 1;
            foreach ($room_data as $key => $room) {
                $game_data = $this->AnderBahar_model->getActiveGameOnTable($room->id);
                // print_r($game_data);
                if (!$game_data) {
                    $card = $this->AnderBahar_model->GetCards($limit)[0]->cards;
                    $this->AnderBahar_model->Create($room->id, $card);

                    echo 'First Ander Baher Game Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        $min = 1;
                        $max = 50;

                        $AnderBetAmount = $this->AnderBahar_model->TotalBetAmount($game_data[0]->id, ANDER);
                        $BaharBetAmount = $this->AnderBahar_model->TotalBetAmount($game_data[0]->id, BAHAR);
                        $winning = ($AnderBetAmount>$BaharBetAmount) ? BAHAR : ANDER; //0=ander,1=bahar
                        $exit = false;
                        do {
                            $number = rand($min, $max);
                            if ($winning==1) {
                                $exit = ($number % 2 != 0);
                            } else {
                                $exit = ($number % 2 == 0);
                            }
                        } while (!$exit);

                        $card_num = substr($game_data[0]->main_card, 2);
                        $middle_cards = $this->AnderBahar_model->GetCards($number, $card_num);
                        $alt_card = $this->AnderBahar_model->GetCards($limit, $game_data[0]->main_card, $card_num)[0]->cards;

                        foreach ($middle_cards as $key => $value) {
                            $this->AnderBahar_model->CreateMap($game_data[0]->id, $value->cards);
                        }
                        $this->AnderBahar_model->CreateMap($game_data[0]->id, $alt_card);

                        // Give winning Amount to user
                        $multiply = ($winning==ANDER) ? 1.85 : 1.95; //ander=1.97,bahar=1.98
                        $bets = $this->AnderBahar_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            // print_r($bets);
                            foreach ($bets as $key => $value) {
                                $this->AnderBahar_model->MakeWinner($value->user_id, $value->id, $value->amount*$multiply, $comission, $game_data[0]->id);
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        // $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+ '.(count($middle_cards)+5).'seconds'));
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.(round(count($middle_cards)/5)+2).' seconds'));
                        $this->AnderBahar_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'ander_bahar_room_id');
                        if ($count>0) {
                            $card = $this->AnderBahar_model->GetCards($limit)[0]->cards;
                            $this->AnderBahar_model->Create($room->id, $card);

                            echo 'Ander Baher Game Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
        $this->Users_model->UpdateOfflineUsers();
    }

    public function dragon_tiger()
    {
        $room_data = $this->DragonTiger_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->DragonTiger_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $this->DragonTiger_model->Create($room->id, $card);

                    echo 'First Dragon Tiger Game Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        $DragonBetAmount = $this->DragonTiger_model->TotalBetAmount($game_data[0]->id, DRAGON)*2;
                        $TigerBetAmount = $this->DragonTiger_model->TotalBetAmount($game_data[0]->id, TIGER)*2;
                        $TieBetAmount = $this->DragonTiger_model->TotalBetAmount($game_data[0]->id, TIE)*11;

                        if ($DragonBetAmount>$TieBetAmount && $TigerBetAmount>$TieBetAmount) {
                            $winning = TIE;
                        } else {
                            $winning = ($DragonBetAmount>$TigerBetAmount) ? TIGER : DRAGON; //0=Dragon,1=Tiger
                        }

                        if ($winning==TIE) {
                            $number = rand(2, 10);
                            $card_dragon = 'BP'.$number;
                            $card_tiger = 'RP'.$number;

                            $this->DragonTiger_model->CreateMap($game_data[0]->id, $card_dragon);
                            $this->DragonTiger_model->CreateMap($game_data[0]->id, $card_tiger);
                        } else {
                            $limit = 2;
                            $cards = $this->DragonTiger_model->GetCards($limit);
                            $card1_point = $this->card_points($cards[0]->cards);
                            $card2_point = $this->card_points($cards[1]->cards);

                            $card_big = '';
                            $card_small = '';
                            if ($card1_point>$card2_point) {
                                $card_big = $cards[0]->cards;
                                $card_small = $cards[1]->cards;
                            } else {
                                $card_big = $cards[1]->cards;
                                $card_small = $cards[0]->cards;
                            }

                            $card_dragon = ($winning==DRAGON) ? $card_big : $card_small;
                            $card_tiger = ($winning==TIGER) ? $card_big : $card_small;

                            $this->DragonTiger_model->CreateMap($game_data[0]->id, $card_dragon);
                            $this->DragonTiger_model->CreateMap($game_data[0]->id, $card_tiger);
                        }

                        // Give winning Amount to user
                        $bets = $this->DragonTiger_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            // print_r($bets);
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                if ($winning==TIE) {
                                    $this->DragonTiger_model->MakeWinner($value->user_id, $value->id, $value->amount*11, $comission, $game_data[0]->id);
                                } else {
                                    $this->DragonTiger_model->MakeWinner($value->user_id, $value->id, $value->amount*2, $comission, $game_data[0]->id);
                                }
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->DragonTiger_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'dragon_tiger_room_id');
                        if ($count>0) {
                            $this->DragonTiger_model->Create($room->id);

                            echo 'Dragon Tiger Game Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function head_tail()
    {
        $room_data = $this->HeadTail_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->HeadTail_model->getActiveGameOnTable($room->id);
                $card = '';
                if (!$game_data) {
                    $this->HeadTail_model->Create($room->id, $card);

                    echo 'First Head Tail Game Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        $DragonBetAmount = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, DRAGON)*2;
                        $TigerBetAmount = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, TIGER)*2;
                        // $TieBetAmount = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, TIE)*11;

                        // if ($DragonBetAmount>$TieBetAmount && $TigerBetAmount>$TieBetAmount) {
                        //     $winning = TIE;
                        // } else {
                        $winning = ($DragonBetAmount>$TigerBetAmount) ? TIGER : DRAGON; //0=Dragon,1=Tiger
                        // }

                        // if ($winning==TIE) {
                        //     $number = rand(2, 10);
                        //     $card_dragon = 'BP'.$number;
                        //     $card_tiger = 'RP'.$number;

                        //     $this->HeadTail_model->CreateMap($game_data[0]->id, $card_dragon);
                        //     $this->HeadTail_model->CreateMap($game_data[0]->id, $card_tiger);
                        // } else {
                        $limit = 2;
                        $cards = $this->HeadTail_model->GetCards($limit);
                        $card1_point = $this->card_points($cards[0]->cards);
                        $card2_point = $this->card_points($cards[1]->cards);

                        $card_big = '';
                        $card_small = '';
                        if ($card1_point>$card2_point) {
                            $card_big = $cards[0]->cards;
                            $card_small = $cards[1]->cards;
                        } else {
                            $card_big = $cards[1]->cards;
                            $card_small = $cards[0]->cards;
                        }

                        $card_dragon = ($winning==DRAGON) ? $card_big : $card_small;
                        $card_tiger = ($winning==TIGER) ? $card_big : $card_small;

                        $this->HeadTail_model->CreateMap($game_data[0]->id, $card_dragon);
                        $this->HeadTail_model->CreateMap($game_data[0]->id, $card_tiger);
                        // }

                        // Give winning Amount to user
                        $bets = $this->HeadTail_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            // print_r($bets);
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                // if ($winning==TIE) {
                                //     $this->HeadTail_model->MakeWinner($value->user_id, $value->id, $value->amount*11, $comission, $game_data[0]->id);
                                // } else {
                                $this->HeadTail_model->MakeWinner($value->user_id, $value->id, $value->amount*2, $comission, $game_data[0]->id);
                                // }
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->HeadTail_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'head_tail_room_id');
                        if ($count>0) {
                            $this->HeadTail_model->Create($room->id);

                            echo 'Head Tail Game Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function card_points($card)
    {
        $card_value = substr($card, 2);

        $point = str_replace(
            array("J", "Q", "K", "A"),
            array(11, 12, 13, 1),
            $card_value
        );
        return $point;
    }

    public function rummy_card_points($card)
    {
        $card_value = substr($card, 2);

        $point = str_replace(
            array("J", "Q", "K", "A"),
            array(11, 12, 13, 1),
            $card_value
        );
        return $point;
    }

    public function jackpot()
    {
        $room_data = $this->Jackpot_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->Jackpot_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $card = '';
                    $this->Jackpot_model->Create($room->id, $card);

                    echo 'First Jackpot Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        $min = ($this->Setting_model->Setting()->jackpot_status==1) ? 'SET' : '';
                        if ($min!='SET') {
                            $HighCardAmount = $this->Jackpot_model->TotalBetAmount($game_data[0]->id, HIGH_CARD);
                            $PairAmount = $this->Jackpot_model->TotalBetAmount($game_data[0]->id, PAIR);
                            $ColorAmount = $this->Jackpot_model->TotalBetAmount($game_data[0]->id, COLOR);
                            $SequenceAmount = $this->Jackpot_model->TotalBetAmount($game_data[0]->id, SEQUENCE);
                            $PureSequenceAmount = $this->Jackpot_model->TotalBetAmount($game_data[0]->id, PURE_SEQUENCE);

                            //1=High Card, 2=Pair, 3=Color, 4=Sequence, 5=Pure Sequence, 6=Set
                            // $total = $HighCardAmount+$PairAmount+$ColorAmount+$SequenceAmount+$PureSequenceAmount+$SetAmount;
                            $arr['HIGH_CARD'] = $HighCardAmount*HIGH_CARD_MULTIPLY;
                            $arr['PAIR'] = $PairAmount*PAIR_MULTIPLY;
                            $arr['COLOR'] = $ColorAmount*COLOR_MULTIPLY;
                            $arr['SEQUENCE'] = $SequenceAmount*SEQUENCE_MULTIPLY;
                            $arr['PURE_SEQUENCE'] = $PureSequenceAmount*PURE_SEQUENCE_MULTIPLY;
                            // $arr['SET'] = $total*HIGH_CARD_MULTIPLY;
                            $min_arr = array_keys($arr, min($arr));
                            $min = $min_arr[0];
                        }

                        $multiply = 0;
                        $color_arr = array('BP','BL','RS','RP');
                        $number_arr = array('A','2','3','4','5','6','7','8','9','10','J','Q','K');

                        switch ($min) {
                            case 'HIGH_CARD':
                                $high = rand(1, 10);
                                switch ($high) {
                                    case 1:
                                        $card1 = 'BPA';
                                        $card2 = 'RS8';
                                        $card3 = 'BL3';
                                        break;

                                    case 2:
                                        $card1 = 'BPK';
                                        $card2 = 'RS7';
                                        $card3 = 'BL4';
                                        break;

                                    case 3:
                                        $card1 = 'BP9';
                                        $card2 = 'RS7';
                                        $card3 = 'BL2';
                                        break;

                                    case 4:
                                        $card1 = 'BPK';
                                        $card2 = 'RSA';
                                        $card3 = 'BLJ';
                                        break;

                                    case 5:
                                        $card1 = 'BP9';
                                        $card2 = 'RS5';
                                        $card3 = 'BL6';
                                        break;

                                    case 6:
                                        $card1 = 'BP3';
                                        $card2 = 'RS2';
                                        $card3 = 'BL8';
                                        break;

                                    case 7:
                                        $card1 = 'BP4';
                                        $card2 = 'RS5';
                                        $card3 = 'BL9';
                                        break;

                                    case 8:
                                        $card1 = 'BP3';
                                        $card2 = 'RS5';
                                        $card3 = 'BL6';
                                        break;

                                    case 9:
                                        $card1 = 'BPQ';
                                        $card2 = 'RSK';
                                        $card3 = 'BL8';
                                        break;

                                    case 10:
                                        $card1 = 'BP4';
                                        $card2 = 'RS6';
                                        $card3 = 'BL9';
                                        break;

                                    default:
                                        $card1 = 'BPA';
                                        $card2 = 'RS8';
                                        $card3 = 'BL3';
                                        break;
                                }

                                $winning = HIGH_CARD;
                                $multiply = HIGH_CARD_MULTIPLY;
                                break;

                            case 'PAIR':
                                $number_index = array_rand($number_arr, 2);
                                $number1 = $number_arr[$number_index[0]];
                                $number2 = $number_arr[$number_index[1]];

                                $card1 = 'BP'.$number1;
                                $card2 = 'RP'.$number1;
                                $card3 = 'BL'.$number2;
                                $winning = PAIR;
                                $multiply = PAIR_MULTIPLY;
                                break;

                            case 'COLOR':
                                $color_index = array_rand($color_arr);
                                $color = $color_arr[$color_index];

                                $card1 = $color.'A';
                                $card2 = $color.'5';
                                $card3 = $color.'7';
                                $winning = COLOR;
                                $multiply = COLOR_MULTIPLY;
                                break;

                            case 'SEQUENCE':
                                $number = rand(2, 7);

                                $card1 = 'RP'.$number;
                                $card2 = 'BL'.($number+1);
                                $card3 = 'BP'.($number+2);
                                $winning = SEQUENCE;
                                $multiply = SEQUENCE_MULTIPLY;
                                break;

                            case 'PURE_SEQUENCE':
                                $color_index = array_rand($color_arr);
                                $color = $color_arr[$color_index];

                                $number = rand(2, 7);
                                $card1 = $color.$number;
                                $card2 = $color.($number+1);
                                $card3 = $color.($number+2);
                                $winning = PURE_SEQUENCE;
                                $multiply = PURE_SEQUENCE_MULTIPLY;
                                break;

                            case 'SET':
                                $number_index = array_rand($number_arr);
                                $number = $number_arr[$number_index];
                                $card1 = 'BP'.$number;
                                $card2 = 'RP'.$number;
                                $card3 = 'BL'.$number;
                                $winning = SET;
                                $SetAmount = $this->Jackpot_model->TotalBetAmount($game_data[0]->id, SET);
                                $jackpot_coin = $this->Setting_model->Setting()->jackpot_coin;
                                $give_coins = round(0.2*$jackpot_coin);
                                $minus_jackpot_coin = '-'.$jackpot_coin;
                                $this->Setting_model->update_jackpot_amount($minus_jackpot_coin);
                                break;

                            default:
                                $card1 = 'BPA';
                                $card2 = 'RP7';
                                $card3 = 'BL4';
                                $winning = HIGH_CARD;
                                $multiply = HIGH_CARD_MULTIPLY;
                                break;
                        }

                        $this->Jackpot_model->CreateMap($game_data[0]->id, $card1);
                        $this->Jackpot_model->CreateMap($game_data[0]->id, $card2);
                        $this->Jackpot_model->CreateMap($game_data[0]->id, $card3);

                        // Give winning Amount to user
                        $bets = $this->Jackpot_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            // print_r($bets);
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                if ($winning==SET) {
                                    $winning_percent = round(($value->amount/$SetAmount)*100);
                                    $winning_amount = round(($winning_percent/100)*$give_coins);
                                    $this->Jackpot_model->MakeWinner($value->user_id, $value->id, $winning_amount, $comission, $game_data[0]->id);
                                } else {
                                    $this->Jackpot_model->MakeWinner($value->user_id, $value->id, $value->amount*$multiply, $comission, $game_data[0]->id);
                                }
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->Jackpot_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'jackpot_room_id');
                        if ($count>0) {
                            $this->Jackpot_model->Create($room->id);

                            echo 'Jackpot Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function red_black()
    {
        $room_data = $this->RedBlack_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->RedBlack_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $card = '';
                    $this->RedBlack_model->Create($room->id, $card);

                    echo 'First Red Black Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        // $RedAmount = $this->RedBlack_model->TotalBetAmount($game_data[0]->id, RB_RED);
                        // $BlackAmount = $this->RedBlack_model->TotalBetAmount($game_data[0]->id, RB_BLACK);
                        // $PairAmount = $this->RedBlack_model->TotalBetAmount($game_data[0]->id, RB_PAIR);
                        // $ColorAmount = $this->RedBlack_model->TotalBetAmount($game_data[0]->id, RB_COLOR);
                        // $SequenceAmount = $this->RedBlack_model->TotalBetAmount($game_data[0]->id, RB_SEQUENCE);
                        // $PureSequenceAmount = $this->RedBlack_model->TotalBetAmount($game_data[0]->id, RB_PURE_SEQUENCE);
                        // $SetAmount = $this->RedBlack_model->TotalBetAmount($game_data[0]->id, RB_SET);

                        // //1=High Card, 2=Pair, 3=Color, 4=Sequence, 5=Pure Sequence, 6=Set
                        // // $total = $HighCardAmount+$PairAmount+$ColorAmount+$SequenceAmount+$PureSequenceAmount+$SetAmount;
                        // $arr['RED'] = $HighCardAmount*RB_RED_MULTIPLE;
                        // $arr['BLACK'] = $HighCardAmount*RB_BLACK_MULTIPLE;
                        // $arr['PAIR'] = $PairAmount*RB_PAIR_MULTIPLE;
                        // $arr['COLOR'] = $ColorAmount*RB_COLOR_MULTIPLE;
                        // $arr['SEQUENCE'] = $SequenceAmount*RB_SEQUENCE_MULTIPLE;
                        // $arr['PURE_SEQUENCE'] = $PureSequenceAmount*RB_PURE_SEQUENCE_MULTIPLE;
                        // $arr['SET'] = $PureSequenceAmount*RB_SET_MULTIPLE;

                        // $min_arr = array_keys($arr, min($arr));
                        // $min = $min_arr[0];

                        // $multiply = 0;
                        // $color_arr = array('BP','BL','RS','RP');
                        // $number_arr = array('A','2','3','4','5','6','7','8','9','10','J','Q','K');

                        // switch ($min) {
                        //     case 'HIGH_CARD':
                        //         $high = rand(1, 10);
                        //         switch ($high) {
                        //             case 1:
                        //                 $card1 = 'BPA';
                        //                 $card2 = 'RS8';
                        //                 $card3 = 'BL3';
                        //                 break;

                        //             case 2:
                        //                 $card1 = 'BPK';
                        //                 $card2 = 'RS7';
                        //                 $card3 = 'BL4';
                        //                 break;

                        //             case 3:
                        //                 $card1 = 'BP9';
                        //                 $card2 = 'RS7';
                        //                 $card3 = 'BL2';
                        //                 break;

                        //             case 4:
                        //                 $card1 = 'BPK';
                        //                 $card2 = 'RSA';
                        //                 $card3 = 'BLJ';
                        //                 break;

                        //             case 5:
                        //                 $card1 = 'BP9';
                        //                 $card2 = 'RS5';
                        //                 $card3 = 'BL6';
                        //                 break;

                        //             case 6:
                        //                 $card1 = 'BP3';
                        //                 $card2 = 'RS2';
                        //                 $card3 = 'BL8';
                        //                 break;

                        //             case 7:
                        //                 $card1 = 'BP4';
                        //                 $card2 = 'RS5';
                        //                 $card3 = 'BL9';
                        //                 break;

                        //             case 8:
                        //                 $card1 = 'BP3';
                        //                 $card2 = 'RS5';
                        //                 $card3 = 'BL6';
                        //                 break;

                        //             case 9:
                        //                 $card1 = 'BPQ';
                        //                 $card2 = 'RSK';
                        //                 $card3 = 'BL8';
                        //                 break;

                        //             case 10:
                        //                 $card1 = 'BP4';
                        //                 $card2 = 'RS6';
                        //                 $card3 = 'BL9';
                        //                 break;

                        //             default:
                        //                 $card1 = 'BPA';
                        //                 $card2 = 'RS8';
                        //                 $card3 = 'BL3';
                        //                 break;
                        //         }

                        //         $winning = HIGH_CARD;
                        //         $multiply = HIGH_CARD_MULTIPLY;
                        //         break;

                        //     case 'PAIR':
                        //         $number_index = array_rand($number_arr, 2);
                        //         $number1 = $number_arr[$number_index[0]];
                        //         $number2 = $number_arr[$number_index[1]];

                        //         $card1 = 'BP'.$number1;
                        //         $card2 = 'RP'.$number1;
                        //         $card3 = 'BL'.$number2;
                        //         $winning = PAIR;
                        //         $multiply = PAIR_MULTIPLY;
                        //         break;

                        //     case 'COLOR':
                        //         $color_index = array_rand($color_arr);
                        //         $color = $color_arr[$color_index];

                        //         $card1 = $color.'A';
                        //         $card2 = $color.'5';
                        //         $card3 = $color.'7';
                        //         $winning = COLOR;
                        //         $multiply = COLOR_MULTIPLY;
                        //         break;

                        //     case 'SEQUENCE':
                        //         $number = rand(2, 7);

                        //         $card1 = 'RP'.$number;
                        //         $card2 = 'BL'.($number+1);
                        //         $card3 = 'BP'.($number+2);
                        //         $winning = SEQUENCE;
                        //         $multiply = SEQUENCE_MULTIPLY;
                        //         break;

                        //     case 'PURE_SEQUENCE':
                        //         $color_index = array_rand($color_arr);
                        //         $color = $color_arr[$color_index];

                        //         $number = rand(2, 7);
                        //         $card1 = $color.$number;
                        //         $card2 = $color.($number+1);
                        //         $card3 = $color.($number+2);
                        //         $winning = PURE_SEQUENCE;
                        //         $multiply = PURE_SEQUENCE_MULTIPLY;
                        //         break;

                        //     case 'SET':
                        //         $number_index = array_rand($number_arr);
                        //         $number = $number_arr[$number_index];
                        //         $card1 = 'BP'.$number;
                        //         $card2 = 'RP'.$number;
                        //         $card3 = 'BL'.$number;
                        //         $winning = SET;
                        //         $SetAmount = $this->Jackpot_model->TotalBetAmount($game_data[0]->id, SET);
                        //         $jackpot_coin = $this->Setting_model->Setting()->jackpot_coin;
                        //         $give_coins = round(0.2*$jackpot_coin);
                        //         $minus_jackpot_coin = '-'.$jackpot_coin;
                        //         $this->Setting_model->update_jackpot_amount($minus_jackpot_coin);
                        //         break;

                        //     default:
                        //         $card1 = 'BPA';
                        //         $card2 = 'RP7';
                        //         $card3 = 'BL4';
                        //         $winning = HIGH_CARD;
                        //         $multiply = HIGH_CARD_MULTIPLY;
                        //         break;
                        // }

                        $cards = $this->RedBlack_model->GetCards(6);
                        $card1 = $cards[0]->cards;
                        $card2 = $cards[1]->cards;
                        $card3 = $cards[2]->cards;
                        $card4 = $cards[3]->cards;
                        $card5 = $cards[4]->cards;
                        $card6 = $cards[5]->cards;

                        $this->RedBlack_model->CreateMap($game_data[0]->id, $card1);
                        $this->RedBlack_model->CreateMap($game_data[0]->id, $card2);
                        $this->RedBlack_model->CreateMap($game_data[0]->id, $card3);
                        $this->RedBlack_model->CreateMap($game_data[0]->id, $card4);
                        $this->RedBlack_model->CreateMap($game_data[0]->id, $card5);
                        $this->RedBlack_model->CreateMap($game_data[0]->id, $card6);

                        $redPoint = $this->RedBlack_model->CardValue($card1, $card2, $card3);
                        $blackPoint = $this->RedBlack_model->CardValue($card4, $card5, $card6);
                        $winningPosition = $this->RedBlack_model->getWinnerPosition($redPoint, $blackPoint);
                        $winning = ($winningPosition==0) ? RB_RED : RB_BLACK;

                        $multiply = ($winning==RB_RED) ? RB_RED_MULTIPLE : RB_BLACK_MULTIPLE;
                        // Give winning Amount to user
                        $bets = $this->RedBlack_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            // print_r($bets);
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                // if ($winning==SET) {
                                //     $winning_percent = round(($value->amount/$SetAmount)*100);
                                //     $winning_amount = round(($winning_percent/100)*$give_coins);
                                //     $this->RedBlack_model->MakeWinner($value->user_id, $value->id, $winning_amount, $comission, $game_data[0]->id);
                                // } else {
                                $this->RedBlack_model->MakeWinner($value->user_id, $value->id, $value->amount*$multiply, $comission, $game_data[0]->id);
                                // }
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $winning_rule = ($winning==RB_RED) ? $redPoint[0] : $blackPoint[0];
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['winning_rule'] = $winning_rule;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->RedBlack_model->Update($update_data, $game_data[0]->id);


                        if ($winning_rule>0) {
                            switch ($winning_rule) {
                                case (RB_PAIR+1):
                                    $multiply_rule = RB_PAIR_MULTIPLE;
                                    break;

                                case (RB_COLOR+1):
                                    $multiply_rule = RB_COLOR_MULTIPLE;
                                    break;

                                case (RB_SEQUENCE+1):
                                    $multiply_rule = RB_SEQUENCE_MULTIPLE;
                                    break;

                                case (RB_PURE_SEQUENCE+1):
                                    $multiply_rule = RB_PURE_SEQUENCE_MULTIPLE;
                                    break;

                                case (RB_SET+1):
                                    $multiply_rule = RB_SET_MULTIPLE;
                                    break;

                                default:
                                    $multiply_rule = 0;
                                    break;
                            }
                            $bets = $this->RedBlack_model->ViewBet("", $game_data[0]->id, $winning_rule);
                            if ($bets && $multiply_rule>0) {
                                // print_r($bets);
                                $comission = $this->Setting_model->Setting()->admin_commission;
                                foreach ($bets as $key => $value) {
                                    $this->RedBlack_model->MakeWinner($value->user_id, $value->id, $value->amount*$multiply_rule, $comission, $game_data[0]->id);
                                }
                                echo "Winning Amount Given".PHP_EOL;
                            } else {
                                echo "No Winning Bet Found".PHP_EOL;
                            }
                        }
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'red_black_id');
                        if ($count>0) {
                            $this->RedBlack_model->Create($room->id);

                            echo 'Red Black Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function seven_up()
    {
        $room_data = $this->SevenUp_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->SevenUp_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $this->SevenUp_model->Create($room->id, $card);

                    echo 'First Seven Up Game Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        $UpBetAmount = $this->SevenUp_model->TotalBetAmount($game_data[0]->id, UP);
                        $DownBetAmount = $this->SevenUp_model->TotalBetAmount($game_data[0]->id, DOWN);
                        $winning = ($UpBetAmount>$DownBetAmount) ? DOWN : UP; //0=Down,1=Up

                        $winning_number = ($winning==DOWN) ? rand(2, 6) : rand(8, 12);

                        $this->SevenUp_model->CreateMap($game_data[0]->id, $winning_number);

                        // Give winning Amount to user
                        $bets = $this->SevenUp_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            // print_r($bets);
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                $this->SevenUp_model->MakeWinner($value->user_id, $value->id, $value->amount*2, $comission, $game_data[0]->id);
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->SevenUp_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'seven_up_room_id');
                        if ($count>0) {
                            $this->SevenUp_model->Create($room->id);

                            echo 'Seven Up Game Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function car_roulette()
    {
        $room_data = $this->CarRoulette_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->CarRoulette_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $card = '';
                    $this->CarRoulette_model->Create($room->id, $card);

                    echo 'First Jackpot Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        // $min = ($this->Setting_model->Setting()->jackpot_status==1) ? 'SET' : '';
                        // if ($min!='SET') {
                        $ToyotaAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, TOYOTA);
                        $MahindraAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, MAHINDRA);
                        $AudiAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, AUDI);
                        $BmwAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, BMW);
                        $MercedesAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, MERCEDES);
                        $PorscheAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, PORSCHE);
                        $LamborghiniAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, LAMBORGHINI);
                        $FerrariAmount = $this->CarRoulette_model->TotalBetAmount($game_data[0]->id, FERRARI);

                        $arr['TOYOTA'] = $ToyotaAmount*TOYOTA_MULTIPLY;
                        $arr['MAHINDRA'] = $MahindraAmount*MAHINDRA_MULTIPLY;
                        $arr['AUDI'] = $AudiAmount*AUDI_MULTIPLY;
                        $arr['BMW'] = $BmwAmount*BMW_MULTIPLY;
                        $arr['MERCEDES'] = $MercedesAmount*MERCEDES_MULTIPLY;
                        $arr['PORSCHE'] = $PorscheAmount*PORSCHE_MULTIPLY;
                        $arr['LAMBORGHINI'] = $LamborghiniAmount*LAMBORGHINI_MULTIPLY;
                        $arr['FERRARI'] = $FerrariAmount*FERRARI_MULTIPLY;
                        $min_arr = array_keys($arr, min($arr));
                        $min = $min_arr[0];
                        // }

                        $multiply = 0;

                        switch ($min) {
                            case 'TOYOTA':
                                $winning = TOYOTA;
                                $multiply = TOYOTA_MULTIPLY;
                                break;
                            case 'MAHINDRA':
                                $winning = MAHINDRA;
                                $multiply = MAHINDRA_MULTIPLY;
                                break;
                            case 'AUDI':
                                $winning = AUDI;
                                $multiply = AUDI_MULTIPLY;
                                break;
                            case 'BMW':
                                $winning = BMW;
                                $multiply = BMW_MULTIPLY;
                                break;
                            case 'MERCEDES':
                                $winning = MERCEDES;
                                $multiply = MERCEDES_MULTIPLY;
                                break;
                            case 'PORSCHE':
                                $winning = PORSCHE;
                                $multiply = PORSCHE_MULTIPLY;
                                break;
                            case 'LAMBORGHINI':
                                $winning = LAMBORGHINI;
                                $multiply = LAMBORGHINI_MULTIPLY;
                                break;
                            case 'FERRARI':
                                $winning = FERRARI;
                                $multiply = FERRARI_MULTIPLY;
                                break;

                            default:
                                $winning = TOYOTA;
                                $multiply = TOYOTA_MULTIPLY;
                                break;
                        }

                        $this->CarRoulette_model->CreateMap($game_data[0]->id, $winning);

                        // Give winning Amount to user
                        $bets = $this->CarRoulette_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                $this->CarRoulette_model->MakeWinner($value->user_id, $value->id, $value->amount*$multiply, $comission, $game_data[0]->id);
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->CarRoulette_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'car_roulette_room_id');
                        if ($count>0) {
                            $this->CarRoulette_model->Create($room->id);

                            echo 'Jackpot Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function animal_roulette()
    {
        $room_data = $this->AnimalRoulette_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->AnimalRoulette_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $card = '';
                    $this->AnimalRoulette_model->Create($room->id, $card);

                    echo 'First Animal Roulette Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        // $min = ($this->Setting_model->Setting()->jackpot_status==1) ? 'SET' : '';
                        // if ($min!='SET') {
                        $TigerAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, TIGER);
                        $SnakeAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, SNAKE);
                        $SharkAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, SHARK);
                        $FoxAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, FOX);
                        $CheetahAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, CHEETAH);
                        $BearAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, BEAR);
                        $WhaleAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, WHALE);
                        $LionAmount = $this->AnimalRoulette_model->TotalBetAmount($game_data[0]->id, LION);

                        $arr['TIGER'] = $TigerAmount*TIGER_MULTIPLY;
                        $arr['SNAKE'] = $SnakeAmount*SNAKE_MULTIPLY;
                        $arr['SHARK'] = $SharkAmount*SHARK_MULTIPLY;
                        $arr['FOX'] = $FoxAmount*FOX_MULTIPLY;
                        $arr['CHEETAH'] = $CheetahAmount*CHEETAH_MULTIPLY;
                        $arr['BEAR'] = $BearAmount*BEAR_MULTIPLY;
                        $arr['WHALE'] = $WhaleAmount*WHALE_MULTIPLY;
                        $arr['LION'] = $LionAmount*LION_MULTIPLY;
                        $min_arr = array_keys($arr, min($arr));
                        $min = $min_arr[0];
                        // }

                        $multiply = 0;

                        switch ($min) {
                            case 'TIGER':
                                $winning = TIGER;
                                $multiply = TIGER_MULTIPLY;
                                break;
                            case 'SNAKE':
                                $winning = SNAKE;
                                $multiply = SNAKE_MULTIPLY;
                                break;
                            case 'SHARK':
                                $winning = SHARK;
                                $multiply = SHARK_MULTIPLY;
                                break;
                            case 'FOX':
                                $winning = FOX;
                                $multiply = FOX_MULTIPLY;
                                break;
                            case 'CHEETAH':
                                $winning = CHEETAH;
                                $multiply = CHEETAH_MULTIPLY;
                                break;
                            case 'BEAR':
                                $winning = BEAR;
                                $multiply = BEAR_MULTIPLY;
                                break;
                            case 'WHALE':
                                $winning = WHALE;
                                $multiply = WHALE_MULTIPLY;
                                break;
                            case 'LION':
                                $winning = LION;
                                $multiply = LION_MULTIPLY;
                                break;

                            default:
                                $winning = TIGER;
                                $multiply = TIGER_MULTIPLY;
                                break;
                        }

                        $this->AnimalRoulette_model->CreateMap($game_data[0]->id, $winning);

                        // Give winning Amount to user
                        $bets = $this->AnimalRoulette_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                $this->AnimalRoulette_model->MakeWinner($value->user_id, $value->id, $value->amount*$multiply, $comission, $game_data[0]->id);
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->AnimalRoulette_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'animal_roulette_room_id');
                        if ($count>0) {
                            $this->AnimalRoulette_model->Create($room->id);

                            echo 'Animal Roulette Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function color_prediction()
    {
        $room_data = $this->ColorPrediction_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->ColorPrediction_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $card = '';
                    $this->ColorPrediction_model->Create($room->id, $card);

                    echo 'First Jackpot Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        $ZeroAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 0);
                        $OneAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 1);
                        $TwoAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 2);
                        $ThreeAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 3);
                        $FourAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 4);
                        $FiveAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 5);
                        $SixAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 6);
                        $SevenAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 7);
                        $EightAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 8);
                        $NineAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, 9);

                        $GreenAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, GREEN);
                        $VioletAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, VIOLET);
                        $RedAmount = $this->ColorPrediction_model->TotalBetAmount($game_data[0]->id, RED);

                        $arr['ZERO'] = ($ZeroAmount*NUMBER_MULTIPLE)+($RedAmount*GREEN_RED_HALF_MULTIPLE)+($VioletAmount*VIOLET_MULTIPLE);
                        $arr['ONE'] = ($OneAmount*NUMBER_MULTIPLE)+($GreenAmount*GREEN_RED_MULTIPLE);
                        $arr['TWO'] = ($TwoAmount*NUMBER_MULTIPLE)+($RedAmount*GREEN_RED_MULTIPLE);
                        $arr['THREE'] = ($ThreeAmount*NUMBER_MULTIPLE)+($GreenAmount*GREEN_RED_MULTIPLE);
                        $arr['FOUR'] = ($FourAmount*NUMBER_MULTIPLE)+($RedAmount*GREEN_RED_MULTIPLE);
                        $arr['FIVE'] = ($FiveAmount*NUMBER_MULTIPLE)+($GreenAmount*GREEN_RED_HALF_MULTIPLE)+($VioletAmount*VIOLET_MULTIPLE);
                        $arr['SIX'] = ($SixAmount*NUMBER_MULTIPLE)+($RedAmount*GREEN_RED_MULTIPLE);
                        $arr['SEVEN'] = ($SevenAmount*NUMBER_MULTIPLE)+($GreenAmount*GREEN_RED_MULTIPLE);
                        $arr['EIGHT'] = ($EightAmount*NUMBER_MULTIPLE)+($RedAmount*GREEN_RED_MULTIPLE);
                        $arr['NINE'] = ($NineAmount*NUMBER_MULTIPLE)+($GreenAmount*GREEN_RED_MULTIPLE);

                        $min_arr = array_keys($arr, min($arr));
                        $min = $min_arr[0];

                        $color = '';
                        $color_multiply = '';
                        $color_1 = '';
                        $color_1_multiply = '';
                        $number = '';
                        $number_multiply = '';

                        switch ($min) {
                            case 'ZERO':
                                $color = GREEN;
                                $color_multiply = GREEN_RED_HALF_MULTIPLE;
                                $color_1 = VIOLET;
                                $color_1_multiply = VIOLET_MULTIPLE;
                                $number = 0;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'ONE':
                                $color = GREEN;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 1;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'TWO':
                                $color = RED;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 2;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'THREE':
                                $color = GREEN;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 3;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'FOUR':
                                $color = RED;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 4;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'FIVE':
                                $color = RED;
                                $color_multiply = GREEN_RED_HALF_MULTIPLE;
                                $color_1 = VIOLET;
                                $color_1_multiply = VIOLET_MULTIPLE;
                                $number = 5;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'SIX':
                                $color = GREEN;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 6;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'SEVEN':
                                $color = RED;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 7;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'EIGHT':
                                $color = GREEN;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 8;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;
                            case 'NINE':
                                $color = RED;
                                $color_multiply = GREEN_RED_MULTIPLE;
                                $number = 9;
                                $number_multiply = NUMBER_MULTIPLE;
                                break;

                            default:
                                $color = '';
                                $color_multiply = '';
                                $color_1 = '';
                                $color_1_multiply = '';
                                $number = '';
                                $number_multiply = '';
                                break;
                        }

                        $this->ColorPrediction_model->CreateMap($game_data[0]->id, $number);

                        $comission = $this->Setting_model->Setting()->admin_commission;
                        // Give winning Amount to Number user
                        $bets = $this->ColorPrediction_model->ViewBet("", $game_data[0]->id, $number);
                        if ($bets) {
                            foreach ($bets as $key => $value) {
                                $this->ColorPrediction_model->MakeWinner($value->user_id, $value->id, $value->amount*$number_multiply, $comission, $game_data[0]->id);
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }

                        // Give winning Amount to Color user
                        if ($color!='') {
                            $color_bets = $this->ColorPrediction_model->ViewBet("", $game_data[0]->id, $color);
                            if ($color_bets) {
                                foreach ($color_bets as $key => $value) {
                                    $this->ColorPrediction_model->MakeWinner($value->user_id, $value->id, $value->amount*$color_multiply, $comission, $game_data[0]->id);
                                }
                                echo "Winning Amount Given".PHP_EOL;
                            } else {
                                echo "No Winning Bet Found".PHP_EOL;
                            }
                        }

                        // Give winning Amount to Color 1 user
                        if ($color_1!='') {
                            $color_1_bets = $this->ColorPrediction_model->ViewBet("", $game_data[0]->id, $color_1);
                            if ($color_1_bets) {
                                foreach ($color_1_bets as $key => $value) {
                                    $this->ColorPrediction_model->MakeWinner($value->user_id, $value->id, $value->amount*$color_1_multiply, $comission, $game_data[0]->id);
                                }
                                echo "Winning Amount Given".PHP_EOL;
                            } else {
                                echo "No Winning Bet Found".PHP_EOL;
                            }
                        }

                        $update_data['status'] = 1;
                        $update_data['winning'] = $number;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->ColorPrediction_model->Update($update_data, $game_data[0]->id);
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'color_prediction_room_id');
                        if ($count>0) {
                            $this->ColorPrediction_model->Create($room->id);

                            echo 'Color Prediction Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }

    public function poker()
    {
        $tables = $this->Poker_model->getActiveTable();
        // print_r($tables);

        foreach ($tables as $val) {
            $chaal = 0;
            $game = $this->Poker_model->getActiveGameOnTable($val->poker_table_id);
            // print_r($game);
            if ($game) {
                $game_log = $this->Poker_model->GameLog($game->id, 1);
                $time = time()-strtotime($game_log[0]->added_date);
                // print_r($game_log);
                if ($time>35) {
                    $game_users = $this->Poker_model->GameAllUser($game->id);


                    $element = 0;
                    foreach ($game_users as $key => $value) {
                        if ($value->user_id==$game_log[0]->user_id) {
                            $element = $key;
                            break;
                        }
                    }

                    $index = 0;
                    foreach ($game_users as $key => $value) {
                        $index = ($key+$element)%count($game_users);
                        if ($key>0) {
                            if (!$game_users[$index]->packed) {
                                $chaal = $game_users[$index]->user_id;
                                break;
                            }
                        }
                    }
                }
                // echo $chaal;
                if ($chaal!=0) {
                    $this->Poker_model->PackGame($chaal, $game->id, 1);
                    $game_users = $this->Poker_model->GameUser($game->id);

                    if (count($game_users)==1) {
                        $comission = $this->Setting_model->Setting()->admin_commission;
                        $this->Poker_model->MakeWinner($game->id, $game->amount, $game_users[0]->user_id, $comission);

                        $user = $this->Users_model->UserProfile($game_users[0]->user_id);
                        if ($user[0]->user_type==1) {
                            $table_user_data = [
                                'poker_table_id' => $val->poker_table_id,
                                'user_id' => $user[0]->id
                            ];

                            $this->Poker_model->RemoveTableUser($table_user_data);
                        }
                    }

                    $table_user_data = [
                        'poker_table_id' => $val->poker_table_id,
                        'user_id' =>$chaal
                    ];

                    $this->Poker_model->RemoveTableUser($table_user_data);
                }
            }

            echo '<br>Success';
        }
    }

    public function baccarat()
    {
        $room_data = $this->Baccarat_model->getRoom();

        if ($room_data) {
            foreach ($room_data as $key => $room) {
                $game_data = $this->Baccarat_model->getActiveGameOnTable($room->id);

                if (!$game_data) {
                    $card = '';
                    $this->Baccarat_model->Create($room->id, $card);

                    echo 'First Baccarat Created Successfully'.PHP_EOL;
                    continue;
                }

                if ($game_data[0]->status==0) {
                    if ((strtotime($game_data[0]->added_date)+DRAGON_TIME_FOR_BET)<=time()) {
                        $cards = $this->Baccarat_model->GetCards(6);
                        $card1 = $cards[0]->cards;
                        $card2 = $cards[1]->cards;
                        $card3 = $cards[2]->cards;
                        $card4 = $cards[3]->cards;
                        $card5 = $cards[4]->cards;
                        $card6 = $cards[5]->cards;

                        $this->Baccarat_model->CreateMap($game_data[0]->id, $card1);
                        $this->Baccarat_model->CreateMap($game_data[0]->id, $card2);
                        $this->Baccarat_model->CreateMap($game_data[0]->id, $card3);
                        $this->Baccarat_model->CreateMap($game_data[0]->id, $card4);

                        $playerPoint = $this->Baccarat_model->CardValue($card1, $card2);
                        $bankerPoint = $this->Baccarat_model->CardValue($card3, $card4);
                        $winning = $this->Baccarat_model->getWinner($playerPoint, $bankerPoint);
                        $multiply = $this->Baccarat_model->getMultiply($winning);

                        // Give winning Amount to user
                        $bets = $this->Baccarat_model->ViewBet("", $game_data[0]->id, $winning);
                        if ($bets) {
                            // print_r($bets);
                            $comission = $this->Setting_model->Setting()->admin_commission;
                            foreach ($bets as $key => $value) {
                                $this->Baccarat_model->MakeWinner($value->user_id, $value->id, $value->amount*$multiply, $comission, $game_data[0]->id);
                            }
                            echo "Winning Amount Given".PHP_EOL;
                        } else {
                            echo "No Winning Bet Found".PHP_EOL;
                        }
                        $playerPair = $this->Baccarat_model->isPair($card1, $card2);
                        $playerPairMultiply = PLAYER_PAIR_MULTIPLE;
                        $bankerPair = $this->Baccarat_model->isPair($card3, $card4);
                        $bankerPairMultiply = BANKER_PAIR_MULTIPLE;

                        $update_data['status'] = 1;
                        $update_data['winning'] = $winning;
                        $update_data['player_pair'] = $playerPair;
                        $update_data['banker_pair'] = $bankerPair;
                        $update_data['updated_date'] = date('Y-m-d H:i:s');
                        $update_data['end_datetime'] = date('Y-m-d H:i:s', strtotime('+'.DRAGON_TIME_FOR_START_NEW_GAME.' seconds'));
                        $this->Baccarat_model->Update($update_data, $game_data[0]->id);

                        if ($playerPair) {
                            $bets = $this->Baccarat_model->ViewBet("", $game_data[0]->id, PLAYER_PAIR);
                            if ($bets) {
                                // print_r($bets);
                                $comission = $this->Setting_model->Setting()->admin_commission;
                                foreach ($bets as $key => $value) {
                                    $this->Baccarat_model->MakeWinner($value->user_id, $value->id, $value->amount*$playerPairMultiply, $comission, $game_data[0]->id);
                                }
                                echo "Winning Amount Given".PHP_EOL;
                            } else {
                                echo "No Winning Bet Found".PHP_EOL;
                            }
                        }

                        if ($bankerPair) {
                            $bets = $this->Baccarat_model->ViewBet("", $game_data[0]->id, BANKER_PAIR);
                            if ($bets) {
                                // print_r($bets);
                                $comission = $this->Setting_model->Setting()->admin_commission;
                                foreach ($bets as $key => $value) {
                                    $this->Baccarat_model->MakeWinner($value->user_id, $value->id, $value->amount*$bankerPairMultiply, $comission, $game_data[0]->id);
                                }
                                echo "Winning Amount Given".PHP_EOL;
                            } else {
                                echo "No Winning Bet Found".PHP_EOL;
                            }
                        }
                    } else {
                        echo "No Game to Start".PHP_EOL;
                    }
                } else {
                    if (strtotime($game_data[0]->end_datetime)<=time()) {
                        $count = $this->Users_model->getOnlineUsers($room->id, 'baccarat_id');
                        if ($count>0) {
                            $this->Baccarat_model->Create($room->id);

                            echo 'Baccarat Created Successfully'.PHP_EOL;
                        } else {
                            echo 'No Online User Found'.PHP_EOL;
                        }
                    } else {
                        echo "No Game to End".PHP_EOL;
                    }
                }
            }
        } else {
            echo 'No Rooms Available'.PHP_EOL;
        }
    }
}