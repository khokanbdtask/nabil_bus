<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_controller extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->permission->module('tracking')->redirect();
        $this->load->model(array(
            'tracking_model','price/price_model'
        ));      

        //// TIME ZONE SET ACCORDING TO USER's Given timezone in WEBSITE SETTINGS

        $timezone=$this->db->select('*')->from('ws_setting')->get()->row();
        date_default_timezone_set($timezone->timezone);
        date_default_timezone_get();


    }

        public function tracking_list()
    {
        // $this->permission->method('tracking','read')->redirect();

        $data['title']  = display('tracking');
            $data['module'] = "tracking";
            $data['page']   = "tracking_list";  
            $data['trackings'] = $this->tracking_model->tracking_view(); 

            $tracks = $this->tracking_model->tracking_view();
            

/////// Find out the progress and show it the % of progress by reaching out to the stoppage points. Progress will be 100% while it reaches to the End Point

            $c = 0;

            foreach ($tracks as $track) {
                $locations = explode(',',$track->stoppage_points);

                $current_location = $track->reached_points;

                $current_location_name = $this->tracking_model->loc_names($current_location)[0]->name;

                $data['trackings'][$c]->reached_points = $current_location_name;
            
                $total_points = count($locations);

                $start_point = $locations[$total_points-2];
                $end_point = $locations[$total_points-1];

                $total_progress = 100;

                $progress_ratio = $total_progress/($total_points-1);

                if($total_points>3)
                {
                    $this->moveElement($locations, $start_point, 0);
                }
                elseif ($total_points == 3) {
                    $locations = Array($locations[1],$locations[0],$locations[2]);
                }

                $location_index = array_search($current_location, $locations);

                // var_dump($progress_ratio);

                $data['trackings'][$c]->locations = $locations;

                $data['trackings'][$c]->progress = round(((float)$location_index*$progress_ratio), 1);

                $c++;

            }

            // echo "<pre>";
            // print_r($data);
            // exit();
          echo Modules::run('template/layout', $data); 
    }


//// Array postion change - Explaination : https://stackoverflow.com/questions/12624153/move-an-array-element-to-a-new-index-in-php

    public function moveElement(&$array, $a, $b) {
        $p1 = array_splice($array, $a, 1);
        $p2 = array_splice($array, 0, $b);
        $array = array_merge($p2,$p1,$array); 
    }

///////////////////////////////////////////////////////

 
    public function tracking_insert($id='')
    {
        if ($id == '') {
            $data['title']  = display('add_tracking');
            $data['module'] = "tracking";
            $data['rout'] = $this->tracking_model->rout(); 
            $trips = $this->tracking_model->trips(); 
            $data['page']   = "tracking_form";   

            // echo "<pre>";
            // print_r($trips);
            // exit();

            $trip_list = "";
            $trip_list .= "<option>".display('select_option')."</option>";
            foreach ($trips as $trip) {
                $trip_list .= "<option value=".$trip->id.">".$trip->reg_no." - ".$trip->trip_title."</option>";
            }

            $data['trips'] = $trip_list;
            $data['fleet_dropdown'] = $this->tracking_model->fleet_dropdown();

          
          echo Modules::run('template/layout', $data); 
        }
        else
        {
            $data['title']  = display('edit_tracking');
            $data['module'] = "tracking";
            $data['rout'] = $this->tracking_model->rout(); 
            $trips = $this->tracking_model->trips(); 
            $tracks = $this->tracking_model->tracks($id); 
            $data['page']   = "tracking_form";   

            // echo "<pre>";
            // print_r($tracks);
            // exit();

            $data['tracks'] = $tracks;

            $trip_list = "";
            $trip_list .= "<option>".display('select_option')."</option>";
            foreach ($trips as $trip) {
            // echo $trip->id;
            // echo "<br>";
                if ($trip->id == $tracks[0]->trips) {
                    $trip_list .= "<option value=".$trip->id." SELECTED >".$trip->reg_no." - ".$trip->trip_title."</option>";
                }
                else
                {
                    $trip_list .= "<option value=".$trip->id.">".$trip->reg_no." - ".$trip->trip_title."</option>";
                }
                
            }

            $data['trips'] = $trip_list;
            $data['fleet_dropdown'] = $this->tracking_model->fleet_dropdown();

            // echo "<pre>";
            // print_r($data);
            // exit();
          
          echo Modules::run('template/layout', $data); 
        }
    }


    public function stoppages()
    {
        
        
        if (isset($_POST['route_id'])) {
            $sp = $this->tracking_model->stoppage_point($this->input->post('route_id',true)); 
        
        $loc = "";
        $loc .= "<option value=\"\">'Please Select Location'</option>";
        //// Find location name from it's id.

        // $stoppage_points = $data['trps'][$i]->stoppage_points;
            $loc_name = Array();

            $stopages = explode(',',$sp['stoppage_points']);
            $c = 0;
            foreach ($stopages as $ids) {

                $loc_name[$c] = $this->tracking_model->loc_names($ids); 
                // $sp_list .=  $loc_name[$c][0]->name.',';

                if (isset($_POST['reached_point']) && $_POST['reached_point'] == $loc_name[$c][0]->id) {
                    $loc .= "<option SELECTED value='".$loc_name[$c][0]->id."'>".$loc_name[$c][0]->name."</option>";
                }
                else
                {
                    $loc .= "<option value='".$loc_name[$c][0]->id."'>".$loc_name[$c][0]->name."</option>";
                }

                
                $c++;
            }


            echo json_encode($loc);
        }
    }


    public function create_tracking()
    { 
        // $this->permission->method('tracking','create')->redirect();

        if(isset($_POST['submit'])){
            // echo "<pre>";
            // print_r($_POST);
            // exit();
        
        #-------------------------------#
        $this->form_validation->set_rules('trips',display('trips'),'required|max_length[12]|is_natural_no_zero');
        $this->form_validation->set_rules('tracking_date',display('tracking_date')  ,'required|max_length[13]');
        $this->form_validation->set_rules('reached_points',display('reached_points'),'required|max_length[12]|is_natural_no_zero');

        $this->form_validation->set_rules('arrival_time',display('arrival_time')  ,'required|max_length[7]');

        
        #-------------------------------#
            if ($this->form_validation->run() === true) {

                $postData = [
                    'tracking_id'       => $this->input->post('tracking_id',true),
                    'trips'             => $this->input->post('trips',true),
                    'tracking_date'     => $this->input->post('tracking_date',true),
                    'reached_points'    => $this->input->post('reached_points',true),
                    'arrival_time'      => $this->input->post('arrival_time',true),
                    'user_id'           => $this->session->userdata('id')
                ];   

                // echo "Valid<pre>";

                // print_r($this->session);
                // print_r($postData);
                // exit();
                if($postData['tracking_id'] == '')
                {
                    if ($this->tracking_model->tracking_create($postData)) { 
                        $this->session->set_flashdata('message', display('successfully_saved'));
                    } else {
                        $this->session->set_flashdata('exception',  display('please_try_again'));
                    }
                }
                else
                {
                    if ($this->tracking_model->update_tracking($postData)) { 
                        $this->session->set_flashdata('message', display('successfully_saved'));
                    } else {
                        $this->session->set_flashdata('exception',  display('please_try_again'));
                    }
                }
                redirect("tracking/tracking_controller/tracking_list"); 
            } 

        }

    }

    



    public function tracking_delete($id=null){
        $this->permission->method('tracking', 'delete')->redirect();
        if($this->tracking_model->delete_tracking($id)) 
        {
            #set success message
            $this->session->set_flashdata('message',display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception',display('please_try_again'));
        }
        redirect('tracking/tracking_controller/create_tracking');
    }

    public function tracking_update($id = null)
    { 
        $this->permission->method('tracking', 'update')->redirect();
        $data['title'] = display('tracking');
        #-------------------------------#
         $this->form_validation->set_rules('tracking_id', display('tracking_id'), 'required'); 
        $this->form_validation->set_rules('tracking_name', display('tracking_name'),'required|max_length[20]');
        $this->form_validation->set_rules('tracking_start_date',display('tracking_start_date')  ,'required|max_length[20]');
        $this->form_validation->set_rules('tracking_end_date',display('tracking_end_date'),'required|max_length[20]');
        $this->form_validation->set_rules('tracking_code',display('tracking_code')  ,'required|max_length[50]');
        $this->form_validation->set_rules('tracking_discount',display('tracking_discount'),'required|max_length[20]');
        $this->form_validation->set_rules('tracking_terms',display('tracking_terms')  ,'max_length[200]');
        $this->form_validation->set_rules('tracking_route_id',display('tracking_route_id'),'required|max_length[20]');
        // $this->form_validation->set_rules('tracking_number',display('tracking_number'));

        #-------------------------------#
        if ($this->form_validation->run() === true) {

            $Data = [    
                'tracking_id'         => $this->input->post('tracking_id',true),
                'tracking_name'       => $this->input->post('tracking_name',true),
                'tracking_start_date' => $this->input->post('tracking_start_date',true),
                'tracking_end_date'   => $this->input->post('tracking_end_date',true),
                'tracking_code'       => $this->input->post('tracking_code',true),
                'tracking_discount'   => $this->input->post('tracking_discount',true),
                'tracking_terms'      => $this->input->post('tracking_terms',true),
                'tracking_route_id'   => $this->input->post('tracking_route_id',true),
                'tracking_number'     => $this->input->post('tracking_number',true),
            ];   

            // echo "<pre>";
            // print_r($Data);
            // exit();

            if ($this->tracking_model->update_tracking($Data)) { 
                $this->session->set_flashdata('message', display('successfully_updated'));
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
            redirect("tracking/tracking_controller/create_tracking");

        } else {
            $data['title']      = display('update');
            $data['data']      =$this->tracking_model->tracking_updateForm($id);
            $data['rout'] = $this->tracking_model->rout();
            $data['bb'] = $this->tracking_model->get_id($id);
            $data['module']    = "tracking";    
            $data['page']      = "update_tracking_form";   
            echo Modules::run('template/layout', $data);  
        }   
    }

   
    public function tracking_code(){
        $tracking_code=$this->input->post('tracking_code');
        $result = $this->db->get('ofr_tracking')->where('tracking_code',$tracking_code);

        if ($result->num_rows() > 0) {
            echo 0;
        } else {
            echo 1;
        }
        echo Modules::run('template/layout', $data); 
   }

    public function view_details(){ 
        $this->permission->method('tracking', 'read')->redirect();
        $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency=$price['currency'];
        $id = $this->uri->segment(4);
        $data['title']  = display('Details');  
        $data['detls']   = $this->tracking_model->details($id);
        $data['module'] = "tracking";
        $data['currency']   = $currency;
        $data['page']   = "tracking_details";   
        echo Modules::run('template/layout', $data); 
    }
}
