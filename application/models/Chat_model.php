<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

    public function get_new_messages() {
        $this->load->database();
        $query = $this->db->get('chat')->result();
        return $query;
    }

    public function save_message($message) {
        $this->load->database();
        $data = [
            'chat_messages' => $message,
        ];
        $this->db->insert('chat', $data);
    }
}
