<?php 


class Pegawai_model extends CI_Model {
     
    public function getPegawai($id=null){

        if ($id===null) {
            return $this->db->get('biodata')->result_array();
        }else{
            return $this->db->get_where('biodata',['id'=>$id])->result_array();
        }
    }

    public function deletePegawai($id){
        $this->db->delete('biodata',['id'=> $id]);
        return $this->db->affected_rows();
    }

    public function createPegawai($data)
    {
        $this->db->insert('biodata',$data);
        return $this->db->affected_rows();
    }

    public function updatePegawai($data,$id){
        $this->db->update('biodata',$data,['id' => $id]);
        return $this->db->affected_rows();
    }


}