<?php

    Class Car_model extends CI_Model{

        public function create($formArray){

            $this->db->insert('car_models',$formArray);
            $id = $this->db->insert_id();
        }

        // This method will return all records from car_models table
        public function all(){
            
            $this->db->order_by('id','ASC');
            return $this->db->get('car_models')->result();  //SELECT * FROM car_models order by ASC
            // return  $this->db->last_query();
            
        }

        public function getRow($id){
            $this->db->where('id',$id);
            return $this->db->get('car_models')->row();
            //SELECT * FROM car_model WHERE id = $id
            return $id;
        }

        public function updateModel($id,$formArray){
            $this->db->where('id',$id);
            $this->db->update('car_models',$formArray);
            return $id;
        }

        public function delete($id){
            $this->db->where('id',$id);
            $this->db->delete('car_models');
        }
    }
?>