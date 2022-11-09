<?php
class RedBlack extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['RedBlack_model','Users_model']);
    }

    public function index()
    {
        $AllGames = $this->RedBlack_model->AllGames();
        $RandomFlag = $this->RedBlack_model->getRandomFlag('red_black_random');
        // foreach ($AllGames as $key => $value) {
        //     $AllGames[$key]->details=$this->RedBlack_model->ViewBet('',$value->id);
        // }
        // echo '<pre>';print_r($AllGames);die;
        $data = [
            'title' => 'Red Vs Black History',
            'AllGames' => $AllGames,
            'RandomFlag'=>$RandomFlag->red_black_random
        ];
        template('red_black/index', $data);
    }

    public function RedBlackBet($id){

        $AllUsers = $this->RedBlack_model->ViewBet('',$id);
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
        template('red_black/show_details', $data);
    }
    public function ChangeStatus() {
        
        $Change = $this->RedBlack_model->ChangeStatus();
        if ( $Change ) {
            echo 'true';
        } else {
            echo 'false';
        }
       
    }
}
