<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'home_model',
        ));

        if (!$this->session->userdata('isLogIn')) {
            redirect('login');
        }

    }

    public function index()
    {
        $data['title'] = display('home');
        #-------------------------------#
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
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
        $data["assigns"] = $this->home_model->schedule($config["per_page"], $page);

        // var_dump($data["assigns"]);
        // exit;
        $data['enquirys'] = $this->home_model->enquiries();
        $data['chart'] = $this->home_model->chart();

        // New code 2021 direct update 

        $data['chartweek'] = $this->chartjsWeek();
        $data['chartyear'] = $this->chartjsYear();
        $data['chartmonth'] = $this->chartmonth();
        $data['ticketluggage'] = $this->tickLuggagebookinchartYear();
        $data['ticketluggageweek'] = $this->ticketluggageweek();
        $data['ticketluggagemonth'] = $this->monthlyticketluggage();
        $data['agentchart'] = $this->agentchart();

        // New code 2021 direct update 

        $data['module'] = "dashboard";
        $data['page'] = "home/home";

        echo Modules::run('template/layout', $data);
    }

    public function profile()
    {
        $data['title'] = display("profile");
        $data['module'] = "dashboard";
        $data['page'] = "home/profile";
        $id = $this->session->userdata('id');
        $data['user'] = $this->home_model->profile($id);
        echo Modules::run('template/layout', $data);
    }

    public function setting()
    {
        $data['title'] = "Profile Setting";
        $id = $this->session->userdata('id');
        /*-----------------------------------*/
        $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[50]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[50]');
        #------------------------#
        $this->form_validation->set_rules('email', 'Email Address', "required|valid_email|max_length[100]");
        /*---#callback fn not supported#---*/
        // $this->form_validation->set_rules('email', 'Email Address', "required|valid_email|max_length[100]|callback_email_check[$id]|trim");
        #------------------------#
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]|md5');
        $this->form_validation->set_rules('about', 'About', 'max_length[1000]');
        /*-----------------------------------*/
        $config['upload_path'] = './assets/img/user/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $data = $this->upload->data();
            $image = $config['upload_path'] . $data['file_name'];

            $config['image_library'] = 'gd2';
            $config['source_image'] = $image;
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = true;
            $config['width'] = 115;
            $config['height'] = 90;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->session->set_flashdata('message', "Image Upload Successfully!");
        }
        /*-----------------------------------*/
        $data['user'] = (object) $userData = array(
            'id' => $this->input->post('id'),
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'about' => $this->input->post('about', true),
            'image' => (!empty($image) ? $image : $this->input->post('old_image')),
        );

        /*-----------------------------------*/
        if ($this->form_validation->run()) {

            if (empty($userData['image'])) {
                $this->session->set_flashdata('exception', $this->upload->display_errors());
            }

            if ($this->home_model->setting($userData)) {

                $this->session->set_userdata(array(
                    'fullname' => $this->input->post('firstname') . ' ' . $this->input->post('lastname'),
                    'email' => $this->input->post('email'),
                    'image' => (!empty($image) ? $image : $this->input->post('old_image')),
                ));

                $this->session->set_flashdata('message', display('update_successfully'));
            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
            redirect("dashboard/home/setting");

        } else {
            $data['module'] = "dashboard";
            $data['page'] = "home/profile_setting";
            if (!empty($id)) {
                $data['user'] = $this->home_model->profile($id);
            }

            echo Modules::run('template/layout', $data);
        }
    }


    // New code 2021 direct update

    public function chartjsWeek()
    {
        
        $weekday['income'] = [0,0,0,0,0,0,0];
        $weekday['expense'] = [0,0,0,0,0,0,0];
        $firstday = date('Y-m-d', strtotime("this week"));
        $lastday = date("Y-m-d", strtotime('sunday this week'));
        $this->db->select("acn_account_transaction.date,acn_account_transaction.amount");
        $this->db->select_sum("acn_account_transaction.amount","totalamount");
        $this->db->from('acn_account_transaction');
        $this->db->join('acc_account_name', 'acc_account_name.account_id = acn_account_transaction.account_id');
        $this->db->where('account_type',1);

        $this->db->where('Date(acn_account_transaction.date) >=', $firstday);
        $this->db->where('Date(acn_account_transaction.date) <=', $lastday);
        // $this->db->group_by('MONTH(date)');DAY(Date)
        $this->db->group_by('DATE_FORMAT(date, "%d")');
        // execute query  
        $incomequery = $this->db->get();
       
        foreach ($incomequery->result() as $key => $incomevalue) {
            
           $indexvalue =  date('w', strtotime($incomevalue->date));
         
           $weekday['income'][$indexvalue] = $incomevalue->totalamount;
          
           
        }

        $this->db->select("acn_account_transaction.date,acn_account_transaction.amount");
        $this->db->select_sum("acn_account_transaction.amount","totalamount");
        $this->db->from('acn_account_transaction');
        $this->db->join('acc_account_name', 'acc_account_name.account_id = acn_account_transaction.account_id');
        $this->db->where('account_type',0);

        $this->db->where('Date(acn_account_transaction.date) >=', $firstday);
        $this->db->where('Date(acn_account_transaction.date) <=', $lastday);
        // $this->db->group_by('MONTH(date)');DAY(Date)
        $this->db->group_by('DATE_FORMAT(date, "%d")');
        // execute query  
        $expensequery = $this->db->get();

        foreach ($expensequery->result() as $key => $incomevalue) {
            
            $indexvalue =  date('w', strtotime($incomevalue->date));
          
            $weekday['expense'][$indexvalue] = $incomevalue->totalamount;
           
            
         }

        return( json_encode($weekday) );
       
        
    }


    public function chartmonth()
    {

        $monthdayday['income'] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $monthdayday['expense'] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $firstmonth = date('Y-01-01');
        $lastmonth = date("Y-12-31");

        $this->db->select("acn_account_transaction.date,acn_account_transaction.amount");
        $this->db->select_sum("acn_account_transaction.amount","totalamount");
        $this->db->from('acn_account_transaction');
        $this->db->join('acc_account_name', 'acc_account_name.account_id = acn_account_transaction.account_id');
        $this->db->where('account_type',1);

        $this->db->where('Date(acn_account_transaction.date) >=', $firstmonth);
        $this->db->where('Date(acn_account_transaction.date) <=', $lastmonth );
        // $this->db->group_by('MONTH(date)');DAY(Date)
        $this->db->group_by('DATE_FORMAT(date, "%m")');
        // execute query  
        $incomequery = $this->db->get();

        foreach ($incomequery->result() as $key => $incomevalue) {
            
            $indexvalue =  date('n', strtotime($incomevalue->date));
          
            $monthdayday['income'][$indexvalue] = $incomevalue->totalamount;
           
            
         }



         $this->db->select("acn_account_transaction.date,acn_account_transaction.amount");
         $this->db->select_sum("acn_account_transaction.amount","totalamount");
         $this->db->from('acn_account_transaction');
         $this->db->join('acc_account_name', 'acc_account_name.account_id = acn_account_transaction.account_id');
         $this->db->where('account_type',0);
 
         $this->db->where('Date(acn_account_transaction.date) >=', $firstmonth);
         $this->db->where('Date(acn_account_transaction.date) <=', $lastmonth );
         // $this->db->group_by('MONTH(date)');DAY(Date)
         $this->db->group_by('DATE_FORMAT(date, "%m")');
         // execute query  
         $expensequery = $this->db->get();


         
        foreach ($expensequery->result() as $key => $incomevalue) {
            
            $indexvalue =  date('n', strtotime($incomevalue->date));
          
            $monthdayday['expense'][$indexvalue] = $incomevalue->totalamount;
           
            
         }

         
         return( json_encode($monthdayday) );

    }


    public function chartjsYear()
    {
        $year['income'] = [];
        $year['expense'] = [];
        $year['year'] = [];

        $this->db->select_max('date');
        $result = $this->db->get('acn_account_transaction')->row();  
         $maxyear = date('Y',strtotime($result->date)) ;
        
        $this->db->select_min('date');
        $result = $this->db->get('acn_account_transaction')->row();
         $minyear = date('Y',strtotime($result->date)) ;
       
        for ($i=0;  $maxyear >=  $minyear  ; $i++) { 
            $year['year'][$i] = $minyear;
           $minyear++;
        }
        foreach ($year['year'] as $yearkey => $yearvalue) {
            array_push($year['expense'],0);  
            array_push($year['income'],0);  
        }

        


        $this->db->select("acn_account_transaction.date,acn_account_transaction.amount");
        $this->db->select_sum("acn_account_transaction.amount","totalamount");
        $this->db->from('acn_account_transaction');
        $this->db->join('acc_account_name', 'acc_account_name.account_id = acn_account_transaction.account_id');
        $this->db->where('account_type',1);
        $this->db->group_by('DATE_FORMAT(date, "%y")');
        $this->db->order_by("date", "asc");

        $yearincome = $this->db->get();

        foreach ($yearincome->result() as $yincomekey => $yearincomevalue) {

            foreach ($year['year'] as $yearkey => $yearvalue) {
                
                if ($yearvalue ==  date('Y',strtotime($yearincomevalue->date))) {
                    $year['income'][$yearkey] = $yearincomevalue->totalamount;
                    
                }
               
            }
            
        }

        $this->db->select("acn_account_transaction.date,acn_account_transaction.amount");
        $this->db->select_sum("acn_account_transaction.amount","totalamount");
        $this->db->from('acn_account_transaction');
        $this->db->join('acc_account_name', 'acc_account_name.account_id = acn_account_transaction.account_id');
        $this->db->where('account_type',0);
        $this->db->group_by('DATE_FORMAT(date, "%y")');
        $this->db->order_by("date", "asc");

        $yearexpense = $this->db->get();


        foreach ($yearexpense->result() as $yincomekey => $yearexpensevalue) {

            foreach ($year['year'] as $yearkey => $yearvalue) {
                
                if ($yearvalue ==  date('Y',strtotime($yearexpensevalue->date))) {
                    $year['expense'][$yearkey] = $yearexpensevalue->totalamount;
                    
                }
               
            }
            
        }


        return( json_encode($year) );
        
    }

    public function tickLuggagebookinchartYear()
    {
        $tick=0;
        $ticketyear= [];
        $luggageyear= [];
        $sortarray=[];
        $year['ticket'] = [];
        $year['luggage'] = [];
        $year['year'] = [];


        $this->db->select_max('booking_date');
        $result = $this->db->get('tkt_booking')->row();  
         $maxyear = date('Y',strtotime($result->booking_date)) ;
        
        $this->db->select_min('booking_date');
        $result = $this->db->get('tkt_booking')->row();
         $minyear = date('Y',strtotime($result->booking_date)) ;
       
        for ($i=0;  $maxyear >=  $minyear  ; $i++) { 
            $ticketyear[$i] = $minyear;
           $minyear++;
        }

        $this->db->select_max('booking_date');
        $result = $this->db->get('luggage_booking')->row();  
         $maxyear = date('Y',strtotime($result->booking_date)) ;

         $this->db->select_min('booking_date');
        $result = $this->db->get('luggage_booking')->row();
         $minyear = date('Y',strtotime($result->booking_date)) ;

         for ($i=0;  $maxyear >=  $minyear  ; $i++) { 
            $luggageyear[$i] = $minyear;
           $minyear++;
        }  
        $sortarray =  $luggageyear;
            foreach($ticketyear as $k=>$ticketvalue){
                  if(!in_array($ticketvalue, $luggageyear)){
                    array_push($sortarray,$ticketvalue);
                    }
                
            }
          asort($sortarray);
          
         foreach ($sortarray as $key => $value) {
            $year['year'][$tick] = $value;
            $tick++;
         }
       
        foreach ($year['year'] as $yearkey => $yearvalue) {
            array_push($year['ticket'],0);  
            array_push($year['luggage'],0);  
        }

        $this->db->select("tkt_booking.booking_date,tkt_booking.price");
        $this->db->select_sum("tkt_booking.price","totalamount");
        $this->db->from('tkt_booking');
        $this->db->where('tkt_refund_id',null);
        $this->db->group_by('DATE_FORMAT(booking_date, "%y")');
        $this->db->order_by("booking_date", "asc");
        $yearbookticket = $this->db->get();



        foreach ($year['year'] as $yearkey => $yearvalue) {

            foreach ($yearbookticket->result() as $ybookkey => $yearticketvalue) {

                if (date('Y',strtotime($yearticketvalue->booking_date)) ==  $yearvalue) {

                    $year['ticket'][$yearkey] = $yearticketvalue->totalamount;
                   
                    
                }

            }
        }


        $this->db->select("luggage_booking.booking_date,luggage_booking.amount");
        $this->db->select_sum("luggage_booking.amount","totalamount");
        $this->db->from('luggage_booking');
        $this->db->where('luggage_refund_id',null);
        $this->db->group_by('DATE_FORMAT(booking_date, "%y")');
        $this->db->order_by("booking_date", "asc");
        $yearbookluggage = $this->db->get();



        foreach ($year['year'] as $yearkey => $yearvalue) {

            foreach ($yearbookluggage->result() as $ybookkey => $yearluggagevalue) {

                if (date('Y',strtotime($yearluggagevalue->booking_date)) ==  $yearvalue) {

                    $year['luggage'][$yearkey] = $yearluggagevalue->totalamount;
                   
                    
                }

            }
        }
        
        return( json_encode($year) );
        


    }


    public function ticketluggageweek()
    
    {
        $weekday['ticket'] = [0,0,0,0,0,0,0];
        $weekday['luggage'] = [0,0,0,0,0,0,0];
        $firstday = date('Y-m-d', strtotime("this week"));
        $lastday = date("Y-m-d", strtotime('sunday this week'));

        $this->db->select("tkt_booking.booking_date,tkt_booking.price");
        $this->db->select_sum("tkt_booking.price","totalamount");
        $this->db->from('tkt_booking');
       
        $this->db->where('tkt_refund_id',null);

        $this->db->where('Date(tkt_booking.booking_date) >=', $firstday);
        $this->db->where('Date(tkt_booking.booking_date) <=', $lastday);
        // $this->db->group_by('MONTH(date)');DAY(Date)
        $this->db->group_by('DATE_FORMAT(booking_date, "%d")');
        // execute query  
        $weekbookticket = $this->db->get();


        foreach ($weekbookticket->result() as $key => $incomevalue) {
            
            $indexvalue =  date('w', strtotime($incomevalue->booking_date));
          
            $weekday['ticket'][$indexvalue] = $incomevalue->totalamount;
           
            
         }




         $this->db->select("luggage_booking.booking_date,luggage_booking.amount");
        $this->db->select_sum("luggage_booking.amount","totalamount");
        $this->db->from('luggage_booking');
        $this->db->where('luggage_refund_id',null);

        $this->db->where('Date(luggage_booking.booking_date) >=', $firstday);
        $this->db->where('Date(luggage_booking.booking_date) <=', $lastday);

        $this->db->group_by('DATE_FORMAT(booking_date, "%d")');
       
        $weekbookluggage = $this->db->get();

        foreach ($weekbookluggage->result() as $key => $incomevalue) {
            
            $indexvalue =  date('w', strtotime($incomevalue->booking_date));
          
            $weekday['luggage'][$indexvalue] = $incomevalue->totalamount;
           
            
         }
       
       
         return( json_encode($weekday) );



    }


    public function monthlyticketluggage()
    {

        $monthdayday['ticket'] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $monthdayday['luggage'] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $firstmonth = date('Y-01-01');
        $lastmonth = date("Y-12-31");


        $this->db->select("tkt_booking.booking_date,tkt_booking.price");
        $this->db->select_sum("tkt_booking.amount","totalamount");
        $this->db->from('tkt_booking');
       
        $this->db->where('tkt_refund_id',null);

        $this->db->where('Date(tkt_booking.booking_date) >=', $firstmonth);
        $this->db->where('Date(tkt_booking.booking_date) <=', $lastmonth);
        // $this->db->group_by('MONTH(date)');DAY(Date)
        $this->db->group_by('DATE_FORMAT(booking_date, "%m")');
        // execute query  
        $weekbookticket = $this->db->get();


        foreach ($weekbookticket->result() as $key => $incomevalue) {
            
            $indexvalue =  date('n', strtotime($incomevalue->booking_date));
          
            $monthdayday['ticket'][$indexvalue] = $incomevalue->totalamount;
           
            
         }

         $this->db->select("luggage_booking.booking_date,luggage_booking.amount");
         $this->db->select_sum("luggage_booking.amount","totalamount");
         $this->db->from('luggage_booking');
         $this->db->where('luggage_refund_id',null);
 
         $this->db->where('Date(luggage_booking.booking_date) >=', $firstmonth);
         $this->db->where('Date(luggage_booking.booking_date) <=', $lastmonth);
 
         $this->db->group_by('DATE_FORMAT(booking_date, "%m")');
        
         $weekbookluggage = $this->db->get();
 
         foreach ($weekbookluggage->result() as $key => $incomevalue) {
             
             $indexvalue =  date('n', strtotime($incomevalue->booking_date));
           
             $monthdayday['luggage'][$indexvalue] = $incomevalue->totalamount;
            
             
          }
        
          return( json_encode($monthdayday) );

    }

    public function agentchart()
    {
        $agentdata['name'] = [];
        $agentdata['ticket'] = [];
        $agentdata['luggage'] = [];

        $this->db->select("user.id,CONCAT (user.firstname, user.lastname) as fullname");
        $this->db->from('user');
        $this->db->where('user.is_admin',0);
        $agentList = $this->db->get();
        

        foreach ($agentList->result() as $key => $listvalue) {
            $agentdata['name'][$key] = $listvalue->fullname;
            $agentdata['ticket'][$key]  = 0;
            $agentdata['luggage'][$key]  = 0;
        }

        $this->db->select("tkt_booking.amount,tkt_booking.booked_by,CONCAT (user.firstname, user.lastname) as fullname,");
        $this->db->select_sum("tkt_booking.amount","totalamount");
        $this->db->from('tkt_booking');
        $this->db->join('user', 'user.id = tkt_booking.booked_by');
        $this->db->where('user.is_admin',0);
     
        $this->db->group_by('tkt_booking.booked_by');
        // execute query  
        $agent = $this->db->get();

        foreach ($agentList->result() as $agentlistkey => $listvalue) {
            
            foreach ($agent->result() as $agentticketkey => $ticketvalue) {
                if ($listvalue->id == $ticketvalue->booked_by) {
                    $agentdata['ticket'][$agentlistkey] = $ticketvalue->totalamount;
                }
            }
        }



        $this->db->select("luggage_booking.amount,luggage_booking.booked_by,CONCAT (user.firstname, user.lastname) as fullname,");
        $this->db->select_sum("luggage_booking.amount","totalamount");
        $this->db->from('luggage_booking');
        $this->db->join('user', 'user.id = luggage_booking.booked_by');
        $this->db->where('user.is_admin',0);
     
        $this->db->group_by('luggage_booking.booked_by');
        // execute query  
        $agentluggage = $this->db->get();

        foreach ($agentList->result() as $agentlistkey => $listvalue) {
            
            foreach ($agentluggage->result() as $agentticketkey => $ticketvalue) {
                if ($listvalue->id == $ticketvalue->booked_by) {
                    $agentdata['luggage'][$agentlistkey] = $ticketvalue->totalamount;
                }
            }
        }

        
        return( json_encode($agentdata) );

        
    }

    // New code 2021 direct update

}
