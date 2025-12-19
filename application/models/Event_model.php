<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

    private $table = 'event';

    public function get_all() {
        return $this->db->order_by('created_at','DESC')->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id_event'=>$id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_event',$id)->update($this->table, $data);
    }

    public function delete($id) {
        $event = $this->get_by_id($id);
        if ($event && $event->foto) {
            @unlink('./uploads/event/'.$event->foto);
        }
        return $this->db->where('id_event',$id)->delete($this->table);
    }
}
