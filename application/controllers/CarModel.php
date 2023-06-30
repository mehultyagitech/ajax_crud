<?php

class CarModel extends CI_Controller{

    // this method will show car listing page 
    function index(){
        $this->load->model('Car_model');
        $data['rows']= $this->Car_model->all();
        // var_dump($data);
        // die();
        $this->load->view('car_model/list',$data);
    }

    public function showCreateForm(){
        $html = $this->load->view('car_model/create.php','',true);
        $response['html'] = $html;
        echo json_encode($response);
    }

    public function saveModel(){

        $this->load->model('Car_model');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('color','color','required');
        $this->form_validation->set_rules('price','Price','required');

        if($this->form_validation->run() == true){
            //save entries to db

            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['price'] = $this->input->post('price');
            $formArray['transmission'] = $this->input->post('transmission');
            $formArray['color'] = $this->input->post('color');
            $formArray['created_at'] = date('y-m-d h:i:s');

            $id = $this->Car_model->create($formArray);

            //$row = $this->car_model->getRow($id);
            //$vData['row'] = $row;
            //$rowHtml = $this->load->view('car_model/car_row', $vData, true);
            
            //$response['row'] = $rowHtml;

            $response['status'] = 1;
            $response['message'] = "<div class = \"alert alert-success\">Record has been added successfully.</div>";

        }else{

            $response['status'] = 0;
            $response['name'] = strip_tags(form_error('name'));
            $response['price'] = strip_tags(form_error('price'));
            $response['color'] = strip_tags(form_error('color'));

            //return error messages
        }

        echo json_encode($response);

    }

    // This method will return the edit form like create form
    public function getCarModel(){
        $this->load->model('Car_model');
        $id=$this->input->post('id');
        $data['row']= $this->Car_model->getRow($id);
    // var_dump($data['row']);
        $html = $this->load->view('car_model/edit',$data,TRUE);
        
        echo json_encode($html);
    }

    public function updateModel(){
        $this->load->model('Car_model');
        $id = $this->input->post('id');
        // var_dump($id);die();
        $row = $this->Car_model->getRow($id);
        
        if(empty($row)){
            $response['msg'] = "Either record deleted from the db";
            $response['status'] = 100;
            json_encode($response);
            exit;
        }
        
        $this->load->model('Car_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('color','Color','required');
        $this->form_validation->set_rules('price','Price','required');

            


        if($this->form_validation->run() == true){
            //save entries to db
            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['price'] = $this->input->post('price');
            $formArray['transmission'] = $this->input->post('transmission');
            $formArray['color'] = $this->input->post('color');
            $formArray['updated_at'] = date('y-m-d h:i:s');
            // var_dump($formArray);die();
            $id = $this->Car_model->updateModel($id,$formArray);
            $row = $this->Car_model->getRow($id);

            $response['row'] = $row;
            $response['status'] = 1;
            $response['message'] = "<div class = \"alert alert-success\">Record has been added successfully.</div>";

        }else{
            $response['status'] = 0;
            $response['name'] = strip_tags(form_error('name'));
            $response['price'] = strip_tags(form_error('price'));
            $response['color'] = strip_tags(form_error('color'));

            //return error messages
        }

        echo json_encode($response);

    }

    public function deleteModel($id){
        $this->load->model('Car_model');
        $row = $this->Car_model->getRow($id);
        
        if(empty($row)){
            $response['msg'] = "Either record deleted from the db";
            $response['status'] = 0;
            echo json_encode($response);
            exit;
        } else {
            $this->Car_model->delete($id);
            $response['msg'] = "Record has been deleted successfully";
            $response['status'] = 1;
            echo json_encode($response); 
        }
        
    }




}
?>
