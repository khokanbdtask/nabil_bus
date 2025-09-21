<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once './vendor/dompdf/autoload.inc.php';

class Luggage_report extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');

        $this->load->model(array(
            'luggage_model',
            'country_model',
            'passenger_model',
            'price/price_model',
            'website/website_model'
        ));
    }

    public function index()
    {
        $this->permission->method('luggage', 'read')->redirect();
        $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
            $currency = $price['currency'];
        }
        $data['title'] = display('list');

        $data["filters"] = $this->luggage_model->read();
        $data['tps'] = $this->luggage_model->fleet_dropdown();
        $data['route_dropdown'] = $this->luggage_model->route_dropdown();
        // New code 2021 direct update 
        $data['agent_list'] = $this->luggage_model->agent_list();
        // New code 2021 direct update 

        $data["logo"] = $this->db->select("*")
        ->from('setting')
        ->get()
        ->row();

        $data['currency'] = $currency;
        $data['module'] = "luggage_nitol";
        $data['page'] = "booking/luggage_report";
        echo Modules::run('template/layout', $data);
    }

    public function filter()
    {

        if ($this->input->post('mysubmit')) {
            $this->form_validation->set_rules('datefrom', display('date'), 'required|max_length[11]');
            $this->form_validation->set_rules('dateto', display('date'), 'required|max_length[11]');


            if ($this->form_validation->run()) {

                $datefrom = date("Y-m-d", strtotime($this->input->post('datefrom')));
                $dateto = date("Y-m-d", strtotime($this->input->post('dateto')));
                $ftypes = $this->input->post('ftypes');
                $route_id = $this->input->post('route_id');
                // New code 2021 direct update 
                $agent_id = $this->input->post('agent_id');
                $result = $this->db->select('*')->from('user')->where('email', $agent_id)->get()->result();
                                            foreach ($result as $name) {
                                                $agent_id = $name->id;
                                            }
                // New code 2021 direct update 
                $data['payment_status'] = $payment_status = $this->input->post('payment_status');


                $data['datefrom'] = $datefrom;
                $data['dateto'] = $dateto;
                // New code 2021 direct update 
                $data['filters'] = $this->luggage_model->luggage_report($datefrom, $dateto, $ftypes, $route_id,$payment_status,$agent_id);
                // New code 2021 direct update 
            } else {
                $data['status'] = false;
                $data['exception'] = validation_errors();
            }

            $currency_details = $this->price_model->retrieve_setting_editdata();
            foreach ($currency_details as $price) {
                $currency = $price['currency'];
            }
            $data['title'] = display('list');

            $data["bookings"] = $this->luggage_model->read();
            $data['tps'] = $this->luggage_model->fleet_dropdown();
            $data['route_dropdown'] = $this->luggage_model->route_dropdown();

            // New code 2021 direct update 
            $data['agent_list'] = $this->luggage_model->agent_list();
             // New code 2021 direct update 
            $data['currency'] = $currency;
            $data['module'] = "luggage_nitol";
            $data['page'] = "booking/luggage_report";


//             echo "<pre>";
//             print_r($data);
//             exit();

            echo Modules::run('template/layout', $data);
        }

    }
}