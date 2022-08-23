<?php
class ColorPrediction extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ColorPrediction_model','Users_model']);
    }

    public function index()
    {
        $AllGames = $this->ColorPrediction_model->AllGames();
        foreach ($AllGames as $key => $value) {
            $AllGames[$key]->details=$this->ColorPrediction_model->ViewBet('',$value->id);
        }
        // echo '<pre>';print_r($AllGames);die;
        $data = [
            'title' => 'Game History',
            'AllGames' => $AllGames
        ];
        template('color_prediction/index', $data);
    }

    public function color_prediction_bet($id){

        $AllUsers = $this->ColorPrediction_model->ViewBet('',$id);
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
        template('color_prediction/show_details', $data);
    }

}
