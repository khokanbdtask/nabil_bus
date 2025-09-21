<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Website extends MX_Controller
{
    private $active_theme = null;

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->autocancel();
        $this->autocancel_cashbookig();
        $this->load->model(array(
            'website_model'
        ));

        // unset transection token data
        $this->session->unset_userdata('_tran_token');

        // Active theme check
        $this->active_theme = $this->website_model->get_active_themes();

        #-----------Setting-------------# 
        $setting = $this->website_model->read_setting();
        // redirect if website status is disabled
        if ($setting->status == 0)
            redirect(base_url('login'));
        #-----------Section-------------# 
    }

    public function autocancel()
    {
        $timezone = $this->db->select('*')->from('ws_setting')->get()->row();
        date_default_timezone_set($timezone->timezone);
        $downtime = $this->db->select('*')->from('booking_downtime')->get()->result();

        foreach ($downtime as $down) {
        }
        $dntime = $down->downtime;
        $cancele = $this->db->select('*')->from('tkt_booking')->where('payment_status', 1)->get()->result();

        if ($cancele) {
            foreach ($cancele as $can) {
            }
            $default = date_default_timezone_set($timezone->timezone);
            $day1 = $can->date;
            $day1 = strtotime($day1);
            $day2 = $date = date('Y-m-d H:i:s', time());
            $day2 = strtotime($day2);
            $diffHours = round(($day2 - $day1) / 3600) + 0.001;

            $sql = "UPDATE tkt_booking SET booking_delete_status = 1 WHERE $diffHours > $dntime AND payment_status=1";

            if ($this->db->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /*Booking cancel automaticallay
      |
      */

    public function autocancel_cashbookig()
    {
        $timezone = $this->db->select('*')->from('ws_setting')->get()->row();
        $downtime = $this->db->select('*')->from('booking_downtime')->get()->row();
        $canceltime = $downtime->downtime * 3600;
        $cancele = $this->db->select('*')->from('tkt_booking')->where('payment_status', 2)->get()->result();
        $downtime = $downtime->downtime;

        if ($cancele) {
            foreach ($cancele as $can) {
            }
            $default = date_default_timezone_set($timezone->timezone);
            $day1 = $can->date;
            $day1 = strtotime($day1);
            $day2 = date('Y-m-d H:i:s', time());
            $day2 = strtotime($day1);

            $diffHours = round(($day2 - $day1) / $canceltime) + 0.001;

            $sql = "UPDATE tkt_booking SET booking_delete_status = 1 WHERE $diffHours >  $downtime AND payment_status=2";
            if ($this->db->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Cancel if cash booking do not paid within an hour

    public function index()
    {
        // $data['title'] = display("home");
        $data['title'] = "Home";
        #---------------GET DATA------------------
        // if(isset($this->input->get))
        // {
        $getStartPoint = $this->input->get('start_point');
        $getEndPoint = $this->input->get('end_point');
        $getDate = $this->input->get('date');
        $getFleetType = $this->input->get('fleet_type');
        // }

        #---------------POST DATA------------------
        // if(isset($this->input->post))
        // {
        $postStartPoint = $this->input->post('start_point');
        $postEndPoint = $this->input->post('end_point');
        $postDate = $this->input->post('date');
        $postFleetType = $this->input->post('fleet_type');

        #---------------FINAL DATA------------------
        $data['search'] = (object)$postData = array(
            'start_point' => (!empty($postStartPoint) ? $postStartPoint : $getStartPoint),
            'end_point' => (!empty($postEndPoint) ? $postEndPoint : $getEndPoint),
            'date' => (!empty($postDate) ? $postDate : $getDate),
            'fleet_type' => (!empty($postFleetType) ? $postFleetType : $getFleetType),
        );
        // }

        // echo "<pre>";
        // print_r($data['search']);
        #---------------------------------------------
        $data['location_dropdown'] = $this->website_model->location_dropdown();
        $data['fleet_dropdown'] = $this->website_model->fleet_dropdown();
        $data['ratings'] = $this->website_model->read_rating();
        $data['offers'] = $this->website_model->read_offer();
        $data['notifications'] = $this->website_model->read_notification();
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();

        #-----------------------------------

        $data['module'] = "website";
        $data['page'] = $this->active_theme . "/pages/home";

//		 echo "<pre>";
//		 print_r($data);
//		 exit();

        $this->load->view($this->active_theme . '/layout', $data);
    }

// how to pay

    public function languageList()
    {
        if ($this->db->table_exists("language")) {

            $fields = $this->db->field_data("language");

            $i = 1;
            $result[] = 'Select Language';
            foreach ($fields as $field) {
                if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
            }

            if (!empty($result)) return $result;


        } else {
            return false;
        }
    }

    public function how_to_pay()
    {
        $data['title'] = display("home");
        $data['notifications'] = $this->website_model->read_notification();
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        #---------------GET DATA------------------
        $data['hpay'] = $this->website_model->how_to_pay();
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "/pages/how_to_pay";
        $this->load->view('layout', $data);
    }

    public function how_to_use()
    {
        $data['title'] = display("home");
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        #---------------GET DATA------------------
        $data['huse'] = $this->website_model->how_to_use();
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "pages/how_to_use";
        $this->load->view('layout', $data);
    }

    public function term_and_condition()
    {
        $data['title'] = display("home");
        $data['notifications'] = $this->website_model->read_notification();
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        #---------------GET DATA------------------
        $data['hpay'] = $this->website_model->how_to_pay();
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "pages/term_and_condition";
        $this->load->view('layout', $data);
    }

    public function recovery_password_confirmation($id = null)
    {
        $data['title'] = display("home");
        $data['notifications'] = $this->website_model->read_notification();
        $data['appSetting'] = $this->website_model->read_setting();
        #---------------GET DATA------------------
        $data['recpass'] = $id;
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "pages/rec_pass";
        $this->load->view('layout', $data);
    }

    public function passenger_password_confirmation($id = null)
    {
        $data['title'] = display("home");
        $data['notifications'] = $this->website_model->read_notification();
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        #---------------GET DATA------------------
        $data['recpass'] = $id;
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "/pages/passenger_rec_pass";
        $this->load->view('layout', $data);
    }

    // language list

    public function rating_passinfo($booking_id)
    {
        $booking_id = $booking_id;
        $pass_info = $this->db->select('a.*,b.firstname,b.lastname')->from('tkt_booking a')->join('tkt_passenger b', 'a.tkt_passenger_id_no=b.id_no')->where('a.id_no', $booking_id)->get()->row();
        $names = $pass_info->firstname . ' ' . $pass_info->lastname;
        echo json_encode($names);
    }

    // language setup

    public function language_setup($id)
    {

        $postData = array(
            'language' => $id,
        );

        $update = $this->db->where('id', 1)
            ->update('setting', $postData);

        if ($update) {
            $data['status'] = 'true';
        }
        echo json_encode($data);
    }
}
