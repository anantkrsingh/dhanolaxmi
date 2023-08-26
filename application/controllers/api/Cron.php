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
            'RedBlack_model',
            'Baccarat_model',
            'JhandiMunda_model',
            'Roulette_model'
        ]);
    }

    

    public function rummy()
    {
        // log_message('error', 'hello test');
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
                $given_time = ($user_type==0) ? 50 : 10;
                // log_message('error', 'robot timing '.$time.' - '.$given_time);
                if ($time>$given_time) {
                    if ($user_type==1) {
                        // log_message('error', 'robot play 123');
                        $bot_chaal = $this->Rummy_model->ChaalCount($game->id, $chaal);
                        // log_message('error', 'robot play - '.$bot_chaal);
                        if ($bot_chaal>2) {
                            $combination_json[] = '[{"card_group":"6","cards":["BLK","RSK","RPK"]},{"card_group":"5","cards":["BP10_","BP9","BP8"]},{"card_group":"4","cards":["RS3_","RS2_","JKR2","RS4"]},{"card_group":"6","cards":["JKR1","RP8_","RS8"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS9_","BL9_","BP9"]},{"card_group":"4","cards":["RPA_","RP4_","RP3","RP2"]},{"card_group":"4","cards":["BLA","BLK_","BLQ_"]},{"card_group":"5","cards":["RPQ","RPJ","RP10_"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS6_","RP6_","BP6"]},{"card_group":"5","cards":["RPA_","RP4_","RP3","RP2"]},{"card_group":"4","cards":["BP4_","BP3_","JKR2"]},{"card_group":"5","cards":["BL8_","BL7_","BL6_"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS2_","BL2_","BP2","RP2_"]},{"card_group":"6","cards":["RS4_","BP4","RP4_"]},{"card_group":"5","cards":["RP7_","RP6_","RP5_"]},{"card_group":"4","cards":["BL5","BL4_","BL3"]}]';
                            $combination_json[] = '[{"card_group":"6","cards":["RS2_","BL2_","BP2","RP2_"]},{"card_group":"6","cards":["RS4_","BP4","RP4_"]},{"card_group":"5","cards":["RP7_","RP6_","RP5_"]},{"card_group":"4","cards":["BL5","BL4_","BL3"]}]';
                            $bot_combination_json = $combination_json[array_rand($combination_json)];
                            // $combination = json_decode($combination_json);
                            $data_declare = [
                                'user_id' => $chaal,
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
                            if ($user_type==1) {
                                $combination_json[] = '[{"card_group":"6","cards":["BLK","RSK","RPK"]},{"card_group":"5","cards":["BP10_","BP9","BP8"]},{"card_group":"4","cards":["RS3_","RS2_","JKR2","RS4"]},{"card_group":"6","cards":["JKR1","RP8_","RS8"]}]';
                                $combination_json[] = '[{"card_group":"6","cards":["RS9_","BL9_","BP9"]},{"card_group":"4","cards":["RPA_","RP4_","RP3","RP2"]},{"card_group":"4","cards":["BLA","BLK_","BLQ_"]},{"card_group":"5","cards":["RPQ","RPJ","RP10_"]}]';
                                $combination_json[] = '[{"card_group":"6","cards":["RS6_","RP6_","BP6"]},{"card_group":"5","cards":["RPA_","RP4_","RP3","RP2"]},{"card_group":"4","cards":["BP4_","BP3_","JKR2"]},{"card_group":"5","cards":["BL8_","BL7_","BL6_"]}]';
                                $combination_json[] = '[{"card_group":"6","cards":["RS2_","BL2_","BP2","RP2_"]},{"card_group":"6","cards":["RS4_","BP4","RP4_"]},{"card_group":"5","cards":["RP7_","RP6_","RP5_"]},{"card_group":"4","cards":["BL5","BL4_","BL3"]}]';
                                $combination_json[] = '[{"card_group":"6","cards":["RS2_","BL2_","BP2","RP2_"]},{"card_group":"6","cards":["RS4_","BP4","RP4_"]},{"card_group":"5","cards":["RP7_","RP6_","RP5_"]},{"card_group":"4","cards":["BL5","BL4_","BL3"]}]';
                                $bot_combination_json = $combination_json[array_rand($combination_json)];
                                $json_arr = array();

                                $json_arr[0]['json'] = $bot_combination_json;
                                $json_arr = json_decode(json_encode($json_arr), false);
                            } else {
                                $json_arr = $this->Rummy_model->GameLog($game->id, 1, 2, $chaal);
                            }
                            // $json_arr = $this->Rummy_model->GameLog($game->id, 1, 2, $value->user_id);

                            if ($json_arr) {
                                $already_declare = $this->Rummy_model->GameLog($game->id, 1, 3, $chaal);

                                if (!$already_declare) {
                                    $json = $json_arr[0]->json;
                                    $arr = json_decode($json);
                                    $points = 0;
                                    // $wrong = 0;

                                    $table = $this->Rummy_model->isTableAvail($val->rummy_table_id);
                                    $actual_points = $points*round($table->boot_value/80, 2);

                                    $data_log = [
                                        'user_id' => $chaal,
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
                                    if ($game) {
                                        $comission = $this->Setting_model->Setting()->admin_commission;
                                        $this->Rummy_model->MakeWinner($game->id, $game->amount, $declare_log[$declare_count-1]->user_id, $comission);
                                    }
                                }
                            }
                        }

                        continue;
                    }

                    $timeout_log = $this->Rummy_model->GameLog($game->id, '', 2, $chaal, 1);
                    // echo count($timeout_log);
                    if (count($timeout_log)<2) {
                        $cards = $this->Rummy_model->getMyCards($game->id, $chaal);

                        if (count($cards)<=13) {
                            $random_card = $this->Rummy_model->GetRamdomGameCard($game->id);

                            if ($random_card) {
                                $table_user_data = [
                                    'game_id' => $game->id,
                                    'user_id' => $chaal,
                                    'card' => $random_card[0]->cards,
                                    'added_date' => date('Y-m-d H:i:s'),
                                    'updated_date' => date('Y-m-d H:i:s'),
                                    'isDeleted' => 0
                                ];

                                $this->Rummy_model->GiveGameCards($table_user_data);
                            }
                        }
                        $user_card = $this->Rummy_model->GameUserCard($game->id, $chaal);
                        if (!empty($user_card)) {
                            $json_arr = $this->Rummy_model->GameLog($game->id, 1, 2, $chaal);
                            $json = (empty($json_arr)) ? '' : $json_arr[0]->json;

                            // Joker Card Code
                            // $joker_num = substr(trim($game->joker,'_'), 2);
                            // $card_num = substr(trim($user_card->card,'_'), 2);
                            $card = "";

                            // if($joker_num==$card_num)
                            if ($user_card->card=='JKR1' || $user_card->card=='JKR2') {
                                if ($json) {
                                    $arr = json_decode($json);

                                    $final_arr = array();

                                    $card_json = array();
                                    foreach ($arr as $key => $value) {
                                        if (empty($card) && $value->card_group==0) {
                                            $card = $value->cards[0];
                                            //var_dump($value->cards);
                                            $card_json['card_group'] = "0";
                                            $card_json['cards'][0] = $user_card->card;
                                            $final_arr[] = $card_json;
                                            continue;
                                        }

                                        $final_arr[] = $value;
                                    }
                                    $json =  json_encode($final_arr);
                                }
                            }

                            $card = (!empty($card)) ? $card : $user_card->card;

                            $table_user_data = [
                                'game_id' => $game->id,
                                'user_id' => $chaal,
                                'card' => $card
                            ];

                            $time_out = ($user_type==0) ? 1 : 0;
                            $this->Rummy_model->DropGameCards($table_user_data, $json, $time_out);
                        }
                    } else {
                        $table = $this->Rummy_model->isTableAvail($val->rummy_table_id);
                        $boot_value = $table->boot_value;
                        $ChaalCount = $this->Rummy_model->ChaalCount($game->id, $chaal);

                        $percent = ($ChaalCount>0) ? CHAAL_PERCENT : NO_CHAAL_PERCENT;
                        $amount = round(($percent / 100) * $boot_value, 2);

                        $this->Rummy_model->PackGame($chaal, $game->id, 1, '', $amount, $percent);
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
                    }
                }
            }

            echo '<br>Success';
        }
    }

    public function rummy_pool()
    {
        $tables = $this->RummyPool_model->getActiveTable();

        foreach ($tables as $val) {
            $game = $this->RummyPool_model->getActiveGameOnTable($val->rummy_pool_table_id);
            $table = $this->RummyPool_model->isTableAvail($val->rummy_pool_table_id);
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
                    $timeout_log = $this->RummyPool_model->GameLog($game->id, '', 2, $chaal, 1);
                    // echo count($timeout_log);
                    if (count($timeout_log)<2) {
                        $cards = $this->RummyPool_model->getMyCards($game->id, $chaal);

                        if (count($cards)<=13) {
                            $random_card = $this->RummyPool_model->GetRamdomGameCard($game->id);

                            if ($random_card) {
                                $table_user_data = [
                                    'game_id' => $game->id,
                                    'user_id' => $chaal,
                                    'card' => $random_card[0]->cards,
                                    'added_date' => date('Y-m-d H:i:s'),
                                    'updated_date' => date('Y-m-d H:i:s'),
                                    'isDeleted' => 0
                                ];

                                $this->RummyPool_model->GiveGameCards($table_user_data);
                            }
                        }
                        $user_card = $this->RummyPool_model->GameUserCard($game->id, $chaal);
                        if (!empty($user_card)) {
                            $json_arr = $this->RummyPool_model->GameLog($game->id, 1, 2, $chaal);
                            $json = (empty($json_arr)) ? '' : $json_arr[0]->json;

                            // Joker Card Code
                            // $joker_num = substr(trim($game->joker,'_'), 2);
                            // $card_num = substr(trim($user_card->card,'_'), 2);
                            $card = "";

                            // if($joker_num==$card_num)
                            if ($user_card->card=='JKR1' || $user_card->card=='JKR2') {
                                if (!empty($json)) {
                                    $arr = json_decode($json);

                                    $final_arr = array();

                                    $card_json = array();
                                    foreach ($arr as $key => $value) {
                                        if (empty($card) && $value->card_group==0) {
                                            $card = $value->cards[0];
                                            //var_dump($value->cards);
                                            $card_json['card_group'] = "0";
                                            $card_json['cards'][0] = $user_card->card;
                                            $final_arr[] = $card_json;
                                            continue;
                                        }

                                        $final_arr[] = $value;
                                    }
                                    $json =  json_encode($final_arr);
                                }
                            }

                            $card = (!empty($card)) ? $card : $user_card->card;

                            $table_user_data = [
                                'game_id' => $game->id,
                                'user_id' => $chaal,
                                'card' => $card
                            ];

                            $this->RummyPool_model->DropGameCards($table_user_data, $json, 1);
                        }
                    } else {
                        $percent = CHAAL_PERCENT;
                        $this->RummyPool_model->PackGame($chaal, $val->rummy_pool_table_id, $game->id, 1, '', '', $percent);
                        $game_users = $this->RummyPool_model->GameUser($game->id);

                        if (count($game_users)==1) {
                            $amount = 0;
                            // $this->RummyPool_model->MinusWallet($this->data['user_id'], $amount);
                            $this->RummyPool_model->MakeWinner($game->id, $amount, $game_users[0]->user_id);
                            $winner_data = ['points'=>0, 'table_id'=>$val->rummy_pool_table_id,'user_id'=>$game_users[0]->user_id,'game_id'=>$game->id,'json'=>''];
                            // print_r($winner_data);
                            $this->RummyPool_model->Declare($winner_data);

                            $All_table_users = $this->RummyPool_model->TableUser($val->rummy_pool_table_id);
                            if (count($All_table_users)>=2) {
                                $exceed_count = 1;
                                $user_ids = array();
                                foreach ($All_table_users as $key => $value) {
                                    // if ($value->total_points>MAX_POINT) {
                                    if ($value->total_points>$table->pool_point) {
                                        $exceed_count++;
                                        $user_ids[] = $value->user_id;
                                    } else {
                                        $winner_user_id = $value->user_id;
                                    }
                                }

                                if (count($All_table_users)==$exceed_count) {
                                    // Remove From Table Code
                                    foreach ($user_ids as $va) {
                                        $table_user_data = [
                                            'table_id' => $val->rummy_pool_table_id,
                                            'user_id' =>$va
                                        ];

                                        $this->RummyPool_model->RemoveTableUser($table_user_data);
                                    }
                                    // // Make Winner Code
                                    $comission = $this->Setting_model->Setting()->admin_commission;
                                    $TotalAmount = $this->RummyPool_model->TotalAmountOnTable($user[0]->rummy_pool_table_id);
                                    $admin_winning_amt = round($TotalAmount * round($comission/100, 2));
                                    $user_winning_amt = round($TotalAmount - $admin_winning_amt, 2);

                                    $this->RummyPool_model->updateTotalWinningAmtTable($TotalAmount, $user_winning_amt, $admin_winning_amt, $val->rummy_pool_table_id, $winner_user_id);
                                    $this->RummyPool_model->AddToWallet($user_winning_amt, $winner_user_id);
                                }
                            }
                        }
                    }
                }
            }

            // echo '<br>Success';
        }
    }

    public function rummy_deal()
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
                // print_r($game_users);

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
                    // echo $chaal;
                    $timeout_log = $this->RummyDeal_model->GameLog($game->id, '', 2, $chaal, 1);
                    // echo count($timeout_log);
                    // exit;
                    if (count($timeout_log)<2) {
                        $cards = $this->RummyDeal_model->getMyCards($game->id, $chaal);

                        if (count($cards)<=13) {
                            $random_card = $this->RummyDeal_model->GetRamdomGameCard($game->id);

                            if ($random_card) {
                                $table_user_data = [
                                    'game_id' => $game->id,
                                    'user_id' => $chaal,
                                    'card' => $random_card[0]->cards,
                                    'added_date' => date('Y-m-d H:i:s'),
                                    'updated_date' => date('Y-m-d H:i:s'),
                                    'isDeleted' => 0
                                ];

                                $this->RummyDeal_model->GiveGameCards($table_user_data);
                            }
                        }
                        $user_card = $this->RummyDeal_model->GameUserCard($game->id, $chaal);
                        if (!empty($user_card)) {
                            $json_arr = $this->RummyDeal_model->GameLog($game->id, 1, 2, $chaal);
                            $json = (empty($json_arr)) ? '' : $json_arr[0]->json;

                            // Joker Card Code
                            // $joker_num = substr(trim($game->joker,'_'), 2);
                            // $card_num = substr(trim($user_card->card,'_'), 2);
                            $card = "";

                            // if($joker_num==$card_num)
                            if ($user_card->card=='JKR1' || $user_card->card=='JKR2') {
                                if (!empty($json)) {
                                    $arr = json_decode($json);

                                    $final_arr = array();

                                    $card_json = array();
                                    foreach ($arr as $key => $value) {
                                        if (empty($card) && $value->card_group==0) {
                                            $card = $value->cards[0];
                                            //var_dump($value->cards);
                                            $card_json['card_group'] = "0";
                                            $card_json['cards'][0] = $user_card->card;
                                            $final_arr[] = $card_json;
                                            continue;
                                        }

                                        $final_arr[] = $value;
                                    }
                                    $json =  json_encode($final_arr);
                                }
                            }

                            $card = (!empty($card)) ? $card : $user_card->card;

                            $table_user_data = [
                                'game_id' => $game->id,
                                'user_id' => $chaal,
                                'card' => $card
                            ];

                            $this->RummyDeal_model->DropGameCards($table_user_data, $json, 1);
                        }
                    } else {
                        // echo 'hello';
                        // exit;
                        $table_user_data = [
                            'table_id' => $val->rummy_deal_table_id,
                            'user_id' => $chaal
                        ];

                        $this->RummyDeal_model->RemoveTableUser($table_user_data);
                        $this->RummyDeal_model->PackGame($chaal, $game->id, 1);
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
            }

            echo '<br>Success';
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

    

   
 
}