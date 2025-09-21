<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->db->query('SET SESSION sql_mode = ""');
		
		$this->load->model(array(
			'agent_model',
            'price/price_model'
        ));
	}
	public function agent_log(){
		$data['title']  = display('agent_log');
        $data['module'] = "reports";
        $config["base_url"] = base_url('reports/agent/agent_log');
        $config["total_rows"] = $this->agent_model->count_agent_log();
        $config["per_page"] = 25;
        $config["uri_segment"] = 4;
        $config["last_link"] = "Last"; 
        $config["first_link"] = "First"; 
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';  
        $config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["links"] = $this->pagination->create_links();
        $data['agen']   = $this->agent_model->agent_log($config["per_page"], $page);
        $data['agent_list'] = $this->agent_model->agent_list();
        $data['page']   = "agent/agent_log_form";   
            echo Modules::run('template/layout', $data);
	}

	public function agent_details(){

		$data['title']  = display('agent_log');
        $data['module'] = "reports";
		$id             = $this->input->post('agent_id');
		$start_date     = date('Y-m-d', strtotime($this->input->post('start_date')));
		$end_date       = date('Y-m-d', strtotime($this->input->post('end_date')));
        $booking_type = $this->input->post('booking_type');

        $data['agen_id']= $id;
        $data['start_date'] = $start_date;
        $data['end_date']= $end_date;
        $data['detls']  = $this->agent_model->agent_inf($id);

        //        echo "<pre>";
        //        print_r($booking_type);
        //        die();

        ///// Booking Type 1 Means Ticket Booking , 2 Means Luggage Booking
        if(isset($booking_type))
        {
            if($booking_type[0] === '1' && !isset($booking_type[1])) {
                $data['agen'] = $this->agent_model->agent_details($id, $start_date, $end_date,1);
            }
            elseif($booking_type[0] === '2' && !isset($booking_type[1]))
            {
                $data['agen']   = $this->agent_model->agent_details($id,$start_date,$end_date,2);
            }
            elseif($booking_type[0] === '1' && $booking_type[1] === '2')
            {
                // $data['agen']   = $this->agent_model->agent_details($id,$start_date,$end_date,0);
                
                 // new code for test 2021
                $data['agen'] = $this->agent_model->agent_details($id, $start_date, $end_date, 1);
                $data['agenL'] = $this->agent_model->agent_details($id, $start_date, $end_date, 2);
                // new code for test 2021
            }
        }
        else
        {
            $data['agen']   = $this->agent_model->agent_details($id,$start_date,$end_date,0);
        }

        $data['agent_list'] = $this->agent_model->agent_list();
        $data['page']   = "agent/agent_details";
        $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency = $price['currency'];
        $data['currency'] = $currency;

//                        echo "<pre>";
//                        print_r($booking_type);
//                        print_r($data);
//                        die();

        echo Modules::run('template/layout', $data);

	}
}