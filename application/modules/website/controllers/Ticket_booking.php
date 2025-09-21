<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ticket_booking extends MX_Controller
{
    private $active_theme = null;

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
//        $this->autocancel();
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


    public function index()
    {
        $data['appSetting'] = $this->website_model->read_setting();

        $data['languageList'] = $this->languageList();
        #-----------------------------------
        $data['module'] = "website";
        $data['page'] = "booking/seat_booking";
        $this->load->view('layout', $data);
    }

    /*findBookingInformation*/

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

    public function findBookingInformation()
    {
        #--------------------------------------------------------
        $trip_route_id = $this->input->post('trip_route_id');

        $trip_id_no = $this->input->post('trip_id_no');

        $oldquery = $this->db->where('trip',$trip_id_no)
                    ->where('closed_by_id',0)
                        ->get('trip_assign');
                    $oldquery  = $oldquery->row();       
        $ticket_booking_trip_id_no =  $oldquery->id; 
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
                // ->where('tb.trip_id_no', $trip_id_no)
                ->where('tb.trip_id_no', $ticket_booking_trip_id_no)
                // ->like('tb.booking_date', $booking_date, 'after')
                ->like('tb.booking_date', $booking_date)
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

             // client 2022 project update
            $freezeSeat  = $this->db->select("*")->from('freeze_seat')->where('tripid',$trip_id_no)->where('status',1)->get()->result();

            foreach ($freezeSeat as $key => $value) {
                array_push($bookArray,$value->seat_number);
            }

             // client 2022 project update

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

                    $data['seats'] .= "<div class=\"col\">
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
                            $data['seats'] .= "<div class=\"col\">&nbsp;</div>";
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

                    $data['seats'] .= "<div class=\"col\">
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
                            $data['seats'] .= "<div class=\"col\">&nbsp;</div>";
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

                    $data['seats'] .= "<div class=\"col\">
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
                            $data['seats'] .= "<div class=\"col\">&nbsp;</div>";
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

                    $data['seats'] .= "<div class=\"col\">
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
                            $data['seats'] .= "<div class=\"col\">&nbsp;</div>";
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

                    $data['seats'] .= "<div class=\"col\">
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
                            $data['seats'] .= "<div class=\"col\">&nbsp;</div>";
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

                    $data['seats'] .= "<div class=\"col\">
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
                            $data['seats'] .= "<div class=\"col\">&nbsp;</div>";
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

//            $data;

            $data['appSetting'] = $this->website_model->read_setting();

            $data['languageList'] = $this->languageList();
            #-----------------------------------
            $data['module'] = "website";
           
            $data['page'] = $this->active_theme . "/booking/seat_booking";

//            echo "<pre>";
//            print_r($data);
//            exit();
            
            $this->load->view($this->active_theme . '/layout', $data);

        } else {
            $data1['status'] = false;
            $data1['message'] = "Without the price has been set by the administration, you can not book a ticket.";
            $data1['appSetting'] = $this->website_model->read_setting();

            $data1['languageList'] = $this->languageList();
            #-----------------------------------
            $data1['module'] = "website";
           
            $data1['page'] = $this->active_theme . "/booking/seat_booking";

            $this->load->view('layout', $data1);
        }


    }
}