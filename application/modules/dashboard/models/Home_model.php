<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{

    public function checkUser($data = array())
    {
        return $this->db->select("
				user.id,
				CONCAT_WS(' ', user.firstname, user.lastname) AS fullname,
				user.email,
				user.image,
				user.last_login,
				user.last_logout,
				user.ip_address,
				user.status,
				user.is_admin,
				IF (user.is_admin=1, 'Admin', 'User') as user_level
			")
            ->from('user')
            ->where('email', $data['email'])
            ->where('password', md5($data['password']))
            ->get();
    }

    public function userPermission($id = null)
    {
        return $this->db->select("
			module.controller,
			module_permission.fk_module_id,
			module_permission.create,
			module_permission.read,
			module_permission.update,
			module_permission.delete
			")
            ->from('module_permission')
            ->join('module', 'module.id = module_permission.fk_module_id', 'full')
            ->where('module_permission.fk_user_id', $id)
            ->get()
            ->result();
    }

    public function last_login($id = null)
    {
        return $this->db->set('last_login', date('Y-m-d H:i:s'))
            ->set('ip_address', $this->input->ip_address())
            ->where('id', $this->session->userdata('id'))
            ->update('user');
    }

    public function last_logout($id = null)
    {
        return $this->db->set('last_logout', date('Y-m-d H:i:s'))
            ->where('id', $this->session->userdata('id'))
            ->update('user');
    }

    public function profile($id = null)
    {
        return $this->db->select("
			*,
				CONCAT_WS(' ', firstname, lastname) AS fullname,
				IF (user.is_admin=1, 'Admin', 'User') as user_level
			")
            ->from("user")
            ->where("id", $id)
            ->get()
            ->row();
    }

    public function setting($data = array())
    {
        return $this->db->where('id', $data['id'])
            ->update('user', $data);
    }

    public function schedule($limit = null, $start = null)
    {
        return $this->db->select("a.*,b.reg_no AS fleet_registration_name,c.*,CONCAT_WS(' ', d.first_name, d.second_name) AS driver_name,e.name,f.start,f.end")
            ->from("trip_assign a")
            ->join('trip c', 'a.trip = c.trip_id', 'left')
            ->join('fleet_registration b', 'a.fleet_registration_id = b.id', 'left')
            ->join('employee_history d', 'a.driver_id = d.id', 'left')
            ->join('trip_route e', 'c.route = e.id', 'left')
            ->join('shedule f', 'c.shedule_id = f.shedule_id', 'left')
            ->group_start()
            ->where('a.closed_by_id', null)
            ->or_where('a.closed_by_id', '')
            ->or_where('a.closed_by_id', 0)
            ->group_end()
        // ->like('a.assign_time', date("Y-m-d"), 'after')
            ->limit($limit, $start)
            ->get()
            ->result();
    }

    public function enquiries()
    {
        return $this->db->select("*")
            ->from('enquiry')
            ->where('checked_by', null)
            ->order_by('enquiry_id', 'desc')
            ->limit(3)
            ->get()
            ->result();
    }

    public function chart()
    {
        $data['assign'] = $this->db->query("
			SELECT
				COUNT(*) AS count, assign_time,
				EXTRACT(YEAR_MONTH FROM assign_time) AS ym,
				MONTH(assign_time) AS m
			FROM
				trip_assign
			WHERE
				YEAR(assign_time) = YEAR(CURDATE())
			GROUP BY ym
		")->result();

        $data['booking'] = $this->db->query("
			SELECT
				COUNT(*) AS count, booking_date,
				EXTRACT(YEAR_MONTH FROM booking_date) AS ym,
				MONTH(booking_date) AS m
			FROM
				tkt_booking
			WHERE
				YEAR(booking_date) = YEAR(CURDATE())
			GROUP BY ym
		")->result();

//print_r($data);exit;

        return $data;
    }
    public function monthlyassign($month = null)
    {
        $result = $this->db->query("
							SELECT count(id) as total_assign FROM `trip_assign`
							WHERE MONTH(assign_time)  = $month
								AND YEAR(assign_time) = YEAR(CURRENT_TIMESTAMP);
							");

        return $result->row();
    }

    public function monthlybooking($month = null)
    {
        $id = $this->session->userdata('id');
        if ($this->session->userdata('isAdmin') == 1) {
            $result = $this->db->query("
							SELECT count(id) as total_booking FROM `tkt_booking`
							WHERE MONTH(booking_date)  = $month
								AND YEAR(booking_date) = YEAR(CURRENT_TIMESTAMP);
							");
        } else {
            $result = $this->db->query("
							SELECT count(id) as total_booking FROM `tkt_booking`
							WHERE MONTH(booking_date)  = $month
							AND booked_by = $id
								AND YEAR(booking_date) = YEAR(CURRENT_TIMESTAMP);
							");
        }
        return $result->row();
    }


    public function read()
	{
        $currentDate = date('Y-m-d');
        // $todaysbefore = 
        $date = $currentDate; //'2012-11-08';
        $day_before = date( 'Y-m-d', strtotime( $date . '3 day' ) );
        // $day_before = '2022-11-15';

        $this->db->select('tb.*, tr.name AS route_name');
        $this->db->from('tkt_booking AS tb');
        $this->db->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left");
        $this->db->where('tb.booking_delete_status',0);
        // $this->db->limit($limit, $start);
        $this->db->where('tkt_refund_id',Null);
        $this->db->where('payment_status !=',"Null");
        $this->db->where('booking_date >=', $currentDate);
        $this->db->where('booking_date <=', $day_before);
        $this->db->order_by('id', 'desc');
        $query=$this->db->get();
            if($query->num_rows() > 0){
            return $query->result();
            }
            return false;	
                    
            } 





            public function luggageread()
            {
                $currentDate = date('Y-m-d');
                $date = $currentDate; 
                $day_before = date( 'Y-m-d', strtotime( $date . '3 day' ) );
       
        
                $this->db->select('lb.*, tr.name AS route_name, pk.package_name AS package_name');
                $this->db->from('luggage_booking AS lb');
                $this->db->join("trip_route AS tr", "tr.id = lb.trip_route_id", "left");
                $this->db->join('package AS pk', 'pk.package_id = lb.package_id','left');

                // $datefrom = date("Y-m-d", strtotime($this->input->post('datefrom')));
                // $dateto = date("Y-m-d", strtotime($this->input->post('dateto')));

                // $this->db->where('DATE(lb.create_date) >=', $day_before);
                // $this->db->where('DATE(lb.create_date) <=', $currentDate);
                $this->db->where('luggage_refund_id',Null);
                $this->db->where('payment_status !=',"Null");

                $this->db->where('lb.booking_date >=', $date);
                $this->db->where('lb.booking_date <=', $day_before);
                
                $this->db->order_by('id', 'desc');
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    return $query->result();
                }
                return false;
            }
}



                                   
                                  
                    