<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ChatController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('chat_model'); // Load your chat model
    }

    public function index()
    {
        $this->load->view('chat');
    }

    public function get_messages()
    {
            $messages = $this->chat_model->get_new_messages();
            if (!empty($messages)) {
                echo json_encode($messages);
            }
    }

    public function send_message()
    {
        $message = $this->input->post('message');
        $this->chat_model->save_message($message);
    }
}
