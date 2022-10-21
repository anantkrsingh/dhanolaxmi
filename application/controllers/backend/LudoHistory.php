<?php

class LudoHistory extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['LudoTableMaster_model']);
    }


    public function index()
    {
        $AllGames = $this->LudoTableMaster_model->getHistory();
        $data = [
            'title' => 'Ludo History',
            'AllGames' => $AllGames
        ];
        template('ludo_table_master/history', $data);
    }

  
}