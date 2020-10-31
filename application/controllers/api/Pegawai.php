<?php 
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pegawai extends REST_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Pegawai_model','pegawai');
    }


    public function index_get(){
       
        $id=$this->get('id');

        if ($id === null) {
            $pegawai = $this->pegawai->getPegawai();
        }else{
            $pegawai= $this->pegawai->getPegawai($id);
        }

        
        if ($pegawai) {
            $this->response([
                'status' => true,
                'data' => $pegawai 
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
        else{
      // Set the response and exit
        $this->response([
        'status' => FALSE,
        'message' => 'id found'
    ], REST_Controller::HTTP_NOT_FOUND);
        }


    }


    public function index_delete()
    {
        $id = $this->delete('id');
 
        if ($id === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'provide an Id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        else{

            if ($this->pegawai->deletePegawai($id)>0) {
                   //ok 
                   $this->response([
                    'status' => true,
                    'id'=>$id,
                    'message'=> 'deleted'
                ], REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }

        }
    }

    public function index_post(){

        $foto = $_FILES['avatar'];
        if ($foto='') {
        
        }

        else{
            $config['upload_path'] ='./assets/foto';
            $config['allowed_types'] ='jpg|png|gif|jpeg';
            
            $this->load->library('upload',$config);
            
            if (!$this->upload->do_upload('avatar')) {
                echo 'Upload gagal';
                die();  
            }
            else{
                $foto=$this->upload->data('file_name');
            }
        }

        $data=[
          'email'=> $this->post('email'),
          'name'=> $this->post('name'),
          'phone'=> $this->post('phone'),
          'avatar'=> $foto,
        ];

        if ($this->pegawai->createPegawai($data)>0) {
            $this->response([
                'status' => true,
                'message' => 'new employee has been created'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed to created new employee'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function index_put(){

        
        $id = $this->put('id');
        $eksfoto= $this->post('eksfoto');
        
        $foto = $_FILES['avatar'];
        if ($foto='') {
        
        }

        else{
            $config['upload_path'] ='./assets/foto';
            $config['allowed_types'] ='jpg|png|gif|jpeg';
            
            $this->load->library('upload',$config);
            
            if (!$this->upload->do_upload('avatar')) {
                echo 'Upload gagal';
                die(); 
                // $foto=$eksfoto; 
            }
            else{
                $foto=$this->upload->data('file_name');
            }
        }

        $data=[
            'email'=> $this->post('email'),
            'name'=> $this->post('name'),
            'phone'=> $this->post('phone'),
            'avatar'=> $foto,
          ];
  
          if ($this->pegawai->updatePegawai($data,$id)>0) {
              $this->response([
                  'status' => true,
                  'message' => 'new employee has been updated'
              ], REST_Controller::HTTP_OK);
          }else{
              $this->response([
                  'status' => false,
                  'message' => 'failed to update employee'
              ], REST_Controller::HTTP_BAD_REQUEST);
          }
    }





}

?>