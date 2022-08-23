<?php
class DragonTiger extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['DragonTiger_model','Users_model']);
    }

    public function index()
    {
        $AllGames = $this->DragonTiger_model->AllGames();
        foreach ($AllGames as $key => $value) {
            $AllGames[$key]->details=$this->DragonTiger_model->ViewBet('',$value->id);
        }
        // echo '<pre>';print_r($AllGames);die;
        $data = [
            'title' => 'Game History',
            'AllGames' => $AllGames
        ];
        template('dragon_tiger/index', $data);
    }

    public function dragon_bet($id){

        $AllUsers = $this->DragonTiger_model->ViewBet('',$id);
        foreach ($AllUsers as $key => $value) {
            $user_details= $this->Users_model->UserProfile($value->user_id);
            $AllUsers[$key]->user_name='';
            if($user_details){
                $AllUsers[$key]->user_name=$user_details[0]->name;
            }
        }
        $data = [
            'title' => 'Game History',
            'AllUsers' => $AllUsers
        ];
        template('dragon_tiger/show_details', $data);
    }

}
