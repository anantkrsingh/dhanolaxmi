<?php
class Pokers extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Poker_model','Users_model']);
    }

    public function index()
    {
        $AllGames = $this->Poker_model->AllGames();
        $data = [
            'title' => 'Poker History',
            'AllGames' => $AllGames,
        ];
        template('poker/index', $data);
    }
}
