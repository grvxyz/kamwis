
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_DB_query_builder $db
 */
class Event extends CI_Controller {


    public function __construct(){
        parent::__construct();
        $this->load->model('Event_model');
        $this->load->library(['upload','image_lib']);
              if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'admin'
        ) {
            redirect('auth/login');
        }

        // 🔥 AUTO NONAKTIF EVENT YANG SUDAH SELESAI
        $this->auto_nonaktif_event();
    }

    /**
     * AUTO NONAKTIF EVENT JIKA SUDAH LEWAT TANGGAL SELESAI
     */
    private function auto_nonaktif_event()
    {
        $this->db->where('tanggal_selesai <', date('Y-m-d'));
        $this->db->where('status', 'aktif');
        $this->db->update('event', ['status' => 'nonaktif']);
    }

    /**
     * HALAMAN UTAMA
     */
    public function index(){
        $data['event'] = $this->Event_model->get_all() ?? [];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/event/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * AJAX SIMPAN (TAMBAH & EDIT)
     */
    public function ajax_simpan(){
        $id = $this->input->post('id_event');

        $tanggal_selesai = $this->input->post('tanggal_selesai');

        // ⛔ PAKSA NONAKTIF JIKA TANGGAL SUDAH LEWAT
        $status = $this->input->post('status');
        if($tanggal_selesai < date('Y-m-d')){
            $status = 'nonaktif';
        }

        $data = [
            'id_admin'        => 1, // nanti ambil dari session
            'nama_event'      => $this->input->post('nama_event'),
            'deskripsi'       => $this->input->post('deskripsi'),
            'tanggal_mulai'   => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $tanggal_selesai,
            'lokasi'          => $this->input->post('lokasi'),
            'status'          => $status
        ];

        /**
         * UPLOAD FOTO
         */
        if(!empty($_FILES['foto']['name'])){
            $config['upload_path']   = './uploads/event/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'event_' . time();
            $config['max_size']      = 2048;

            $this->upload->initialize($config);

            if($this->upload->do_upload('foto')){
                $img = $this->upload->data();

                // RESIZE (Landscape Friendly)
                $resize = [
                    'image_library'  => 'gd2',
                    'source_image'   => $img['full_path'],
                    'maintain_ratio' => TRUE,
                    'width'          => 1200
                ];

                $this->image_lib->clear();
                $this->image_lib->initialize($resize);
                $this->image_lib->resize();

                $data['foto'] = $img['file_name'];
            }
        }

        if($id){
            $this->Event_model->update($id, $data);
        }else{
            $this->Event_model->insert($data);
        }

        echo json_encode([
            'status' => 'success',
            'message'=> ($tanggal_selesai < date('Y-m-d'))
                ? 'Event disimpan sebagai NONAKTIF karena sudah selesai'
                : 'Event berhasil disimpan'
        ]);
    }

    /**
     * AJAX HAPUS
     */
    public function ajax_hapus(){
        $id = $this->input->post('id');

        if(!$id){
            echo json_encode(['status'=>'error','message'=>'ID tidak valid']);
            return;
        }

        $this->Event_model->delete($id);

        echo json_encode([
            'status' => 'success',
            'message'=> 'Event berhasil dihapus'
        ]);
    }
}
