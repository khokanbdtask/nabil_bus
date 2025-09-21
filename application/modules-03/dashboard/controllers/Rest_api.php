<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_api extends MX_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
      $this->db->query('SET SESSION sql_mode = ""');
 		$this->load->model(array(
 			'auth_model',
 		   'api_model' 
 		));
 		if (! $this->session->userdata('isLogIn'))
			redirect('login');
 	}

 	public function index()
	{ 
		$data['title']      = display('secret_key_list');
		$data['module'] 	= "dashboard";  
		$data['page']   	= "api/list";   
		$data['api']        = $this->api_model->read();
		echo Modules::run('template/layout', $data); 
	}

	public function form($id = null)
	{ 
		
		/*-----------------------------------*/
		$this->form_validation->set_rules('secret_key', display('secret_key'),'required|max_length[250]');
		#------------------------#
	    $check_exist = $this->api_model->check_key($this->input->post('secret_key',true)); 
		/*-----------------------------------*/
		$data['api'] = (object)$userLevelData = array(
			'id' 		  => $this->input->post('id'),
			'secret_key'  => $this->input->post('secret_key',true),
			'create_by'   => $this->session->userdata('id'),
			
		);

		/*-----------------------------------*/
		if ($this->form_validation->run()) {
          
			if (empty($userLevelData['id'])) {
				if($check_exist < 1){
				if ($this->api_model->create($userLevelData)) {
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
		
			}else{
			  $this->session->set_flashdata('exception', display('key_already_exist'));	
			}
              redirect("dashboard/rest_api/form/");
			} else {
				if ($this->api_model->update($userLevelData)) {
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));
				}

				redirect("dashboard/rest_api/form/$id");
			}


		} else {
			$data['title']    = display('add_secret_key');
			$data['module'] = "dashboard";  
			$data['secret_key'] =  hash ( "sha256", $this->randID());
			$data['page']   = "api/form"; 
			if(!empty($id))
			$data['api']   = $this->api_model->single($id);
			echo Modules::run('template/layout', $data);
		}
	}

	public function delete($id = null)
	{ 
		if ($this->api_model->delete($id)) {
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			$this->session->set_flashdata('exception', display('please_try_again'));
		}

		redirect("dashboard/rest_api/index");
	}

	 public function randID()
    {
        $result = ""; 
        $chars  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $charArray = str_split($chars);
        for($i = 0; $i < 10; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return "SK-".$result;
    }
	
}
