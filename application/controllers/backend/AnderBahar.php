<?php
class AnderBahar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['AnderBahar_model','Users_model']);
    }

    public function index()
    {
        $AllGames = $this->AnderBahar_model->AllGames();
        foreach ($AllGames as $key => $value) {
            $AllGames[$key]->details=$this->AnderBahar_model->ViewBet('',$value->id);
        }
        // echo '<pre>';print_r($AllGames);die;
        $data = [
            'title' => 'Game History',
            'AllGames' => $AllGames
        ];
        template('ander_baher/index', $data);
    }

    public function ander_baher_bet($id){

        $AllUsers = $this->AnderBahar_model->ViewBet('',$id);
        foreach ($AllUsers as $key => $value) {
            $user_details= $this->Users_model->UserProfile($value->user_id);
            if($user_details){
                $AllUsers[$key]->user_name=$user_details[0]->name;
            }else{
                $AllUsers[$key]->user_name='';
            }
        }
        $data = [
            'title' => 'Game History',
            'AllUsers' => $AllUsers
        ];
        template('ander_baher/show_details', $data);
    }

}
