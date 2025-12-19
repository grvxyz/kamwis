<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri_model extends CI_Model {

    protected $table = 'galeri';

    public function get_all(){
        return $this->db
            ->order_by('created_at','DESC')
            ->get($this->table)
            ->result();
    }

    public function simpan($input, $files){
        $id = $input->post('id_galeri');

        $data = [
            'id_admin'   => 1, // nanti dari session
            'jenis'      => $input->post('jenis'),
            'heading'    => $input->post('heading'),
            'deskripsi'  => $input->post('deskripsi')
        ];

        // FOTO
        if($data['jenis'] === 'foto' && !empty($files['file']['name'])){
            $foto = $this->upload_foto();
            if($foto){
                $data['file'] = $foto;
            }
        }

        // VIDEO (LINK)
        if($data['jenis'] === 'video'){
            $data['file'] = $input->post('file_video');
        }

        if($id){
            $this->db->where('id_galeri',$id)->update($this->table,$data);
            $msg = 'Galeri berhasil diperbarui';
        }else{
            $this->db->insert($this->table,$data);
            $msg = 'Galeri berhasil ditambahkan';
        }

        return ['status'=>'success','message'=>$msg];
    }

    private function upload_foto(){
        $CI =& get_instance();

        $config = [
            'upload_path'   => './uploads/galeri/',
            'allowed_types' => 'jpg|jpeg|png',
            'file_name'     => 'galeri_' . time(),
            'max_size'      => 2048
        ];

        $CI->upload->initialize($config);

        if(!$CI->upload->do_upload('file')){
            return false;
        }

        return $CI->upload->data('file_name');
    }

    public function delete($id){
        return $this->db->where('id_galeri',$id)->delete($this->table);
    }
}
