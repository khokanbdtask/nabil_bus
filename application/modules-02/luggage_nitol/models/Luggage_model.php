<?php defined('BASEPATH') or exit('No direct script access allowed');

class Luggage_model extends CI_Model
{

    private $table = "luggage_booking";


    public function create($data = [])
    {
        return $this->db->insert($this->table, $data);
    }


    public function read($limit = null, $start = null)
    {
        // New code 2021 direct update 
        if ($this->session->userdata('isAdmin') == 0) {
            $agentdetail = $this->db->where('agent_email', $this->session->userdata('email'))->get('agent_info')->row();
        }
        // New code 2021 direct update 

        $this->db->select('lb.*, tr.name AS route_name, pk.package_name AS package_name');
        $this->db->from('luggage_booking AS lb');
        $this->db->join("trip_route AS tr", "tr.id = lb.trip_route_id", "left");
        $this->db->join('package AS pk', 'pk.package_id = lb.package_id','left');
// New code 2021 direct update 
        if ($this->session->userdata('isAdmin') == 0) {
            $this->db->where('lb.booked_by', $this->session->userdata('id'))
            ->or_where('lb.drop_trip_location', $agentdetail->locationid);
        }

        if(!(empty($this->input->post('datefrom'))) && !(empty($this->input->post('dateto'))))
        {
            $datefrom = date("Y-m-d", strtotime($this->input->post('datefrom')));
            $dateto = date("Y-m-d", strtotime($this->input->post('dateto')));
            $this->db->where('DATE(lb.create_date) >=', $datefrom);
            $this->db->where('DATE(lb.create_date) <=', $dateto);
            
        }
// New code 2021 direct update 
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

// New code 2021 direct update 
    public function partialSingleBooking($bookingid)
    {

        $this->db->select('lb.*, tr.name AS route_name, pk.package_name AS package_name');
        $this->db->from('luggage_booking AS lb');
        $this->db->join("trip_route AS tr", "tr.id = lb.trip_route_id", "left");
        $this->db->join('package AS pk', 'pk.package_id = lb.package_id','left');
      
        $this->db->where('lb.id_no',$bookingid);
        // $this->db->where('lb.payment_status','partial');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

// New code 2021 direct update 





    public function findById($id_no = null)
    {
        return $this->db->select("
				tb.*, 
				tr.name AS route_name, 
				tp.image, 
				trf.cancelation_fees, 
				trf.causes, 
				CONCAT_WS(' ', u.firstname, u.lastname) AS refund_by

			")->from("luggage_booking AS tb")
            ->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left")
            ->join("tkt_passenger AS tp", "tp.id_no = tb.tkt_passenger_id_no", "left")
            ->join('tkt_refund AS trf', 'trf.luggage_booking_id_no = tb.id_no', "left")
            ->join('user AS u', 'u.id = trf.refund_by_id', "left")
            ->where('tb.id_no', $id_no)
            ->limit($limit, $start)
            ->get()
            ->row();
    }

    public function fleetWeightCheck($fleetTp)
    {
        // Find Fleet Weight
        return $this->db->select("*")
            ->from("fleet_type")
            ->where('id', $fleetTp)
            ->get()
            ->row();
    }

    public function facilities($fleetTp)
    {
        // Find Fleet Facilities
        return $this->db->select("fleet_facilities")
            ->from("fleet_type")
            ->where('id', $fleetTp)
            ->get()
            ->row()
            ->fleet_facilities;
    }

    public function ticket($id_no = null)
    {
        // return booking data
        return $this->db->select("
                lb.*,
                DATE_FORMAT(lb.booking_date, '%m/%d/%Y') as booking_date,
                tr.name AS route_name,
                pk.package_name AS package_name,
                trass.id_no AS trip_assing_idno

                
            ")
            ->from('luggage_booking AS lb')
            ->join('trip_route AS tr', 'tr.id = lb.trip_route_id', 'left')
            ->join('trip_assign AS trass', 'trass.id = lb.trip_id_no', 'left')
            ->join('package AS pk', 'pk.package_id = lb.package_id','left')
            ->where('lb.id_no', $id_no)
            ->get()
            ->row();
    }

    public function passanger_by_id($id_no='')
    {
        return $this->db->select('*, 
            CONCAT_WS(" ", firstname, lastname) AS passenger_name , 
            CONCAT_WS(" , ", address_line_1, address_line_2, city, zip_code) AS passenger_address ')
                        ->from('tkt_passenger')
                        ->where('id_no', $id_no)
                        ->get()
                        ->row();
    }




    public function website_setting()
    {
        return $this->db->get('ws_setting')->row();
    }


    public function update($data = [])
    {
        return $this->db->where('id_no', $data['id_no'])
            ->update($this->table, $data);
    }


    public function delete($id = null)
    {
        $this->db->where('id', $id)
            ->delete($this->table);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function location_dropdown()
    {
        $data = $this->db->select("*")
            ->from("trip_location")
            ->where('status', 1)
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        $list[''] = display('select_option');
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->id] = $value->name;
            return $list;
        } else {
            return false;
        }
    }

    public function packages_dropdown()
    {
        $data = $this->db->select("*")
            ->from("package")
            ->where('delete_status', 0)
            ->order_by('name', 'DESC')
            ->get()
            ->result();

        $list[''] = display('select_option');
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->id] = $value->name;
            return $list;
        } else {
            return false;
        }
    }

    public function route_dropdown()
    {
        $data = $this->db->select("*")
            ->from("trip_route")
            ->where('status', 1)
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        $list[''] = display('select_option');
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->id] = $value->name;
            return $list;
        } else {
            return false;
        }
    }

    public function facilities_dropdown()
    {
        $data = $this->db->select("*")
            ->from("fleet_facilities")
            ->where('status', 1)
            ->order_by('name', 'ASC')
            ->get()
            ->result();

        $list = array('' => 'Select One...');
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->id] = $value->name;
            return $list;
        } else {
            return false;
        }
    }

    public function assigned_trips($id_no, $date)
    {
        return $this->db->select("lb.package_id AS package_id")
            ->from("luggage_booking AS lb")
            ->where('lb.trip_id_no', $id_no)
            ->like('lb.booking_date', $date, 'after')
            ->group_start()
            ->where("lb.luggage_refund_id IS NULL", null, false)
            ->or_where("lb.luggage_refund_id", 0)
            ->or_where("lb.luggage_refund_id", null)
            ->group_end()
            ->get()
            ->row()
            ->package_id;
    }

    public function trip_result($routeID, $type, $date)
    {
        return $this->db->query("
            SELECT 
            tas.`id` AS id,
            
            tas.`assign_time` AS assigntime,

            ta.`trip_id` AS id_no, 
            ft.`total_weight`,
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
    }


    public function luggage_prices($package_id)
    {
        $prices = $this->db->SELECT('*')
            ->from('package')
            ->where('package_id', $package_id)
            ->get()
            ->row();
        return $prices;
    }

    public function checkOffer($offerCode, $offerRouteId, $tripDate)
    {
        // Code Here
        return $this->db->select("*")
            ->from("ofr_offer AS of")
            ->where("of.offer_code", $offerCode)
            ->where("of.offer_route_id", $offerRouteId)
            ->where("of.offer_start_date <=", $tripDate)
            ->where("of.offer_end_date   >=", $tripDate)
            ->get()
            ->row();
    }

    public function bookingOffer($offerCode)
    {
        // Code Here
        return $this->db->select("COUNT(id) AS booked_offer")
            ->from('luggage_booking')
            ->where('offer_code', $offerCode)
            ->group_start()
            ->where("luggage_refund_id IS NULL", null, false)
            ->or_where("luggage_refund_id", 0)
            ->or_where("luggage_refund_id", null)
            ->group_end()
            ->get()
            ->row()
            ->booked_offer;
    }

// paid information
    public function ticket_paid($id_no = null)
    {

        // return booking data
        return $this->db->select("*")
            ->from('luggage_booking')
            ->where('id_no', $id_no)
            ->get()
            ->result();
    }


        public function ticket_payment_update($id_no = null)
    {

        // return booking data
        return $this->db->select("*")
            ->from('luggage_booking')
            ->where('id_no', $id_no)
            ->get()
            ->result();
    }

    public function confirmation()
    {
        return $this->db->select("btr.*,btr.id as ids, lb.*, lb.id AS luggage_booking_id")
            ->from("luggage_booking AS lb")
            ->join("bank_transaction AS btr", "btr.booking_id = lb.id_no", "left")
            ->where('lb.delete_status',0)
            ->where('btr.booking_id = lb.id_no')
            ->order_by('btr.booking_id', 'desc')
            ->get()
            ->result();
    }


    public function upaid_cash_bookig()
    {
        return $this->db->select("tb.*, tr.name AS route_name, pk.package_name AS package")
            ->from("luggage_booking AS tb")
            ->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left")
            ->join('package AS pk', 'pk.package_id = tb.package_id','left')
            ->where('tb.payment_status', 1)
            ->order_by('id', 'desc')
            ->get()
            ->result();
    }


    // confirmation delete
    public function confirmation_delete($id = null)
    {
        $this->db->where('id', $id)
            ->delete('bank_transaction');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

// terms and condition  info
    public function terms_and_cond_data($id = null)
    {

        // return booking data
        return $this->db->select("*")
            ->from('payment_informations')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function term_and_condition_list()
    {
        return $terms = $this->db->select('*')
            ->from('payment_informations')
            ->get()
            ->result();
    }

    // terms delete
    public function terms_delete($id = null)
    {
        $this->db->where('id', $id)
            ->delete('payment_informations');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

// update terms and condition
    public function update_condition($data = [])
    {
        return $this->db->where('id', $data['id'])
            ->update('payment_informations', $data);
    }

    //create_terms
    public function create_terms($data = [])
    {
        return $this->db->insert('payment_informations', $data);
    }

    public function fleet_dropdown()
    {
        $data = $this->db->select("*")
            ->from("fleet_type")
            ->where('status', 1)
            ->where('luggage_service', 1)
            ->get()
            ->result();

        $list = array('' => 'Select One...');
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->id] = $value->type;
        }
        return $list;
    }

    public function count_ticket()
    {
        // New code 2021 direct update 
            if ($this->session->userdata('isAdmin') == 0) {
                $agentdetail = $this->db->where('agent_email', $this->session->userdata('email'))->get('agent_info')->row();
            }
         // New code 2021 direct update 
        $this->db->select('*');
        $this->db->from('luggage_booking');
        // New code 2021 direct update 
        if ($this->session->userdata('isAdmin') == 0) {
            $this->db->where('booked_by', $this->session->userdata('id'))
            ->or_where('drop_trip_location', $agentdetail->locationid);
        }
        // New code 2021 direct update 
       $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

// New code 2021 direct update 
    public function bookingCount($bookingid)
    {
        $this->db->select('*');
        $this->db->from('luggage_booking');
        $this->db->where('id_no',$bookingid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

// New code 2021 direct update 


    public function loc_names($id = null)
    {
        return $this->db->select("name, id")
            ->from('trip_location')
            ->where('id', $id)
            ->get()
            ->result();
    }

    public function location_id_name($id = null)
    {
        return $this->db->select("name")
            ->from('trip_location')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row();
    }

    // New code 2021 direct update 
    public function luggage_report($datefrom = "", $dateto = "", $ftypes = "", $route_id = "",$payment_status = "",$agent_id = "")
    // New code 2021 direct update 
    {
       
        if (empty($ftypes) && !empty($route_id)) {

            
            $this->db->select("luggage_booking.*, trip_route.name AS route_name, package.package_name AS package_name");
            $this->db->from('luggage_booking');
            $this->db->join("trip_route", "trip_route.id = luggage_booking.trip_route_id", "left");
            $this->db->join('package', 'package.package_id = luggage_booking.package_id','left');
            $this->db->where('luggage_booking.trip_route_id', $route_id);
            if (!empty($payment_status)){
                $this->db->where('luggage_booking.payment_status', $payment_status);
            }
            // New code 2021 direct update 
            if (!empty($agent_id)){
                $this->db->where('luggage_booking.booked_by', $agent_id);
             }
           // New code 2021 direct update 
            $this->db->where('luggage_booking.delete_status', 0);
            $this->db->where('luggage_booking.luggage_refund_id', null);
            $this->db->where('DATE(luggage_booking.create_date) >=', $datefrom);
            $this->db->where('DATE(luggage_booking.create_date) <=', $dateto);
            $query = $this->db->get();
            return $query->result();

        }else if (empty($route_id) && !empty($ftypes)) {

            $this->db->select("luggage_booking.*, trip_route.name AS route_name, package.package_name AS package_name");
            $this->db->from('luggage_booking');
            $this->db->join("trip_route", "trip_route.id = luggage_booking.trip_route_id", "left");
            $this->db->join('package', 'package.package_id = luggage_booking.package_id','left');
            $this->db->where('luggage_booking.ftypes', $ftypes);
            if (!empty($payment_status)){
                $this->db->where('luggage_booking.payment_status', $payment_status);
            }
             // New code 2021 direct update 
             if (!empty($agent_id)){
                $this->db->where('luggage_booking.booked_by', $agent_id);
            }
            // New code 2021 direct update 
            $this->db->where('luggage_booking.delete_status', 0);
            $this->db->where('luggage_booking.luggage_refund_id', null);
            $this->db->where('DATE(luggage_booking.create_date) >=', $datefrom);
            $this->db->where('DATE(luggage_booking.create_date) <=', $dateto);
            $query = $this->db->get();
            return $query->result();

        }else if(empty($ftypes) && empty($route_id)) {

           
              
                $this->db->select("luggage_booking.*, trip_route.name AS route_name, package.package_name AS package_name");
                $this->db->from('luggage_booking');
                $this->db->join("trip_route", "trip_route.id = luggage_booking.trip_route_id", "left");
                $this->db->join('package', 'package.package_id = luggage_booking.package_id','left');
                if (!empty($payment_status)){
                    $this->db->where('luggage_booking.payment_status', $payment_status);
                }
                 
                // New code 2021 direct update 
                    if (!empty($agent_id)){
                        $this->db->where('luggage_booking.booked_by', $agent_id);
                    }
                // New code 2021 direct update 
                $this->db->where('luggage_booking.delete_status', 0);
                $this->db->where('luggage_booking.luggage_refund_id', null);
                $this->db->where('DATE(luggage_booking.create_date) >=', $datefrom);
                $this->db->where('DATE(luggage_booking.create_date) <=', $dateto);
                $query = $this->db->get();

                
                return $query->result();

        } else {

            $this->db->select("luggage_booking.*, trip_route.name AS route_name, package.package_name AS package_name");
            $this->db->from('luggage_booking');
            $this->db->join("trip_route", "trip_route.id = luggage_booking.trip_route_id", "left");
            $this->db->join('package', 'package.package_id = luggage_booking.package_id','left');
            $this->db->where('luggage_booking.ftypes', $ftypes);
            $this->db->where('luggage_booking.trip_route_id', $route_id);
            if (!empty($payment_status)){
                $this->db->where('luggage_booking.payment_status', $payment_status);
            }
             // New code 2021 direct update 
             if (!empty($agent_id)){
                $this->db->where('luggage_booking.booked_by', $agent_id);
            }
            // New code 2021 direct update 
            $this->db->where('luggage_booking.delete_status', 0);
            $this->db->where('luggage_booking.luggage_refund_id', null);
            $this->db->where('DATE(luggage_booking.create_date) >=', $datefrom);
            $this->db->where('DATE(luggage_booking.create_date) <=', $dateto);
            $query = $this->db->get();
            return $query->result();

        }
        
    }

 // New code 2021 direct update 


    public function tax()
    {
        # code...
        return $this->db->select('*')
                        ->from('tax_settings')
                        ->get()
                        ->result_array();
    }


    // New code 2021 direct update 
    public function agent_list()
    {
        $this->db->select('*');
        $this->db->from('agent_info');
        if ($this->session->userdata('isAdmin') == 0) {
            $this->db->where('agent_email', $this->session->userdata('email'));
        }
        $query = $this->db->get();
        $data = $query->result();
        $list[''] = display('select_option');
        if (!empty($data)) {
            foreach ($data as $value) {
                $list[$value->agent_email] = $value->agent_first_name . ' ' . $value->agent_second_name;
            }

            return $list;
        } else {
            return false;
        }

    }
// New code 2021 direct update 

}

 