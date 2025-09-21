<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_controller extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->permission->module('account')->redirect();
        $this->load->model(array(
            'account_model','price/price_model'
            //  New code 2021 direct update
            , 'Payment_method_model'
            //New code 2021 direct update  
        ));      
    }
   
    public function create_account()
    { 
        $this->permission->method('account','read')->redirect();
        $data['title'] = display('account');
        #-------------------------------#
        $this->form_validation->set_rules('account_name',display('account_name'),'required|max_length[150]');
        $this->form_validation->set_rules('account_type',display('account_type'),'required|max_length[10]');
        
      
        #-------------------------------#
        if ($this->form_validation->run() === true) 
        {

            $postData = [
                'account_name'      => $this->input->post('account_name',true),
                'account_type'      => $this->input->post('account_type',true),   
            ];   

            if ($this->account_model->account_create($postData)) { 
                $this->session->set_flashdata('message', display('successfully_saved'));
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
            redirect("account/account_controller/create_account");

        } else {
            $data['title']  = display('account');
            $data['module'] = "account";
            $data['acview'] = $this->account_model->account_view();
            $data['page']   = "account_form";   
          echo Modules::run('template/layout', $data); 
        }   
    }

    public function account_delete($id=null)
    {
        $this->permission->method('account','delete')->redirect();
        if($this->account_model->delete_account($id)) {
            #set success message
            $this->session->set_flashdata('message',display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception',display('please_try_again'));
        }
        redirect('account/account_controller/create_account');
    }

    public function account_update($id = null)
    { 
        $this->permission->method('account','update')->redirect();
        $data['title'] = display('price');
        #-------------------------------#
         $this->form_validation->set_rules('account_id',display('account_id'));
        $this->form_validation->set_rules('account_name',display('account_name'),'required|max_length[150]');
        $this->form_validation->set_rules('account_type',display('account_type'),'required|max_length[20]');
        #-------------------------------#
        if ($this->form_validation->run() === true) {

            $Data = [    
            'account_id'   =>$this->input->post('account_id',true),
            
            'account_name' => $this->input->post('account_name',true),
            'account_type' => $this->input->post('account_type',true),
            ];   

            if ($this->account_model->update_account($Data)) { 
                $this->session->set_flashdata('message', display('successfully_updated'));
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
            redirect("account/account_controller/create_account");



        } else {
           $data['title']      = display('update');
            $data['data']      =$this->account_model->account_updateForm($id);
            $data['module']    = "account";    
            $data['page']      = "update_account_form";   
            echo Modules::run('template/layout', $data);  
        }   
    }
 

    public function create_transaction()
    { 
        ini_set('memory_limit', '1024M');
       
        $this->permission->method('account','read')->redirect();
        $data['title'] = display('account');
        #-------------------------------#
        $this->form_validation->set_rules('account_id',display('account_id'),'required|max_length[150]');
        $this->form_validation->set_rules('transaction_description',display('transaction_description'),'max_length[200]');

         $this->form_validation->set_rules('amount',display('amount'),'required|max_length[150]');
        $this->form_validation->set_rules('pass_book_id',display('pass_book_id'),'max_length[200]');
         $this->form_validation->set_rules('trip_id',display('trip_id'),'max_length[150]');
        $this->form_validation->set_rules('payment_id',display('payment_id'),'max_length[200]');

        $currency_details = $this->price_model->retrieve_setting_editdata();

         // New code 2021 direct update
         $this->form_validation->set_rules('payment_method',display('payment_method'),'max_length[200]');
        if ($image = $this->fileupload->do_upload('./application/modules/account/assets/images/invoice/', 'image')) {
           $this->session->set_flashdata('message', display('image_upload_successfully'));
         }
         // New code 2021 direct update
       
        if(!empty($this->input->post('agent_id',true))){
            $agent_details = 'Agent ID :'.$this->input->post('agent_id').'-';
        }else{
            $agent_details = '';
        }
        foreach ($currency_details as $price) {
        }
        $currency=$price['currency'];
        #-------------------------------#
        if ($this->form_validation->run()) 
        {
           

            $postData = [
                'account_id'       => $this->input->post('account_id',true),
                'transaction_description'   => $agent_details.$this->input->post('transaction_description',true),

                'amount'        => $this->input->post('amount',true),
                'create_by_id'  => $this->session->userdata('id'),
                 #-----------New code for store data in db-----------#
                'date'        => date('Y-m-d H:i:s'),
                 #-----------New code for store data in db-----------#

                 // New code 2021 direct update
                 'document_pic' =>   $image, 
                 'payment_method' =>   $this->input->post('payment_method'), 
                // New code 2021 direct update
            ];   
            $agent_debit = [
                'agent_id'       => $this->input->post('agent_id',true),
                'debit'   => $this->input->post('amount',true),
                'date'        => date('Y-m-d'),
            ];
            $agent_credit = [
                'agent_id'       => $this->input->post('agent_id',true),
                'credit'   => $this->input->post('amount',true),
                'date'        => date('Y-m-d'),
            ];
            
           
            if ($this->account_model->trans_create($postData)) { 
                 // New code 2021 direct update 
                 
                 if($this->input->post('agent_id') != NULL){
                   
                    if($this->input->post('type') == "income"){
                        $this->db->insert('agent_ledger',$agent_credit);
                        
                        $agent_ledger_new = array();
                       
                            $agent_ledger_new = [
                                'agent_id' => $this->input->post('agent_id',true),
                                'credit' => $this->input->post('amount',true),
                                'date' => date('Y-m-d H:i:s'),
                                'detail' => $this->input->post('transaction_description',true),
                                
                            ];

                            $this->db->insert('agent_ledger_total', $agent_ledger_new);
                       
                        // New code 2021 direct update 

                    }
                    elseif($this->input->post('type') == "expense")
                    {
                       $this->db->insert('agent_ledger',$agent_debit); 
                         // New code 2021 direct update 
                         $agent_ledger_new = array();
                       
                         $agent_ledger_new = [
                             'agent_id' => $this->input->post('agent_id',true),
                             'debit' => $this->input->post('amount',true),
                             'date' => date('Y-m-d H:i:s'),
                             'detail' => $this->input->post('transaction_description',true),
                             
                         ];

                         $this->db->insert('agent_ledger_total', $agent_ledger_new);
                    
                     // New code 2021 direct update 

                    }

                    
                }
                $this->session->set_flashdata('message', display('successfully_saved'));
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
            redirect("account/account_controller/create_transaction");

        } else { 
            $data['title']      = display('account_transaction');
            $data['module']     = "account";
            $data['currency']   = $currency;
            $data['accountlist']=$this->account_model->accountlist();

            // New code 2021 direct update
            $data['paymethod']=$this->Payment_method_model->paymentmethod();
            if($this->session->userdata('isAdmin') == 0)
            {
                $agent_com_per = $this->db->select('*')->from('agent_info')->where('agent_email', $this->session->userdata('email'))->get()->row();
                $data['agent_id'] = $agent_com_per->agent_id;
                
            }

            // if($this->session->userdata('isAdmin') == 1)
            // {
               
            // }
            
           
            
            // $data['agent_list'] = $this->account_model->agent_list();

         // New code 2021 direct update
            $data['acc']        =$this->account_model->acc();
            $data['acctrans']   =$this->account_model->trans_view(); 
            $data['page']       = "transaction_form";   
            echo Modules::run('template/layout', $data);  
        }   
    } 

    public function transaction_delete($id = null)
    {
        $this->permission->method('account','delete')->redirect();
        if($this->account_model->delete_trans($id)) {
            #set success message
            $this->session->set_flashdata('message',display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception',display('please_try_again'));
        }
        redirect('account/account_controller/create_transaction');
    }

    public function transaction_update($id = null, $account_type = null)
    { 
        $this->permission->method('account','update')->redirect();
        $data['title'] = display('transaction');
        #-------------------------------#
         $this->form_validation->set_rules('account_tran_id',display('account_tran_id'));
         $this->form_validation->set_rules('account_id',display('account_id'),'required|max_length[150]');
        $this->form_validation->set_rules('transaction_description',display('transaction_description'),'max_length[200]');

         $this->form_validation->set_rules('amount',display('amount'),'required|max_length[150]');
        $this->form_validation->set_rules('pass_book_id',display('pass_book_id'),'max_length[200]');
         $this->form_validation->set_rules('trip_id',display('trip_id'),'max_length[150]');
        $this->form_validation->set_rules('payment_method',display('payment_method'),'max_length[200]');
        #-------------------------------#


        


        if ($this->form_validation->run()) {

        // New code 2021 direct update

         if($_FILES['image']['name']=='')
         {
            $this->db->where('account_tran_id', $id);
            $query = $this->db->get('acn_account_transaction');
            $result = $query->row();
            $image = $result->document_pic; 
         }

         else
         {
            $image =  $this->fileupload->do_upload('./application/modules/account/assets/images/invoice/', 'image');
         }

          // New code 2021 direct update

            $Data = [    
                'account_tran_id'     =>$this->input->post('account_tran_id',true),
                'account_id'          => $this->input->post('account_id',true),
                'transaction_description' => $this->input->post('transaction_description', true),
                'amount'              => $this->input->post('amount',true),
                'create_by_id'        => $this->session->userdata('id'),

                  // New code 2021 direct update
                  'document_pic' =>   $image, 
                  'payment_method' =>   $this->input->post('payment_method'), 
                 // New code 2021 direct update
            ];   

            if ($this->account_model->update_trans($Data)) { 
                $this->session->set_flashdata('message', display('successfully_updated'));
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
            redirect("account/account_controller/create_transaction");
        } else {
            $data['title']     = display('update');
            $data['module']    = "account";  
            $data['data']      = $this->account_model->details($id);
            $data['accountlist']=$this->account_model->acdropdown($account_type); 

            // New code 2021 direct update
            $data['paymethod']=$this->Payment_method_model->paymentmethoddropdown();
            // New code 2021 direct update
            
            $data['page']      = "update_trans_form";   
            echo Modules::run('template/layout', $data);  
        }   
    }
 

    public function view_details()
    {
        $this->permission->method('account','read')->redirect();
         $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency=$price['currency'];
        $id = $this->uri->segment(4);
        $data['title']    = display('details');  
        $data['detail']   = $this->account_model->details($id); 
        $data['currency'] = $currency;
        $data['module']   = "account";
        $data['page']     = "account_details";   
        echo Modules::run('template/layout', $data); 
    }

    
}
