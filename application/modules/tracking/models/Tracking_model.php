<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tracking_model extends CI_Model {
 
    public function tracking_view()
	{
// SELECT
//     tracking.*,
//     trip_assign.id_no,
//     fleet_registration.reg_no,
//     trip.trip_title,
//     trip_route.stoppage_points,
//     shedule.start,
//     shedule.end
// FROM
//     `tracking`
// LEFT JOIN `trip_assign` ON tracking.trips = trip_assign.id
// LEFT JOIN `trip` ON trip_assign.trip = trip.trip_id
// LEFT JOIN trip_route ON trip.route = trip_route.id
// LEFT JOIN fleet_registration ON fleet_registration.id = trip_assign.fleet_registration_id
// LEFT JOIN shedule ON shedule.shedule_id = trip.shedule_id

            return  $this->db
                ->select('
                    tracking.*,
                    trip_assign.id,
                    trip_assign.id_no,
                    fleet_registration.reg_no,
                    trip.trip_title,
                    trip_route.stoppage_points,
                    shedule.start,
                    shedule.end
                ')
                ->from('tracking')
                ->join('trip_assign', 'tracking.trips = trip_assign.id', 'left')
                ->join('trip', 'trip_assign.trip = trip.trip_id', 'left')
                ->join('trip_route', 'trip.route = trip_route.id', 'left')
                ->join('fleet_registration', 'fleet_registration.id = trip_assign.fleet_registration_id', 'left')
                ->join('shedule', 'shedule.shedule_id = trip.shedule_id', 'left')
                ->order_by('tracking.tracking_id', 'DESC')
                ->get()
                ->result();
	}

    public function tracks($id='')
    {
        return  $this->db
                ->select('
                    tracking.*,
                    trip_assign.id,
                    trip_assign.id_no,
                    fleet_registration.reg_no,
                    trip.trip_title,
                    trip_route.stoppage_points,
                    shedule.start,
                    shedule.end
                ')
                ->from('tracking')
                ->join('trip_assign', 'tracking.trips = trip_assign.id', 'left')
                ->join('trip', 'trip_assign.trip = trip.trip_id', 'left')
                ->join('trip_route', 'trip.route = trip_route.id', 'left')
                ->join('fleet_registration', 'fleet_registration.id = trip_assign.fleet_registration_id', 'left')
                ->join('shedule', 'shedule.shedule_id = trip.shedule_id', 'left')
                ->where('tracking.tracking_id = '.$id)
                ->order_by('tracking.tracking_id', 'DESC')
                ->get()
                ->result();
    }

	public function tracking_create($data = array())
	{
		return $this->db->insert('tracking', $data);
	}

	public function delete_tracking($id = null)
	{
		$this->db->where('tracking_id',$id)
			->delete('tracking');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 

    public function rout($id = ''){
        $this->db->select('*');
        $this->db->from('trip_route');
        $query=$this->db->get();
        $data=$query->result();
        $list[''] = display('select_option');
        if(!empty($data)){
            foreach ($data as  $value) {
                $list[$value->id]=$value->name;
            }
        }
        return $list;
    }

    public function stoppage_point($route_id){

        $list = Array();
        // $this->db->select('trip_route.stoppage_points');
        // $this->db->from('trip_assign');
        // $this->db->join('trip_route', 'trip_assign.trip = trip_route.id', 'left');
        // $this->db->where('trip_assign.id',$route_id);
        // $query=$this->db->get();
        // $data=$query->result();

        $data = $this->db
                ->select('trip_route.stoppage_points')
                ->from('trip_assign')
                ->join('trip', 'trip_assign.trip = trip.trip_id', 'left')
                ->join('trip_route', 'trip.route = trip_route.id', 'left')
                ->where('trip_assign.id',$route_id)
                ->get()
                ->result();


        if(!empty($data)){
            foreach ($data as  $value) {
                $list['stoppage_points']=$value->stoppage_points;
            }
        }
        return $list;
    }

public  function get_id($id)
    {
        $query=$this->db->get_where('tracking',array('tracking_id'=>$id));
        return $query->row_array();
    } 

    public function update_tracking($data = array())
	{
		return $this->db->where('tracking_id', $data["tracking_id"])
			->update("tracking", $data);
	}

	public function tracking_updateForm($id){
        $this->db->where('tracking_id',$id);
        $query = $this->db->get('tracking');
        return $query->row();
    }

    public function of_enddate()
    {
        return $this->db->select('*')   
            ->from('tracking')
            ->get()
            ->result();
    }

    public function details($id)
    {

        return $this->db->select('tracking.*,trip_route.*')   
            ->from('tracking')
            ->where('tracking_id',$id)
            ->join('trip_route', 'trip_route.id = tracking.tracking_route_id', 'left')
            ->get()
            ->result();
    }

    public function loc_names($id = null)
    {
        return $this->db->select("name, id")
            ->from('trip_location')
            ->where('id',$id) 
            ->get()
            ->result();
    } 

    public function trips()
    {

// SELECT
//     trip_assign.id_no,
//     fleet_registration.reg_no,
//     trip.trip_title,
//     trip_route.stoppage_points,
//     shedule.start,
//     shedule.end
// FROM
//     `trip_assign`
// LEFT JOIN `trip` ON trip_assign.trip = trip.trip_id
// LEFT JOIN trip_route ON trip.route = trip_route.id
// LEFT JOIN fleet_registration ON fleet_registration.id = trip_assign.fleet_registration_id
// LEFT JOIN shedule ON shedule.shedule_id = trip.shedule_id

        // return  $this->db
        //         ->select('trip_assign.id,
        //             trip_assign.id_no,
        //             fleet_registration.reg_no,
        //             trip.trip_title,
        //             trip_route.stoppage_points,
        //             shedule.start,
        //             shedule.end
        //         ')
        //         ->from('trip_assign')
        //         ->join('trip', 'trip_assign.trip = trip.trip_id', 'left')
        //         ->join('trip_route', 'trip.route = trip_route.id', 'left')
        //         ->join('fleet_registration', 'fleet_registration.id = trip_assign.fleet_registration_id', 'left')
        //         ->join('shedule', 'shedule.shedule_id = trip.shedule_id', 'left')
        //         ->get()
        //         ->result();

                return  $this->db
                ->select('trip_assign.id,
                    trip_assign.id_no,
                    fleet_registration.reg_no,
                    trip.trip_title
                ')
                ->from('trip_assign')
                ->join('trip', 'trip_assign.trip = trip.trip_id', 'left')
                ->join('fleet_registration', 'fleet_registration.id = trip_assign.fleet_registration_id', 'left') 
                ->get()
                ->result();
    }
     

     public function fleet_dropdown()
    {
        $data = $this->db->select("*")
            ->from("fleet_registration")
            ->where('status', 1) 
            ->get()
            ->result();

            // echo "<pre>";
            // print_r($data);
            // exit();

        $list[''] = display('select_option');
        if (!empty($data)) {
            foreach($data as $value)
                $list[$value->id] = $value->reg_no;
            return $list;
        } else {
            return false; 
        }
    }
    // Fleet List for update
    public function fleet_dropdown_update()
    {
        $data = $this->db->select("*")
            ->from("fleet_registration")
            ->where('status',1)
            ->get()
            ->result();

        $list[''] = display('select_option');
        if (!empty($data)) {
            foreach($data as $value)
                $list[$value->id] = $value->reg_no;
            return $list;
        } else {
            return false; 
        }
    }
}
