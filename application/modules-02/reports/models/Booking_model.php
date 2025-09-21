<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

	public function read($data= array())
	{
		$start_date = date('Y-m-d', strtotime($data->start_date));
		$end_date   = date('Y-m-d', strtotime($data->end_date));

	
		$this->db->select("
				tb.*, 
				tr.name AS route_name, 
				eh.id AS driver_id,
				CONCAT_WS(' ', eh.first_name, eh.second_name) AS driver_name,
				trp.trip_title
			")
			->from("tkt_booking AS tb")
			
			->join("trip_assign AS ta", "ta.trip = tb.trip_id_no", "left")
			// ->join("trip AS trp", "trp.trip_id = tb.trip_id_no", "left") 
			->join("trip AS trp", "ta.trip  = trp.trip_id" , "left") 
			->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left") 
			->join("employee_history AS eh", "eh.id = ta.driver_id", "left") 
            ->group_start()
                ->where("tb.tkt_refund_id IS NULL", null, false)
                ->or_where("tb.tkt_refund_id", 0)
                ->or_where("tb.tkt_refund_id", null)
            ->group_end()
            ->where("tb.booking_delete_status",0);


		#----new code 2021 show report for single day
if(strtotime($start_date) == strtotime($end_date))

{
	$this->db->where("DATE(tb.date) BETWEEN '$start_date' AND '$start_date'", null, false);



        return $this->db->limit($data->limit, $data->offset)
        	->order_by('booking_date', 'desc')
			->get()
			->result(); 
 
}


		#----new code 2021 show report for single day

 
		switch ($data->filter) 
		{
    		case 'trip':
				
				$this->db->where('tb.trip_id_no', $data->trip);
				
    			break; 
    		case 'route':
    			$this->db->where('tb.trip_route_id', $data->route);
    			break; 
    		case 'driver':
    			$this->db->where('eh.id', $data->driver);
    			break; 
    	} 
        $this->db->where("DATE(tb.booking_date) BETWEEN '$start_date' AND '$end_date'", null, false);



        return $this->db->limit($data->limit, $data->offset)
        	->order_by('booking_date', 'desc')
			->get()
			->result(); 

       
	} 

	public function countRecord($data= array())
	{
		$start_date = date('Y-m-d', strtotime($data->start_date));
		$end_date   = date('Y-m-d', strtotime($data->end_date));


		$tripidfromassingtable="";
		switch ($data->filter) 
		{
    		case 'trip':
				
				$tripidfromassingtable = $this->db->where('id',$data->trip)->get('trip_assign')->row();
				
    			break; 
    		case 'route':
    			
    			break; 
    		case 'driver':
    			
    			break; 
    	}


		$this->db->select("
				tb.*, 
				tr.name AS route_name, 
				eh.id AS driver_id,
				CONCAT_WS(' ', eh.first_name, eh.second_name) AS driver_name
			")

			->from("tkt_booking AS tb")

			// ->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left") 
			// ->join("trip_assign AS ta", "ta.id_no = tb.trip_id_no", "left") 
			// ->join("employee_history AS eh", "eh.id = ta.driver_id", "left") 

			->join("trip_assign AS ta", "ta.trip = tb.trip_id_no", "left")
			// ->join("trip AS trp", "trp.trip_id = tb.trip_id_no", "left") 
			->join("trip AS trp", "ta.trip  = trp.trip_id" , "left") 
			->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left") 
			->join("employee_history AS eh", "eh.id = ta.driver_id", "left") 


            ->group_start()
                ->where("tb.tkt_refund_id IS NULL", null, false)
                ->or_where("tb.tkt_refund_id", 0)
                ->or_where("tb.tkt_refund_id", null)
            ->group_end();



#----new code 2021 show report for single day
if(strtotime($start_date) == strtotime($end_date))

{
	$this->db->where("DATE(tb.date) BETWEEN '$start_date' AND '$end_date'", null, false);
	return $this->db->get()->num_rows();
 
}


else
{
	switch ($data->filter) 
		{
    		case 'trip':
    			$this->db->where('tb.trip_id_no', $data->trip);
    			break; 
    		case 'route':
    			$this->db->where('tb.trip_route_id', $data->route);
    			break; 
    		case 'driver':
    			$this->db->where('eh.id', $data->driver);
    			break; 
    	} 

		$this->db->where("DATE(tb.booking_date) BETWEEN '$start_date' AND '$end_date'", null, false);
        return $this->db->get()->num_rows();

}

#----new code 2021 show report for single day
 
		


        
	} 


	public function routeList()
	{
		$data = $this->db->select("*")
			->from('trip_route')
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

// trip list
	// public function tripList()
	// {
	// 	$data = $this->db->select("*")
	// 		->from('trip_assign')
	// 		// ->join('trip','trip_assign.trip = trip.trip_id','left')
	// 		->join('trip','trip.trip_id =trip_assign.trip')
	// 		->where('trip_assign.status', 1) 
	// 		->where('closed_by_id', 0) 
	// 		->order_by('createdate', 'desc')
	// 		->get()
	// 		->result();

	// 	$list[''] = display('select_option');
	// 	if (!empty($data)) {
	// 		foreach($data as $value)
	// 			$list[$value->id] = $value->id_no.'-id-'.$value->id.'-trip-'.$value->trip." , ".$value->trip_title;
	// 		return $list;
	// 	} else {
	// 		return false; 
	// 	}
	// }

	public function tripList()
	{
		$data = $this->db->select("*")
			->from('trip')
			->join('trip_assign','trip_assign.trip = trip.trip_id','left')
			
			->where('trip_assign.status', 1) 
			->where('closed_by_id', 0) 
			->order_by('createdate', 'desc')
			->get()
			->result();

		$list[''] = display('select_option');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->id] = $value->id_no.'-id'.$value->id.'-trip'.$value->trip." , ".$value->trip_title;
			return $list;
		} else {
			return false; 
		}
	}
	
	public function driverList()
	{
		$data = $this->db->select("id, CONCAT_WS(' ', first_name, second_name) AS name")
			->from("employee_history")
			->like('position','driver', 'both')
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

#----new code 2021 show report for single day
	public function countRowSingleDay($data= array())
	{

		{
			$singleday = date('Y-m-d', strtotime($data->single_day));
			
	
	
			$this->db->select("
					tb.*, 
					tr.name AS route_name, 
					eh.id AS driver_id,
					CONCAT_WS(' ', eh.first_name, eh.second_name) AS driver_name
				")
				->from("tkt_booking AS tb")
				->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left") 
				->join("trip_assign AS ta", "ta.id_no = tb.trip_id_no", "left") 
				->join("employee_history AS eh", "eh.id = ta.driver_id", "left") 
				->group_start()
					->where("tb.tkt_refund_id IS NULL", null, false)
					->or_where("tb.tkt_refund_id", 0)
					->or_where("tb.tkt_refund_id", null)
				->group_end();
	 
			
			$this->db->where("DATE(tb.date) BETWEEN '$singleday' AND '$singleday'", null, false);
	
	
			return $this->db->get()->num_rows();
		} 

	}

	public function readSingleDayRecord($data= array())

	{

		$singleday = date('Y-m-d', strtotime($data->single_day));


		$this->db->select("
				tb.*, 
				tr.name AS route_name, 
				eh.id AS driver_id,
				CONCAT_WS(' ', eh.first_name, eh.second_name) AS driver_name,
				trp.trip_title
			")
			->from("tkt_booking AS tb")
			->join("trip_route AS tr", "tr.id = tb.trip_route_id", "left") 
			->join("trip_assign AS ta", "ta.trip = tb.trip_id_no", "left")
			->join("trip AS trp", "trp.trip_id = tb.trip_id_no", "left") 
			->join("employee_history AS eh", "eh.id = ta.driver_id", "left") 
            ->group_start()
                ->where("tb.tkt_refund_id IS NULL", null, false)
                ->or_where("tb.tkt_refund_id", 0)
                ->or_where("tb.tkt_refund_id", null)
            ->group_end()
            ->where("tb.booking_delete_status",0);


		// 	switch ($data->filter) 
		// {
    	// 	case 'trip':
    	// 		$this->db->where('tb.trip_id_no', $data->trip);
    	// 		break; 
    	// 	case 'route':
    	// 		$this->db->where('tb.trip_route_id', $data->route);
    	// 		break; 
    	// 	case 'driver':
    	// 		$this->db->where('eh.id', $data->driver);
    	// 		break; 
    	// } 
 
		 
        $this->db->where("DATE(tb.date) BETWEEN '$singleday' AND '$singleday'", null, false);



        return $this->db->limit($data->limit, $data->offset)
        	->order_by('booking_date', 'desc')
			->get()
			->result(); 


	}
 #----new code 2021 show report for single day
}

 