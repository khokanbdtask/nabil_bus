<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once './vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Booking extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->autocancel();
        $this->autocancel_cashbookig();
        // $this->load->library('pdf');

        // load helper
        // $this->load->helper(array('new'));

        $this->load->model(array(
            'booking_model',
            'country_model',
            'passenger_model',
            'price/price_model',
            'website/website_model',
            // New code 2021 direct update 
            'Journey_list_model',
            // New code 2021 direct update 
        ));

        // client 2022 project update
        ini_set('memory_limit', '8192M');
        // client 2022 project update
    }

    public function index()
    {
        $this->permission->method('ticket', 'read')->redirect();
        $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency = $price['currency'];
        $data['title'] = display('list');

        $data["logo"] = $this->db->select("*")
			->from('setting')
			->get()
			->row();
        #-------------------------------#
        #
        #pagination starts
        #

        $config["base_url"] = base_url('ticket/booking/index');
        $config["total_rows"] = $this->booking_model->count_ticket();
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
        $data["bookings"] = $this->booking_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #
        $data['appSetting'] = $this->booking_model->website_setting();
        $data['module'] = "ticket";
        $data['page'] = "booking/list";
        echo Modules::run('template/layout', $data);
    }

    public function view($id = null)
    {
        if (!empty($id)) {
            $this->permission->method('ticket', 'create')->redirect();
            $data['title'] = display('view');
            #-------------------------------#
            $data['ticket'] = $this->booking_model->ticket($id);
            $data['ticket_arr'] = (array) $this->booking_model->ticket($id);

            $data['passanger'] = $this->booking_model->passanger_by_id($data['ticket_arr']['tkt_passenger_id_no']);

            $data['pickup'] = $this->booking_model->location_id_name($data['ticket_arr']['pickup_trip_location']);

            $data['drop'] = $this->booking_model->location_id_name($data['ticket_arr']['drop_trip_location']);

            $rokute_id = $data['ticket']->trip_route_id;

            $data['pricess'] = $this->db->select('*')->from('pri_price')->where('route_id', $rokute_id)->get()->row();

            $data['appSetting'] = $this->booking_model->website_setting();
            $data['module'] = "ticket";

            $data['user_name'] = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS fullname")
                ->from("user")
                ->where('status', 1)
                ->where('id', $data['ticket']->booked_by)
                ->limit(1)
                ->get()
                ->row();

            // new code 2021

            $schuduleid = $data['ticket']->trip_route_id;
            $getschuduleid = $this->db->select('*')->from('shedule')->where('shedule_id', $schuduleid)->get()->row();
            $data['startTime'] = $getschuduleid->start;

            // new code 2021

            // echo "<pre>";
            // print_r($data);
            // exit();

           // new code invoice desing 2022 feb
            $data['partial_pay_all'] = $this->db->where('booking_id', $id)->get('partial_pay_all')->result();
            // new code invoice desing 2022 feb

            $data['disclaimers'] = $this->db->select('disclaimer_details')->from('disclaimer')->where('status', 0)->limit(1)->get()->row();

            $data['page'] = "booking/ticket";

            echo Modules::run('template/layout', $data);
        } else {
            redirect('ticket/booking/index');
        }
    }

    public function invoice($id = '')
    {
        $data['title'] = display('view');
        #-------------------------------#
        $data['ticket'] = $this->booking_model->ticket($id);
        $data['ticket_arr'] = (array) $this->booking_model->ticket($id);

        $data['passanger'] = $this->booking_model->passanger_by_id($data['ticket_arr']['tkt_passenger_id_no']);

        $data['pickup'] = $this->booking_model->location_id_name($data['ticket_arr']['pickup_trip_location']);

        $data['drop'] = $this->booking_model->location_id_name($data['ticket_arr']['drop_trip_location']);

        $route_id = $data['ticket']->trip_route_id;

        $data['pricess'] = $this->db->select('*')->from('pri_price')->where('route_id', $route_id)->get()->row();

        $data['appSetting'] = $this->booking_model->website_setting();
        // New code 2021 direct update 
        $data['setting'] = $this->booking_model->websettings();
        // New code 2021 direct update 
        $data['user_name'] = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS fullname")
            ->from("user")
            ->where('status', 1)
            ->where('id', $data['ticket']->booked_by)
            ->limit(1)
            ->get()
            ->row();
        // new code 2021

        $schuduleid = $data['ticket']->trip_route_id;

        $getschuduleid = $this->db->select('*')->from('shedule')->where('shedule_id', $schuduleid)->get()->row();

        $data['startTime'] = $getschuduleid->start;
        // new code 2021

        // echo "<pre>";
        // print_r($data);
        // exit();

        // new code invoice desing 2022 feb
        $data['partial_pay_all'] = $this->db->where('booking_id', $id)->get('partial_pay_all')->result();
        // new code invoice desing 2022 feb

        $data['disclaimers'] = $this->db->select('disclaimer_details')->from('disclaimer')->where('status', 0)->limit(1)->get()->row();

        $this->load->view('booking/invoice', $data);
    }

    public function form()
    {
        $this->permission->method('ticket', 'create')->redirect();
        $data['title'] = display('add');
        #-------------------------------#
        $data['location_dropdown'] = $this->booking_model->location_dropdown();
        $data['route_dropdown'] = $this->booking_model->route_dropdown();
        $data['facilities_dropdown'] = $this->booking_model->facilities_dropdown();
        $data['country_dropdown'] = $this->country_model->country();
        $data['tps'] = $this->booking_model->fleet_dropdown();
        $data['module'] = "ticket";
        $data['taxes'] = (array) $this->booking_model->tax();

        $data['tax_module'] = explode(',', $data['taxes'][0]['apply_tax_module']);
        // echo "<pre>";
        // print_r($data);
        // exit();
        $data['page'] = "booking/form";
        echo Modules::run('template/layout', $data);
    }

    public function delete($id = null)
    {
        $this->permission->method('ticket', 'delete')->redirect();

        if ($this->booking_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('ticket/booking/index');
    }

    /*
    |----------------------------------------------
    |  Add Passenger
    |----------------------------------------------
     */

    public function newPassenger()
    {
        $this->permission->method('ticket', 'create')->redirect();
        #-------------------------------#
        $this->form_validation->set_rules('firstname', display('firstname'), 'required|max_length[50]');
        $this->form_validation->set_rules('lastname', display('lastname'), 'required|max_length[50]');
        $this->form_validation->set_rules('phone', display('phone'), 'max_length[30]');
        $this->form_validation->set_rules('email', display('email'), 'required|valid_email|is_unique[tkt_passenger.email]|max_length[100]');
        $this->form_validation->set_rules('address_line_1', display('address_line_1'), 'max_length[255]');
        $this->form_validation->set_rules('address_line_2', display('address_line_2'), 'max_length[255]');
        $this->form_validation->set_rules('city', display('city'), 'max_length[50]');
        $this->form_validation->set_rules('zip_code', display('zip_code'), 'max_length[6]');
        $this->form_validation->set_rules('country', display('country'), 'max_length[20]');

        // New code 2021 direct update 
        $this->form_validation->set_rules('nid', display('nid_passport'), 'max_length[50]');
        // New code 2021 direct update
        #-------------------------------#
        $data['passenger'] = (Object) $postData = [
            'id_no' => $this->randID(),
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
             //  client 2022 project update
            'password' => md5( $this->input->post('password')),
             //  client 2022 project update
            'address_line_1' => $this->input->post('address_line_1'),
            'address_line_2' => $this->input->post('address_line_2'),
            'city' => $this->input->post('city'),
            'zip_code' => $this->input->post('zip_code'),
            'country' => $this->input->post('country'),
            'status' => 1,
            // New code 2021 direct update
            'nid' => $this->input->post('nid'),
            // New code 2021 direct update
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
                // if mail not working
                goto skip_mail;
                if ($this->setmail($passenger_mail, '', '', '', $subject, $message)) {
                    $data['status'] = true;
                    $data['message'] = display('save_successfully') . " Password sent to user's mail";
                }
                skip_mail:

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

    /*
    |____________________________________________________________________
    |
    | Validate input
    |____________________________________________________________________
    |--------------------------------------------------------------------
    | tracking seats, price and offer
    |----------------------------------------------
     */
    private function checkBooking($tripIdNo = null, $fleet_type_id = null, $newSeats = null, $booking_date = null)
    {
        //---------------fleet seats----------------
        $fleetSeats = $this->db->select("
                total_seat, seat_numbers, fleet_facilities
            ")->from("fleet_type")
            ->where('id', $fleet_type_id)
            ->get()
            ->row();

        $seatArray = array();
        $seatArray = array_map('trim', explode(',', $fleetSeats->seat_numbers));

        //-----------------booked seats-------------------
        $bookedSeats = $this->db->select("
                tb.trip_id_no,
                SUM(tb.total_seat) AS booked_seats,
                GROUP_CONCAT(tb.seat_numbers SEPARATOR ', ') AS booked_serial
            ")
            ->from('tkt_booking AS tb')
            ->where('tb.trip_id_no', $tripIdNo)
            ->like('tb.booking_date', $booking_date, 'after')
            ->group_start()
            ->where("tb.tkt_refund_id IS NULL", null, false)
            ->or_where("tb.tkt_refund_id", 0)
            ->or_where("tb.tkt_refund_id", null)
            ->group_end()
            ->get()
            ->row();

        $bookArray = array();
        $bookArray = array_map('trim', explode(',', $bookedSeats->booked_serial));

        //-----------------booked seats-------------------
        $newSeatArray = array();
        $newSeatArray = array_map('trim', explode(',', $newSeats));

        if (sizeof($newSeatArray) > 0) {

            foreach ($newSeatArray as $seat) {

                if (!empty($seat)) {
                    if (in_array($seat, $bookArray)) {
                        return false;
                    } else if (!in_array($seat, $seatArray)) {
                        return false;
                    }
                }

            }
            return true;
        } else {
            return false;
        }
    }

    private function checkPassenger($passengerIdNo = null)
    {
        $result = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS name ")
            ->from('tkt_passenger')
            ->where('id_no', $passengerIdNo)
            ->get()
            ->row();

        if (isset($result)) {
            return true;
        } else {
            return false;
        }
    }

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

    /*
    |____________________________________________________________________
    |
    | AJAX Functions
    |____________________________________________________________________
    |--------------------------------------------------------------------
    | Create booking
    |----------------------------------------------
     */

    public function createBooking()
    {  
                      

        #-------------------------------#
        #-------------------------------#

        $facilities = "";
        $this->permission->method('ticket', 'create')->redirect();
        #-------------------------------#
        $this->form_validation->set_rules('route_id', display('route_name'), 'required|max_length[255]');
        $this->form_validation->set_rules('approximate_time', display('booking_date'), 'required|max_length[20]');
        $this->form_validation->set_rules('tripIdNo', display('trip_id'), 'required');
        $this->form_validation->set_rules('seat_number', display('select_seats'), 'required');
        $this->form_validation->set_rules('price', display('price'), 'required|numeric');
        $this->form_validation->set_rules('amount', display('amount'), 'required');
        $this->form_validation->set_rules('passenger_id_no', display('passenger_id'), 'required|max_length[30]');
        #-------------------------------#
        $request_facilities = $this->input->post('request_facilities');

        if (isset($request_facilities)) {
            $fa = "";
            foreach ($request_facilities as $fa) {
                $facilities .= $fa . ", ";
            }
        }
        
        $trip_id_no = $this->input->post('tripIdNo');
        $fleet_registration_id = $this->input->post('fleet_registration_id');
        $fleet_type_id = $this->input->post('ftypes');
        $seat_number = $this->input->post('seat_number');
        $routeId = (int) $this->input->post('route_id');
        $passenger_id = $this->input->post('passenger_id_no');
        $offer_code = $this->input->post('offer_code');
        $total_seat = (int) $this->input->post('total_seat');
        $pickup_location = $this->input->post('pickup_location');
        $drop_location = $this->input->post('drop_location');
        $booking_dates = $this->input->post('approximate_time');
        $adult = (int) $this->input->post('adult');
        $child = (int) $this->input->post('child_no');
        $special = (int) $this->input->post('special');
        $extra_fee = (double)$this->input->post('extra_fee');
        #-------------------------------#

        $booking_date = date('Y-m-d', strtotime($booking_dates));
        $b_dates = date('Y-m-d', strtotime($booking_dates));
        $price = $this->input->post('price');
        $discount = $this->input->post('discount');
        $amount = $this->input->post('amount');
        $agent_com_per = $this->db->select('*')->from('agent_info')->where('agent_email', $this->session->userdata('email'))->get()->row();
        $total_tax = $this->input->post('total_tax');
        $taxids = $this->input->post('taxids');
        
        $emergency_name = $this->input->post('emergency_name');
        $emergency_phone = $this->input->post('emergency_phone');

        // client 2022 project update
        $partialpay =  $this->input->post('partialpay');
        if(empty($partialpay))
        {
            $partamount = 0;
            $paystep =0;
        }

        else
        {
            $partamount = $partialpay;
            $paystep = 1;
            $amount =  $partialpay;
        }
        // client 2022 project update

        $agent_commission = 0;

        if (!empty($agent_com_per)) {
            $agent_commission = $agent_com_per->agent_commission;
        }

        $id = $this->randomId();
        $totl_inpt = $child + $adult + $special;
        #-------------------------------#
        $cs = $this->db->select("
                count(tb.child) AS tchild,
                count(tb.special) AS tspecial
            ")
            ->from('tkt_booking AS tb')
            ->where('tb.trip_id_no', $this->input->post('tripIdNo'))
            ->like('tb.booking_date', $booking_date, 'after')
            ->get()
            ->row();
        $tcs = $cs->tchild + (int) $this->input->post('child_no');
        $tspecialck = $cs->tspecial + (int) $this->input->post('special');
        $rout_chsp_seat = $this->db->select('*')->from('trip_route')->where('id', $this->input->post('route_id'))->get()->row();
        $req_children_seat = (!empty($rout_chsp_seat->children_seat) ? $rout_chsp_seat->children_seat : 20);
        $req_special_seat = (!empty($rout_chsp_seat->special_seat) ? $rout_chsp_seat->special_seat : 20);

        if ($this->form_validation->run()) {
            if ($total_seat == $totl_inpt) {

                //check seats
                if ($this->checkBooking($trip_id_no, $fleet_type_id, $seat_number, $booking_date)) {
                    #---------New Code---------#
                    $currentdate = date('Y-m-d H:i:s');
                    #---------New Code---------#

                    //check passenger
                    if ($this->checkPassenger($passenger_id)) {

                        $postData = [
                            'id_no' => $id,
                            'trip_id_no' => $trip_id_no,
                            'tkt_passenger_id_no' => $passenger_id,
                            'trip_route_id' => $routeId,
                            'pickup_trip_location' => $pickup_location,
                            'drop_trip_location' => $drop_location,
                            'request_facilities' => $facilities,
                            'price' => $price,
                            'discount' => $discount,
                            //  client 2022 project update
                            'amount' => $this->input->post('amount'),
                            //  client 2022 project update
                            'total_seat' => $total_seat,
                            'seat_numbers' => $seat_number,
                            'offer_code' => $offer_code,
                            'adult' => $adult,
                            'child' => $child,
                            'special' => $special,
                            'tkt_refund_id' => null,
                            'agent_id' => null,
                            'booking_date' => $b_dates,
                            'booking_type' => $this->input->post('pay_type').'(' . $this->session->userdata("fullname") . ')',

                            'payment_status' => $this->input->post('status'),

                            #---------New Code---------#
                            'date' => $currentdate,
                            #---------New Code---------#

                            'booked_by' => $this->session->userdata('id'),
                            'total_tax' => $total_tax,
                            'taxids' => $taxids,
                            // New code 2021 direct update 
                            'pay_type' => $this->input->post('pay_type'),
                            'pay_detail' => $this->input->post('pay_detail'),
                            // New code 2021 direct update 

                            // client 2022 project update
                            'partialpay' => $partamount,
                            'paystep' => $paystep,

                            // client 2022 project update

                            'other_location_id' => $this->input->post('other_location_id'),
                            'extra_fee' => $extra_fee,
                            
                            // client 2023 project update

                            'emergency_name' => $emergency_name,
                            'emergency_phone' => $emergency_phone,
                        ];

                        $notice = [
                            'b_idno' => $id,
                            'passenger_id' => $passenger_id,
                            'route_id' => $routeId,
                            'booking_time' => date('Y-m-d H:i:s'),
                            'trip_id' => $trip_id_no,
                            'no_tkts' => $total_seat,
                            'amount' => $price,
                            'booked_by' => $this->session->userdata('id'),
                        ];

                        $accoutn_transaction = [
                            'account_id' => 3,
                            'transaction_description' => 'Booking ID-' . $id . '<br> Route ID-' . $routeId . '<br> Trip Id-' . $trip_id_no . '' . '<br> Ticket No-' . $seat_number . '' . '<br> Passanger ID-' . $passenger_id . '' . '<br> Seat Price-' . $price . '' . '<br> Discount-' . $discount . '',
                            'amount' => $amount,
                            'create_by_id' => $this->session->userdata('id'),
                            #---------New Code 2021 for store date in db---------#
                            'date' => date('Y-m-d H:i:s'),
                            #---------New Code 2021 for store date in db---------#
                        ];

                        $agent_ledger = array();
                        // New code 2021 direct update 
                        $agent_ledger_new = array();
                        if ($agent_commission > 0) {
                            $agent_ledger_new = [
                                'agent_id' => $agent_com_per->agent_id,
                                // client 2022 project update
                                'booking_id' => $id,
                                // client 2022 project update
                                'credit' => ( (double)$amount - (double)$extra_fee),
                                'date' => date('Y-m-d H:i:s'),
                                'detail' => "Ticket Booking",
                                
                            ];
                           
                            // client 2022 project update

                            if( ($this->input->post('status') == "NULL") || ($this->input->post('status') == "partial"))
                            // client 2022 project update
                                {
                                    $this->db->insert('agent_ledger_total', $agent_ledger_new);
                                } 
                        }
                        // New code 2021 direct update 

                        if ($agent_commission > 0) {

                            $newAmount = (double)$amount - (double)$extra_fee;
                            $agent_ledger = [
                                'booking_id' => $id,
                                'credit' => ($agent_commission * $newAmount) / 100,
                                'date' => date('Y-m-d H:i:s'),
                                'agent_id' => $agent_com_per->agent_id,
                                'commission_rate' => $agent_commission,
                                // 'total_price' => $price,
                                'total_price' => $newAmount,
                            ];
                        }

                        
                        if ($this->booking_model->create($postData)) {
                            $this->db->insert('ticket_notification', $notice);

                            // client 2022 project update
                            if( ($this->input->post('status') == "NULL") || ($this->input->post('status') == "partial"))
                            // client 2022 project update
                            {
                                $this->db->insert('acn_account_transaction', $accoutn_transaction);

                                $partial_pay_all = [
                                    'book_by' => $this->session->userdata('id'),
                                    'booking_id' => $id,
                                    'amount' =>  $amount,
                                    'date' => $currentdate,
                                    'payment_step' => "First Payment",
                                    'detail' => $this->input->post('pay_detail'),
                                 ];

                                $this->db->insert('partial_pay_all', $partial_pay_all);
                            }
                            if ($agent_commission > 0) {
                                // client 2022 project update
                                if( ($this->input->post('status') == "NULL") || ($this->input->post('status') == "partial"))
                                // client 2022 project update
                                {
                                    $this->db->insert('agent_ledger', $agent_ledger);
                                }
                            }


                        // New code 2021 direct update 
                            $firstname= $this->input->post('firstName');
                            $lastname= $this->input->post('lastName');
                            $nid= $this->input->post('nid');
                            $children= $this->input->post('children');

                            if((!empty($children))&&( $children == 1))

                           {
                               $x=0;
                               foreach ($firstname as $key => $value) {
                                   $childInput[$x] = array(
                                     'booking_id'=>$id,
                                     'passenger_id'=>$passenger_id,
                                     'entry_date'=>date('Y-m-d'),
                                     'firstName' => $firstname[$x],
                                     'lastName' => $lastname[$x],
                                     'nid' => $nid[$x],
                                    
                                 );
                                   $x++;
                               }
                               $this->db->insert_batch('child_passenger', $childInput);
                           }
                        // New code 2021 direct update 




                            $data['status'] = true;
                            $data['id_no'] = $postData['id_no'];
                            $data['message'] = display('save_successfully');

                            $passeninfo = $this->db->select('*')->from('tkt_passenger')->where('id_no', $passenger_id)->get()->row();
                            $email = $passeninfo->email;
                            $this->load->library('pdfgenerator');
                            $datas['appSetting'] = $this->website_model->read_setting();
                            $datas['ticket'] = $this->website_model->getTicket($id);

                            // echo "<pre>";
                            // print_r($datas);
                            // exit();

                            ///////////////////////////////////////////////////////////////////////
                            //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
                            ///////////////////////////////////////////////////////////////////////

                            goto skip_pdf_mail;

                            $html = $this->load->view('booking/ticket_pdf', $datas, true);

                            $data['html'] = $html;

                            // echo $html;
                            // exit();

                            $dompdf = new Dompdf();
                            $dompdf->load_html($html);
                            $dompdf->render();

                            $output = $dompdf->output();
                            file_put_contents('assets/data/pdf/' . $id . '.pdf', $output);
                            $file_path = 'assets/data/pdf/' . $id . '.pdf';

                            file_put_contents('assets/data/pdf/' . $id . '.html', $html);
                            $file_path1 = 'assets/data/pdf/' . $id . '.html';
                            // $dompdf->stream($file_path, array("Attachment"=>0));

                            // goto skip_pdf_mail;

                            $send_email = '';
                            if (!empty($email)) {
                                $send_email = $this->setmail($email, $file_path, $id, 'Passanger');
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

                } else {
                    $data['status'] = false;
                    $data['exception'] = display('invalid_input');
                }
            } else {
                $data['status'] = false;
                $data['exception'] = 'Please Check Your Seat Quantity';
            }

        } else {
            $data['status'] = false;
            $data['exception'] = validation_errors();
        }
        #-------------------------------#
        #-------------------------------#

        echo json_encode($data);

    }

    /*
    |----------------------------------------------
    |  id genaretor
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
            ->from('tkt_booking')
            ->where('id_no', "B" . $id_no)
            ->get()
            ->num_rows();

        if ($check > 0) {
            $id_no = strrev($id_no);
        }
        return "B" . $id_no;
    }

    /*
     *------------------------------------------------------
     * Trip schedule
     *------------------------------------------------------
     */

    //display trip list with date
//     public function findTripByRouteDate()
//     {
//         //New code 2021 direct update 
//         $tripStartDate ='';
//         $tripfoundDate='';
//          // New code 2021 direct update 

//         $type = $this->input->post('tps', true);
//         $routeID = $this->input->post('route_id', true);
//         $datees = $this->input->post('date', true);
//         $date = date("Y-m-d", strtotime($datees));

       
//         $startDate = date("Y-m-d H:i:s", strtotime($date . '-1 hour'));
//         $endDate = date("Y-m-d H:i:s", strtotime($date . "+3 hour"));
//         $tripResult = $this->db->query("
//             SELECT
//             tas.`id` AS id,
           
//             tas.`assign_time` AS assigntime,
//             tas.`fleet_registration_id` AS vehicalid,
           
//             ta.`trip_id` AS id_no,
//             ft.`total_seat`,
//             ft.`type` As type_name,
//             fr.`reg_no` AS fleet_reg,
//             tr.`name`,
//             ta.`type`,
//             sh.`start`,
//             sh.`end`
//             FROM trip AS ta
//             LEFT JOIN fleet_type AS ft ON ft.`id` = ta.`type`
//             LEFT JOIN trip_route AS tr ON tr.`id` = ta.`route`
//             LEFT JOIN shedule AS sh ON sh.`shedule_id` = ta.`shedule_id`
//             LEFT JOIN trip_assign AS tas ON tas.`trip` = ta.`trip_id`
//             LEFT JOIN fleet_registration AS fr ON fr.`id` = tas.`fleet_registration_id`
//             WHERE tr.`id`= $routeID
//             AND ft.`id` = $type
//             AND tas.closed_by_id = 0
//             AND (!FIND_IN_SET(DAYOFWEEK('$date'),ta.`weekend`))
//             ")->result();

//         $html = "<table class=\"table table-condensed table-striped\">
//             <thead>
//                 <tr class=\"bg-primary\">
//                     <th>#</th>
//                     <th>" . display('start') . "</th>
//                     <th>" . display('end') . "</th>
//                     <th>" . display('available_seats') . "</th>
//                     <th>" . display('types') . "</th>
//                     <th>" . display('reg_no') . "</th>
//                 </tr>
//             </thead>
//             <tbody>";

//         $available = null;

//         // New code 2021 direct update

//         $this->db->where('id', $routeID);
//             $query = $this->db->get('trip_route');
//             $result = $query->row();
//             $totalJourneyhour = (int) $result->approximate_time*2;
//         if ( $totalJourneyhour >= 24) {


//                                     foreach ($tripResult as $value) {
//                                         $bookingResult = 0;
//                                         $bookingResult = $this->db->select("SUM(tb.total_seat) AS available")
//                                                                     ->from("tkt_booking AS tb")
//                                                                     ->join('trip AS ta', "ta.trip_id = tb.trip_id_no")
//                                                                     ->where('tb.trip_id_no', $value->id)
//                                                                     ->where('tb.booking_delete_status', 0)
//                                                                     ->like('tb.booking_date', $date, 'after')
//                                                                     ->group_start()
//                                                                     ->where("tb.tkt_refund_id IS NULL", null, false)
//                                                                     ->or_where("tb.tkt_refund_id", 0)
//                                                                     ->group_end()
//                                                                     ->get()
//                                                                     ->row()
//                                                                     ->available;
        
//                                         if (($value->total_seat - $bookingResult) > 0 ) {

//                                             $today = date("Y-m-d H:i:s");
//                                             $today = date("Y-m-d H:i:s", strtotime($today));
//                                             //$currentDateCheck = date("Y-m-d", strtotime($today));
//                                            // $currenttimeCheck = date("H:i:s", strtotime($today));
//                                             $tripStartDate= $value->assigntime;
//                                             //$triptimecheck = date("H:i:s", strtotime($tripStartDate));

//                                             $tripStartDate = date("Y-m-d", strtotime($tripStartDate));

//                                             // if( $currentDateCheck == $date )
//                                             // {   
//                                             //     if($triptimecheck>$currenttimeCheck)
//                                             //     {

//                                             //     }

//                                             // }

//                                             // else
//                                             // {

//                                             // }



//                                             if ($date >= $tripStartDate)
//                                              {

//                                                 $startdateschedule = $tripStartDate;

//                                                 while ($startdateschedule <= $date) {
//                                                     if ($date == $startdateschedule ) {

                                                        
//                                                         $html .= "<tr>
//                                                                     <td>
//                                                                         <input type=\"radio\" name=\"tripIdNo\" value=" . $value->id . " class=\"tripIdNo radio-inline\" data-fleetRegNo=\"\" data-fleetTypeId=\"$value->type\" required>
//                                                                         <input type=\"hidden\" name=\"fleet_registration_id\" id=\"$value->vehicalid\" value=\"$value->vehicalid\">
//                                                                         <input type=\"hidden\" name=\"fleet_type_id\" value=\"$value->type\">
//                                                                     </td>
//                                                                         <td>" . $value->start . "</td>
//                                                                         <td>" . $value->end . "</td>
//                                                                         <td class=\"text-center\">" . ($value->total_seat - $bookingResult) . "</td>
//                                                                         <td>" . $value->type_name . "</td>
//                                                                         <td>" . $value->fleet_reg . "</td>
        
//                                                                   </tr> ";
//                                                     }
                        
//                                                     $scheduleJourneydate = date('Y-m-d', strtotime("+$totalJourneyhour  hour", strtotime($startdateschedule)));
//                                                     $scheduleJourneydate = date('Y-m-d', strtotime("+24  hour", strtotime($scheduleJourneydate)));
//                                                     $startdateschedule = $scheduleJourneydate;
//                                                 }
 

//                                             }
                                   
//                                         } 
                                        
                                        
//                                         else {
//                                             $html .= "<tr><td><input type='radio' disabled></td><td colspan=\"4\">No Seat Available!</td></tr>";
//                                         }
        
                                                                    
//                                         if (!$tripResult) {
//                                             $html .= "<tr><td colspan=\"4\">No Trip Assigned / Available!</td></tr>";
//                                         }
                                    

//                                     }

           
//         }

//          // New code 2021 direct update

// // New code 2021 direct update
//          else{
//  // New code 2021 direct update

//              foreach ($tripResult as $value) {
//                  $bookingResult = 0;
//                  $bookingResult = $this->db->select("SUM(tb.total_seat) AS available")
//                 ->from("tkt_booking AS tb")
//                 ->join('trip AS ta', "ta.trip_id = tb.trip_id_no")
//                 ->where('tb.trip_id_no', $value->id)
//                 ->where('tb.booking_delete_status', 0)
//                 ->like('tb.booking_date', $date, 'after')
//                 ->group_start()
//                 ->where("tb.tkt_refund_id IS NULL", null, false)
//                 ->or_where("tb.tkt_refund_id", 0)
//                 ->group_end()
//                 ->get()
//                 ->row()
//                 ->available;

//                  if (($value->total_seat - $bookingResult) > 0) {
//                      $html .= "<tr>
//                     <td>
//                         <input type=\"radio\" name=\"tripIdNo\" value=" . $value->id . " class=\"tripIdNo radio-inline\" data-fleetRegNo=\"\" data-fleetTypeId=\"$value->type\">
//                         <input type=\"hidden\" name=\"fleet_registration_id\" id=\"$value->vehicalid\" value=\"$value->vehicalid\">
//                         <input type=\"hidden\" name=\"fleet_type_id\" value=\"$value->type\">



//                     </td>
//                     <td>" . $value->start . "</td>
//                     <td>" . $value->end . "</td>
//                     <td class=\"text-center\">" . ($value->total_seat - $bookingResult) . "</td>
//                     <td>" . $value->type_name . "</td>
//                     <td>" . $value->fleet_reg . "</td>
//                 </tr> ";
//                  } else {
//                      $html .= "<tr><td><input type='radio' disabled></td><td colspan=\"4\">No Seat Available!</td></tr>";
//                  }
//              }
  
             
//         if (!$tripResult) {
//             $html .= "<tr><td colspan=\"4\">No Trip Assigned / Available!</td></tr>";
//         }


//  // New code 2021 direct update
// }
// // New code 2021 direct update

//         $html .= "</tbody></table>";

//         //---------------location---------------
//         $tripLocation = $this->db->select('stoppage_points')
//             ->from('trip_route')
//             ->where('id', $routeID)
//             ->get()
//             ->row();

//         // $locationArray = array();
//         // $stoppage_points = array_map('trim', explode(',', $tripLocation->stoppage_points));
//         $loc = "";

//         $loc .= "<option value=\"\">'Please Select Location'</option>";
//         //// Find location name from it's id.

//         // $stoppage_points = $data['trps'][$i]->stoppage_points;
//         $loc_name = array();

//         $stopages = explode(',', $tripLocation->stoppage_points);
//         $c = 0;
//         foreach ($stopages as $ids) {
//             $loc_name[$c] = $this->booking_model->loc_names($ids);
//             // $sp_list .=  $loc_name[$c][0]->name.',';

//             $loc .= "<option value='" . $loc_name[$c][0]->id . "'>" . $loc_name[$c][0]->name . "</option>";
//             $c++;
//         }

//         // foreach ($locationArray as $lx) {
//         //     $loc .= "<option value=\"\">'Please Select Location'</option>";
//         //     $loc .= "<option value=\"$lx\">$lx</option>";
//         // }

        

        

//         echo json_encode(array(
//             'html' => $html,
//             'location' => $loc,
//         ));
//     }


public function findTripByRouteDate()
    {
        $type   =  $this->input->post('tps', true);
        $routeID = $this->input->post('route_id', true);
        $datees     = $this->input->post('date', true);
        $date     = date("Y-m-d", strtotime($datees));
        $startDate = date("Y-m-d H:i:s", strtotime($date. '-1 hour'));
        $endDate   = date("Y-m-d H:i:s", strtotime($date. "+3 hour"));
          $tripResult = $this->db->query("
            SELECT 
            tas.`id` AS id,
			tas.`assign_time` AS assigntime,
            tas.`fleet_registration_id` AS vehicalid,
            ta.`trip_id` AS id_no, 
            ft.`total_seat`,
            ft.`type` As type_name,
            fr.`reg_no` AS fleet_reg,
            tr.`name`,
            ta.`type`,
            sh.`start`,
            sh.`end`
            FROM trip AS ta
            LEFT JOIN fleet_type AS ft ON ft.`id` = ta.`type`
            LEFT JOIN trip_route AS tr ON tr.`id` = ta.`route`
            LEFT JOIN shedule AS sh ON sh.`shedule_id` = ta.`shedule_id`
            LEFT JOIN trip_assign AS tas ON tas.`trip` = ta.`trip_id` 
            LEFT JOIN fleet_registration AS fr ON fr.`id` = tas.`fleet_registration_id`
            WHERE tr.`id`= $routeID
            AND ft.`id` = $type
            AND tas.closed_by_id = 0
            AND (!FIND_IN_SET(DAYOFWEEK('$date'),ta.`weekend`))
            ")->result();

        $html = "<table class=\"table table-condensed table-striped\">
            <thead>
                <tr class=\"bg-primary\">
                    <th>#</th>
                    <th>" . display('start')            . "</th>
                    <th>" . display('end')            . "</th>
                    <th>" . display('available_seats') . "</th>
                    <th>" . display('types')    . "</th> 
                    <th>" . display('reg_no')    . "</th> 
                </tr>
            </thead>
            <tbody>";

        $available     = null;
        foreach ($tripResult as $value) { 
           

            $bookingResult = 0;
            $bookingResult = $this->db->select("SUM(tb.total_seat) AS available")
                ->from("tkt_booking AS tb")
                ->join('trip AS ta', "ta.trip_id = tb.trip_id_no")
                ->where('tb.trip_id_no', $value->id)
                ->where('tb.booking_delete_status', 0)
                ->like('tb.booking_date',$date,'after')
                ->group_start()
                    ->where("tb.tkt_refund_id IS NULL", null, false)
                    ->or_where("tb.tkt_refund_id", 0)
                ->group_end()
                ->get()
                ->row()
                ->available; 

            if (($value->total_seat-$bookingResult) > 0)
            {$html .= "<tr>
                    <td>
                        <input type=\"radio\" name=\"tripIdNo\" value=".$value->id." class=\"tripIdNo radio-inline\" data-fleetRegNo=\"\" data-fleetTypeId=\"$value->type\"> 
                        <input type=\"hidden\" name=\"fleet_registration_id\" value=\"\">
                        <input type=\"hidden\" name=\"fleet_type_id\" value=\"$value->type\">
                    </td>
                    <td>".$value->start."</td>
                    <td>".$value->end."</td>
                    <td class=\"text-center\">". ($value->total_seat-$bookingResult)."</td>
                    <td>".$value->type_name ."</td>
                    <td>".$value->fleet_reg ."</td>
                </tr> ";
            }
            else
            {
                $html .= "<tr><td><input type='radio' disabled></td><td colspan=\"4\">No Seat Available!</td></tr>";
            }
 
        } 

        if (!$tripResult) {
            $html .= "<tr><td colspan=\"4\">No Trip Assigned / Available!</td></tr>";
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
            $loc_name = Array();

            $stopages = explode(',',$tripLocation->stoppage_points);
            $c = 0;
            foreach ($stopages as $ids) {
                $loc_name[$c] = $this->booking_model->loc_names($ids); 
                // $sp_list .=  $loc_name[$c][0]->name.',';

                $loc .= "<option value='".$loc_name[$c][0]->id."'>".$loc_name[$c][0]->name."</option>";
                $c++;
            }

        // foreach ($locationArray as $lx) {
        //     $loc .= "<option value=\"\">'Please Select Location'</option>";
        //     $loc .= "<option value=\"$lx\">$lx</option>";
        // }

        echo json_encode(array(
            'html' => $html,
            'location' => $loc
        ));
    }

    /*
     *------------------------------------------------------
     * Seats
     *------------------------------------------------------
     */

    //find seats by trip id
    public function findSeatsByTripID()
    {
        $tripIdNo = $this->input->post('tripIdNo', true);
        
        $fleetTp = $this->input->post('fleetTp', true);
        $bdate = $this->input->post('bdate', true);
        $date = date("Y-m-d", strtotime($bdate));
        //-----------------booked seats-------------------
        $bookedSeats = $this->db->select("
                tb.trip_id_no,
                SUM(tb.total_seat) AS booked_seats,
                GROUP_CONCAT(tb.seat_numbers SEPARATOR ', ') AS booked_serial
            ")
            ->from('tkt_booking AS tb')
            ->where('tb.trip_id_no', $tripIdNo)
            ->where("tb.booking_delete_status", 0)
            ->like('tb.booking_date', $date, 'after')
            ->group_start()
            ->where("tb.tkt_refund_id IS NULL", null, false)
            ->or_where("tb.tkt_refund_id", 0)
            ->group_end()
            ->get()
            ->row();

        $bookArray = array();
        $bookArray = array_map('trim', explode(',', $bookedSeats->booked_serial));

        // client 2022 project update
            $tripassinid = $this->db->select("*")->from('trip_assign')->where('id',$tripIdNo)->where('status',1)->get()->row();

            $freezeSeat  = $this->db->select("*")->from('freeze_seat')->where('tripid',$tripassinid->trip)->where('status',1)->get()->result();

            foreach ($freezeSeat as $key => $value) {
                array_push($bookArray,$value->seat_number);
            }
        // client 2022 project update

        //---------------fleet seats----------------
        $fleetSeats = $this->db->select("
                total_seat, seat_numbers, fleet_facilities
            ")->from("fleet_type")
            ->where('id', $fleetTp)
            ->get()
            ->row();

        $seatArray = array();
        $seatArray = array_map('trim', explode(',', $fleetSeats->seat_numbers));

        $html = "<h4 class=\"bg-primary\" style=\"padding:5px;margin:0\">" . display('select_seats') . "</h4>";

        foreach ($seatArray as $seat) {
            if (in_array($seat, $bookArray)) {
                $html .= "<button style=\"margin:1px;min-width:60px\" type=\"button\" class=\"btn btn-sm btn-square btn-danger disabled\">$seat</button>";
            } else {
                $html .= "<button style=\"margin:1px;min-width:60px\" type=\"button\" class=\"btn btn-sm btn-square btn-primary ChooseSeat\">$seat</button>";
            }
        }

        //---------------find facilities---------------
        $facilities = "";
        $facilitiesArray = array();
        $facilitiesArray = array_map('trim', explode(',', $fleetSeats->fleet_facilities));
        if (sizeof($facilitiesArray) > 0) {
            foreach ($facilitiesArray as $key => $fa) {
                if ($fa != "") {
                    $facilities .= "<input id=\"f$key\" name=\"request_facilities[]\" class=\"inline-checkbox\" type=\"checkbox\" value=\"$fa\"> <label for=\"f$key\">$fa</label> ";
                }

            }
        }

        echo json_encode(array(
            'html' => $html,
            'facilities' => $facilities,
            'bookArray' => $bookArray,
            'seatArray' => $seatArray,
        ));
    }

    /*
     *------------------------------------------------------
     * Price & Discount
     * return price & group price
     *------------------------------------------------------
     */
    public function priceByRouteTypeAndSeat()
    {
        $routeId = $this->input->post('routeId', true);
        $fleetTypeId = $this->input->post('fleetTypeId', true);
        $requestSeat = (int) $this->input->post('totalSeat', true);
        $child = (int) $this->input->post('child', true);
        $adult = (int) $this->input->post('adult', true);
        $special = (int) $this->input->post('special', true);
        $checkseat = $this->input->post('checkseat', true);
        //---------------price---------------------
        $tripPrice = $this->db->select("*")
            ->from('pri_price')
            ->where('route_id', $routeId)
            ->where('vehicle_type_id', $fleetTypeId)
            ->order_by('group_size', 'desc')
            ->get()
            ->result();
        if ($checkseat == 'false') {
            $data['status'] = false;
            $data['price'] = 0;
            $data['exception'] = "Please check Seat !!";
        } else {

            if (sizeof($tripPrice) > 0) {

                $maxGroup = 0;
                $maxGroupPrice = 0;
                $total_childgprice = 0;
                $total_specialgprice = 0;
                foreach ($tripPrice as $value) {

                    $singlePrice = $value->price;
                    $childprice = $value->children_price;
                    $specialprice = $value->special_price;
                    $groupSeat = $value->group_size;
                    $groupPrice = $value->group_price_per_person;
                    $price = 0;

                    if ($requestSeat < $groupSeat or $groupSeat < 1) {
                        $price = ($adult * $singlePrice);

                        $total_childprice = ((int) $child * $childprice);
                        $total_specialprice = ((int) $specialprice * (int) $special);
                        $data['status'] = true;
                        $data['price'] = $price + $total_childprice + $total_specialprice;

                    } else if ($requestSeat >= $groupSeat) {

                        if ($maxGroup < $groupSeat) {
                            $maxGroup = $groupSeat;
                            $maxGroupPrice = $groupPrice;
                        }
                        $total = ($adult * $maxGroupPrice);
                        $total_childgprice = ($child * $maxGroupPrice);
                        $total_specialgprice = ($special * $maxGroupPrice);
                        //$price = ($requestSeat * $maxGroupPrice);

                        $data['status'] = true;
                        $data['price'] = $total + $total_childgprice + $total_specialgprice;

                    } else {

                        $data['status'] = false;
                        $data['price'] = $price;
                    }

                }

            } else {
                $data['status'] = false;
                $data['exception'] = "Price not found!";
            }
        }

        echo json_encode($data);
    }

    /*
     *------------------------------------------------------
     * Offer
     *------------------------------------------------------
     */

    public function findOfferByCode()
    {
        $offerCode = $this->input->post('offerCode', true);
        $offerRouteId = $this->input->post('offerRouteId', true);
        $tripDate = date("Y-m-d", strtotime($this->input->post('tripDate')));

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

    /*
     *------------------------------------------------------
     * Passenger
     *------------------------------------------------------
     */

    public function findPassengerName()
    {
        $passengerEamil = $this->input->post('passengerEamil', true);

        $result = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS name,id_no ")
            ->from('tkt_passenger')
            ->where('email', $passengerEamil)
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

        echo json_encode($data);
    }

    // loacally ticket view
    public function ticket_view($booking_id_no = null)
    {
        $this->permission->method('ticket', 'create')->redirect();
        $data['title'] = display('view');
        #-------------------------------#
        $data['ticket'] = $this->booking_model->ticket($booking_id_no);
        $data['appSetting'] = $this->booking_model->website_setting();

        $data['disclaimers'] = $this->db->select('disclaimer_details')->from('disclaimer')->where('status', 0)->limit(1)->get()->row();

        $data['user_name'] = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS fullname")
            ->from("user")
            ->where('status', 1)
            ->where('id', $data['ticket']->booked_by)
            ->limit(1)
            ->get()
            ->row();

        $data['module'] = "ticket";
        $data['page'] = "booking/ticket";

        $data['user_name'] = $this->db->select("CONCAT_WS(' ', firstname, lastname) AS fullname")
            ->from("user")
            ->where('status', 1)
            ->where('id', $data['ticket']->booked_by)
            ->limit(1)
            ->get()
            ->row();

        $data['disclaimers'] = $this->db->select('disclaimer_details')->from('disclaimer')->where('status', 0)->limit(1)->get()->row();
        // echo "<pre>";

        // print_r($data);

        // die();

        echo Modules::run('template/layout', $data);
    }

    // booking paid information
    public function booking_paid()
    {

        //$this->permission->method('ticket','create')->redirect();

        $data['title'] = display('paid');
        #-------------------------------#
        $id_no = $this->input->post('booking_id');
        $payinfo = $this->booking_model->ticket_paid($id_no);
        foreach ($payinfo as $payinfor) {
        }
        $id = $payinfor->id;
        $postData = ['id' => $payinfor->id,
            'id_no' => $id_no,
            'trip_id_no' => $payinfor->trip_id_no,
            'tkt_passenger_id_no' => $payinfor->tkt_passenger_id_no,
            'trip_route_id' => $payinfor->trip_route_id,
            'pickup_trip_location' => $payinfor->pickup_trip_location,
            'drop_trip_location' => $payinfor->drop_trip_location,
            'request_facilities' => $payinfor->request_facilities,
            'price' => $payinfor->price,
            'discount' => $payinfor->discount,
            'total_seat' => $payinfor->total_seat,
            'seat_numbers' => $payinfor->seat_numbers,
            'offer_code' => $payinfor->offer_code,
            'tkt_refund_id' => $payinfor->tkt_refund_id,
            'agent_id' => $payinfor->agent_id,
            'booking_date' => $payinfor->booking_date,
            'booking_type' => $payinfor->booking_type,
            'date' => date("Y-m-d H:i:s"),
            'payment_status' => 'NULL',
        ];
      
        $agent_com_per = $this->db->select('*')->from('agent_info')->where('agent_email', $this->session->userdata('email'))->get()->row();
        $agent_commission = 0;

        if (!empty($agent_com_per)) {
            $agent_commission = $agent_com_per->agent_commission;
            
        }
        $agent_ledger = array();
        $agent_ledger_new = array();
         if($this->session->userdata('is_admin') == 0)
         {
            if ($agent_commission > 0) {
                $agent_ledger_new = [
                    'agent_id' => $agent_com_per->agent_id,
                    // 'credit' => ($agent_commission * $amount) / 100,
                    'credit' =>  $payinfor->amount,
                    'date' => date('Y-m-d H:i:s'),
                    'detail' => "Ticket Booking",
                 ];
               
                
                $this->db->insert('agent_ledger_total', $agent_ledger_new);
                
            }

            if ($agent_commission > 0) {
                $agent_ledger = [
                    'booking_id' => $id_no,
                    'credit' => ($agent_commission * $payinfor->amount) / 100,
                    'date' => date('Y-m-d H:i:s'),
                    'agent_id' => $agent_com_per->agent_id,
                    'commission_rate' => $agent_commission,
                    // 'total_price' => $price,
                    'total_price' => $payinfor->amount,
                ];
                $this->db->insert('agent_ledger', $agent_ledger);
            }

            
         }


        $accoutn_transaction = [
            'account_id' => 3,
            'transaction_description' => 'Booking ID-' . $id_no. '<br> Route ID-' . $payinfor->trip_route_id . '<br> Trip Id-' . $payinfor->trip_id_no . '' . '<br> Ticket No-' . $payinfor->seat_number . '' . '<br> Passanger ID-' . $payinfor->tkt_passenger_id_no . '' . '<br> Seat Price-' . $payinfor->price . '' . '<br> Discount-' . $payinfor->discount . '',
            'amount' => $payinfor->amount,
            'create_by_id' => $this->session->userdata('id'),
            #---------New Code 2021 for store date in db---------#
            'date' => date('Y-m-d H:i:s'),
            #---------New Code 2021 for store date in db---------#
        ];

        $this->db->insert('acn_account_transaction', $accoutn_transaction);
       



        $updata = $this->db->where('id_no', $id_no)
            ->update('tkt_booking', $postData);

        $pemail = $this->db->select('*')->from('tkt_passenger')->where('id_no', $payinfor->tkt_passenger_id_no)->get()->row();
        $id = $this->input->post('booking_id');
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

            // if mail not working
            goto skip_mail2;

            if (!empty($email)) {
                $send_email = $this->setmail($email, $file_path, $id, $name);
                redirect("ticket/booking/unpaisd_cash_booking");
            }

            skip_mail2:

            redirect("ticket/booking/unpaisd_cash_booking");

        }
    }

    // success mail strat

    public function setmail($email, $file_path = null, $id = null, $name = null, $subject = null, $message = null)
    {

        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();

        if (empty($subject)) {
            $subject = 'ticket Information';
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
            'charset' => 'utf-8',
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

    //Email testing for email
    public function test_input($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // sucessmail end

    /*Booking cancel automaticallay
    |
     */

    public function autocancel()
    {

        $timezone = $this->db->select('*')->from('ws_setting')->where('id', 1)->get()->row();
        $downtime = $this->db->select('*')->from('booking_downtime')->get()->result();

        foreach ($downtime as $down) {}
        $dntime = $down->downtime;

        $cancele = $this->db->select('*')->from('tkt_booking')->where('payment_status', 1)->get()->result();

        if ($cancele) {
            foreach ($cancele as $can) {}
            $default = date_default_timezone_set($timezone->timezone);
            $day1 = $can->date;
            $day1 = strtotime($day1);
            $day2 = $date = date('Y-m-d H:i:s', time());
            $day2 = strtotime($day2);
            $diffHours = round(($day2 - $day1) / 3600) + 0.001;
            $sql = "UPDATE tkt_booking SET booking_delete_status = 1 WHERE $diffHours > $dntime AND payment_status=1";

            if ($this->db->query($sql) === true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function autocancel_cashbookig()
    {
        $timezone = $this->db->select('*')->from('ws_setting')->where('id', 1)->get()->row();
        $downtime = $this->db->select('downtime')->from('booking_downtime')->get()->result();
        // echo "<pre>";
        // print_r($downtime[0]->downtime);
        // exit();
        $cancele = $this->db->select('*')->from('tkt_booking')->where('payment_status', 2)->get()->result();

        $dntime = $downtime[0]->downtime;

        if ($cancele) {
            foreach ($cancele as $can) {}
            $default = date_default_timezone_set($timezone->timezone);
            $day1 = $can->date;
            $day1 = strtotime($day1);
            $day2 = $date = date('Y-m-d H:i:s', time());
            $day2 = strtotime($day2);
            $diffHours = round(($day2 - $day1) / 3600) + 0.001;
            $sql = "UPDATE tkt_booking SET booking_delete_status = 1 WHERE $diffHours > $dntime AND payment_status=2";
            if ($this->db->query($sql) === true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function confirmation()
    {
        $data["logo"] = $this->db->select("*")
        ->from('setting')
        ->get()
        ->row();
        $data["confirm"] = $this->booking_model->confirmation();
        $data['module'] = "ticket";
        $data['page'] = "booking/confirmlist";
        $data['appSetting'] = $this->booking_model->website_setting();
        // echo "<pre>";
        // print_r($data);
        // exit();
        echo Modules::run('template/layout', $data);
    }

    // unpaid cash bookin list
    public function unpaisd_cash_booking()
    {
        $data["logo"] = $this->db->select("*")
        ->from('setting')
        ->get()
        ->row();
        $data["bookings"] = $this->booking_model->upaid_cash_bookig();
        $data['module'] = "ticket";
        $data['page'] = "booking/unpaid_cashbooking";
        $data['appSetting'] = $this->booking_model->website_setting();
        // echo "<pre>";
        // print_r($data["bookings"]);
        // exit();
        echo Modules::run('template/layout', $data);
    }

    // ticket transaction confirmation  delete
    public function delete_confirmation($id = null)
    {

        if ($this->booking_model->confirmation_delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("ticket/booking/confirmation");
    }

//     //payment term and condition
    //     public function terms_and_condition_form($id = null)
    //  {
    //   $this->permission->method('ticket','create')->redirect();
    //   $data['title'] = display('add');
    //   #-------------------------------#
    //   $this->form_validation->set_rules('how_to_pay', display('how_to_pay')  ,'required|max_length[1000]');
    //   $this->form_validation->set_rules('terms_and_condition', display('terms_and_condition')  ,'max_length[1000]');
    //   #-------------------------------#
    //      $data['term']   = (Object) $postData = [
    //         'id'                 => $this->input->post('id'),
    //    'how_to_pay'              => $this->input->post('how_to_pay'),
    //    'terms_and_condition'     => $this->input->post('terms_and_condition')
    //   ];

//   if ($this->form_validation->run()) {

//    if (empty($postData['id'])) {

//           $this->permission->method('ticket','create')->redirect();

//     if ($this->booking_model->create_terms($postData)) {
    //      $this->session->set_flashdata('message', display('save_successfully'));
    //      redirect('ticket/booking/terms_and_condition_list');
    //     } else {
    //      $this->session->set_flashdata('exception',  display('please_try_again'));
    //     }
    //     redirect("ticket/booking/terms_and_condition_form");

//    } else {

//     $this->permission->method('ticket','update')->redirect();

//     if ($this->booking_model->update_condition($postData)) {

//      $this->session->set_flashdata('message', display('update_successfully'));
    //     } else {
    //      $this->session->set_flashdata('exception',  display('please_try_again'));
    //     }
    //     redirect("ticket/booking/terms_and_condition_form/".$postData['id']);
    //    }

//   } else {
    //    if(!empty($id)) {
    //     $data['title'] = display('update');
    //     $data['terms'] = $this->booking_model->terms_and_cond_data($id);
    //    }
    //    $data['module'] = "ticket";
    //    $data['page']   = "booking/terms_form";
    //    echo Modules::run('template/layout', $data);
    //    }
    //  }

// // terms and condition list
    //   public function terms_and_condition_list()
    //     {
    //         $data["terms"]  = $this->booking_model->term_and_condition_list();
    //         $data['module'] = "ticket";
    //         $data['page']   = "booking/term_condition_list";
    //         echo Modules::run('template/layout', $data);
    //     }
    //     //terms_delete
    //      public function terms_delete($id = null)
    //     {

//     if ($this->booking_model->terms_delete($id)) {
    //         #set success message
    //         $this->session->set_flashdata('message',display('delete_successfully'));
    //     } else {
    //         #set exception message
    //         $this->session->set_flashdata('exception',display('please_try_again'));
    //     }
    //      redirect("ticket/booking/terms_and_condition_list");
    //     }



// New code 2021 direct update

public function journeyListform()
{
    $this->permission->method('ticket', 'read')->redirect();
    $currency_details = $this->price_model->retrieve_setting_editdata();
    foreach ($currency_details as $price) {
    }
    $currency = $price['currency'];

    $data["logo"] = $this->db->select("*")
    ->from('setting')
    ->get()
    ->row();
    $data['title'] = display('journey_list');
    $data['fleetType'] = $this->Journey_list_model ->getFleetType();
    $data['tripRoutType'] = $this->Journey_list_model ->getRoutType();
    $data['module'] = "ticket";
    $data['page'] = "booking/journeyFilter";
    echo Modules::run('template/layout', $data);

}


    public function journeyList()
    {
        $this->permission->method('ticket', 'read')->redirect();
        $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency = $price['currency'];
        $data['title'] = display('journey_list');


        $vehicleid = $this->input->post('vehicle');
        
        $postdate = $this->input->post('start_date');
        $postdate = date("Y-m-d", strtotime($postdate));
        $triptypeId =  $this->input->post('tripType');

      
       

        $data["logo"] = $this->db->select("*")
        ->from('setting')
        ->get()
        ->row();
       
        $data["passengarlist"] = $this->Journey_list_model->passengerList($postdate,$vehicleid,$triptypeId);
        // var_dump($data["passengarlist"]);
        // exit;
        $data["links"] = $this->pagination->create_links();

    
        
        #
        #pagination ends
        #
        $data["jdate"] = $postdate;
        $data["vehicelid"] = $vehicleid;
        $data["triptypeId"] = $triptypeId;
        
        $data['fleetType'] = $this->Journey_list_model ->getFleetType();
        $data['tripRoutType'] = $this->Journey_list_model ->getRoutType();

        // $data['passengerList'] = $this->Journey_list_model ->passengerList($postdate,$vehicleid);

        // client 2022 project update
            $data["vehicledetail"] = $this->db->where('id',$vehicleid)->get('fleet_registration')->row();
        // client 2022 project update

        $data['appSetting'] = $this->booking_model->website_setting();
        $data['module'] = "ticket";
        $data['page'] = "booking/journeyList";
        echo Modules::run('template/layout', $data);
    }

    public function getTripScheduleAjax()
    {
        $routetype    = $this->input->post('datarout');
        $fleetType = $this->input->post('datafleet');
        $date = $this->input->post('date');

        $this->db->where('status', 1);
        $this->db->where('type', $fleetType);
        $this->db->where('route',$routetype);
        $query = $this->db->get('trip');
        $date = $query->result_array();

       
        echo json_encode( $date);
    }

    public function getVehicleListAjax()
    {
        $vehicle    = $this->input->post('vehicle');
       

        $this->db->select('*');
        $this->db->from('trip_assign');
        $this->db->join('fleet_registration', 'fleet_registration.id = trip_assign.fleet_registration_id');
        $this->db->where('fleet_registration.status', 1);
        $this->db->where('trip_assign.status', 1);
        $this->db->where('trip_assign.closed_by_id', 0);
        $this->db->where('trip_assign.trip',  $vehicle );
        $query = $this->db->get();

        $date = $query->result_array();

       
        echo json_encode( $date);
    }


    public function paymentdetail($id)
{
   
    $this->permission->method('ticket', 'read')->redirect();
    $currency_details = $this->price_model->retrieve_setting_editdata();
    foreach ($currency_details as $price) {
    }

    $paymetdetail =  $this->db->where('id', $id)->get('tkt_booking')->row();
   
    $currency = $price['currency'];
    $data['title'] = display('Payment Detail');
    $data['paydetail'] = $paymetdetail->pay_detail;
    $data['paytype'] = $paymetdetail->pay_type;
    $data['partial_pay_all'] = $this->db->where('booking_id', $paymetdetail->id_no)->get('partial_pay_all')->result();
    $data['module'] = "ticket";
    $data['page'] = "booking/view";
    echo Modules::run('template/layout', $data);

}

public function journelistpdf($jdate,$vehicleid,$triptypeId)
{

    $data["logo"] = $this->db->select("*")
			->from('setting')
			->get()
			->row();

    $tripAssign = $this->db->where('fleet_registration_id',$vehicleid)->get('trip_assign')->row();

    // client 2022 project update
    $data["vehicledetail"] = $this->db->where('id',$vehicleid)->get('fleet_registration')->row();
    // client 2022 project update

    $data["tripname"] = $this->db->where('trip_id',$tripAssign->trip)->get('trip')->row();         
    $data["employees"] = $this->db->select('*')->from('employee_history')->join('dynamic_assign', 'dynamic_assign.employeeid = employee_history.id')->where('randomid',$tripAssign->id_no)->get()->result();         

    $data["passengarlist"] = $this->Journey_list_model->passengerListpdf($jdate,$vehicleid,$triptypeId);
    $data['startlocation'] = $this->Journey_list_model ->startLocation( $vehicleid);
     $data['endlocation'] = $this->Journey_list_model ->endLocation( $vehicleid);
     $this->load->view('booking/journeyListpdf',$data);
    $html = $this->output->get_output();
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);

    $dompdf->setPaper('A4','potrait');
    ob_end_clean();
    $dompdf->render();
    // $dompdf->stream("journeylist.pdf",array("Attachment" =>1));
    $output = $dompdf->output();
    file_put_contents("file.pdf", $output);
}


public function updateform($id)
    {
        $this->permission->method('ticket', 'create')->redirect();
        $data['title'] = "Edit";
        #-------------------------------#

        // $data["booking"] = $this->db->select("*")       
        $teacket_booking = $this->db->select("*")       
			->from('tkt_booking')
			->where('id',$id)
			->where('tkt_refund_id', NULL)
			->where('booking_delete_status', 0)
			->get()
			->row();
        $trip_assign_id =   $this->db->select("*")       
			->from('trip_assign')
			->where('id',$teacket_booking->trip_id_no)
			->get()
			->row();
            
        $fleet_registration_id =   $this->db->select("*")       
			->from('fleet_registration')
			->where('id',$trip_assign_id->fleet_registration_id)
			->get()
			->row();
           
      
        $data['fleetType'] = $fleet_registration_id->fleet_type_id;
        $data['triprouteid'] =  $teacket_booking->trip_route_id;
        $data['date']= $teacket_booking->booking_date;


        
        $data['tripassignid'] =  $trip_assign_id->id;
        $data['vehicelid'] =  $trip_assign_id->fleet_registration_id;
        $data['fleettypeid'] =  $fleet_registration_id->fleet_type_id;

        $data['totalseat'] =  $teacket_booking->total_seat;
        $data['tkt_booking_id'] = $id;
        $data['bookingid'] = $teacket_booking->id_no ;

        $data['location_dropdown'] = $this->booking_model->location_dropdown();
        $data['route_dropdown'] = $this->booking_model->route_dropdown();
        $data['facilities_dropdown'] = $this->booking_model->facilities_dropdown();
        $data['country_dropdown'] = $this->country_model->country();
        $data['tps'] = $this->booking_model->fleet_dropdown();
        $data['module'] = "ticket";
        $data['taxes'] = (array) $this->booking_model->tax();

        $data['tax_module'] = explode(',', $data['taxes'][0]['apply_tax_module']);
        
        $data['page'] = "booking/ticketedit";
        echo Modules::run('template/layout', $data);
    }

    public function updatebooking()
    {

        #-------------------------------#
        #-------------------------------#

      
        $this->permission->method('ticket', 'create')->redirect();
        #-------------------------------#
        $this->form_validation->set_rules('route_id', display('route_name'), 'required|max_length[255]');
        $this->form_validation->set_rules('seat_number', display('select_seats'), 'required');
        $this->form_validation->set_rules('approximate_time', display('booking_date'), 'required|max_length[20]');

        $trip_id_no = $this->input->post('tripIdNo');
        $fleet_registration_id = $this->input->post('fleet_registration_id');
        $fleet_type_id = $this->input->post('ftypes');
        $seat_number = $this->input->post('seat_number');
        $routeId = (int) $this->input->post('route_id');
      
        $total_seat = (int) $this->input->post('total_seat');
       
        $booking_dates = $this->input->post('approximate_time');
       
        #-------------------------------#

        $booking_date = date('Y-m-d', strtotime($booking_dates));
        $b_dates = date('Y-m-d', strtotime($booking_dates));
       
        $tkt_bookin_id = $this->input->post('id');
        $bookingid = $this->input->post('bookingid');
        

        


        if ($this->form_validation->run()) {
            
                //check seats
                if ($this->checkBooking($trip_id_no, $fleet_type_id, $seat_number, $booking_date)) {
                    #---------New Code---------#
                    $currentdate = date('Y-m-d H:i:s');
                    #---------New Code---------#

                    //check passenger
                  

                        $postData = [
                            
                            'trip_id_no' => $trip_id_no,
                            'trip_route_id' => $routeId,
                            'total_seat' => $total_seat,
                            'seat_numbers' => $seat_number,
                            'booking_date' => $b_dates,
                            'date' => $currentdate,
                         ];

                         
                                if ($this->booking_model->updatedata($postData,$tkt_bookin_id)) {
                                
                                    // client 2022 project update
                                        $rechedulefee =   $this->input->post('rechedulefee');
                                        $bookingid = $this->input->post('bookingid');
                                        if (!empty( $rechedulefee)) {

                                                if ($this->session->userdata('isAdmin')==0) {

                                                    $agent_com_per = $this->db->select('*')->from('agent_info')->where('agent_email', $this->session->userdata('email'))->get()->row();
                                                    $agent_commission = 0;

                                                    if (!empty($agent_com_per)) {
                                                        $agent_commission = $agent_com_per->agent_commission;
                                                        }

                                                        $agent_ledger = array();
                                                        $agent_ledger_new = array();
                                                        if ($agent_commission > 0) {
                                                            $agent_ledger_new = [
                                                                'agent_id' => $agent_com_per->agent_id,
                                                                'booking_id' => $bookingid,
                                                                'credit' =>  $rechedulefee,
                                                                'date' => $currentdate,
                                                                'detail' => "Ticket Rescheduling",
                                                            ];

                                                            $agent_ledger = [
                                                                'booking_id' => $bookingid,
                                                                'credit' => ($agent_commission * $rechedulefee) / 100,
                                                                'date' => $currentdate,
                                                                'agent_id' => $agent_com_per->agent_id,
                                                                'commission_rate' => $agent_commission,
                                                                'total_price' => $rechedulefee,
                                                            ];
                                                        
                                                            $this->db->insert('agent_ledger_total', $agent_ledger_new);
                                                            $this->db->insert('agent_ledger', $agent_ledger);
                                                            
                                                        }


                                                        

                                                    
                                                }

                                            
                                            $accoutn_transaction = [
                                                'account_id' => 3,
                                                'transaction_description' => 'Booking ID-' . $bookingid . '<br> Route ID-' . $routeId . '<br> Trip Id-' . $trip_id_no . '' . '<br> Ticket No-' . $seat_number . ''  ,
                                                'amount' => $rechedulefee,
                                                'create_by_id' => $this->session->userdata('id'),
                                                'date' => $currentdate,
                                                
                                            ];

                                            $this->db->insert('acn_account_transaction', $accoutn_transaction);

                                        
                                        }


                                    // client 2022 project update

                                    $data['status'] = true;
                                    $data['id_no'] = $bookingid;
                                    $data['message'] = display('save_successfully');

                                    

                                    
                                }
                                
                                else {
                                    $data['status'] = false;
                                    $data['exception'] = display('please_try_again');
                                }

                    

                }
                
                else
                 {
                    $data['status'] = false;
                    $data['exception'] = display('invalid_input');
                 }
            

        } else {
            $data['status'] = false;
            $data['exception'] = validation_errors();
        }
        #-------------------------------#
        #-------------------------------#

        echo json_encode($data);
       
       

    }

// New code 2021 direct update

 //  client 2022 project update
public function partialpay($bookingid)
{
    $teacket_booking = $this->db->select("*")       
			->from('tkt_booking')
			->where('id',$bookingid)
			->where('tkt_refund_id', NULL)
			->where('booking_delete_status', 0)
			->get()
			->row();
            
    $data['appSetting'] = $this->booking_model->website_setting();
    $data['module'] = "ticket";
    $data['page'] = "booking/partialpay";
    $data['booking'] =  $teacket_booking;
    echo Modules::run('template/layout', $data);
}


public function addPartialPay()
{
    $trantime = date("Y-m-d H:i:s");
    $pay_type = $this->input->post('pay_type');
    $partialpayamount = (float) $this->input->post('partialpayamount');
    $partialpay = (float) $this->input->post('partialpay');
    $pay_detail =  $this->input->post('pay_detail');
    $bookingid = $this->input->post('bookingid');
    $payinfor = $this->db->select("*")       
			->from('tkt_booking')
			->where('id',$bookingid)
			->where('tkt_refund_id', NULL)
			->where('booking_delete_status', 0)
			->get()
			->row();
    
    if($partialpayamount>$partialpay)
        {
            $paystatus = "partial";
        }
    if($partialpayamount == $partialpay)
        {
            $paystatus = "NULL";
        }


    $paystep = $payinfor->paystep;

    if( ($paystep>2) && ($partialpayamount>$partialpay))
    {
        $this->session->set_flashdata('exception', 'You must pay the full Payment');
        $data['appSetting'] = $this->booking_model->website_setting();
        $data['module'] = "ticket";
        $data['page'] = "booking/partialpay";
        $data['booking'] =  $payinfor;
        echo Modules::run('template/layout', $data);
    }

    else
    {
        
        $postData = ['id' => $payinfor->id,
            'id_no' => $payinfor->id_no,
            'trip_id_no' => $payinfor->trip_id_no,
            'tkt_passenger_id_no' => $payinfor->tkt_passenger_id_no,
            'trip_route_id' => $payinfor->trip_route_id,
            'pickup_trip_location' => $payinfor->pickup_trip_location,
            'drop_trip_location' => $payinfor->drop_trip_location,
            'request_facilities' => $payinfor->request_facilities,
            'price' => $payinfor->price,
            'discount' => $payinfor->discount,
            'total_seat' => $payinfor->total_seat,
            'seat_numbers' => $payinfor->seat_numbers,
            'offer_code' => $payinfor->offer_code,
            'tkt_refund_id' => $payinfor->tkt_refund_id,
            'agent_id' => $payinfor->agent_id,
            'booking_date' => $payinfor->booking_date,
            'booking_type' => $pay_type,
            'date' =>  $trantime,
            'payment_status' => $paystatus,
            'pay_detail' => $pay_detail,
            'paystep' => (int)$payinfor->paystep + 1 ,
            'partialpay' => (float)$payinfor->partialpay + (float) $partialpay ,
        ];


        $agent_com_per = $this->db->select('*')->from('agent_info')->where('agent_email', $this->session->userdata('email'))->get()->row();
        $agent_commission = 0;

        if (!empty($agent_com_per)) {
            $agent_commission = $agent_com_per->agent_commission;
            
        }
        $agent_ledger = array();
        $agent_ledger_new = array();

         if($this->session->userdata('is_admin') == 0)
         {
            if ($agent_commission > 0) {
                $agent_ledger_new = [
                    'agent_id' => $agent_com_per->agent_id,
                    'booking_id' => $payinfor->id_no,
					'credit' =>  $partialpay,
                    'date' => $trantime,
                    'detail' => "Ticket Booking",
                 ];
               
                
                $this->db->insert('agent_ledger_total', $agent_ledger_new);
                
            }

            if ($agent_commission > 0) {
                $agent_ledger = [
                    'booking_id' => $payinfor->id_no,
                    'credit' => ($agent_commission * $partialpay) / 100,
                    'date' => $trantime,
                    'agent_id' => $agent_com_per->agent_id,
                    'commission_rate' => $agent_commission,
                    // 'total_price' => $price,
                    'total_price' => $partialpay,
                ];
                $this->db->insert('agent_ledger', $agent_ledger);
            }

            
         }


         $accoutn_transaction = [
            'account_id' => 3,
            'transaction_description' => 'Booking ID-' . $payinfor->id_no. '<br> Route ID-' . $payinfor->trip_route_id . '<br> Trip Id-' . $payinfor->trip_id_no . '' . '<br> Ticket No-' . $payinfor->seat_numbers . '' . '<br> Passanger ID-' . $payinfor->tkt_passenger_id_no . '' . '<br> Seat Price-' . $payinfor->price . '' . '<br> Discount-' . $payinfor->discount . '',
            'amount' => $partialpay,
            'create_by_id' => $this->session->userdata('id'),
            'date' => $trantime,
           
        ];

        $this->db->insert('acn_account_transaction', $accoutn_transaction);

        $updata = $this->db->where('id_no', $payinfor->id_no) ->update('tkt_booking', $postData);

        if($paystep == 0)
        {
            $payment_step = "First Payment";
        }
        if($paystep == 1)
        {
            $payment_step = "Second Payment";
        }
        if($paystep == 2)
        {
            $payment_step = "Third Payment";
        }
        if($paystep == 3)
        {
            $payment_step = "Fourth Payment";
        }
        

        $partial_pay_all = [
            'book_by' => $this->session->userdata('id'),
            'booking_id' => $payinfor->id_no,
            'amount' =>  $partialpay,
            'date' => $trantime,
            'payment_step' => $payment_step,
            'detail' => $pay_detail,
         ];

        $this->db->insert('partial_pay_all', $partial_pay_all);


        $this->session->set_flashdata('message', display('save_successfully'));
        $this->index();
    }
    
   
}


public function findticketBySearch()
{
    $bookingId =  $this->input->post('bookingid');

    $this->db->select('tb.*, tr.name AS route_name');
    $this->db->from('tkt_booking AS tb');
    $this->db->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left");
    
    $this->db->where('tb.booking_delete_status',0);
    $this->db->where('tb.id_no ',$bookingId);
    $this->db->order_by('id', 'desc');
    $query=$this->db->get();
    $ticketbooking =  $query->result();
       

    $data["bookings"] = $ticketbooking;
    $data["links"] = $this->pagination->create_links();
    $data['appSetting'] = $this->booking_model->website_setting();
    $data['module'] = "ticket";
    $data['page'] = "booking/list";
    echo Modules::run('template/layout', $data);
}


 //  client 2022 project update

 public function travel()
 {
    $bookinid = $this->input->post('currentid');
    $status = $this->input->post('currentStatus');
    if ($status == "check") {
        $state = 0;
        $time = null;
    } else {
        $state = 1;
        $time = date('Y-m-d H:i:s A');
    }
    
    $data = [
        "travel_status" => $state,
        "chake_in_time" => $time,
    ];

    $return_data =   $this->db->where('id_no',$bookinid)->update('tkt_booking',$data); 
    
    echo json_encode( $return_data );
    // redirect('ticket/booking/journeyList');
    

 }

 public function untravel($bookingid)
 {
    $data = [
        "travel_status" => 0
    ];

    $this->db->where('id_no',$bookingid)->update('tkt_booking',$data); 
    redirect('ticket/booking/journeyList');
 }

}
