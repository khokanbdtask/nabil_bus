<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price_luggage_model extends CI_Model {
 
    public function price_view()
	{
		return $this->db->select('luggage_price_master.*, trip_route.name, fleet_type.type')
			->from('luggage_price_master')
            ->join('trip_route', 'trip_route.id = luggage_price_master.trip_route_id', 'left')
            ->join('fleet_type', 'fleet_type.id = luggage_price_master.fleet_type_id', 'left')
            ->where('luggage_price_master.delete_status',0)
			->order_by('luggage_price_master_id', 'desc')
			->get()
			->result();
	}

	public function price_luggage_view($id = null)
    {
        return $this->db->select('luggage_price_master.*, trip_route.name, fleet_type.type')
            ->from('luggage_price_master')
            ->join('trip_route', 'trip_route.id = luggage_price_master.trip_route_id', 'left')
            ->join('fleet_type', 'fleet_type.id = luggage_price_master.fleet_type_id', 'left')
            ->where('luggage_price_master.luggage_price_master_id',$id)
            ->where('luggage_price_master.delete_status',0)
            ->order_by('luggage_price_master_id', 'desc')
            ->get()
            ->row_array();
    }

	public function price_create($data = array())
	{
		 $this->db->insert('luggage_price_master', $data);
        $lpm = $this->db->insert_id();

        return $lpm;

	}

	public function luggage_price_details($data = array())
    {
        return $this->db->insert('luggage_price_details',$data);
    }

    public function luggege_price_details_delete_before_update($id)
    {
        return $this->db->where('luggage_price_master_id',$id)
            ->delete('luggage_price_details');
    }

    public function luggage_price_details_update($data = array())
    {
        return $this->db->insert('luggage_price_details',$data);
    }

    public function luggage_price_detailsget($id)
    {
        return $this->db->select('*')
            ->from('luggage_price_details')
            ->where('luggage_price_master_id',$id)
            ->get()
            ->result_array();
    }

	public function delete_price($id = null)
	{
		$this->db->where('luggage_price_master_id',$id)
			->update('luggage_price_master',['delete_status'=>1]);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 

    public function update_price($data = array())
	{
		return $this->db->where('luggage_price_master_id', $data["luggage_price_master_id"])
			->update("luggage_price_master", $data);
	}

	public function price_updateForm($id){
        $this->db->where('luggage_price_master_id',$id);
        $query = $this->db->get('luggage_price_master');
        return $query->row();
    }

    public  function get_id($id)
    {
        $query=$this->db->get_where('luggage_price_master',array('luggage_price_master_id'=>$id));
        return $query->row_array();
    }

    public function rout(){
        $data = $this->db->select('*')
        ->from('trip_route')
        ->where('status',1)
        ->get()
        ->result();
        $list[''] = display('select_option');
        if(!empty($data)){
            foreach ($data as  $value) {
                $list[$value->id]=$value->name;
            }
        }
        return $list;
    }

    public function vehicles(){
        $data = $this->db->select('*')
        ->from('fleet_type')
        ->where('status',1)
        ->where('luggage_service',1)
        ->get()
        ->result();
        $list[''] = display('select_option');
        if(!empty($data)){
            foreach ($data as  $value) {
                $list[$value->id]=$value->type;
            }
        }
        return $list;
    }
    // currency and web information
     public function retrieve_setting_editdata()
    {
        $this->db->select('*');
        $this->db->from('ws_setting');
        $this->db->where('id',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();  
        }
        return false;
    }

    public function max_luggage_weight($id=null)
    {
        return $this->db->select('total_weight')
        ->from('fleet_type')
        ->where('id',$id)
        ->get()
        ->row()
        ->total_weight;

    }
}
