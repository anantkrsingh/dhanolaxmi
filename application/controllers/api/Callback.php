<?php

use Restserver\Libraries\REST_Controller;

include APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/libraries/Format.php';
class Callback extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Users_model');
        $this->load->model('Coin_plan_model');
        $this->load->helper('string');
    }

    public function index_post()
    {
        $post_data_expected = file_get_contents("php://input");
        $data = [
            'response' => $post_data_expected
        ];
        $this->db->insert('response_log', $data);

        $post = json_decode($post_data_expected);

        //param1 is mandatory
        if (empty($post->param1)) {
            $data['message'] = 'Invalid Order Id';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
        //checks param1 in local
        $order_details = $this->Coin_plan_model->GetUserByOrderId($post->param1);

        if (empty($order_details)) {
            $data['message'] = 'Invalid Order Id';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
        //cross check user id with your local order
        if ($post->user_id!=$order_details[0]->user_id) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
        //cross check amount with your local order
        if ($post->amount!=$order_details[0]->price) {
            $data['message'] = 'Invalid Amount';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
        //cross check if your local payment already done
        if ($post->status==1 && $order_details[0]->payment==0) {
            //update local payment status
            $this->Coin_plan_model->UpdateOrderPaymentStatus($post->param1);
            $this->Users_model->UpdateWalletOrder($order_details[0]->coin, $post->user_id);
        }
    }
}
