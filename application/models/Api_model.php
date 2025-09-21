<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api_model extends CI_Model
{

    public function settings_data()
    {
        return $data = $this->db->query("
            SELECT ws_setting.* ,setting.footer_text,setting.language 
            FROM ws_setting, setting
        ")->row();
    }


    public function settings()
    {
        return $data = $this->db->select('*')
            ->from('ws_setting')
            ->get()
            ->row();
    }

    /*
   |---------------------------------------------
   |All Location list
   |---------------------------------------------
   */
    public function all_location()
    {
        return $this->db->select("*")
            ->from("trip_location")
            ->where('status', 1)
            ->order_by('name', 'asc')
            ->get()
            ->result();
    }

    /*
    |--------------------------------------------------
    |All fleet list
    |--------------------------------------------------
    */
    public function all_fleet()
    {
        return $this->db->select("id,type")
            ->from("fleet_type")
            ->where('status', 1)
            ->get()
            ->result();
    }

    public function all_passenger()
    {
        return $data = $this->db->select('COUNT(id) AS total')
            ->from('tkt_passenger')
            ->get()
            ->row();
    }

    public function total_fleets()
    {
        return $data = $this->db->select('COUNT(id) AS total')
            ->from('fleet_registration')
            ->get()
            ->row();
    }

    public function all_trip()
    {
        return $data = $this->db->select('COUNT(id) AS total')
            ->from('trip_assign')
            ->where('DATE(assign_time)', date('Y-m-d'))
            ->get()
            ->row();
    }

    public function offer_image()
    {
        return $data = $this->db->order_by('position', 'asc')
            ->get('ws_offer')->result();
    }


    /*
|---------------------------------------------------
| Trip Search query
|---------------------------------------------------
*/
    public function trip_search($startpoint, $endpoint, $fleet, $date)
    {
        $result = $this->db->query("SELECT 
            ta.`trip_id` AS trip_id_no,
            ta.`route`,
            ta.`shedule_id`,
            tr.`name` AS trip_route_name, 
            tl1.`name` AS pickup_trip_location,
            tl2.`name` AS drop_trip_location,
            ta.`type`, 
            tp.`total_seat` AS fleet_seats, 
            pp.`price` AS price,
            pp.`children_price`,
            pp.`special_price`,
            tr.`approximate_time` AS duration,
            tr.`stoppage_points`,
            tr.`distance`,
            shedule.`start`,
            shedule.`end`,
            tras.`closed_by_id`
        FROM trip AS ta
        LEFT JOIN shedule ON shedule.`shedule_id` = ta.`shedule_id`
        LEFT JOIN trip_route AS tr ON tr.`id` = ta.`route`
        LEFT JOIN trip_assign AS tras ON tras.`trip` = ta.`trip_id`
        LEFT JOIN fleet_type AS tp ON tp.`id` = ta.`type`
        LEFT JOIN pri_price AS pp ON pp.`route_id` = ta.`route` AND pp.`vehicle_type_id`= ta.`type`
        LEFT JOIN trip_location AS tl1 ON tl1.`id` = tr.`start_point`
        LEFT JOIN trip_location AS tl2 ON tl2.`id` = tr.`end_point`
        WHERE (FIND_IN_SET('$startpoint',tr.`stoppage_points`))
        AND (FIND_IN_SET('$endpoint',tr.`stoppage_points`))
        AND ta.`type` = $fleet
        AND (!FIND_IN_SET(DAYOFWEEK('$date'),ta.`weekend`))
        GROUP BY ta.`trip_id`

       ")->result();
        return $result;
    }


    public function booking_result($trip_id, $date)
    {
        return $data = $this->db->select("SUM(tb.total_seat) AS available")
            ->from("tkt_booking AS tb")
            ->join('trip AS ta', "ta.trip_id = tb.trip_id_no")
            ->where('tb.trip_id_no', $trip_id)
            ->like('tb.booking_date', $date, 'after')
            ->group_start()
            ->where("tb.tkt_refund_id IS NULL", null, false)
            ->or_where("tb.tkt_refund_id", 0)
            ->or_where("tb.tkt_refund_id", null)
            ->group_end()
            ->get()
            ->row()
            ->available;
    }

    public function booked_seats($trip_id, $date)
    {
        return $data = $this->db->select("
                tb.trip_id_no,
                SUM(tb.total_seat) AS booked_seats,
                GROUP_CONCAT(tb.seat_numbers SEPARATOR ', ') AS booked_serial 
            ")
            ->from('tkt_booking AS tb')
            ->where('tb.trip_id_no', $trip_id)
            ->like('tb.booking_date', $date, 'after')
            ->group_start()
            ->where("tb.tkt_refund_id IS NULL", null, false)
            ->or_where("tb.tkt_refund_id", 0)
            ->or_where("tb.tkt_refund_id", null)
            ->group_end()
            ->get()
            ->row();
    }

    public function fleet_seats($trip_id)
    {
        return $data = $this->db->select("
                total_seat, seat_numbers,fleet_facilities,layout 
            ")->from("fleet_type")
            ->where('id', $trip_id)
            ->get()
            ->row();
    }

    public function stoppage_points($trip_id)
    {
        return $data = $this->db->select('stoppage_points')
            ->from('trip_route')
            ->where('id', $trip_id)
            ->get()
            ->row();
    }
    
    public function stoppage_points_full($trip_id)
    {
        return $this->db->query("
            SELECT
                a.stoppage_points,
                GROUP_CONCAT(b.name ORDER BY b.id) location_name
            FROM 
                trip_route a 
            INNER JOIN 
                trip_location b
                ON FIND_IN_SET(b.id, a.stoppage_points) > 0
            WHERE
                a.id = ?
            GROUP BY a.id
        ", [$trip_id])->row();
    }

    public function trip_price($route, $fleet_type)
    {
        return $data = $this->db->select("*")
            ->from('pri_price')
            ->where('route_id', $route)
            ->where('vehicle_type_id', $fleet_type)
            ->order_by('group_size', 'desc')
            ->get()
            ->row();
    }

    public function offers($trip_route_id, $offer_date)
    {
        $this->db->select("
                of.offer_code,
                of.offer_number,
                of.offer_discount 
            ")->from("ofr_offer AS of")
            ->where("of.offer_route_id", $trip_route_id)
            ->where("of.offer_start_date <=", $offer_date)
            ->where("of.offer_end_date   >=", $offer_date)
            ->get()
            ->row();
    }

    // Auth check user
    public function checkUser($data = array())
    {
        return $data = $this->db->select("*")
            ->from('tkt_passenger')
            ->where('email', $data['email'])
            ->where('password', md5($data['password']))
            ->get();
    }

    //User registration check info
    // Auth check user
    public function registration_checkUser($email)
    {
        return $data = $this->db->select("*")
            ->from('tkt_passenger')
            ->where('email', $email)
            ->get();
    }

    public function create_passenger($data = array())
    {
        $postData = array(
            'id_no' => $data['id_no'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => md5($data['password']),
            'nid' => $data['nid'],
            'phone' => $data['phone'],
            'address_line_1' => $data['address_line_1'],
            'status' => 1
        );

        return $this->db->insert('tkt_passenger', $postData);
    }

    public function paggenger_details($id)
    {
        return $data = $this->db->select('*')
            ->from('tkt_passenger')
            ->where('id_no', $id)
            ->get()
            ->row();
    }

    public function update_passenger($data = array())
    {
        return $this->db->where('id_no', $data["id_no"])
            ->update("tkt_passenger", $data);
    }

    public function bank_info()
    {
        return $data = $this->db->select('*')
            ->from('bank_info')
            ->get()
            ->result();
    }

    public function create_booking_history($data = array())
    {
        return $this->db->insert('ws_booking_history', $data);
    }

    public function CashbookingTicket($booking_id_no = null)
    {
        // return booking data
        return $this->db->select("tp.email,bh.*,
                bh.pickup_trip_location,
                bh.drop_trip_location,
                CONCAT_WS(' ', tp.firstname, tp.lastname) AS passenger_name, 
                bh.tkt_passenger_id_no AS tkt_passenger_id_no,
                bh.trip_id_no AS trip_id_no,
                bh.id_no AS booking_id_no,
                bh.booking_date,
                tr.name AS route_name,
                bh.request_facilities AS request_facilities,
                bh.price AS price,
                bh.total_seat AS quantity,
                bh.discount AS discount,
                bh.seat_numbers AS seat_serial,
                bh.adult,
                bh.child,
                bh.special 
            ")
            ->from('ws_booking_history AS bh')
            ->join('tkt_passenger AS tp', 'bh.tkt_passenger_id_no = tp.id_no', 'full')
            ->join('trip_route AS tr', 'tr.id = bh.trip_route_id', 'full')
            ->where('bh.id_no', $booking_id_no)
            ->get()
            ->row();
    }

    public function remove_existing_booking($id = null)
    {
        return $this->db->where('id_no', $id)
            ->delete("tkt_booking");
    }

    public function create_booking($data = array())
    {
        return $this->db->insert('tkt_booking', $data);
    }

    public function remove_history($id = null)
    {
        return $this->db->where('id_no', $id)
            ->delete("ws_booking_history");
    }

    public function getTicket($booking_id_no = null)
    {
        //get current booking history
        $rowData = $this->db->select('
            id_no,trip_id_no, tkt_passenger_id_no, trip_route_id, pickup_trip_location,
            drop_trip_location, request_facilities, price,
            discount, total_seat,seat_numbers,offer_code,tkt_refund_id, agent_id,
            booking_date,date,adult,child,special
        ')
            ->where('id_no', $booking_id_no)
            ->get('ws_booking_history')
            ->row();

        // if booking history available then copy to tkt_booking and delete the history
        $notice = [
            'b_idno' => $rowData->id_no,
            'passenger_id' => $rowData->tkt_passenger_id_no,
            'route_id' => $rowData->trip_route_id,
            'booking_time' => date('Y-m-d H:i:s'),
            'trip_id' => $rowData->trip_id_no,
            'no_tkts' => $rowData->total_seat,
            'amount' => $rowData->price
        ];

        $paysettings = $this->db->select('*')->from('ws_setting')->get()->row();


        if (sizeof($rowData) > 0) {
            if ($paysettings->payment_type != 'disable') {
                $this->db->insert('tkt_booking', $rowData);
                $this->db->insert('ticket_notification', $notice);

                $this->db->where('id_no', $booking_id_no)->delete('ws_booking_history');
            }
        }
    }

    public function getbookingTicket($booking_id_no = null)
    {
        $rowData = $this->db->select('
		    id_no,trip_id_no, tkt_passenger_id_no, trip_route_id, pickup_trip_location,
		    drop_trip_location, request_facilities, price,
		    discount, total_seat,seat_numbers,offer_code,tkt_refund_id, agent_id,
		    booking_date,date,adult,child,special
		')
            ->where('id_no', $booking_id_no)
            ->get('ws_booking_history')
            ->row();


        $paysettings = $this->db->select('*')->from('ws_setting')->get()->row();


        if (sizeof($rowData) > 0) {
            if ($paysettings->payment_type != 'disable') {
                $this->db->insert('tkt_booking', $rowData);
                $this->db->where('id_no', $booking_id_no)->delete('ws_booking_history');
            }
        }


        // return booking data
        return $this->db->select("
                tb.pickup_trip_location,
                tb.drop_trip_location,
                CONCAT_WS(' ', tp.firstname, tp.lastname) AS passenger_name, 
                tb.tkt_passenger_id_no AS tkt_passenger_id_no,
                tb.trip_id_no AS trip_id_no,
                tb.id_no AS booking_id_no,
                DATE_FORMAT(tb.booking_date, '%m/%d/%Y %h:%i %p') as booking_date,
                tr.name AS route_name,
                tb.request_facilities AS request_facilities,
                tb.price AS price,
                tb.total_seat AS quantity,
                tb.discount AS discount,
                tb.seat_numbers AS seat_serial,
                tb.adult,
                tb.child,
                tb.special,
                tb.booking_type,
                tb.trip_route_id,
                tp.nid

            ")
            ->from('tkt_booking AS tb')
            ->join('tkt_passenger AS tp', 'tb.tkt_passenger_id_no = tp.id_no', 'full')
            ->join('trip_route AS tr', 'tr.id = tb.trip_route_id', 'full')
            ->where('tb.id_no', $booking_id_no)
            ->get()
            ->row();
    }

    public function create_bank_transaction($data = array())
    {
        return $this->db->insert('bank_transaction', $data);
    }

    public function remove_passenger($id = null)
    {
        return $this->db->where('id_no', $id)
            ->delete("tkt_passenger");
    }


    public function insertTransaction($data = array())
    {
        $insert = $this->db->insert('ws_payments', $data);
        return $insert ? true : false;
    }


    public function email_config_data()
    {
        return $data = $this->db->select('*')
            ->from('email_config')
            ->get()
            ->row();
    }

    public function passenger_recovery_pass($data = [])
    {
        return $this->db->where('email', $data['email'])
            ->update('tkt_passenger', $data);
    }

    public function passenger_password_recovery($email)
    {
        return $this->db->select("*")
            ->from('tkt_passenger')
            ->where('email', $email)
            ->get();
    }

//passenger booking details
    public function passenger_booking_data($user_id)
    {
        return $data = $this->db->select('a.*,b.*')
            ->from('tkt_passenger a')
            ->where('a.id_no', $user_id)
            ->join('tkt_booking b', 'a.id_no=b.tkt_passenger_id_no')
            ->get()
            ->result();
    }

//checkin secret key
    public function check_secret($key)
    {
        return true;
        return $data = $this->db->select('*')
            ->from('api_user')
            ->where('secret_key', $key)
            ->get()
            ->num_rows();
    }


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

}