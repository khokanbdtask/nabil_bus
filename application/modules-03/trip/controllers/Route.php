<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Route extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'route_model',
            'location_model'
        ));
    }

    public function index()
    {
        $this->permission->method('trip', 'read')->redirect();
        $data['title'] = display('list');
        #-------------------------------#
        $data['routes'] = $this->route_model->read();

        $data['module'] = "trip";
        $data['page'] = "route/list";

        // echo "<pre>";
        // echo count($data['routes']);
        //   print_r($data['routes']);
        //   exit();


        /// === By using location ID, showing the location's name in Data Table.

        $route_no = count($data['routes']);

        for ($i = 0; $i < $route_no; $i++) {
            $stoppage_points = $data['routes'][$i]->stoppage_points;
            $loc_name = array();

            $sp_list = "";
            $stopages = explode(',', $stoppage_points);
            $c = 0;
            foreach ($stopages as $ids) {
                $loc_name[$c] = $this->location_model->loc_names($ids);
                $sp_list .= $loc_name[$c][0]->name . ',';
                $c++;
            }

            $data['routes'][$i]->stoppages = $sp_list;

        }

        echo Modules::run('template/layout', $data);
    }

    public function add()
    {

////////// === Showing the Route Create Form

        $data['title'] = display('add');
        $data['location_list'] = $this->location_model->dropdown();
        $data['stopage'] = $this->location_model->stopage();
        $data['module'] = "trip";
        $data['page'] = "route/form";

        $locations = $this->location_model->read();

        $c = count($locations);
        for ($i = 0; $i < $c; $i++) {
            $data['loc_lists'] = $locations;
        }

        // echo "<pre>";
        // print_r($data);
        // die();

        echo Modules::run('template/layout', $data);
    }

    public function form($id = null)
    {
        if ($this->input->post()) {
            # code...
            $start = array();
            $end = array();
            $array1 = array();

            $this->permission->method('trip', 'create')->redirect();
            $data['title'] = display('add');
            #-------------------------------#
            $this->form_validation->set_rules('name', display('route_name'), 'required|max_length[255]');
            $this->form_validation->set_rules('start_point', display('start_point'), 'required|max_length[50]');
            $this->form_validation->set_rules('end_point', display('end_point'), 'required|max_length[50]');
            $this->form_validation->set_rules('stoppage_points', display('stoppage_points'), 'required');
            $this->form_validation->set_rules('status', display('status'), 'required');

            $start = $this->db->select('id')->from('trip_location')->where('id', $this->input->post('start_point'))->get()->row();

            $end = $this->db->select('id')->from('trip_location')->where('id', $this->input->post('end_point'))->get()->row();

            $array1[0] = $start->id;
            $array1[1] = $end->id;


            $array2 = $this->input->post('stoppage_points');

            if (!empty($this->input->post('stoppage_points'))) {
                $array3 = array_diff($this->input->post('stoppage_points'), $array1);
                $output = implode(',', $array3);
                $stopagp = (!empty($this->input->post('stoppage_points')) ? $output . ',' . $array1[0] . ',' . $array1[1] : '');
            } else {
                $stopagp = $array1[0] . ',' . $array1[1];
            }

            #-------------------------------#

            $data['route'] = (object)$postData = [
                'id' => $this->input->post('id'),
                'name' => $this->input->post('name'),
                'start_point' => $this->input->post('start_point'),
                'end_point' => $this->input->post('end_point'),
                'stoppage_points' => $stopagp,
                'distance' => $this->input->post('distance'),
                'approximate_time' => $this->input->post('approximate_time'),
                'children_seat' => $this->input->post('children_seat'),
                'special_seat' => $this->input->post('special_seat'),
                'status' => $this->input->post('status'),
            ];

            #-------------------------------#
            // echo "<pre>";
            // print_r($postData);
            // print_r($array2);
            // exit();

            // print_r($postData);

            if (empty($postData['id'])) {

                $this->permission->method('trip', 'create')->redirect();

                if ($this->route_model->create($postData)) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("trip/route/index");

            } else {

                $this->permission->method('trip', 'update')->redirect();

                if ($this->route_model->update($postData)) {
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("trip/route/edit/" . $postData['id']);
            }

        } else {
            redirect("trip/route/add");
        }

    }

    public function edit($id = '')
    {
        if (!empty($id)) {
            $data['title'] = display('update');
            $data['route'] = $this->route_model->findById($id);
        }

        $data['location_list'] = $this->location_model->dropdown();
        $data['stopage'] = $this->location_model->stopage();
        $data['module'] = "trip";
        $data['page'] = "route/route_edit";

        $locations = $this->location_model->read();

        $c = count($locations);
        for ($i = 0; $i < $c; $i++) {
            $data['loc_lists'] = $locations;
        }

        // echo "<pre>";
        // print_r($data);

        // die();

        echo Modules::run('template/layout', $data);
    }


    public function delete($id = null)
    {
        $this->permission->method('trip', 'delete')->redirect();

        if ($this->route_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('trip/route/index');
    }


    public function startendpoints()
    {

        $html = '';

        $a = array();
        $startpoints = $this->input->post('start_point');
        $endpoints = $this->input->post('end_point');

        $loc_ids = explode(',', $this->input->post('stoppage_points'));

        // echo "<pre>";
        // print_r($loc_ids);
        // exit();


        $data = $this->db->select("id,name")
            ->from('trip_location')
            ->where('status', 1)
            ->where('id !=', $startpoints)
            ->where('id !=', $endpoints)
            ->get()
            ->result();

        $c = count($data);
        $x = 0;
        for ($i = 0; $i < $c; $i++) {
            if (array_search($data[$i]->id, $loc_ids)) {
                $a[$x] = array_search($data[$i]->id, $loc_ids);
                $x++;
            }

            // goto b;
            if (isset($a) && $loc_ids[$x] == $data[$i]->id) {
                // echo $i;
                $html .= '<option value="' . $data[$i]->id . '" selected>
                  ' . $data[$i]->name . '
                  </option>';
            } else {
                $html .= '<option value="' . $data[$i]->id . '">
                  ' . $data[$i]->name . '
                  </option>';
            }

            // 				$html .= '<option value="'. $data[$i]->id.'">
            //                '. $data[$i]->name.'
            //                </option>';
            // b:

            // echo "<pre>";
            // print_r($data[$i]);
            // print_r($loc_ids);
            // print_r($a);

            // echo $html;

        }
// exit();


        // echo "<pre>";
        // print_r($data);
        // die();
        echo json_encode($html);

    }

    public function locations_name()
    {
        $loc_name = array();
        $data = "";
        $loc_ids = explode(',', $this->input->post('loc_id'));

        $c = 0;
        foreach ($loc_ids as $ids) {


            $loc_name[$c] = $this->location_model->loc_names($ids);
            $data .= $loc_name[$c][0]->name . ',';
            $c++;
        }

        echo json_encode($data);


    }


}
