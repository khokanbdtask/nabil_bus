<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {
 
	private $table = "tkt_booking";


	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}

	// New code 2021 direct update 
	public function updatedata($data,$id)
	{	 
		return $this->db->where('id', $id)
						->update($this->table, $data);
		
	}
	// New code 2021 direct update 

	public function read($limit = null, $start = null)
	{

 $this->db->select('tb.*, tr.name AS route_name');
  $this->db->from('tkt_booking AS tb');
  $this->db->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left");
  if($this->session->userdata('isAdmin')==0){
		$this->db->where('tb.booked_by',$this->session->userdata('id'));
  }
  $this->db->where('tb.booking_delete_status',0);
  $this->db->limit($limit, $start);
  $this->db->order_by('id', 'desc');
  $query=$this->db->get();
     if($query->num_rows() > 0){
      return $query->result();
     }
     return false;	
			
	} 


	public function findById($id_no = null)
	{
		return $this->db->select("
				tb.*, 
				tr.name AS route_name, 
				tp.image, 
				trf.cancelation_fees, 
				trf.causes, 
				CONCAT_WS(' ', u.firstname, u.lastname) AS refund_by

			")->from("tkt_booking AS tb")
			->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left") 
			->join("tkt_passenger AS tp", "tp.id_no = tb.tkt_passenger_id_no", "left") 
			 ->join('tkt_refund AS trf', 'trf.tkt_booking_id_no = tb.id_no', "left")
			 ->join('user AS u', 'u.id = trf.refund_by_id', "left")
			->where('tb.id_no',$id_no) 
        	->limit($limit, $start)
			->get()
			->row();
	} 

	public function ticket($id_no = null)
	{
		// return booking data
    	return $this->db->select("
                tb.*,
                CONCAT_WS(' ', tp.firstname, tp.lastname) AS passenger_name, 
                DATE_FORMAT(tb.booking_date, '%m/%d/%Y') as booking_date,
                tr.name AS route_name,
                tp.nid,
                trass.id_no AS trip_assing_idno
            ")
            ->from('tkt_booking AS tb')
            ->join('tkt_passenger AS tp', 'tb.tkt_passenger_id_no = tp.id_no' ,'left')
            ->join('trip_route AS tr', 'tr.id = tb.trip_route_id','left')
            ->join('trip_assign AS trass', 'trass.id = tb.trip_id_no', 'left')
            ->where('tb.id_no', $id_no)
            ->get()
            ->row();
	}


	public function website_setting() 
	{
		return $this->db->get('ws_setting')->row();
	}

	//  New code 2021 direct update 
	public function websettings() 
	{
		return $this->db->get('setting')->row();
	}
	//  New code 2021 direct update 
 
	public function update($data = [])
	{
		return $this->db->where('id_no',$data['id_no'])
			->update($this->table,$data); 
	} 


	public function delete($id = null)
	{
		$this->db->where('id',$id)
			->update($this->table,["booking_delete_status" =>1]);

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
			foreach($data as $value)
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
			foreach($data as $value)
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
			foreach($data as $value)
				$list[$value->id] = $value->name;
			return $list;
		} else {
			return false; 
		}
	}
 
// paid information
	public function ticket_paid($id_no = null)
	{
		
		// return booking data
    	return $this->db->select("*")
            ->from('tkt_booking')
            ->where('id_no',$id_no)
            ->get()
            ->result();
	}

	public function confirmation()
	{
		return $this->db->select("btr.*,btr.id as ids, tr.*")
			->from("bank_transaction AS btr")
			->join("tkt_booking AS tr", "tr.id_no = btr.booking_id", "left")
			->where('tr.booking_delete_status',0)
			->where('tr.id_no = btr.booking_id')
        	->order_by('btr.id', 'desc')
			->get()
			->result();
	} 


	public function upaid_cash_bookig()
	{
		return $this->db->select("tb.*, tr.name AS route_name")
			->from("tkt_booking AS tb")
			->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left") 
        	->where('tb.payment_status',2)
        	->or_where('tb.payment_status',1)
        	->where('tb.booking_delete_status',0)
        	->order_by('tb.id', 'desc')
			->get()
			->result();
	} 

	// confirmation delete 
	public function confirmation_delete($id = null)
	{
		$this->db->where('id',$id)
			->update('bank_transaction', ["booking_delete_status" => 1]);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
// // terms and condition  info
// 	public function terms_and_cond_data($id = null)
// 	{
		
// 		// return booking data
//     	return $this->db->select("*")
//             ->from('payment_informations')
//             ->where('id',$id)
//             ->get()
//             ->row();
// 	}
// 	public function term_and_condition_list(){
// 		return $terms = $this->db->select('*')
// 		                  ->from('payment_informations')
// 		                  ->get()
// 		                  ->result();
// 	}
// 	// terms delete
// 	public function terms_delete($id = null)
// 	{
// 		$this->db->where('id',$id)
// 			->delete('payment_informations');

// 		if ($this->db->affected_rows()) {
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	} 
// // update terms and condition
// 	public function update_condition($data = [])
// 	{
// 		return $this->db->where('id',$data['id'])
// 			->update('payment_informations',$data); 
// 	} 
// 	//create_terms
// 	public function create_terms($data = [])
// 	{	 
// 		return $this->db->insert('payment_informations',$data);
// 	}

		public function fleet_dropdown()
	{
		$data = $this->db->select("*")
			->from("fleet_type")
			->where('status', 1) 
			->get()
			->result();

		$list = array('' => 'Select One...');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->id] = $value->type;
		} 
		return $list;
	}
	public function count_ticket(){
		$this->db->select('*');
		$this->db->from('tkt_booking');
		if($this->session->userdata('isAdmin')==0){
         $this->db->where('booked_by',$this->session->userdata('id'));
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}


		public function loc_names($id = null)
	{
		return $this->db->select("name, id")
			->from('trip_location')
			->where('id',$id) 
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

    public function tax()
    {
        # code...
        return $this->db->select('*')
                        ->from('tax_settings')
                        ->get()
                        ->result_array();
    }

}

 