<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once './vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Luggage extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        // $this->autocancel();
        // $this->autocancel_cashbookig();

        // $this->load->library('pdf');

        // load helper
        // $this->load->helper(array('new'));

        $this->load->model(array(
            'luggage_model',
            'country_model',
            'passenger_model',
            'price/price_model',
            'website/website_model'
        ));
    }

    public function invoice($id = null)
    {

        $data['ticket'] = $this->luggage_model->ticket($id);
        $data['ticket_arr'] = (array)$this->luggage_model->ticket($id);
        $data['sender'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['sender_id_no']);
        $data['receiver'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['receiver_id_no']);

        $data['pickup'] = $this->luggage_model->location_id_name($data['ticket_arr']['pickup_trip_location']);

        $data['drop'] = $this->luggage_model->location_id_name($data['ticket_arr']['drop_trip_location']);

        $route_id = $data['ticket']->trip_route_id;

        $data['pricess'] = $this->db->select('*')->from('pri_price')->where('route_id', $route_id)->get()->row();

        $data['appSetting'] = $this->luggage_model->website_setting();


        // echo "<pre>";
        // print_r($data);
        // exit();

        $this->load->view('booking/invoice', $data);
    }

    // public function autocancel()
    // {
    //     $timezone = $this->db->select('*')->from('ws_setting')->where('id', 1)->get()->row();
    //     $downtime = $this->db->select('*')->from('booking_downtime')->get()->result();
    //     foreach ($downtime as $down) {
    //     }
    //     $dntime = $down->downtime;
    //     $cancele = $this->db->select('*')->from('tkt_booking')->where('payment_status', 1)->get()->result();

    //     if ($cancele) {
    //         foreach ($cancele as $can) {
    //         }
    //         $default = date_default_timezone_set($timezone->timezone);
    //         $day1 = $can->date;
    //         $day1 = strtotime($day1);
    //         $day2 = $date = date('Y-m-d H:i:s', time());
    //         $day2 = strtotime($day2);
    //         $diffHours = round(($day2 - $day1) / 3600) + 0.001;
    //         $sql = "DELETE FROM tkt_booking WHERE $diffHours > $dntime AND payment_status=1";

    //         if ($this->db->query($sql) === TRUE) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    // public function autocancel_cashbookig()
    // {
    //     $timezone = $this->db->select('*')->from('ws_setting')->where('id', 1)->get()->row();
    //     $downtime = $this->db->select('downtime')->from('booking_downtime')->get()->result();
    //     // echo "<pre>";
    //     // print_r($downtime[0]->downtime);
    //     // exit();
    //     $cancele = $this->db->select('*')->from('tkt_booking')->where('payment_status', 2)->get()->result();

    //     $dntime = $downtime[0]->downtime;

    //     if ($cancele) {
    //         foreach ($cancele as $can) {
    //         }
    //         $default = date_default_timezone_set($timezone->timezone);
    //         $day1 = $can->date;
    //         $day1 = strtotime($day1);
    //         $day2 = $date = date('Y-m-d H:i:s', time());
    //         $day2 = strtotime($day2);
    //         $diffHours = round(($day2 - $day1) / 3600) + 0.001;
    //         $sql = "DELETE FROM tkt_booking WHERE $diffHours > $dntime AND payment_status=2";
    //         if ($this->db->query($sql) === TRUE) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    public function index()
    {
        $this->permission->method('ticket', 'read')->redirect();
        $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
            $currency = $price['currency'];
        }
        $data['title'] = display('list');
        #-------------------------------#
        #
        #pagination starts
        #
        // $config["base_url"] = base_url('luggage/luggage/index');
        // $config["total_rows"] = $this->luggage_model->count_ticket();
        // $config["per_page"] = 25;
        // $config["uri_segment"] = 4;
        // $config["last_link"] = "Last";
        // $config["first_link"] = "First";
        // $config['next_link'] = 'Next';
        // $config['prev_link'] = 'Prev';
        // $config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
        // $config['full_tag_close'] = "</ul>";
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';
        // $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        // $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        // $config['next_tag_open'] = "<li>";
        // $config['next_tag_close'] = "</li>";
        // $config['prev_tag_open'] = "<li>";
        // $config['prev_tagl_close'] = "</li>";
        // $config['first_tag_open'] = "<li>";
        // $config['first_tagl_close'] = "</li>";
        // $config['last_tag_open'] = "<li>";
        // $config['last_tagl_close'] = "</li>";
        // /* ends of bootstrap */
        // $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["bookings"] = $this->luggage_model->read(25, $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #
        $data['currency'] = $currency;
        $data['module'] = "luggage";
        $data['page'] = "booking/list";
        echo Modules::run('template/layout', $data);
    }

    public function view($id = null)
    {
        if (!empty($id)) {
            $this->permission->method('ticket', 'create')->redirect();
            $data['title'] = display('view');
            #-------------------------------#
            $data['ticket'] = $this->luggage_model->ticket($id);
            $data['ticket_arr'] = (array)$this->luggage_model->ticket($id);
            $data['sender'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['sender_id_no']);
            $data['receiver'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['receiver_id_no']);

            $data['pickup'] = $this->luggage_model->location_id_name($data['ticket_arr']['pickup_trip_location']);

            $data['drop'] = $this->luggage_model->location_id_name($data['ticket_arr']['drop_trip_location']);

            $route_id = $data['ticket']->trip_route_id;

            // $data['pricess'] = $this->db->select('*')->from('pri_price')->where('route_id', $route_id)->get()->row();


            $data['appSetting'] = $this->luggage_model->website_setting();

            $data['module'] = "luggage";

            // echo "<pre>";
            // print_r($data);
            // exit();

            $data['page'] = "booking/ticket";

            echo Modules::run('template/layout', $data);
        } else {
            redirect('luggage/luggage/index');
        }
    }

    /*
    |----------------------------------------------
    |  Add Passenger
    |----------------------------------------------
    */

    public function delete($id = null)
    {
        $this->permission->method('ticket', 'delete')->redirect();

        if ($this->luggage_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('luggage/luggage/index');
    }

    public function newPassenger()
    {
        $this->permission->method('ticket', 'create')->redirect();
        #-------------------------------#
        $this->form_validation->set_rules('firstname', display('firstname'), 'required|max_length[50]');
        $this->form_validation->set_rules('lastname', display('lastname'), 'required|max_length[50]');
        $this->form_validation->set_rules('phone', display('phone'), 'required|is_unique[tkt_passenger.phone]|max_length[30]');
        $this->form_validation->set_rules('email', display('email'), 'required|valid_email|is_unique[tkt_passenger.email]|max_length[130]');
        $this->form_validation->set_rules('address_line_1', display('address_line_1'), 'max_length[255]');
        $this->form_validation->set_rules('address_line_2', display('address_line_2'), 'max_length[255]');
        $this->form_validation->set_rules('city', display('city'), 'max_length[50]');
        $this->form_validation->set_rules('zip_code', display('zip_code'), 'max_length[6]');
        $this->form_validation->set_rules('country', display('country'), 'max_length[20]');
        #-------------------------------#
        $data['passenger'] = (object)$postData = [
            'id_no' => $this->randID(),
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'password' => md5(strtotime(date("His"))),
            'address_line_1' => $this->input->post('address_line_1'),
            'address_line_2' => $this->input->post('address_line_2'),
            'city' => $this->input->post('city'),
            'zip_code' => $this->input->post('zip_code'),
            'country' => $this->input->post('country'),
            'status' => 1,
        ];
        #-------------------------------#
        if ($this->form_validation->run()) {

            if ($this->passenger_model->create($postData)) {

                $data['passenger_id_no'] = $postData['id_no'];
                $data['email'] = $postData['email'];
                $passenger_mail = $postData['email'];
                $subject = "Passenger Information";
                $message = "Dear Pessanger, \nUse your email address as your username/email and \nYour password is : \n\t\t\t " . strtotime(date("His")) . "  \n\nThis is an auto generated email. \n\nDO NOT REPLY HERE. \n\nTHANK YOU";

                $data['status'] = true;
                $data['message'] = display('save_successfully');

                ///////////////////////////////////////////////////////////////////////
                //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
                ///////////////////////////////////////////////////////////////////////


                goto skip_pdf_mail;

                if ($this->setmail($passenger_mail, '', '', '', $subject, $message)) {
                    $data['status'] = true;
                    $data['message'] = display('save_successfully') . " Password sent to user's mail";
                }

                skip_pdf_mail:

                ///////////////////////////////////////////////////////////////////////
                //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
                ///////////////////////////////////////////////////////////////////////
            } else {
                $data['status'] = false;
                $data['exception'] = display('please_try_again');
            }

        } else {
            $data['status'] = false;
            $data['exception'] = validation_errors();
        }

        echo json_encode($data);
    }


    /*
    |____________________________________________________________________
    |
    | Validate input
    |____________________________________________________________________
    |--------------------------------------------------------------------
    | tracking seats, price and offer
    |----------------------------------------------
    */

    public function randID()
    {
        $result = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $charArray = str_split($chars);
        for ($i = 0; $i < 7; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }
        return "P" . $result;
    }

    public function setmail($email, $file_path = null, $id = null, $name = null, $subject = null, $message = null)
    {

        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();

        if (empty($subject)) {
            $subject = 'Luggage Information';
        }

        if (empty($message)) {
            $message = display('email_gritting') . ' ' . $name . display('email_ticket_idinfo') . '-' . $id . "";
        }

        $config = array(
            'protocol' => $setting_detail->protocol,
            'smtp_host' => $setting_detail->smtp_host,
            'smtp_port' => $setting_detail->smtp_port,
            'smtp_user' => $setting_detail->smtp_user,
            'smtp_pass' => $setting_detail->smtp_pass,
            'mailtype' => $setting_detail->mailtype,
            'charset' => 'utf-8'
        );


        //////////// OLD VERSION
        // $this->load->library('email', $config);
        // $this->email->set_newline("\r\n");
        // $this->email->from($setting_detail->smtp_user);
        // $this->email->to($email);
        // $this->email->subject($subject);
        // $this->email->message($message);
        // $this->email->attach($file_path);

        //////////// NEW VERSION
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        //Email content
        // $htmlContent = 'Dear '.$u_name.',<br><h1>Your Verification Code is 1234</h1>';
        // $subject = "Verification Mail";

        $this->email->to($email);
        $this->email->from($setting_detail->smtp_user);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($file_path);
        // $this->email->send();

        $check_email = $this->test_input($email);

        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {

            if ($this->email->send()) {
                $this->session->set_flashdata(array('message' => display('email_send_to_passenger')));
                return true;
            } else {
                $this->session->set_flashdata(array('exception' => display('please_configure_your_mail')));
                return false;
            }

        } else {
            $this->session->set_flashdata(array('message' => display('successfully_added')));
            redirect("website/Paypal/local_success/" . $id);
        }
    }

    public function test_input($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function createBooking()
    {

        $facilities = "";
        $this->permission->method('ticket', 'create')->redirect();
        #-------------------------------#
        $this->form_validation->set_rules('route_id', display('route_name'), 'required|numeric');
        $this->form_validation->set_rules('ftypes', display('fleet_type'), 'required|numeric');
        $this->form_validation->set_rules('approximate_time', display('booking_date'), 'required|max_length[20]');
        $this->form_validation->set_rules('trip_assign_id', display('trip_assign'), 'required|numeric');
        $this->form_validation->set_rules('tripIdNo', display('trip_id'), 'required|numeric');
        $this->form_validation->set_rules('packages', display('packages'), 'required|numeric');
        $this->form_validation->set_rules('price', display('price'), 'required|numeric');
        $this->form_validation->set_rules('amount', display('amount'), 'required');
        $this->form_validation->set_rules('sender_id_no', display('sender_email'), 'required|max_length[30]');
        $this->form_validation->set_rules('receiver_id_no', display('receiver'), 'required|max_length[30]');
        #-------------------------------#

        $trip_assign_id = $this->input->post('trip_assign_id');
        $trip_id_no = $this->input->post('tripIdNo');
        $fleet_type_id = $this->input->post('ftypes');
        $packages = $this->input->post('packages');
        $routeId = (int)$this->input->post('route_id');
        $sender_id_no = $this->input->post('sender_id_no');
        $receiver_id_no = $this->input->post('receiver_id_no');
        $offer_code = $this->input->post('offer_code');
        $pickup_location = $this->input->post('pickup_location');
        $drop_location = $this->input->post('drop_location');
        $booking_dates = $this->input->post('approximate_time');
        $urgent = $this->input->post('urgent');
        $urgent_price = $this->input->post('urgent_price');
        $amount = $this->input->post('amount');
        $price = $this->input->post('price');
        $discount = $this->input->post('discount');
        $total_tax = $this->input->post('total_tax');
        $taxids = $this->input->post('taxids');


        $datetime = date('Y-m-d H:i:s');


        $user_info = $_SERVER['HTTP_USER_AGENT'] . " , " . $_SERVER['SERVER_ADDR'] . " , " . $_SERVER['SERVER_PORT'] . " , " . $_SERVER['REMOTE_ADDR'] . " , " . $_SERVER['REMOTE_PORT'] . " , " . $_SERVER['REDIRECT_URL'];

        // $total_weight = $this->luggage_model->fleetWeightCheck($fleet_type_id)->total_weight;
        #-------------------------------#

        $booking_date = date('Y-m-d', strtotime($booking_dates));
        $b_dates = date('Y-m-d H:i:s', strtotime($booking_dates));

        $agent_com_per = $this->db->select('*')->from('agent_info')->where('agent_email', $this->session->userdata('email'))->get()->row();

        $agent_commission = 0;

        if (!empty($agent_com_per)) {
            $agent_commission = $agent_com_per->agent_commission;
        }

        $id = $this->randomId();

        #-------------------------------#

        if ($this->form_validation->run()) {

            //check passenger
            if ($this->checkPassenger($sender_id_no) && $this->checkPassenger($receiver_id_no)) {

                $postData = [
                    'id_no' => $id,
                    'trip_id_no' => $trip_assign_id,
                    'trip_id' => $trip_id_no,
                    'luggage_passenger_id_no' => $sender_id_no,
                    'trip_route_id' => $routeId,
                    'pickup_trip_location' => $pickup_location,
                    'drop_trip_location' => $drop_location,
                    'price' => $price,
                    'discount' => $discount,
                    'package_id' => $packages,
                    'offer_code' => $offer_code,
                    'luggage_refund_id' => null,
                    'agent_id' => null,
                    'booking_date' => $b_dates,
                    'booking_type' => 'Cash(' . $this->session->userdata("fullname") . ')',
                    'payment_status' => $this->input->post('status'),
                    'booked_by' => $this->session->userdata('id'),
                    'user_info' => $user_info,
                    'ftypes' => $fleet_type_id,
                    'urgent_status' => $urgent,
                    'urgent_price' => $urgent_price,
                    'amount' => $amount,
                    'sender_id_no' => $sender_id_no,
                    'receiver_id_no' => $receiver_id_no,
                    'create_date' => $datetime,
                    'total_tax' => $total_tax,
                    'taxids' => $taxids,
                    'created_by' => $this->session->userdata('id'),

                ];


                $notice = [
                    'b_idno' => $id,
                    'passenger_id' => $sender_id_no,
                    'route_id' => $routeId,
                    'booking_time' => date('Y-m-d H:i:s'),
                    'trip_id' => $trip_id_no,
                    'no_tkts' => $packages,
                    'amount' => $price,
                    'booked_by' => $this->session->userdata('id')
                ];

                $accoutn_transaction = [
                    'account_id' => 7,
                    'transaction_description' => 'Trip Id-' . $trip_id_no . '<br> Sender ID-' . $sender_id_no . '<br> Route ID -' . $routeId . '<br> Luggage Booking Time - ' . date("d-F-Y", strtotime($datetime)) . '<br> Package No - ' . $packages . '<br> Price - ' . $price . '<br> Discount- ' . $discount . '<br> Urgent Price Added - ' . $urgent_price . '<br> Total Price - ' . $amount,
                    'amount' => $amount,
                    'create_by_id' => $this->session->userdata('id')
                ];

                $agent_ledger = array();

                if ($agent_commission > 0) {
                    $agent_ledger = [
                        'booking_id' => $id,
                        'credit' => ($agent_commission * $price) / 100,
                        'date' => $datetime,
                        'agent_id' => $agent_com_per->agent_id,
                        'commission_rate' => $agent_commission,
                        'total_price' => $price,
                    ];
                }


                // echo "<pre>";

                // print_r($postData);
                // print_r($notice);
                // print_r($accoutn_transaction);
                // print_r($agent_ledger);

                // die();


                if ($this->luggage_model->create($postData)) {
                    $this->db->insert('ticket_notification', $notice);
                    if ($this->input->post('status') == "NULL") {
                        $this->db->insert('acn_account_transaction', $accoutn_transaction);
                    }
                    if ($agent_commission > 0) {
                        $this->db->insert('agent_ledger', $agent_ledger);
                    }

                    $data['status'] = true;
                    $data['id_no'] = $id;
                    $data['message'] = display('save_successfully');

                    $passeninfo = $this->db->select('*')->from('tkt_passenger')->where('id_no', $sender_id_no)->get()->row();


                    $email = ($passeninfo->email) ? $passeninfo->email : '';


                    //  $datass['ticket'] = $this->luggage_model->ticket($id);
                    //  $datass['ticket_arr'] = (array)$this->luggage_model->ticket($id);
                    //  $datass['sender'] = $this->luggage_model->passanger_by_id($datass['ticket_arr']['sender_id_no']);
                    //  $datass['receiver'] = $this->luggage_model->passanger_by_id($datass['ticket_arr']['receiver_id_no']);

                    //  $datass['pickup'] = $this->luggage_model->location_id_name($datass['ticket_arr']['pickup_trip_location']);

                    //  $datass['drop'] = $this->luggage_model->location_id_name($datass['ticket_arr']['drop_trip_location']);

                    //  $route_id = $datass['ticket']->trip_route_id;

                    //  $datass['pricess'] = $this->db->select('*')->from('pri_price')->where('route_id', $route_id)->get()->row();

                    //  $datass['appSetting'] = $this->luggage_model->website_setting();


                    //  $invoice = $this->load->view('booking/invoice', $datass,true);

                    // file_put_contents('assets/data/luggage/' . $id . '.html', $invoice);

                    // echo $invoice;
                    // echo json_encode($data);


                    ///////////////////////////////////////////////////////////////////////
                    //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
                    ///////////////////////////////////////////////////////////////////////

                    // echo json_encode($data);
                    
                    goto skip_pdf_mail;

                    $this->load->library('pdfgenerator');
                    $datas['appSetting'] = $this->website_model->read_setting();
                    $datas['ticket'] = $this->website_model->getLuggage($id);

                    $html = $this->load->view('booking/ticket_pdf', $datas, true);

                    $data['html'] = $html;

                    $dompdf = new Dompdf();
                    $dompdf->load_html($html);
                    $dompdf->render();

                    $output = $dompdf->output();
                    file_put_contents('assets/data/pdf/' . $id . '.pdf', $output);
                    $file_path = 'assets/data/pdf/' . $id . '.pdf';

                    file_put_contents('assets/data/pdf/' . $id . '.html', $html);
                    $file_path1 = 'assets/data/pdf/' . $id . '.html';


                    $send_email = '';
                    if (!empty($email)) {
                        $send_email = $this->setmail($email, $file_path, $id, 'Passanger');

                        if ($send_email) {
                            $data['status'] = true;
                            $data['message'] = "Mail Sent Successfully. Please Check your mail.";
                        } else {
                            $data['status'] = false;
                            $data['exception'] = "Mail Not Sent. Contact with Admin.";
                        }

                    }

                    skip_pdf_mail:

                    ///////////////////////////////////////////////////////////////////////
                    //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
                    ///////////////////////////////////////////////////////////////////////

                } else {
                    $data['status'] = false;
                    $data['exception'] = display('please_try_again');
                }

            } else {
                $data['status'] = false;
                $data['exception'] = display('invalid_passenger_id');
            }


            // } else {
            //     $data['status'] = false;
            //     $data['exception'] = display('invalid_input');
            // }


        } else {
            $data['status'] = false;
            $data['exception'] = validation_errors();
        }
        #-------------------------------#

        // $data['title'] = display('view');
        // #-------------------------------#
        // $data['ticket'] = $this->luggage_model->ticket($id);
        // $data['appSetting'] = $this->luggage_model->website_setting();
        // $data['tps'] = $this->luggage_model->fleet_dropdown();

        // $data['route_dropdown'] = $this->luggage_model->route_dropdown();
        // $data['module'] = "luggage";
        // $data['tax'] = $this->luggage_model->tax();

        echo json_encode($data);

        // if ($data['status'] == true) {

        //      $data['ticket_arr'] = (array)$this->luggage_model->ticket($id);
        // $data['sender'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['sender_id_no']);
        // $data['receiver'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['receiver_id_no']);

        // $data['pickup'] = $this->luggage_model->location_id_name($data['ticket_arr']['pickup_trip_location']);

        // $data['drop'] = $this->luggage_model->location_id_name($data['ticket_arr']['drop_trip_location']);

        //     $data['page'] = "booking/ticket";
        //     echo Modules::run('template/layout', $data);
        // } else {
        //     return $this->form();
        // }

    }


    /*
    |____________________________________________________________________
    |
    | AJAX Functions
    |____________________________________________________________________
    |--------------------------------------------------------------------
    | Create booking
    |----------------------------------------------
    */

    public function randomId($id_no = null)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $charArray = str_split($chars);
        for ($i = 0; $i < 7; $i++) {
            $randItem = array_rand($charArray);
            $id_no .= "" . $charArray[$randItem];
        }

        $check = $this->db->select("id_no")
            ->from('luggage_booking')
            ->where('id_no', "LB" . $id_no)
            ->get()
            ->num_rows();

        if ($check > 0) {
            $id_no = strrev($id_no);
        }
        return "LB" . $id_no;
    }

    /*
    |----------------------------------------------
    |  id genaretor
    |----------------------------------------------
    */

//     private function checkBooking($tripIdNo = null, $fleet_type_id = null, $packages = null, $booking_date = null)
//     {
//         //---------------fleet seats----------------
//         $fleetWeight = $this->luggage_model->fleetWeightCheck($fleet_type_id)->total_weight;

//         //-----------------Total weight Booked-------------------

//         $totalBookedpackage_id = $this->luggage_model->assigned_trips($tripIdNo, $booking_date);

//         if ($totalBookedpackage_id == null) {
//             $totalBookedpackage_id = 0;
//         }

//         // ---------- Available Weight ----------------------

//         $availableWeight = $fleetWeight - $totalBookedWeight;

// //        echo "<pre>";
// //        echo "1 ".$fleetWeight;
// //        echo "<br>2 ".$totalBookedWeight;
// //        echo "<br>3 ".$availableWeight;
// //        die();

//         if ($availableWeight >= $weight) {
//             return true;
//         } else {
//             return false;
//         }

//     }


    /*
    *------------------------------------------------------
    * Trip schedule
    *------------------------------------------------------
    */

    //display trip list with date

    private function checkPassenger($id_no = null)
    {
        $result = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS name ")
            ->from('tkt_passenger')
            ->where('id_no', $id_no)
            ->get()
            ->row();

        if (isset($result)) {
            return true;
        } else {
            return false;
        }
    }


    /*
    *------------------------------------------------------
    * Seats
    *------------------------------------------------------
    */


    //find seats by trip id

    public function form()
    {
        $this->permission->method('ticket', 'create')->redirect();
        $data['title'] = display('add');
        #-------------------------------#
        $data['location_dropdown'] = $this->luggage_model->location_dropdown();
        $data['route_dropdown'] = $this->luggage_model->route_dropdown();
        $data['facilities_dropdown'] = $this->luggage_model->facilities_dropdown();
        $data['country_dropdown'] = $this->country_model->country();
        $data['tps'] = $this->luggage_model->fleet_dropdown();
        $data['module'] = "luggage";
        $data['taxes'] = (array)$this->luggage_model->tax();

        // echo "<pre>";
        // print_r($data);
        // exit();

        $data['page'] = "booking/form";
        echo Modules::run('template/layout', $data);
    }


    /*
    *------------------------------------------------------
    * Price & Discount
    * return price & group price
    *------------------------------------------------------
    */

    public function findTripByRouteDate()
    {
        $type = $this->input->post('tps', true);
        $routeID = $this->input->post('route_id', true);
        $datees = $this->input->post('date', true);
        $date = date("Y-m-d", strtotime($datees));
        $startDate = date("Y-m-d H:i:s", strtotime($date . '-1 hour'));
        $endDate = date("Y-m-d H:i:s", strtotime($date . "+3 hour"));

        $tripResult = $this->luggage_model->trip_result($routeID, $type, $date);

        $html = "<table class='table table-condensed table-striped'>
            <thead>
                <tr class='bg-primary'>
                    <th>#</th>
                    <th>" . display('start') . "</th>
                    <th>" . display('end') . "</th>
                    <th>" . display('total_weight') . "</th>
                    <th>" . display('fleet_type') . "</th> 
                    <th>" . display('reg_no') . "</th> 
                </tr>
            </thead>
            <tbody>";

        $available = null;
        foreach ($tripResult as $value) {


            // $bookingResult = 0;
            // $bookingResult = $this->luggage_model->assigned_trips($value->id_no, $date);

            // if (($value->total_weight - $bookingResult) > 0)
            $html .= "<tr>
                    <td>
                        <input type='radio' name='trip_assign_id' value=" . $value->id . " class='trip_assign_id radio-inline' data-fleetRegNo='' data-fleetTypeId='" . $value->type . "'>

                        <input type='hidden' name='tripIdNo' id='tripIdNo' value='" . $value->id_no . "' data-fleetTypeId='" . $value->type . "'> 
                        
                    </td>
                    <td>" . $value->start . "</td>
                    <td>" . $value->end . "</td>
                    <td>" . $value->total_weight . "</td>
                    
                    <td>" . $value->type_name . "</td>
                    <td>" . $value->fleet_reg . "</td>
                </tr> ";

        }

        if (!$tripResult) {
            $html .= "<tr><td colspan='4'>No trip available!</td></tr>";
        }
        $html .= "</tbody></table>";


        //---------------location---------------
        $tripLocation = $this->db->select('stoppage_points')
            ->from('trip_route')
            ->where('id', $routeID)
            ->get()
            ->row();

        // $locationArray = array();
        // $stoppage_points = array_map('trim', explode(',', $tripLocation->stoppage_points));

        $loc = "";

        $loc .= "<option value=\"\">'Please Select Location'</option>";
        //// Find location name from it's id.

        // $stoppage_points = $data['trps'][$i]->stoppage_points;
        $loc_name = array();

        $stopages = explode(',', $tripLocation->stoppage_points);
        $c = 0;
        foreach ($stopages as $ids) {
            $loc_name[$c] = $this->luggage_model->loc_names($ids);
            // $sp_list .=  $loc_name[$c][0]->name.',';

            $loc .= "<option value='" . $loc_name[$c][0]->id . "'>" . $loc_name[$c][0]->name . "</option>";
            $c++;
        }


        //---------------Packages---------------
        $packages = $this->db->select('package_id, package_name')
            ->from('package')
            ->where('trip_route_id', $routeID)
            ->where('fleet_type_id', $type)
            ->where('delete_status', 0)
            ->order_by('package_id', 'DESC')
            ->get()
            ->result_array();

        $package_dropdown = "";


        $c = 0;

        if (count($packages) > 0) {
            $package_dropdown .= "<option value=\"\">'Please Select Packages'</option>";
            foreach ($packages as $package) {
                $package_dropdown .= "<option value='" . $package['package_id'] . "'>" . $package['package_name'] . "</option>";
                $c++;
            }
        } else {
            $package_dropdown .= "<option>No Package Available</option>";
        }

        echo json_encode(array(
            'html' => $html,
            'location' => $loc,
            'packages' => $package_dropdown
        ));
    }

    // public function findSeatsByTripID()
    // {
    //     $tripIdNo = $this->input->post('tripIdNo', true);
    //     $fleetTp = $this->input->post('fleetTp', true);
    //     $bdate = $this->input->post('bdate', true);
    //     $date = date("Y-m-d", strtotime($bdate));
    //     //-----------------booked seats-------------------
    //     $bookedSeats = $this->db->select("
    //             tb.trip_id_no,
    //             SUM(tb.total_seat) AS booked_seats, 
    //             GROUP_CONCAT(tb.seat_numbers SEPARATOR ', ') AS booked_serial 
    //         ")
    //         ->from('tkt_booking AS tb')
    //         ->where('tb.trip_id_no', $tripIdNo)
    //         ->like('tb.booking_date', $date, 'after')
    //         ->group_start()
    //         ->where("tb.tkt_refund_id IS NULL", null, false)
    //         ->or_where("tb.tkt_refund_id", 0)
    //         ->or_where("tb.tkt_refund_id", null)
    //         ->group_end()
    //         ->get()
    //         ->row();


    //     $bookArray = array();
    //     $bookArray = array_map('trim', explode(',', $bookedSeats->booked_serial));


    //     //---------------fleet seats----------------
    //     $fleetSeats = $this->db->select("
    //             total_seat, seat_numbers, fleet_facilities
    //         ")->from("fleet_type")
    //         ->where('id', $fleetTp)
    //         ->get()
    //         ->row();

    //     $seatArray = array();
    //     $seatArray = array_map('trim', explode(',', $fleetSeats->seat_numbers));


    //     $html = "<h4 class=\"bg-primary\" style=\"padding:5px;margin:0\">" . display('select_seats') . "</h4>";

    //     foreach ($seatArray as $seat) {
    //         if (in_array($seat, $bookArray)) {
    //             $html .= "<button style=\"margin:1px;min-width:60px\" type=\"button\" class=\"btn btn-sm btn-square btn-danger disabled\">$seat</button>";
    //         } else {
    //             $html .= "<button style=\"margin:1px;min-width:60px\" type=\"button\" class=\"btn btn-sm btn-square btn-primary ChooseSeat\">$seat</button>";
    //         }
    //     }


    //     //---------------find facilities---------------
    //     // $facilities = "";
    //     // $facilitiesArray = array();
    //     // $facilitiesArray = array_map('trim', explode(',', $fleetSeats->fleet_facilities));
    //     // if (sizeof($facilitiesArray) > 0) {
    //     //     foreach ($facilitiesArray as $key => $fa) {
    //     //         if ($fa != "")
    //     //             $facilities .= "<input id=\"f$key\" name=\"request_facilities[]\" class=\"inline-checkbox\" type=\"checkbox\" value=\"$fa\"> <label for=\"f$key\">$fa</label> ";
    //     //     }
    //     // }

    //     echo json_encode(array(
    //         'html' => $html,
    //         // 'facilities' => $facilities
    //     ));
    // }

    /*
    *------------------------------------------------------
    * Offer
    *------------------------------------------------------
    */

    public function priceByRouteTypeAndFleetType()
    {

        $package_id = $this->input->post('package_id', true);

        $packages = (array)$this->luggage_model->luggage_prices($package_id);


        echo json_encode($packages);
    }


    /*
    *------------------------------------------------------
    * Passenger
    *------------------------------------------------------
    */

//     public function fleetfacilities()
//     {

//         //---------------find facilities---------------

//         $fleetTp = $this->input->post('fleetTp', true);

//         $fleetfacilities = $this->luggage_model->facilities($fleetTp);

// //        echo "<pre>";
// //        print_r($fleetfacilities);
// //        die();

//         $facilities = "";
// //        var_dump($facilities);
//         $facilitiesArray = array();
//         $facilitiesArray = array_map('trim', explode(',', $fleetfacilities));

// //        echo "<pre>";
// //        print_r($facilitiesArray);
// //        die();

//         if (count($facilitiesArray) > 0) {
//             foreach ($facilitiesArray as $key => $fa) {
//                 if ($fa != "") {
//                     $facilities .= "<input id='" . $key . "' name='request_facilities[]' class='inline-checkbox' type='checkbox' value='" . $fa . "'> <label for='" . $key . "'>" . $fa . "</label> ";
//                 }
//             }
//         }

//         echo json_encode($facilities);
//     }

    // loacally ticket view

    public function findOfferByCode()
    {
        $offerCode = $this->input->post('offerCode', true);
        $offerRouteId = $this->input->post('offerRouteId', true);
        $tripDate = date("Y-m-d", strtotime($this->input->post('tripDate')));

        $checkOffer = $this->luggage_model->checkOffer($offerCode, $offerRouteId, $tripDate);

        $bookingOffer = 0;
        $bookingOffer = $this->luggage_model->bookingOffer($offerCode);

//        echo "<pre>";
//        print_r($checkOffer);
//        print_r($bookingOffer);
//        die();

        $data = array();
        if (isset($checkOffer) && ($checkOffer->offer_number - $bookingOffer) > 0) {
            $data['status'] = true;
            $data['message'] = "The $checkOffer->offer_name offer will be expired on $checkOffer->offer_end_date ";
            $data['discount'] = $checkOffer->offer_discount;


            echo json_encode($data);

        } else {
            $datas['status'] = false;
            $datas['message'] = "No offer found!";

            echo json_encode($datas);

        }


    }

    // booking paid information

    public function findPassengerName()
    {
        $passengerEamil = $this->input->post('passengerEamil', true);

        if (!empty($passengerEamil)) {
            $result = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS name,id_no ")
                ->from('tkt_passenger')
                ->where('email', $passengerEamil)
                ->or_where('phone', $passengerEamil)
                ->get()
                ->row();

            if (isset($result)) {
                $data['passenger_id'] = $result->id_no;
                $data['status'] = true;
                $data['name'] = "<span class=\"text-success\">$result->name</span>";
            } else {
                $data['status'] = false;
                $data['name'] = "<span class=\"text-danger\">Invalid passenger</span>";
            }
        } else {
            $data['status'] = false;
            $data['name'] = "<span class=\"text-danger\">Invalid passenger</span>";
        }
        echo json_encode($data);
    }

    // success mail strat

    public function ticket_view($booking_id_no = null)
    {
        $this->permission->method('ticket', 'create')->redirect();
        $data['title'] = display('view');
        #-------------------------------#
        $data['ticket'] = $this->luggage_model->ticket($booking_id_no);
        $data['appSetting'] = $this->luggage_model->website_setting();
        $data['ticket_arr'] = (array)$this->luggage_model->ticket($id);
        $data['sender'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['sender_id_no']);
        $data['receiver'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['receiver_id_no']);

        $data['pickup'] = $this->luggage_model->location_id_name($data['ticket_arr']['pickup_trip_location']);

        $data['drop'] = $this->luggage_model->location_id_name($data['ticket_arr']['drop_trip_location']);
        $data['module'] = "luggage";
        $data['page'] = "booking/ticket";


        // echo "<pre>";
        // print_r($data);
        // exit();

        echo Modules::run('template/layout', $data);
    }

    //Email testing for email

    public function booking_paid()
    {


        //$this->permission->method('ticket','create')->redirect();

        $data['title'] = display('paid');
        #-------------------------------#
        $id_no = $this->input->post('booking_id');
        $payinfo = $this->luggage_model->ticket_paid($id_no);


        // echo "<pre>";
        // print_r($payinfo);
        // exit();

        foreach ($payinfo as $payinfor) {
        }
        // $id = $payinfor->id;
        // $postData = ['id' => $payinfor->id,
        //     'id_no' => $id_no,
        //     'trip_id_no' => $payinfor->trip_id_no,
        //     'tkt_passenger_id_no' => $payinfor->tkt_passenger_id_no,
        //     'trip_route_id' => $payinfor->trip_route_id,
        //     'pickup_trip_location' => $payinfor->pickup_trip_location,
        //     'drop_trip_location' => $payinfor->drop_trip_location,
        //     'request_facilities' => $payinfor->request_facilities,
        //     'price' => $payinfor->price,
        //     'discount' => $payinfor->discount,
        //     'total_seat' => $payinfor->total_seat,
        //     'seat_numbers' => $payinfor->seat_numbers,
        //     'offer_code' => $payinfor->offer_code,
        //     'tkt_refund_id' => $payinfor->tkt_refund_id,
        //     'agent_id' => $payinfor->agent_id,
        //     'booking_date' => $payinfor->booking_date,
        //     'booking_type' => $payinfor->booking_type,
        //     'date' => $payinfor->date,
        //     'payment_status' => ''
        // ];
        $updata = $this->db->where('id_no', $id_no)
            ->update('luggage_booking', ['payment_status' => 'NULL']);

        $pemail = $this->db->select('*')
            ->from('luggage_booking')
            ->join('tkt_passenger', 'tkt_passenger.id_no = luggage_booking.luggage_passenger_id_no', 'left')
            ->where('tkt_passenger.id_no', $payinfor->luggage_passenger_id_no)
            ->get()
            ->row();

        $id = $this->input->post('booking_id');

        $accoutn_transaction = [
            'account_id' => 7,
            'transaction_description' => 'Trip Id-' . $payinfor->trip_id_no . '<br> Passanger ID-' . $payinfor->luggage_passenger_id_no . '<br> Route ID -' . $payinfor->trip_route_id . '<br> Luggage Booking Time - ' . date("d-F-Y", strtotime($payinfor->booking_date)) . '<br> Package ID - ' . $payinfor->package_id . '<br> Price - ' . $payinfor->price . '<br> Discount- ' . $payinfor->discount . '<br> Urgent Price Added - ' . $payinfor->urgent_price . '<br> Total Price - ' . $payinfor->amount,
            'amount' => $payinfor->amount,
            'create_by_id' => $this->session->userdata('id')
        ];

        $this->db->insert('acn_account_transaction', $accoutn_transaction);

///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////

        goto skip_pdf_mail_unpaid;

        $name = $pemail->firstname;

        if ($updata) {
            $email = $pemail->email;
            $this->load->library('pdfgenerator');
            $datas['appSetting'] = $this->website_model->read_setting();
            $datas['ticket'] = $this->website_model->getTicket($id);
            $html = $this->load->view('booking/ticket_pdf', $datas, true);
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/' . $id . '.pdf', $output);
            $file_path = 'assets/data/pdf/' . $id . '.pdf';
            $send_email = '';
            if (!empty($email)) {
                $send_email = $this->setmail($email, $file_path, $id, $name);
                // redirect("luggage/luggage/confirmation");
                if ($send_email) {
                    $data['status'] = true;
                    $data['message'] = "Mail Sent Successfully. Please Check your mail.";
                } else {
                    $data['status'] = false;
                    $data['message'] = "Mail not sent. Contact with Admin.";
                }
            }
        }


        skip_pdf_mail_unpaid:


///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////


        $data['title'] = display('view');
        #-------------------------------#
        $data['ticket'] = $this->luggage_model->ticket($id);
        $data['appSetting'] = $this->luggage_model->website_setting();
        $data['ticket_arr'] = (array)$this->luggage_model->ticket($id);
        $data['sender'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['sender_id_no']);
        $data['receiver'] = $this->luggage_model->passanger_by_id($data['ticket_arr']['receiver_id_no']);

        $data['pickup'] = $this->luggage_model->location_id_name($data['ticket_arr']['pickup_trip_location']);

        $data['drop'] = $this->luggage_model->location_id_name($data['ticket_arr']['drop_trip_location']);
        $data['module'] = "luggage";
        $data['page'] = "booking/ticket";
//                        echo "<pre>";
//                        print_r($data);
//                        die();
        echo Modules::run('template/layout', $data);

    }
// sucessmail end


    /*Booking cancel automaticallay
    |
    */

    public function confirmation()
    {
        $data["confirm"] = $this->luggage_model->confirmation();
        $data['module'] = "luggage";
        $data['page'] = "booking/confirmlist";

        // echo "<pre>";
        // print_r($data);
        // exit();
        echo Modules::run('template/layout', $data);
    }

    public function unpaid_cash_booking()
    {
        $data["bookings"] = $this->luggage_model->upaid_cash_bookig();
        $data['module'] = "luggage";
        $data['page'] = "booking/unpaid_cashbooking";
        // echo "<pre>";
        // print_r($data["bookings"]);
        // exit();
        echo Modules::run('template/layout', $data);
    }

    public function delete_confirmation($id = null)
    {

        if ($this->luggage_model->confirmation_delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("luggage/luggage/confirmation");
    }

    // unpaid cash bookin list

    public function terms_and_condition_form($id = null)
    {
        $this->permission->method('ticket', 'create')->redirect();
        $data['title'] = display('add');
        #-------------------------------#
        $this->form_validation->set_rules('how_to_pay', display('how_to_pay'), 'required|max_length[1000]');
        $this->form_validation->set_rules('terms_and_condition', display('terms_and_condition'), 'max_length[1000]');
        #-------------------------------#
        $data['term'] = (object)$postData = [
            'id' => $this->input->post('id'),
            'how_to_pay' => $this->input->post('how_to_pay'),
            'terms_and_condition' => $this->input->post('terms_and_condition')
        ];

        if ($this->form_validation->run()) {

            if (empty($postData['id'])) {

                $this->permission->method('ticket', 'create')->redirect();

                if ($this->luggage_model->create_terms($postData)) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                    redirect('ticket/booking/terms_and_condition_list');
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("luggage/luggage/terms_and_condition_form");

            } else {

                $this->permission->method('ticket', 'update')->redirect();

                if ($this->luggage_model->update_condition($postData)) {

                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("luggage/luggage/terms_and_condition_form/" . $postData['id']);
            }


        } else {
            if (!empty($id)) {
                $data['title'] = display('update');
                $data['terms'] = $this->luggage_model->terms_and_cond_data($id);
            }
            $data['module'] = "luggage";
            $data['page'] = "booking/terms_form";
            echo Modules::run('template/layout', $data);
        }
    }

    // ticket transaction confirmation  delete

    public function terms_and_condition_list()
    {
        $data["terms"] = $this->luggage_model->term_and_condition_list();
        $data['module'] = "luggage";
        $data['page'] = "booking/term_condition_list";
        echo Modules::run('template/layout', $data);
    }

    //payment term and condition

    public function terms_delete($id = null)
    {

        if ($this->luggage_model->terms_delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("luggage/luggage/terms_and_condition_list");
    }

// terms and condition list

    private function checkOffer($offerCode = null, $offerRouteId = null, $tripDate = null)
    {
        $checkOffer = $this->db->select("
                of.offer_name,
                of.offer_end_date,
                of.offer_number,
                of.offer_discount 
            ")->from("ofr_offer AS of")
            ->where("of.offer_code", $offerCode)
            ->where("of.offer_route_id", $offerRouteId)
            ->where("of.offer_start_date <=", $tripDate)
            ->where("of.offer_end_date   >=", $tripDate)
            ->get()
            ->row();

        $bookingOffer = 0;
        $bookingOffer = $this->db->select("COUNT(id) AS booked_offer")
            ->from('tkt_booking')
            ->where('offer_code', $offerCode)
            ->group_start()
            ->where("tkt_refund_id IS NULL", null, false)
            ->or_where("tkt_refund_id", 0)
            ->or_where("tkt_refund_id", null)
            ->group_end()
            ->get()
            ->row()
            ->booked_offer;

        $data = array();
        if (sizeof($checkOffer) > 0 && ($checkOffer->offer_number - $bookingOffer) > 0) {
            return $checkOffer->offer_discount;
        } else {
            return 0;
        }

    }

    //terms_delete

    private function checkPrice($routeId = null, $fleetTypeId = null, $requestSeat = null)
    {
        //---------------price---------------------
        $tripPrice = $this->db->select("*")
            ->from('pri_price')
            ->where('route_id', $routeId)
            ->where('vehicle_type_id', $fleetTypeId)
            ->order_by('group_size', 'desc')
            ->get()
            ->result();

        $maxGroup = 0;
        $maxGroupPrice = 0;
        $price = 0;

        if (sizeof($tripPrice) > 0) {

            foreach ($tripPrice as $value) {

                $singlePrice = $value->price;
                $groupSeat = $value->group_size;
                $groupPrice = $value->group_price_per_person;
                $price = 0;

                if ($requestSeat < $groupSeat) {
                    $price = ($requestSeat * $singlePrice);
                } else if ($requestSeat >= $groupSeat) {

                    if ($maxGroup < $groupSeat) {
                        $maxGroup = $groupSeat;
                        $maxGroupPrice = $groupPrice;
                    }
                    $price = ($requestSeat * $maxGroupPrice);
                }
            }
        }

        return $price;
    }


}
