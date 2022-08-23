<?php

class AnimalRoulette extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['AnimalRoulette_model','Users_model']);
    }

    public function index()
    {
        $AllGames = $this->AnimalRoulette_model->AllGames();
        foreach ($AllGames as $key => $value) {
            $AllGames[$key]->details=$this->AnimalRoulette_model->ViewBet('', $value->id);
        }
        // echo '<pre>';print_r($AllGames);die;
        $data = [
            'title' => 'Game History',
            'AllGames' => $AllGames
        ];
        template('animal_roulette/index', $data);
    }

    public function animal_roulette_bet($id)
    {
        $AllUsers = $this->AnimalRoulette_model->ViewBet('', $id);
        foreach ($AllUsers as $key => $value) {
            $user_details= $this->Users_model->UserProfile($value->user_id);
            if ($user_details) {
                $AllUsers[$key]->user_name=$user_details[0]->name;
            } else {
                $AllUsers[$key]->user_name='';
            }
        }
        $data = [
            'title' => 'Game History',
            'AllUsers' => $AllUsers
        ];
        template('animal_roulette/show_details', $data);
    }
}