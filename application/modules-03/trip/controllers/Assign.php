<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Assign extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'assign_model',
            'route_model'
        ));
    }

    public function index()
    {
        $this->permission->method('trip', 'read')->redirect();
        $data['title'] = display('list');
        #-------------------------------#
        #
        #pagination starts
        #
        $config["base_url"] = base_url('trip/assign/index');
        $config["total_rows"] = $this->db->count_all('trip_assign');
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
        $data["assigns"] = $this->assign_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #  

        $data["logo"] = $this->db->select("*")
        ->from('setting')
        ->get()
        ->row();

        $data['module'] = "trip";
        $data['page'] = "assign/list";
        echo Modules::run('template/layout', $data);
    }

    public function form($id = null)
    {
        $data['title'] = display('add');

        $rand[]= array();
        #-------------------------------#
        $this->form_validation->set_rules('fleet_registration_id', display('fleet_registration_no'), 'required|max_length[11]');
        // New code 2021 direct update
        $this->form_validation->set_rules('driver_id[]', display('driver_name'), 'required');
        $this->form_validation->set_rules('assistant_1[]', display('assistant_1'), 'required');
       // New code 2021 direct update
        $this->form_validation->set_rules('status', display('status'), 'required');

        /*-----------------------------------*/
        $ids = $this->input->post('id');
        $id_no = (!empty($ids) ? $this->input->post('id_no') : $this->randStrGen());
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $assigndate = $this->input->post('assign_date');
        //$trip = (!empty($this->input->post('trip'))?$this->input->post('trip'):0);

        #-------------------------------#
        // New code 2021 direct update

        $data['assign'] = (object)$postData = [
            'id' => $ids,
            'id_no' => $id_no,
            'fleet_registration_id' => $this->input->post('fleet_registration_id'),
            'status' => $this->input->post('status'),
            'assign_time' => date('Y-m-d H:i:s', strtotime((!empty($assigndate) ? $assigndate : date('Y-m-d H:i:s')))),
            'trip' => $this->input->post('trip'),
            'createdate' => date('Y-m-d H:i:s')
        ];
       
        $rand['beganing'] = $id_no;
        $fleetinfo = [
            'is_assign' => 1,
        ];
         // New code 2021 direct update
        #-------------------------------#
        if ($this->form_validation->run()) {

            // New code 2021 direct update
            $data['assign'] = (object)$postData = [
               
                
                'id' => $ids,
                'id_no' => $id_no,
                'fleet_registration_id' => $this->input->post('fleet_registration_id'),
                'status' => $this->input->post('status'),
                'assign_time' => date('Y-m-d H:i:s', strtotime((!empty($assigndate) ? $assigndate : date('Y-m-d H:i:s')))),
                'trip' => $this->input->post('trip'),
                'createdate' => date('Y-m-d H:i:s'),
                'driver_id' => $this->input->post('driver_id')[0],
                'assistant_1' => $this->input->post('assistant_1')[0],
                
               
            ];
            // New code 2021 direct update
        

            if (empty($postData['id'])) {

                $this->permission->method('trip', 'create')->redirect();

                if ($this->assign_model->create($postData)) {
               

                    // New code 2021 direct update
                    if (count($this->input->post('driver_id')) > 1) {
                        
                        $driverid =  $this->input->post('driver_id');
                        $x=0;
                               foreach ($driverid as $key => $value) {
                                   $dynamicInput[$x] = array(
                                     'randomid'=>$id_no,
                                     'tripid'=>$this->input->post('trip'),
                                     'fleetid'=>$this->input->post('fleet_registration_id'),
                                     'employeetype' => "Driver",
                                     'employeeid' =>$value,
                                     'date' => date("Y-m-d"),
                                    
                                 );
                                   $x++;
                               }

                               $d=0;
                              foreach ($driverid as $key => $dvalue) {
                                $updateDriver[$d] = array(
                                  'is_assign' => 1,
                                  'id' =>$dvalue,
                                );
                                $d++;
                            }

                           
                           
                    }

                    else
                    {

                        $dynamicInput[] = array(
                            'randomid'=>$id_no,
                            'tripid'=>$this->input->post('trip'),
                            'fleetid'=>$this->input->post('fleet_registration_id'),
                            'employeetype' => "Driver",
                            'employeeid' =>$this->input->post('driver_id')[0],
                            'date' => date("Y-m-d"),
                           
                        );


                        $updateDriver[] = array(
                            'is_assign' => 1,
                            'id' =>$this->input->post('driver_id')[0],
                          );

                    }

                    $this->db->insert_batch('dynamic_assign', $dynamicInput);
                    $this->db->update_batch('employee_history', $updateDriver, 'id');
                           

                    if (count($this->input->post('assistant_1')) > 1) {
                        
                        $assistanceid =  $this->input->post('assistant_1');
                        $n=0;
                               foreach ($assistanceid as $key => $avalue) {
                                   $assistanceInput[$n] = array(
                                     'randomid'=>$id_no,
                                     'tripid'=>$this->input->post('trip'),
                                     'fleetid'=>$this->input->post('fleet_registration_id'),
                                     'employeetype' => "Assistant",
                                     'employeeid' =>$avalue,
                                     'date' => date("Y-m-d"),
                                    
                                 );
                                   $n++;
                               }

                               $a=0;
                              foreach ($assistanceid as $key => $asvalue) {
                                $updateAsistant[$a] = array(
                                  'is_assign' => 1,
                                  'id' =>$asvalue,
                                );
                                $a++;
                            }
                            
                    }

                    else
                    {
                        $assistanceInput[] = array(
                            'randomid'=>$id_no,
                            'tripid'=>$this->input->post('trip'),
                            'fleetid'=>$this->input->post('fleet_registration_id'),
                            'employeetype' => "Assistant",
                            'employeeid' =>$this->input->post('assistant_1')[0],
                            'date' => date("Y-m-d"),
                           
                        );

                        $updateAsistant[] = array(
                            'is_assign' => 1,
                            'id' =>$this->input->post('assistant_1')[0],
                          );

                    }

                    $this->db->insert_batch('dynamic_assign', $assistanceInput);
                    $this->db->update_batch('employee_history', $updateAsistant, 'id');
                   
                 
                   // New code 2021 direct update

                   
                    if (!empty($this->input->post('fleet_registration_id'))) {
                        $this->db->where('id', $this->input->post('fleet_registration_id', true))
                            ->update('fleet_registration', $fleetinfo);
                          
                    }
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("trip/assign/form");

            } else {

                $this->permission->method('trip', 'update')->redirect();

                if ($this->assign_model->update($postData)) {

                     // New code 2021 direct update



                            if (count($this->input->post('driver_id')) > 1) {
                                
                                $driverid =  $this->input->post('driver_id');
                                $x=0;
                                    foreach ($driverid as $key => $value) {
                                        $dynamicInput[$x] = array(
                                            'randomid'=>$id_no,
                                            'tripid'=>$this->input->post('trip'),
                                            'fleetid'=>$this->input->post('fleet_registration_id'),
                                            'employeetype' => "Driver",
                                            'employeeid' =>$value,
                                            'date' => date("Y-m-d"),
                                            
                                        );
                                        $x++;
                                    }

                                    $d=0;
                                    foreach ($driverid as $key => $dvalue) {
                                        $updateDriver[$d] = array(
                                        'is_assign' => 1,
                                        'id' =>$dvalue,
                                        );
                                        $d++;
                                    }
    
                                
                            }

                            else
                            {

                                $dynamicInput[] = array(
                                    'randomid'=>$id_no,
                                    'tripid'=>$this->input->post('trip'),
                                    'fleetid'=>$this->input->post('fleet_registration_id'),
                                    'employeetype' => "Driver",
                                    'employeeid' =>$this->input->post('driver_id')[0],
                                    'date' => date("Y-m-d"),
                                
                                );


                                $updateDriver[] = array(
                                    'is_assign' => 1,
                                    'id' =>$this->input->post('driver_id')[0],
                                );

                            }

                                $this->db->where('randomid', $id_no);
                                $this->db->where('employeetype', 'Driver');
                                $this->db->delete('dynamic_assign');

                            $this->db->insert_batch('dynamic_assign', $dynamicInput);
                            $this->db->update_batch('employee_history', $updateDriver, 'id');


                            if (count($this->input->post('assistant_1')) > 1) {
                        
                                $assistanceid =  $this->input->post('assistant_1');
                                $n=0;
                                       foreach ($assistanceid as $key => $avalue) {
                                           $assistanceInput[$n] = array(
                                             'randomid'=>$id_no,
                                             'tripid'=>$this->input->post('trip'),
                                             'fleetid'=>$this->input->post('fleet_registration_id'),
                                             'employeetype' => "Assistant",
                                             'employeeid' =>$avalue,
                                             'date' => date("Y-m-d"),
                                            
                                         );
                                           $n++;
                                       }
        
                                       $a=0;
                                      foreach ($assistanceid as $key => $asvalue) {
                                        $updateAsistant[$a] = array(
                                          'is_assign' => 1,
                                          'id' =>$asvalue,
                                        );
                                        $a++;
                                    }
                                    
                            }
        
                            else
                            {
                                $assistanceInput[] = array(
                                    'randomid'=>$id_no,
                                    'tripid'=>$this->input->post('trip'),
                                    'fleetid'=>$this->input->post('fleet_registration_id'),
                                    'employeetype' => "Assistant",
                                    'employeeid' =>$this->input->post('assistant_1')[0],
                                    'date' => date("Y-m-d"),
                                   
                                );
        
                                $updateAsistant[] = array(
                                    'is_assign' => 1,
                                    'id' =>$this->input->post('assistant_1')[0],
                                  );
        
                            }
                            
                            $this->db->where('randomid', $id_no);
                            $this->db->where('employeetype', 'Assistant');
                            $this->db->delete('dynamic_assign');

                            $this->db->insert_batch('dynamic_assign', $assistanceInput);
                            $this->db->update_batch('employee_history', $updateAsistant, 'id');

                            // New code 2021 direct update


                    if (!empty($this->input->post('fleet_registration_id'))) {
                        $this->db->where('id', $this->input->post('fleet_registration_id', true))
                            ->update('fleet_registration', $fleetinfo);
                    }
                    $this->session->set_flashdata('message', display('update_successfully'));
                }
                
                
                else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }

                redirect("trip/assign/form/" . $postData['id']);
            }


        } else {
            if (!empty($id)) {

                 // New code 2021 direct update
                $tripid = $this->db->where('id', $id)->get("trip_assign")->row();
                $tripid =$tripid->id_no;
                
                $driverdata = $this->assign_model->driverdropdownupdate($tripid);
                if(!empty( $driverdata))
                {
                    $data['addedDrivelist'] = $driverdata;
                   
                }
                else
                {
                    $driverdata = $this->assign_model->driverdropdownupdateNodynamic($tripid);
                    $data['addedDrivelist'] = $driverdata;
                }

                $assistansedata = $this->assign_model->asistnsedropdownupdate($tripid);
                if(!empty( $assistansedata))
                {
                    $data['addedAsistantlist'] =  $assistansedata;
                   
                }
                else
                {
                    $assistansedata = $this->assign_model->asistantdropdownupdateNodynamic($tripid);
                    $data['addedAsistantlist'] = $assistansedata;
                }
                

                $data['title'] = display('update');
                $data['assign'] = $this->assign_model->findById($id);
                $data['fleet_dropdown'] = $this->assign_model->fleet_dropdown_update();
                // $data['driver_dropdown'] = $this->assign_model->driver_dropdown_update();
                // $data['assistant_dropdown'] = $this->assign_model->assistant_dropdown_update();

                // New code 2021 direct update
                $data['driver_dropdown'] = $this->assign_model->driverUpdate($tripid);
                $data['assistant_dropdown'] = $this->assign_model->asistantUpdate($tripid);
               // New code 2021 direct update
               

            }
            if (empty($id)) {
                // New code 2021 direct update
                $data['driver_dropdown'] = $this->assign_model->dropdowndriver();
                $data['assistant_dropdown'] = $this->assign_model->dropdownassistant();
                // New code 2021 direct update 
                $data['fleet_dropdown'] = $this->assign_model->fleet_dropdown();
               
            }
            $data['route_dropdown'] = $this->route_model->dropdown();
            $data['trip'] = $this->assign_model->trip_dropdown();
            $data['shedule'] = $this->assign_model->shedule_dropdown();
            $data['module'] = "trip";
            $data['page'] = "assign/form";



            echo Modules::run('template/layout', $data);
        }
    }

    public function randStrGen()
    {
        return date('ymdhis');
    }

    public function view($id_no = null)
    {
        $this->permission->method('trip', 'read')->redirect();
        $data['title'] = display('assign');
        $data['assign'] = $this->assign_model->findByIdNo($id_no);

         // New code 2021 direct update
        if(!empty($id_no))
        {
          $tiripid =  $this->db->where('id_no', $id_no)->get('trip_assign')->result();
        

          $fleetType =  $this->db->where('id', $tiripid[0]->fleet_registration_id)->get('fleet_registration')->result();
         

          $totalseat =  $this->db->where('id', $fleetType[0]->fleet_type_id)->get('fleet_type')->result();
         

          $totalbookseat =  $this->db->select_sum('total_seat')->where('trip_id_no', $tiripid[0]->id)->where('booking_date', date('Y-m-d'))->get('tkt_booking')->row();
         

          $driver =  $this->db->select(' CONCAT_WS(" ",first_name, '.', second_name) AS name')
                            ->from('dynamic_assign')
                            ->join('employee_history', 'employee_history.id = dynamic_assign.employeeid') 
                            ->where('randomid', $id_no)
                            ->where('employeetype', 'Driver')
                            ->get()
                            ->result();
                           
        

          $assistant =   $this->db->select(' CONCAT_WS(" ", first_name, '.', second_name) AS name')
                        ->from('dynamic_assign')
                        ->join('employee_history', 'employee_history.id = dynamic_assign.employeeid') 
                        ->where('randomid', $id_no)
                        ->where('employeetype', 'Assistant')
                        ->get()
                        ->result();

          $data['abailableseat'] = (int)$totalseat[0]->total_seat - (int)$totalbookseat->total_seat ;
          $data['driver'] =  $driver  ;
          $data['assistant'] = $assistant ;
        }

        // New code 2021 direct update

        $data['module'] = "trip";
        $data['page'] = "assign/view";
        echo Modules::run('template/layout', $data);
    }


    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */

    public function delete($id = null)
    {
        $this->permission->method('trip', 'delete')->redirect();

        if ($this->assign_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('trip/assign/index');
    }
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */

    
    // client 2022 project update
    
    public function freezelist($tripassingId)
    {

        $data["logo"] = $this->db->select("*")
        ->from('setting')
        ->get()
        ->row();
        $treipassignid = $this->db->select("*")->from('trip_assign')->where('id',$tripassingId)->get()->row();
        $data['seat_list'] = $this->db->select("*")->from('freeze_seat')->where('tripid',$treipassignid->trip)->get()->result();

        $data['module'] = "trip";
        $data['tripid'] = $tripassingId;
        $data['page'] = "assign/freezelist";
        echo Modules::run('template/layout', $data);

    }


    public function freezeform($tripassingId)
    {
        $fleet_rgistration = $this->db->select("*")->from('trip_assign')->where('id',$tripassingId)->get()->row();
       
        $fleet_typeid = $this->db->select("*")->from('fleet_registration')->where('id',$fleet_rgistration->fleet_registration_id)->get()->row();
        $fleet_seats = $this->db->select("*")->from('fleet_type')->where('id',$fleet_typeid->fleet_type_id)->get()->row();
        $fleet_seats = explode(",",$fleet_seats->seat_numbers);

        $data["logo"] = $this->db->select("*")
        ->from('setting')
        ->get()
        ->row();
        $data['module'] = "trip";
        $data['tripid'] = $fleet_rgistration->trip;
        $data['tripidassignid'] = $tripassingId;
        $data['page'] = "assign/freezeform";
        $data['seats'] = $fleet_seats;
        echo Modules::run('template/layout', $data);
    }

    public function addfreeze()
    {
        $postData = [
             'status' =>$this->input->post('status'),
            'tripid' => $this->input->post('tripid'),
            'seat_number' => $this->input->post('seat_number'),
           ];

           $this->db->insert('freeze_seat', $postData);

           $this->freezelist($this->input->post('tripid'));
    }

    public function deletefreeze($tripid,$deleteid)
    {
        $this->db->where('id', $deleteid);
        $this->db->delete('freeze_seat');
        $this->freezelist($tripid);
    }

    public function status($type,$id,$tripid)
    {
        $data = array(
            'status' => $type,
           );
    
    $this->db->where('id', $id);
    $this->db->update('freeze_seat', $data);
    $this->freezelist($tripid);

    }
    
    // client 2022 project update


}