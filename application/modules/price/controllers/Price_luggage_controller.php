<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Price_luggage_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'price_model',
            'price_luggage_model'
        ));
    }

    public function index()
    {
        $this->permission->method('price', 'read')->redirect();
        $data['title'] = display('price_list');
        $data['module'] = "price";

        $data['prices'] = $this->price_luggage_model->price_view();
        $data['page'] = "price_luggage_list";

//        echo "<pre>";
//        print_r($data);
//        die();

        echo Modules::run('template/layout', $data);

    }

    public function create_price()
    {
        $this->permission->method('price', 'read')->redirect();
        #-------------------------------#
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


        $currency_details = $this->price_luggage_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency = $price['currency'];
        $route_id = $this->input->post('route_id');
        $type = $this->input->post('vehicle_type_id');
//       $price_info = $this->db->select('*')->from('pri_price')->where('route_id',$route_id)->where('vehicle_type_id',$type)->get();
        #-------------------------------#
        if ($this->form_validation->run()) {

            $postData = [
                'trip_route_id' => $route_id,
                'fleet_type_id' => $type,
                'max_weight_carry' => $this->input->post('max_weight_limit'),
                'urgency_status' => $this->input->post('urgency'),
                'urgent_price_add' => $this->input->post('urgency_price')

            ];

//            if($price_info->num_rows() < 1){
            if ($lpm = $this->price_luggage_model->price_create($postData)) {
                $this->session->set_flashdata('message', display('successfully_saved'));

                $count = count($min_weights);
                $pdata['luggage_price_master_id'] = $lpm;
                for ($i = 0; $i < $count; $i++) {

                    $pdata['min_weight'] = $min_weights[$i];
                    $pdata['max_weight'] = $max_weights[$i];
                    $pdata['price'] = $prices[$i];

                    $this->price_luggage_model->luggage_price_details($pdata);
                }

            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
//            }else{
//               $this->session->set_flashdata('exception', 'This Route Price Already Exist');
//            }

            redirect("price/price_luggage_controller/create_price");

        } else {
            $data['title'] = display('price_list');
            $data['module'] = "price";
            $data['currency'] = $currency;
            $data['rout'] = $this->price_luggage_model->rout();
            $data['vehc'] = $this->price_luggage_model->vehicles();
            $data['pri'] = $this->price_luggage_model->price_view();
            $data['page'] = "price_luggage_form";
            echo Modules::run('template/layout', $data);
        }
    }

    public function price_luggage_view($id = null)
    {
        $this->permission->method('price', 'read')->redirect();
        $data['title'] = display('view');
        $data['module'] = "price";

        $data['data'] = $this->price_luggage_model->price_luggage_view($id);
        $data['bb'] = $this->price_luggage_model->get_id($id);

        $data['price_ranges'] = $this->price_luggage_model->luggage_price_detailsget($id);
        $data['page'] = "price_luggage_view";

//        echo "<pre>";
//        print_r($data);
//        die();

        echo Modules::run('template/layout', $data);
    }

    public function price_update($id = null)
    {
        $this->permission->method('price', 'update')->redirect();
        #-------------------------------#
        $this->form_validation->set_rules('luggage_price_master_id', display('luggage_price_master_id'), 'required');
        $this->form_validation->set_rules('route_id', display('route_id'), 'required|max_length[20]');
        $this->form_validation->set_rules('vehicle_type_id', display('vehicle_type_id '), 'required|max_length[20]');
        $this->form_validation->set_rules('max_weight_limit', display('max_weight_limit'), 'required|max_length[20]');

        $min_weights = $this->input->post('min_weight');
        $max_weights = $this->input->post('max_weight');
        $prices = $this->input->post('price');

//        echo "<pre>";
//
//        print_r($min_weights);
//        print_r($max_weights);
//        print_r($prices);
//        die();

        $luggage_price_master_id = $this->input->post('luggage_price_master_id');
        $route_id = $this->input->post('route_id');
        $type = $this->input->post('vehicle_type_id');
//       $price_info = $this->db->select('*')->from('pri_price')->where('route_id',$route_id)->where('vehicle_type_id',$type)->get();
        #-------------------------------#
        if ($this->form_validation->run()) {

            $postData = [
                'luggage_price_master_id' => $luggage_price_master_id,
                'trip_route_id'        => $route_id,
                'fleet_type_id' =>  $type,
                'max_weight_carry' => $this->input->post('max_weight_limit'),
                'urgency_status' => $this->input->post('urgency'),
                'urgent_price_add' => $this->input->post('urgency_price')
            ];

//                    print_r($postData);

//            if($price_info->num_rows() < 1){
            if ($this->price_luggage_model->update_price($postData)) {
                $this->session->set_flashdata('message', display('successfully_saved'));

                $count = count($min_weights);
                $pdata['luggage_price_master_id'] = $luggage_price_master_id;
                $this->price_luggage_model->luggege_price_details_delete_before_update($luggage_price_master_id);
                for($i = 0;$i<$count;$i++)
                {

                    $pdata['min_weight'] = $min_weights[$i];
                    $pdata['max_weight'] = $max_weights[$i];
                    $pdata['price'] = $prices[$i];

//                    print_r($pdata);

                    $this->price_luggage_model->luggage_price_details_update($pdata);
                }

//                die();


            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
//            }else{
//               $this->session->set_flashdata('exception', 'This Route Price Already Exist');
//            }

            redirect("price/price_luggage_controller/index");

        } else {
            $data['title'] = display('update');
            $data['data'] = $this->price_luggage_model->price_updateForm($id);
            $data['rout'] = $this->price_luggage_model->rout();
            $data['vehc'] = $this->price_luggage_model->vehicles();
            $data['bb'] = $this->price_luggage_model->get_id($id);

            $data['price_ranges'] = $this->price_luggage_model->luggage_price_detailsget($id);

            $data['module'] = "price";
            $data['page'] = "price_luggage_form_update";

//            echo "<pre>";
//            print_r($data);
//            die();

            echo Modules::run('template/layout', $data);
        }
    }

    public function max_luggage_weight()
    {
        $vehicle_type_id = $this->input->post('vehicle_type_id');
        $max_weight_limit = $this->price_luggage_model->max_luggage_weight($vehicle_type_id);
        echo $max_weight_limit;
    }


    public function price_delete($id = null)
    {
        $this->permission->method('price', 'delete')->redirect();
        if ($this->price_luggage_model->delete_price($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('price/price_luggage_controller/');
    }

}
