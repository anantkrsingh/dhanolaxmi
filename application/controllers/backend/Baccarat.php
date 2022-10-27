<?php
class Baccarat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Baccarat_model','Users_model']);
    }

    public function index()
    {
        $AllGames = $this->Baccarat_model->AllGames();
        foreach ($AllGames as $key => $value) {
            $AllGames[$key]->details=$this->Baccarat_model->ViewBet('',$value->id);
        }
        // echo '<pre>';print_r($AllGames);die;
        $data = [
            'title' => 'Game History',
            'AllGames' => $AllGames
        ];
        template('baccarat/index', $data);
    }

    public function baccarat_bet($id){

        $AllUsers = $this->Baccarat_model->ViewBet('',$id);
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
        template('baccarat/show_details', $data);
    }

}
