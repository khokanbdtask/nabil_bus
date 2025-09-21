<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Packages extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'Packages_model'
        ));
    }

    public function index()
    {

        $this->permission->method('price', 'read')->redirect();
        $data['title'] = display('package_list');
        $data['module'] = "luggage_nitol";

        $data['prices'] = $this->Packages_model->price_view();
        $data['page'] = "/price/price_luggage_list";

       // echo "<pre>";
       // print_r($data);
       // die();

        echo Modules::run('template/layout', $data);

    }

    public function create_price()
    {
        $this->permission->method('price', 'read')->redirect();
        #-------------------------------#
        $this->form_validation->set_rules('package_name', display('package_name'), 'required|max_length[250]|trim|is_unique[package.package_name]');
        $this->form_validation->set_rules('route_id', display('route_id'), 'required|max_length[12]');
        $this->form_validation->set_rules('vehicle_type_id', display('vehicle_type_id '), 'required|max_length[12]');
        $this->form_validation->set_rules('max_weight_limit', display('max_weight_limit'), 'required|max_length[12]');
        $this->form_validation->set_rules('min_weight', display('min_weight'), 'required|max_length[12]');
        $this->form_validation->set_rules('max_weight', display('max_weight'), 'required|max_length[12]');
        $this->form_validation->set_rules('price', display('price'), 'required|max_length[12]');
        $this->form_validation->set_rules('urgency', display('urgency'), 'max_length[1]');
        $this->form_validation->set_rules('urgency_price', display('urgency_price'), 'max_length[12]');

        $min_weights = $this->input->post('min_weight');
        $max_weights = $this->input->post('max_weight');
        $prices = $this->input->post('price');

        $currency_details = $this->Packages_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency = $price['currency'];
        $route_id = $this->input->post('route_id');
        $type = $this->input->post('vehicle_type_id');

        $checkPackage = $this->db->select('*')->from('package')
                                ->where('trip_route_id',$route_id)
                                ->where('fleet_type_id',$type)
                                ->where('min_weight',$min_weights)
                                ->where('max_weight',$max_weights)
                                ->where('package_price',$prices)
                                ->get()
                                ->result();

        #-------------------------------#

        if ($this->form_validation->run()) {
            if(empty($checkPackage))
            {
                $postData = [
                    'package_name' => $this->input->post('package_name'),
                    'trip_route_id' => $route_id,
                    'fleet_type_id' => $type,
                    'max_weight_carry' => $this->input->post('max_weight_limit'),
                    'urgency_status' => $this->input->post('urgency'),
                    'urgent_price_add' => $this->input->post('urgency_price'),
                    'min_weight' => $this->input->post('min_weight'),
                    'max_weight' => $this->input->post('max_weight'),
                    'package_price' => $this->input->post('price'),
                    'created_at ' => date("Y-m-d H:i:s")
    
                ];


                // echo "<pre>"; 
                
                // print_r($postData);
                
                // die();
                
    
                // if($price_info->num_rows() < 1){
                if ($lpm = $this->Packages_model->price_create($postData)) {
                    $this->session->set_flashdata('message', display('successfully_saved'));
    
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
    
                redirect("luggage_nitol/packages/index");
            }
            else
            {
                $this->session->set_flashdata('exception', 'Exact Same Package Already Exist.');
                redirect("luggage_nitol/packages/index");
            }
        } else {

            $data['title'] = display('add_package');
            $data['module'] = "luggage_nitol";
            $data['currency'] = $currency;
            $data['rout'] = $this->Packages_model->rout();
            $data['vehc'] = $this->Packages_model->vehicles();
            $data['pri'] = $this->Packages_model->price_view();
            $data['page'] = "price/price_luggage_form";

            echo Modules::run('template/layout', $data);
        }
    }

    public function price_luggage_view($id = null)
    {
        $this->permission->method('price', 'read')->redirect();
        $data['title'] = display('view');
        $data['module'] = "luggage_nitol";

        $data['data'] = $this->Packages_model->price_luggage_view($id);
        $data['bb'] = $this->Packages_model->get_id($id);

        // $data['price_ranges'] = $this->Packages_model->luggage_price_detailsget($id);
        $data['page'] = "price/price_luggage_view";

       // echo "<pre>";
       // print_r($data);
       // die();

        echo Modules::run('template/layout', $data);
    }

    public function price_update($id = null)
    {
        $this->permission->method('price', 'update')->redirect();
        #-------------------------------#

        // $this->form_validation->set_rules('package_name', display('package_name'), 'required|max_length[250]|trim');

        $this->form_validation->set_rules('package_id', display('package_id'), 'required');
        $this->form_validation->set_rules('route_id', display('route_id'), 'required|max_length[20]');
        $this->form_validation->set_rules('vehicle_type_id', display('vehicle_type_id '), 'required|max_length[20]');
        $this->form_validation->set_rules('max_weight_limit', display('max_weight_limit'), 'required|max_length[20]');

        $min_weights = $this->input->post('min_weight');
        $max_weights = $this->input->post('max_weight');
        $prices = $this->input->post('price');

//        echo "<pre>";
//        print_r($min_weights);
//        print_r($max_weights);
//        print_r($prices);
//        die();

        $package_id = $this->input->post('package_id');
        $route_id = $this->input->post('route_id');
        $type = $this->input->post('vehicle_type_id');

//       $price_info = $this->db->select('*')->from('pri_price')->where('route_id',$route_id)->where('vehicle_type_id',$type)->get();

        #-------------------------------#
        if ($this->form_validation->run()) {

            $postData = [
                'package_id' => $package_id,
                'package_name' => $this->input->post('package_name'),
                'trip_route_id' => $route_id,
                'fleet_type_id' =>  $type,
                'max_weight_carry' => $this->input->post('max_weight_limit'),
                'urgency_status' => $this->input->post('urgency'),
                'urgent_price_add' => $this->input->post('urgency_price'),
                'min_weight' => $this->input->post('min_weight'),
                'max_weight' => $this->input->post('max_weight'),
                'package_price' => $this->input->post('price'),
                'updated_at ' => date("Y-m-d H:i:s")
            ];

            if ($this->Packages_model->update_price($postData)) {
                $this->session->set_flashdata('message', display('successfully_updated'));


            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }

            redirect("luggage_nitol/packages/index");

        } else {
            $data['title'] = display('update');
            $data['packages'] = (array)$this->Packages_model->price_updateForm($id);
            $data['rout'] = $this->Packages_model->rout();
            $data['vehc'] = $this->Packages_model->vehicles(); 
 
            $data['module'] = "luggage_nitol";
            $data['page'] = "price/price_luggage_form_update";

           // echo "<pre>";
           // print_r($data);
           // die();

            echo Modules::run('template/layout', $data);
        }
    }

    public function max_luggage_weight()
    {
        $vehicle_type_id = $this->input->post('vehicle_type_id');
        $max_weight_limit = $this->Packages_model->max_luggage_weight($vehicle_type_id);
        echo $max_weight_limit;
    }


    public function price_delete($id = null)
    {
        $this->permission->method('price', 'delete')->redirect();
        if ($this->Packages_model->delete_price($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('luggage_nitol/packages/');
    }

}
