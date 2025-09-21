<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disclaimer extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'terms_model',
        ));
    }

    //payment term and condition
    public function disclaimer_form($id = 1)
    {
        // $this->permission->method('disclaimer', 'create')->redirect();
        $data['title'] = display('add');
        #-------------------------------#
        $this->form_validation->set_rules('disclaimer_details', display('disclaimer'), 'required');
        #-------------------------------#
        $data['disclaimer'] = (object)$postData = [
            'id' => $this->input->post('id'),
            'disclaimer_details' => $this->input->post('disclaimer_details')
        ];

        // $data['disclaimer'] = array();

        if ($this->form_validation->run()) {

            if (empty($postData['id'])) {

                // $this->permission->method('disclaimer', 'create')->redirect();

                if ($this->terms_model->create_disclaimer($postData)) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                    redirect('website/disclaimer/disclaimer_form');
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                    redirect("website/disclaimer/disclaimer_form");
            } else {

                // $this->permission->method('disclaimer', 'update')->redirect();

                if ($this->terms_model->update_disclaimer($postData)) {

                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("website/disclaimer/disclaimer_form/" . $postData['id']);
            }
        } else {
            if (!empty($id)) {
                $data['title'] = display('update');
                $data['disclaimer'] = $this->terms_model->disclaimerinfo($id);
            }
            $data['module'] = "website";
            $data['page'] = "booking/disclaimer";


            // echo "<pre>";
            // print_r($data);
            // exit();

            echo Modules::run('template/layout', $data);
        }
    }


// // terms and condition list
//     public function disclaimer_list()
//     {
//         $data["terms"] = $this->terms_model->term_and_condition_list();
//         $data['module'] = "website";
//         $data['page'] = "booking/term_condition_list";
//         echo Modules::run('template/layout', $data);
//     }

//     //terms_delete
//     public function disclaimer_delete($id = null)
//     {

//         if ($this->terms_model->terms_delete($id)) {
//             #set success message
//             $this->session->set_flashdata('message', display('delete_successfully'));
//         } else {
//             #set exception message
//             $this->session->set_flashdata('exception', display('please_try_again'));
//         }
//         redirect("website/terms/terms_and_condition_list");
//     }


}
