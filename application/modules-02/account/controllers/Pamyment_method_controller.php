<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pamyment_method_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->db->query('SET SESSION sql_mode = ""');
		 $this->permission->module('account')->redirect();
		$this->load->model(array(
			'Payment_method_model'
		));		 
	}
 
	public function index()
	{   
        $this->permission->method('account','read')->redirect();
		$data['title']    = display('list'); 
		#-------------------------------#
		$data['paymentMethod'] = $this->Payment_method_model->read();
		$data['module'] = "account";
		$data['page']   = "PamymentMethod/list";   
		echo Modules::run('template/layout', $data); 
	}  

 	public function form($id = null)
	{ 
		$data['title'] = display('add');
		#-------------------------------#
		$this->form_validation->set_rules('payment_method',display('payment_method')  ,'required|max_length[255]');
		
	
		#-------------------------------#
		$data['paymentMethod'] = (Object) $postData = [
			'id' 	        => $this->input->post('id'), 
			'payment_method' 	 => $this->input->post('payment_method'), 
		
		];  
		#-------------------------------#
		if ($this->form_validation->run()) { 

			if (empty($postData['id'])) {

        		$this->permission->method('account','create')->redirect();


			// $this->session->set_flashdata('message', display('image_upload_successfully'));

				if ($this->Payment_method_model->create($postData)) { 
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					$this->session->set_flashdata('exception',  display('please_try_again'));
				}
				redirect("account/Pamyment_method_controller/form"); 

         


			} else {

        		$this->permission->method('account','update')->redirect();


 
			$this->session->set_flashdata('message', display('image_upload_successfully'));
              
				if ($this->Payment_method_model->update($postData)) { 
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					$this->session->set_flashdata('exception',  display('please_try_again'));
				}
				redirect("account/Pamyment_method_controller/form/".$postData['id']);  


			}
 

		} else { 
			if(!empty($id)) {
				$data['title'] = display('update');
				$data['paymentMethod']   = $this->Payment_method_model->findById($id);
			}
			$data['module'] = "account";
			$data['page']   = "PamymentMethod/form";   
			echo Modules::run('template/layout', $data); 
		}   
	}
 

	public function delete($id = null) 
	{ 
        $this->permission->method('account','delete')->redirect();

		if ($this->Payment_method_model->delete($id)) {
			#set success message
			$this->session->set_flashdata('message',display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception',display('please_try_again'));
		}
		redirect('account/bank/index');
	}
	 

}
