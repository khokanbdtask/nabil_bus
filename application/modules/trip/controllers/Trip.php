<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trip extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'trip_model',
            'location_model',
        ));
        $this->permission->module()->redirect();
    }

    public function index()
    {
        $this->permission->module()->read()->redirect();
        $data['title'] = display('list');
        #-------------------------------#
        $data['trps'] = $this->trip_model->read();
        $data['module'] = "trip";
        $data['page'] = "trip/list";

        $route_no = count($data['trps']);

        for ($i = 0; $i < $route_no; $i++) {
            $stoppage_points = $data['trps'][$i]->stoppage_points;
            $loc_name = array();

            $sp_list = "";
            $stopages = explode(',', $stoppage_points);
            $c = 0;
            foreach ($stopages as $ids) {
                $loc_name[$c] = $this->location_model->loc_names($ids);
                $sp_list .= $loc_name[$c][0]->name . ',';
                $c++;
            }

            $data['trps'][$i]->stoppages = $sp_list;

        }

        echo Modules::run('template/layout', $data);
    }

    public function form($id = null)
    {
        if ($this->input->post()) {

            $this->permission->module()->create()->redirect();
            $data['title'] = display('add');
            #-------------------------------#
            $this->form_validation->set_rules('status', display('status'), 'required');
            $shels = $this->input->post('shedule');
            $shd = explode("-", $shels);
            $strt = $shd[0];
            $ends = $shd[1];
            //$test = $this->db->select('*')->from('trip_route')->where('start_point',6)->where('end_point',3)->get()->row();
            $routes = $this->db->select('*')->from('trip_route')->where('name', $this->input->post('route'))->get()->row();
            $types = $this->db->select('*')->from('fleet_type')->where('type', $this->input->post('types'))->get()->row();
            $shedule = $this->db->select('*')->from('shedule')->where('start', $strt)->get()->row();
            $weekend = $this->input->post("weekend");
            if (!empty($weekend)) {
                $weekday = implode(',', $weekend);
            }

            #-------------------------------#
            $data['trips'] = (object) $postData = [
                'trip_id' => $this->input->post('trip_id'),
                'trip_title' => $this->input->post('trip_title'),
                'route' => $routes->id,
                'shedule_id' => $shedule->shedule_id,
                'type' => $types->id,
                'weekend' => (!empty($weekday) ? $weekday : 8),
                'status' => $this->input->post('status'),
            ];

            #-------------------------------#
            if ($this->form_validation->run()) {
                if (empty($postData['trip_id'])) {

                    // echo "<pre>";
                    // print_r($postData);
                    // exit();

                    $this->permission->method('trip', 'create')->redirect();

                    if ($this->trip_model->create($postData)) {
                        $this->session->set_flashdata('message', display('save_successfully'));
                    } else {
                        $this->session->set_flashdata('exception', display('please_try_again'));
                    }

                    redirect("trip/trip/index");

                } else {

                    $this->permission->method('trip', 'update')->redirect();

                    if ($this->trip_model->update($postData)) {
                        $this->session->set_flashdata('message', display('update_successfully'));
                    } else {
                        $this->session->set_flashdata('exception', display('please_try_again'));
                    }
                    redirect("trip/trip/form/" . $postData['trip_id']);
                }

            }
        }

        if (!empty($id)) {
            $data['title'] = display('update');
            $data['trips'] = $this->trip_model->findById($id);
            $data['weekdaylist'] = array(
                '1' => 'Sunday',
                '2' => 'Monday',
                '3' => 'Tuesday',
                '4' => 'Wednesday',
                '5' => 'Thursday',
                '6' => 'Friday',
                '7' => 'Saturday',
            );

        }
        $data['route_list'] = $this->trip_model->dropdown();
        $data['shedule'] = $this->trip_model->shedules();
        $data['types'] = $this->trip_model->types();
        $data['weekdaylist'] = array(
            '1' => 'Sunday',
            '2' => 'Monday',
            '3' => 'Tuesday',
            '4' => 'Wednesday',
            '5' => 'Thursday',
            '6' => 'Friday',
            '7' => 'Saturday',
        );
        $data['module'] = "trip";
        $data['page'] = "trip/form";

        // echo "<pre>";
        // print_r($data);
        // exit();

        echo Modules::run('template/layout', $data);

    }

    public function delete($id = null)
    {
        $this->permission->module()->delete()->redirect();

        if ($this->trip_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('trip/trip/index');
    }


    public function otherLocation()

    {
        $this->permission->module()->read()->redirect();
        $data['title'] = "Other Location List";
        #-------------------------------#
        $data['otherlocation'] = $this->trip_model->getAllOtherLocation();
        
        // echo "<pre>";
        // print_r ($data['otherlocation']);
        // echo "</pre>";
        // exit;

        $data['module'] = "trip";
        $data['page'] = "trip/other_location_list";

        

        echo Modules::run('template/layout', $data);

    }

    public function otherLocationFromLoad()
    {
        $data['title'] = "Other Location Add";

        
        $data['route_list'] = $this->trip_model->routListdropdown();
        
        $data['module'] = "trip";
        $data['page'] = "trip/other_location_form";

        // echo "<pre>";
        // print_r($data);
        // exit();

        echo Modules::run('template/layout', $data);

    }

    public function addOtherLocation()
    {

                $this->form_validation->set_rules('trip_route_id[]', 'Trip Route', 'required');
                $this->form_validation->set_rules('location_name', 'Location Name', 'required');
                $this->form_validation->set_rules('extra_fee', 'extra_fee', 'required');
                $this->form_validation->set_rules('status', 'Status', 'required');

                if ($this->form_validation->run() === FALSE)
                {
                   
                    $data['title'] = "Other Location Add";
                    $data['route_list'] = $this->trip_model->routListdropdown();
                    $data['module'] = "trip";
                    $data['page'] = "trip/other_location_form";
                    echo Modules::run('template/layout', $data);
                }
                else
                {
                    $routIds =  $this->input->post('trip_route_id[]');
                    foreach ($routIds as $key => $routIdvalue) {
                        $data [$key]= [
                            'trip_route_id' => $routIdvalue,
                            'location_name' => $this->input->post('location_name'),
                            'extra_fee' => $this->input->post('extra_fee'),
                            'status' => $this->input->post('status'),
                        ];
                    }
                    

                    if ($this->trip_model->otherLocationcreate($data)) {
                        $this->session->set_flashdata('message', display('save_successfully'));
                    } else {
                        $this->session->set_flashdata('exception', display('please_try_again'));
                    }
                        redirect("trip/trip/otherLocation");
                }

    }


    public function otherLocationEdit($otherLocationID)
    {
        $data['title'] = "Other Location Edit";

        
        $data['route_list'] = $this->trip_model->routListdropdown();
        $data['otherlocation'] = $this->trip_model->getOtherLocation($otherLocationID);

        // echo "<pre>";
        // print_r ($data['route_list']);
        // echo "</pre>";
        // exit;
        
        $data['module'] = "trip";
        $data['page'] = "trip/other_location_form_edit";
        echo Modules::run('template/layout', $data);

       

    }

    public function upDateOtherLocation($locationId)
    {
        $this->form_validation->set_rules('trip_route_id', 'Trip Route', 'required');
        $this->form_validation->set_rules('location_name', 'Location Name', 'required');
        $this->form_validation->set_rules('extra_fee', 'extra_fee', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');


        if ($this->form_validation->run() === FALSE)
                {
                   
                    $data['title'] = "Other Location Edit";
                    $data['route_list'] = $this->trip_model->routListdropdown();
                    $data['otherlocation'] = $this->trip_model->getOtherLocation($locationId);

                    // echo "<pre>";
                    // print_r ($data['route_list']);
                    // echo "</pre>";
                    // exit;
                    
                    $data['module'] = "trip";
                    $data['page'] = "trip/other_location_form_edit";
                    echo Modules::run('template/layout', $data);
                }
                else
                {
                    $data= [
                        'trip_route_id' => $this->input->post('trip_route_id'),
                        'location_name' => $this->input->post('location_name'),
                        'extra_fee' => $this->input->post('extra_fee'),
                        'status' => $this->input->post('status'),
                    ];

                    if ($this->trip_model->updateOtherLocation($locationId,$data)) {
                        $this->session->set_flashdata('message', display('save_successfully'));
                    } else {
                        $this->session->set_flashdata('exception', display('please_try_again'));
                    }
                        redirect("trip/trip/otherLocation");
                }
    }


    public function findExtraLocation($roteId)
    {
        $data = $this->trip_model->getOtherLocationData($roteId);

        echo json_encode($data);
    }

}
