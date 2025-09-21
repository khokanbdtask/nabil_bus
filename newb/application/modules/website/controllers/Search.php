<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends MX_Controller
{

    private $active_theme = null;

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->autocancel();
        $this->load->model(array(
            'website_model'
        ));

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
        $downtime = $this->db->select('*')->from('booking_downtime')->get()->row();

        $dntime = $downtime->downtime;
        $cancele = $this->db->select('*')->from('tkt_booking')->where('payment_status', 1)->get()->result();

        if ($cancele) {
            foreach ($cancele as $can) {
            }

            $day1 = $can->date;
            $day1 = strtotime($day1);
            $day2 = $date = date('Y-m-d h:i:s', time());
            $day2 = strtotime($day2);
            $diffHours = round(($day2 - $day1) / 3600);

            $sql = "DELETE FROM tkt_booking WHERE $diffHours > $dntime AND payment_status=1";

            if ($this->db->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /*
    |--------------------------------------------------------------------
    | Create booking 
    |--------------------------------------------------------------------
    */

    public function index()
    {
        $data['title'] = display('booking');
        #---------------GET DATA------------------
        $getStartPoint = $this->input->get('start_point');
        $getEndPoint = $this->input->get('end_point');
        $getDate = $this->input->get('date');
        $selectedDate = date("Y-m-d", strtotime(!empty($getDate) ? $getDate : date('Y-m-d')));

        $getFleetType = $this->input->get('fleet_type');
        #---------------POST DATA------------------
        $postStartPoint = $this->input->post('start_point');
        $postEndPoint = $this->input->post('end_point');
        $postFleetType = $this->input->post('fleet_type');
        #---------------FINAL DATA------------------
        $data['search'] = (object)$postData = array(
            'start_point' => (!empty($postStartPoint) ? $postStartPoint : $getStartPoint),
            'end_point' => (!empty($postEndPoint) ? $postEndPoint : $getEndPoint),
            'date' => $selectedDate,
            'fleet_type' => (!empty($postFleetType) ? $postFleetType : $getFleetType),
        );
        // print_r($postData);exit;
        #---------------------------------------------
        $data['trip_list'] = $this->website_model->trip_list($postData);
        $data['b_date'] = $selectedDate;
        $data['location_dropdown'] = $this->website_model->location_dropdown();
        $data['fleet_dropdown'] = $this->website_model->fleet_dropdown();
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();


//        $bookingResult = 0;
        $trip_lists = $this->website_model->trip_list($postData);
        $x = 0;
        foreach ($trip_lists as $trip_list) {
            $data['bookingResult'][$x] = $this->website_model->seat_available($trip_list->trip_id_no, $selectedDate);
            $x++;
        }

//		echo "<pre>";
//		print_r($data);
//		die();

        #-----------------------------------
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "/pages/search";
        $this->load->view($this->active_theme . '/layout', $data);
    }


    /*
    |----------------------------------------------
    |  ADD PASSENGER AND PAYMENT 
    |----------------------------------------------     
    */

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


    /*
    |----------------------------------------------
    |  RANDOM STRING 
    |----------------------------------------------     
    */

    public function booking()
    {
        $timezone = $this->db->select('*')->from('ws_setting')->where('id', 1)->get()->row();
        date_default_timezone_set($timezone->timezone);
        $this->form_validation->set_rules('trip_id_no', display('trip_id_no'), 'required');
        $this->form_validation->set_rules('trip_route_id', display('trip_route_id'), 'required');
        $this->form_validation->set_rules('pickup_location', display('pickup_location'), 'required');
        $this->form_validation->set_rules('drop_location', display('drop_location'), 'required');
        $this->form_validation->set_rules('price', display('price'), 'required');
        $this->form_validation->set_rules('total_seat', display('total_seat'), 'required');
        $this->form_validation->set_rules('seat_number', display('seat_numbers'), 'required');
        $this->form_validation->set_rules('booking_date', display('booking_date'), 'required');
        $total_seats = (!empty($this->input->post('total_seat')) ? $this->input->post('total_seat') : 0);
        $child_sts = (!empty($this->input->post('child_no')) ? $this->input->post('child_no') : 0);
        $adult_sts = (!empty($this->input->post('adult')) ? $this->input->post('adult') : 0);
        $special_sts = (!empty($this->input->post('special')) ? $this->input->post('special') : 0);
        $totl_inpt = $child_sts + $adult_sts + $special_sts;
        $fleet_type = $this->input->post('fleet_type_id');

        /// Every Route Children and special seats info
        $rout_chsp_seat = $this->db->select('*')->from('trip_route')->where('id', $this->input->post('trip_route_id'))->get()->row();

        $facilities = "";

        if ($total_seats == $totl_inpt) {
            #--------------------------------------
            $request_facilities = ($this->input->post('request_facilities')) ? $this->input->post('request_facilities') : array();
            if (count($request_facilities) > 0) {
                $fa = "";
                foreach ($request_facilities as $fa) {
                    $facilities .= $fa . ", ";
                }
            }
            $booking_date = $this->input->post('booking_date') . ' ' . date('H:i:s');

            if ($this->input->post('offer_code') != '') {
                $discount = $this->checkOffer(
                    $this->input->post('offer_code'),
                    $this->input->post('trip_route_id'),
                    date('Y-m-d', strtotime($booking_date))
                );
            } else {
                $discount = 0;
            }

            if (!empty($this->session->userdata('id_no'))) {
                $passengerid = $this->session->userdata('id_no');
            } else {
                $passengerid = $this->randdomString("P");
//            $passengerid = '';
            }

            #--------------------------------------

            $postData = array(
                'id_no' => $this->randdomString("B"),
                'trip_id_no' => $this->input->post('trip_id_no'),
                'tkt_passenger_id_no' => $passengerid,
                'trip_route_id' => $this->input->post('trip_route_id'),
                'pickup_trip_location' => $this->input->post('pickup_location'),
                'drop_trip_location' => $this->input->post('drop_location'),
                'request_facilities' => $facilities,
                'price' => $this->input->post('price'),
                'discount' => $discount,
                'adult' => $this->input->post('adult'),
                'child' => $this->input->post('child_no'),
                'special' => $this->input->post('special'),
                'total_seat' => $this->input->post('total_seat'),
                'seat_numbers' => $this->input->post('seat_number'),
                'offer_code' => $this->input->post('offer_code'),
                'tkt_refund_id' => null,
                'agent_id' => null,
                'booking_date' => $booking_date,
                'date' => date('Y-m-d H:i:s'),
                'status' => '0'
            );


     // echo "<pre>";
     // print_r($postData);
     // die();


            #--------------------------------------
            if ($this->form_validation->run()) {

                $cs = $this->db->select("
                count(tb.child) AS tchild, 
                count(tb.special) AS tspecial 
            ")
                    ->from('tkt_booking AS tb')
                    ->where('tb.trip_id_no', $this->input->post('trip_id_no'))
                    ->like('tb.booking_date', $booking_date, 'after')
                    ->get()
                    ->row();
                $tcs = $cs->tchild + (int)$this->input->post('child_no');
                $tspecialck = $cs->tspecial + (int)$this->input->post('special');
                $req_children_seat = (!empty($rout_chsp_seat->children_seat) ? $rout_chsp_seat->children_seat : 20);
                $req_special_seat = (!empty($rout_chsp_seat->special_seat) ? $rout_chsp_seat->special_seat : 20);
                if ($tcs <= $req_children_seat) {
                    if ($tspecialck <= $rout_chsp_seat->special_seat) {
                        #---------check seats--------
                        if ($this->checkBooking(
                            $this->input->post('trip_id_no'), $fleet_type, $this->input->post('seat_number'), $booking_date
                        )) {

                            #---------check price--------
                            // if ($this->checkPrice(
                            //     $this->input->post('trip_route_id'),
                            //     $this->input->post('fleet_type_id'),
                            //     (sizeof(explode(',', $this->input->post('seat_number')))-1)
                            // ) > 0)
                            // {

                            if ($this->website_model->createBooking($postData)) {

     // print_r($postData);
     // die();


                                $data['booking'] = $binfo = $this->db->select("
                        bh.*,
                        tr.name AS route_name,
                        DATE_FORMAT(bh.booking_date, '%m/%d/%Y %h:%i %p') AS booking_date
                    ")
                                    ->from('ws_booking_history AS bh')
                                    ->join('trip_route AS tr', 'tr.id = bh.trip_route_id')
                                    ->where('id_no', $postData['id_no'])
                                    ->get()
                                    ->row();
                                $total_amnt = $binfo->price;
                                $comission = $this->db->select('*')->from('ws_setting')->get()->row();
                                $data['b_commission'] = ($binfo->price * $comission->bank_commission) / 100;
                                $data['commission_per'] = $comission->bank_commission;
                                $data['routePrice'] = $this->db->select('*')->from('pri_price')->where('route_id', $this->input->post('trip_route_id'))->get()->row();

//                        $this->load->view($this->active_theme.'/booking/payment_option', $obj, true);

                                $data['appSetting'] = $this->website_model->read_setting();
                                $data['languageList'] = $this->languageList();
                                $data['module'] = "website";
                                $data['page'] = $this->active_theme . "/booking/payment_option";

                                $data['title'] = "Payment";
                                $data['status'] = true;
                                $data['message'] = display('save_successfully');
                                $this->load->view($this->active_theme . '/layout', $data);
                            } else {
                                $data['status'] = false;
                                $data['exception'] = display('please_try_again');
                            }

                            // } else {
                            //     $data['status'] = false;
                            //     $data['exception'] = display('something_went_worng');
                            // }

                        } else {
                            $data['status'] = false;
                            $data['exception'] = display('something_went_worng');
                        }
                    } else {
                        $data['status'] = false;
                        $data['exception'] = 'Special Seats Are not Available';
                    }
                } else {
                    $data['status'] = false;
                    $data['exception'] = 'Children Seats Are not Available';
                }
            } else {
                $data['status'] = false;
                $data['exception'] = validation_errors();
            }
        } else {
            $data['status'] = false;
            $data['exception'] = 'Please Check your seat';
        }

        #--------------------------------------
//        echo json_encode($data);

    }

    /*
    |____________________________________________________________________
    |  
    | AJAX 
    |____________________________________________________________________ 
    |
    */

    /*findBookingInformation*/

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
        if (isset($checkOffer) && ($checkOffer->offer_number - $bookingOffer) > 0) {
            return $checkOffer->offer_discount;
        } else {
            return "0.00";
        }

    }


    /*
    *------------------------------------------------------
    * Price & Discount
    * return price & group price
    *------------------------------------------------------
    */

    private function randdomString($prefix = null)
    {
        $result = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $charArray = str_split($chars);
        for ($i = 0; $i < 7; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }
        return $prefix . $result;
    }

    /*
    *------------------------------------------------------
    * Offer
    *------------------------------------------------------
    */

    private function checkBooking($tripIdNo = null, $fleetId = null, $newSeats = null, $booking_date = null)
    {
        if (empty($tripIdNo) || empty($fleetId) || empty($newSeats)) {
            return false;
        }

        //---------------fleet seats----------------
        $fleetSeats = $this->db->select("
                total_seat, seat_numbers,fleet_facilities
            ")->from("fleet_type")
            ->where('id', $fleetId)
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


    /*
    |____________________________________________________________________
    |  
    | Validate input 
    |____________________________________________________________________
    |--------------------------------------------------------------------
    | tracking seats, price and offer
    |----------------------------------------------
    */

    public function checkout()
    {
        #--------------------------------------
        $this->form_validation->set_rules('booking_id_no', display('booking_id_no'), 'required|max_length[30]');
        $this->form_validation->set_rules('hdn_passenger_id', display('hdn_passenger_id'), 'required|max_length[30]');
        $this->form_validation->set_rules('passenger_id_no', display('passenger_id_no'), 'required|max_length[30]');
        $this->form_validation->set_rules('firstname', display('firstname'), 'required|max_length[50]');
        $this->form_validation->set_rules('lastname', display('lastname'), 'required|max_length[50]');
        $this->form_validation->set_rules('phone', display('phone'), 'required|max_length[20]');
        $this->form_validation->set_rules('email', display('email'), 'required|valid_email|max_length[100]');
        $this->form_validation->set_rules('password', display('password'), 'max_length[100]');
        $this->form_validation->set_rules('address_line_1', display('address'), 'max_length[255]');
        $password = (!empty($this->input->post('old_password')) ? $this->input->post('old_password') : md5($this->input->post('password')));

        $passenger_id = $this->input->post('hdn_passenger_id');
        $nid = $this->input->post('p_nid');
        #--------------------------------------
        $postData = array(
            'id_no' => $passenger_id,
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'password' => $password,
            'phone' => $this->input->post('phone'),
            'address_line_1' => $this->input->post('address_line_1'),
            'status' => 1,
            'nid' => $nid,
        );

        $bankdata = array(
            'booking_id' => $this->input->post('booking_id_no', true),
            'bank_id' => $this->input->post('bank_id', true),
            'payer_name' => $passenger_id,
            'transaction_id' => $this->input->post('tran_num', true),
            'b_account_no' => 0,
            'amount' => $this->input->post('amount', true),
            'note' => 'bank booking'
        );

        $data['booking'] = $binfo = $this->db->select("
                            bh.*,
                            tr.name AS route_name,
                            DATE_FORMAT(bh.booking_date, '%m/%d/%Y %h:%i %p') AS booking_date
                        ")
            ->from('ws_booking_history AS bh')
            ->join('trip_route AS tr', 'tr.id = bh.trip_route_id')
            ->where('id_no', $this->input->post('booking_id_no'))
            ->get()
            ->row();
        $data['firstname'] = $this->input->post('firstname');
        $data['lastname'] = $this->input->post('lastname');
        $data['email'] = $this->input->post('email');
        $data['address'] = $this->input->post('address_line_1');
        $data['mobile'] = $this->input->post('phone');
        $data['booking_id'] = $this->input->post('booking_id_no', true);
        $total_amnt = $binfo->price;
        $comission = $this->db->select('*')->from('ws_setting')->get()->row();
        $data['b_commission'] = ($binfo->price * $comission->bank_commission) / 100;
        $data['commission_per'] = $comission->bank_commission;
        $data['routePrice'] = $routePrices = $this->db->select('*')->from('pri_price')->where('route_id', $binfo->trip_route_id)->get()->row();


        // echo "<pre>";
        // print_r($bankdata);
        // print_r($postData);
        // print_r($data);
        // die();

        #--------------------------------------
        if ($this->form_validation->run()) {
            if ($this->website_model->email_check($this->input->post('email'))) {

                if ($this->website_model->createPassenger($postData)) {
                    if (!empty($this->input->post('tran_num', true))) {

                        $this->db->insert('bank_transaction', $bankdata);
                    }

                    $data['status'] = true;

                    $data['booking_id_no'] = $this->input->post('booking_id_no', true);
//                    $data['payment'] = $this->load->view($this->active_theme.'/pages/payment_confirm', $data, true);
                    $data['success'] = display('save_successfully');

                    // $data['appSetting']        = $this->website_model->read_setting();
                    // $data['languageList']      = $this->languageList();
                    // $data['module'] = "website";
                    // $data['page']   = $this->active_theme."/booking/payment_confirm";

                    // $data['title'] = "Check Out";
                    // $data['status']  = true;
                    // $data['message'] = display('save_successfully');

                    // $this->load->view($this->active_theme."/layout", $data);

                } else {
                    $data['status'] = false;
                    $data['exception'] = display('please_try_again');
                }

            } else {
                $data['status'] = false;
                $data['exception'] = 'Email already exist,Please login';
            }

        } else {
            $data['status'] = false;
            $data['exception'] = validation_errors();
        }

        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "/booking/payment_confirm";
        $data['bank'] = $this->db->select('*')
            ->from('bank_info')
            ->get()
            ->result();

        $data['title'] = "Check Out";
        $data['status'] = true;
        $data['message'] = display('save_successfully');

        // echo "<pre>";
        // print_r($data);
        // die();

        $this->load->view($this->active_theme . "/layout", $data);

        #--------------------------------------

//        echo json_encode($data);

    }

    public function findBookingInformation()
    {
        #--------------------------------------------------------
        $trip_route_id = $this->input->post('trip_route_id');
        $trip_id_no = $this->input->post('trip_id_no');
//    	$fleet_registration_id = $this->input->post('fleet_registration_id');
        $fleet_type_id = $this->input->post('fleet_type_id');
        $booking_date = $this->input->post('booking_date');

        #--------------------------------------------------------
        $currency = $this->website_model->retrieve_currency();
        $data['trip_id_no'] = $trip_id_no;
        $data['trip_route_id'] = $trip_route_id;
//        $data['fleet_registration_id'] = $fleet_registration_id;
        $data['fleet_type_id'] = $fleet_type_id;
        $data['booking_date'] = $booking_date;

        $pricess = $this->db->select('*')->from('pri_price')->where('route_id', $trip_route_id)->where(' vehicle_type_id', $fleet_type_id)->get()->row();

        if (isset($pricess)) {

            $data['status'] = true;


            $data['child_pric'] = 'Children - ' . $pricess->children_price . $currency->currency . ', Adult -' . $pricess->price . $currency->currency . ', Special-' . $pricess->special_price . $currency->currency;

            $data['bankinfo'] = $this->db->select('*')->from('bank_info')->get()->result();


            #---------BOOKED SEAT(S)-----------#
            $bookedSeats = $this->db->select("
                tb.trip_id_no,
                SUM(tb.total_seat) AS booked_seats,
                GROUP_CONCAT(tb.seat_numbers SEPARATOR ', ') AS booked_serial 
            ")
                ->from('tkt_booking AS tb')
                ->where('tb.trip_id_no', $trip_id_no)
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

            #---------FLEET SEAT(S)-----------#
            $fleetSeats = $this->db->select("
                total_seat, seat_numbers,fleet_facilities 
            ")->from("fleet_type")
                ->where('id', $fleet_type_id)
                ->get()
                ->row();
            $seatArray = array();
            $seatArray = array_map('trim', explode(',', $fleetSeats->seat_numbers));
            $layoutset = $this->db->select("*")->from("fleet_type")
                ->where('id', $fleet_type_id)
                ->get()
                ->result();

            foreach ($layoutset as $lay) {

            }
            $seatlayout = $lay->layout;
            $data['seats'] = "<h4 class=\"text-primary text-center\">Click on Seat to select / deselect</h4>";

            $rowSeat = 1;
            $totalSeats = 1;
            $lastSeats = ((sizeof($seatArray) >= 3) ? (sizeof($seatArray) - 5) : sizeof($seatArray));
            if ($seatlayout == '3-2') {
                foreach ($seatArray as $seat) {

                    if ($rowSeat == 1) {
                        $data['seats'] .= "<div class=\"row\">";
                    }

                    $data['seats'] .= "<div class=\"col-xs-2\">
                <div class='" . (in_array($seat, $bookArray) ? ("seat ladies") : ("seat occupied ChooseSeat")) . "' data-item=\"\">
                <div class=\"seat-body\">
                    $seat
                    <span class=\"seat-handle-left\"></span>
                    <span class=\"seat-handle-right\"></span>
                    <span class=\"seat-bottom\"></span>
                </div>
                </div>
            </div> ";

                    if ($rowSeat == 3) {
                        //adding a cental row
                        if ((count($seatArray) & 0) == 2 && ($lastSeats == 0 || $lastSeats < $totalSeats)) {
                            continue;
                        } else {
                            $data['seats'] .= "<div class=\"col-xs-2\">&nbsp;</div>";
                        }
                    } else if ($rowSeat == 5 || $rowSeat == count($seatArray)) {
                        //ends of each row
                        $data['seats'] .= "</div>";
                        $rowSeat = 0;
                    }

                    $rowSeat++;
                    $totalSeats++;

                }
            } else if ($seatlayout == '2-3') {
                foreach ($seatArray as $seat) {

                    if ($rowSeat == 1) {
                        $data['seats'] .= "<div class=\"row\">";
                    }

                    $data['seats'] .= "<div class=\"col-xs-2\">
                <div class='" . (in_array($seat, $bookArray) ? ("seat ladies") : ("seat occupied ChooseSeat")) . "' data-item=\"\">
                <div class=\"seat-body\">
                    $seat
                    <span class=\"seat-handle-left\"></span>
                    <span class=\"seat-handle-right\"></span>
                    <span class=\"seat-bottom\"></span>
                </div>
                </div>
            </div> ";

                    if ($rowSeat == 2) {
                        //adding a cental row
                        if ((count($seatArray) & 0) == 2 && ($lastSeats == 0 || $lastSeats < $totalSeats)) {
                            continue;
                        } else {
                            $data['seats'] .= "<div class=\"col-xs-2\">&nbsp;</div>";
                        }
                    } else if ($rowSeat == 5 || $rowSeat == count($seatArray)) {
                        //ends of each row
                        $data['seats'] .= "</div>";
                        $rowSeat = 0;
                    }

                    $rowSeat++;
                    $totalSeats++;

                }
            } else if ($seatlayout == '2-2') {
                foreach ($seatArray as $seat) {

                    if ($rowSeat == 1) {
                        $data['seats'] .= "<div class=\"row\">";
                    }

                    $data['seats'] .= "<div class=\"col-xs-2\">
                <div class='" . (in_array($seat, $bookArray) ? ("seat ladies") : ("seat occupied ChooseSeat")) . "' data-item=\"\">
                <div class=\"seat-body\">
                    $seat
                    <span class=\"seat-handle-left\"></span>
                    <span class=\"seat-handle-right\"></span>
                    <span class=\"seat-bottom\"></span>
                </div>
                </div>
            </div> ";

                    if ($rowSeat == 2) {
                        //adding a cental row
                        if ((sizeof($seatArray) & 0) == 2 && ($lastSeats == 0 || $lastSeats < $totalSeats)) {
                            continue;
                        } else {
                            $data['seats'] .= "<div class=\"col-xs-2\">&nbsp;</div>";
                        }
                    } else if ($rowSeat == 4 || $rowSeat == sizeof($seatArray)) {
                        //ends of each row
                        $data['seats'] .= "</div>";
                        $rowSeat = 0;
                    }

                    $rowSeat++;
                    $totalSeats++;

                }
            } else if ($seatlayout == '1-1') {
                foreach ($seatArray as $seat) {

                    if ($rowSeat == 1) {
                        $data['seats'] .= "<div class=\"row\">";
                    }

                    $data['seats'] .= "<div class=\"col-xs-2\">
                <div class='" . (in_array($seat, $bookArray) ? ("seat ladies") : ("seat occupied ChooseSeat")) . "' data-item=\"\">
                <div class=\"seat-body\">
                    $seat
                    <span class=\"seat-handle-left\"></span>
                    <span class=\"seat-handle-right\"></span>
                    <span class=\"seat-bottom\"></span>
                </div>
                </div>
            </div> ";

                    if ($rowSeat == 1) {
                        //adding a cental row
                        if ((sizeof($seatArray) & 0) == 2 && ($lastSeats == 0 || $lastSeats < $totalSeats)) {
                            continue;
                        } else {
                            $data['seats'] .= "<div class=\"col-xs-2\">&nbsp;</div>";
                        }
                    } else if ($rowSeat == 2 || $rowSeat == sizeof($seatArray)) {
                        //ends of each row
                        $data['seats'] .= "</div>";
                        $rowSeat = 0;
                    }

                    $rowSeat++;
                    $totalSeats++;

                }
            } else if ($seatlayout == '2-1') {
                foreach ($seatArray as $seat) {

                    if ($rowSeat == 1) {
                        $data['seats'] .= "<div class=\"row\">";
                    }

                    $data['seats'] .= "<div class=\"col-xs-2\">
                <div class='" . (in_array($seat, $bookArray) ? ("seat ladies") : ("seat occupied ChooseSeat")) . "' data-item=\"\">
                <div class=\"seat-body\">
                    $seat
                    <span class=\"seat-handle-left\"></span>
                    <span class=\"seat-handle-right\"></span>
                    <span class=\"seat-bottom\"></span>
                </div>
                </div>
            </div> ";

                    if ($rowSeat == 2) {
                        //adding a cental row
                        if ((sizeof($seatArray) & 0) == 2 && ($lastSeats == 0 || $lastSeats < $totalSeats)) {
                            continue;
                        } else {
                            $data['seats'] .= "<div class=\"col-xs-2\">&nbsp;</div>";
                        }
                    } else if ($rowSeat == 3 || $rowSeat == sizeof($seatArray)) {
                        //ends of each row
                        $data['seats'] .= "</div>";
                        $rowSeat = 0;
                    }

                    $rowSeat++;
                    $totalSeats++;

                }
            } else {
                foreach ($seatArray as $seat) {

                    if ($rowSeat == 1) {
                        $data['seats'] .= "<div class=\"row\">";
                    }

                    $data['seats'] .= "<div class=\"col-xs-2\">
                <div class='" . (in_array($seat, $bookArray) ? ("seat ladies") : ("seat occupied ChooseSeat")) . "' data-item=\"\">
                <div class=\"seat-body\">
                    $seat
                    <span class=\"seat-handle-left\"></span>
                    <span class=\"seat-handle-right\"></span>
                    <span class=\"seat-bottom\"></span>
                </div>
                </div>
            </div> ";

                    if ($rowSeat == 1) {
                        //adding a cental row
                        if ((sizeof($seatArray) & 0) == 2 && ($lastSeats == 0 || $lastSeats < $totalSeats)) {
                            continue;
                        } else {
                            $data['seats'] .= "<div class=\"col-xs-2\">&nbsp;</div>";
                        }
                    } else if ($rowSeat == 3 || $rowSeat == sizeof($seatArray)) {
                        //ends of each row
                        $data['seats'] .= "</div>";
                        $rowSeat = 0;
                    }

                    $rowSeat++;
                    $totalSeats++;

                }
            }


            #--------- FACILITIES -----------#
            $facilitiesArray = array();
            $facilitiesArray = array_map('trim', explode(',', $fleetSeats->fleet_facilities));

            $data['facilities'] = "";
            if (sizeof($facilitiesArray) > 0) {
                foreach ($facilitiesArray as $key => $fa) {
                    if ($fa != "")
                        $data['facilities'] .= "<input id=\"f$key\" name=\"request_facilities[]\" class=\"inline-checkbox\" type=\"checkbox\" value=\"$fa\"> <label for=\"f$key\">$fa</label> ";
                }
            }

            #--------- LOCATION -----------#
            $tripLocation = $this->db->select('stoppage_points')
                ->from('trip_route')
                ->where('id', $trip_route_id)
                ->get()
                ->row();

            $locationArray = array();
            $bingo = array();
            $locationArray = array_map('trim', explode(',', $tripLocation->stoppage_points));
            // $data['select_l'] = "Select Location";
            $data['location'] = "";
            $data['location'] .= "<option value=''>Please Select</option>";
            $x = 0;
            foreach ($locationArray as $lx) {
                $lx = (object)$this->website_model->location_name($lx);

                $data['location'] .= "<option value=" . $lx->id . ">$lx->name</option>";
                // $bingo = $this->website_model->location_name($lx);

            }

            echo json_encode($data);

        } else {
            $data1['status'] = false;
            $data1['message'] = "Without the price has been set by the administration, you can not book a ticket.";

            echo json_encode($data1);

        }
        // echo json_encode($data);


    }

    public function findPriceBySeat()
    {
        $trip_route_id = $this->input->post('trip_route_id', true);
        $fleet_type_id = $this->input->post('fleet_type_id', true);
        $requestSeat = (int)$this->input->post('total_seat', true);
        $child = (int)$this->input->post('child', true);
        $adult = (int)$this->input->post('adult', true);
        $special = (int)$this->input->post('special', true);
        //---------------price---------------------
        $tripPrice = $this->db->select("*")
            ->from('pri_price')
            ->where('route_id', $trip_route_id)
            ->where('vehicle_type_id', $fleet_type_id)
            ->order_by('group_size', 'desc')
            ->order_by('price', 'desc')
            ->get()
            ->result();

        if (sizeof($tripPrice) > 0) {

            $maxGroup = 0;
            $maxGroupPrice = 0;
            $total_childgprice = 0;
            $total_specialgprice = 0;
            foreach ($tripPrice as $value) {

                $singlePrice = $value->price;
                $groupSeat = $value->group_size;
                $groupPrice = $value->group_price_per_person;
                $childprice = $value->children_price;
                $specialprice = $value->special_price;
                $price = 0;
                $total = 0;
                $total_specialprice = 0;
                $total_childprice = 0;
                $total_price = 0;
                if ($requestSeat < $groupSeat || $groupSeat < 1) {
                    $total = ($adult * $singlePrice);
                    $total_childprice = ((int)$child * $childprice);
                    $total_specialprice = ((int)$specialprice * (int)$special);
                    $data['status'] = true;
                    $data['price'] = '--';
                    $data['pricechild'] = $total_childprice;
                    $data['priceadult'] = $total;
                    $data['pricespecial'] = $total_specialprice;
                    $data['total'] = $total + $total_childprice + $total_specialprice;

                } else if ($requestSeat >= $groupSeat) {

                    if ($maxGroup < $groupSeat) {
                        $maxGroup = $groupSeat;
                        $maxGroupPrice = $groupPrice;
                    }

                    $total = ($adult * $maxGroupPrice);
                    $total_childgprice = ($child * $maxGroupPrice);
                    $total_specialgprice = ($special * $maxGroupPrice);
                    $data['status'] = true;
                    $data['price'] = $maxGroupPrice;
                    $data['pricechild'] = $total_childgprice;
                    $data['priceadult'] = $total;
                    $data['pricespecial'] = $total_specialgprice;
                    $data['total'] = $total + $total_childgprice + $total_specialgprice;

                } else {

                    $data['status'] = false;
                    $data['price'] = $price;
                    $data['total'] = $total;
                }

            }

        } else {
            $data['status'] = false;
            $data['exception'] = "Price not found!";
        }

        echo json_encode($data);
    }

    /*Booking cancel automaticallay
       |
       */

    public function findOfferByCode()
    {
        $checkOffer = array();
        $offer_code = $this->input->post('offer_code', true);
        $trip_route_id = $this->input->post('trip_route_id', true);
        $booking_date = date("Y-m-d H:i:s", strtotime($this->input->post('booking_date')));

        $checkOffer = $this->db->select("
                of.offer_name,
                of.offer_end_date,
                of.offer_number,
                of.offer_discount 
            ")->from("ofr_offer AS of")
            ->where("of.offer_code", $offer_code)
            ->where("of.offer_route_id", $trip_route_id)
            ->where("of.offer_start_date <=", $booking_date)
            ->where("of.offer_end_date   >=", $booking_date)
            ->get()
            ->row();

        // echo "<pre>";
        // print_r($checkOffer);
        // exit();

        $bookingOffer = 0;
        $bookingOffer = $this->db->select("COUNT(id) AS booked_offer")
            ->from('tkt_booking')
            ->where('offer_code', $offer_code)
            ->group_start()
            ->where("tkt_refund_id IS NULL", null, false)
            ->or_where("tkt_refund_id", 0)
            ->or_where("tkt_refund_id", null)
            ->group_end()
            ->get()
            ->row()
            ->booked_offer;

        $data = array();
        if (isset($checkOffer)) {
            if (($checkOffer->offer_number - $bookingOffer) > 0) {
                $data['status'] = true;
                $data['message'] = "The $checkOffer->offer_name offer will be expired on $checkOffer->offer_end_date ";
                $data['discount'] = $checkOffer->offer_discount;

            } else {
                $data['status'] = false;
                $data['message'] = "No more offer available!";
            }
        } else {
            $data['status'] = false;
            $data['message'] = "No offer found!";
        }

        echo json_encode($data);
    }

    public function bank_booking()
    {
        #--------------------------------------
        $this->form_validation->set_rules('bank_id', display('bank_id'), 'required|max_length[50]');
        $this->form_validation->set_rules('tran_num', display('tran_num'), 'required|max_length[30]');

        // test part
        $bankdata = array(
            'booking_id' => $this->input->post('booking_id_no', true),
            'bank_id' => $this->input->post('bank_id', true),
            'payer_name' => $this->input->post('passenger_id_no', true),
            'transaction_id' => $this->input->post('tran_num', true),
            'b_account_no' => 0,
            'amount' => $this->input->post('amount', true),
            'note' => 'bank booking'
        );

        #--------------------------------------
        if ($this->form_validation->run()) {


            if ($this->website_model->createbanktransaction($bankdata)) {
                $data['status'] = true;
                $data['booking_id_no'] = $this->input->post('booking_id_no', true);
                $data['success'] = display('save_successfully');
                // window.location.href = 'website/paypal/bank_info/'+data.booking_id_no;
                // redirect
                redirect(base_url('website/paypal/bank_info/' . $this->input->post('booking_id_no')));
            } else {
                $data['status'] = false;
                $data['exception'] = display('please_try_again');
            }

        } else {
            $data['status'] = false;
            $data['exception'] = validation_errors();
        }
        #--------------------------------------
        echo json_encode($data);
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
}
