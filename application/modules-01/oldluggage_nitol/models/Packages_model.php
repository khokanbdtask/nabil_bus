<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages_model extends CI_Model {
 
    public function price_view()
    {
        return $this->db->select('package.*, trip_route.name, fleet_type.type')
            ->from('package')
            ->join('trip_route', 'trip_route.id = package.trip_route_id', 'left')
            ->join('fleet_type', 'fleet_type.id = package.fleet_type_id', 'left')
            ->where('package.delete_status',0)
            ->order_by('package_id', 'desc')
            ->get()
            ->result();
    }

    public function price_luggage_view($id = null)
    {
        return $this->db->select('package.*, trip_route.name, fleet_type.type')
            ->from('package')
            ->join('trip_route', 'trip_route.id = package.trip_route_id', 'left')
            ->join('fleet_type', 'fleet_type.id = package.fleet_type_id', 'left')
            ->where('package.package_id',$id)
            ->where('package.delete_status',0)
            ->order_by('package_id', 'desc')
            ->get()
            ->row_array();
    }

    public function price_create($data = array())
    {
         $this->db->insert('package', $data);
        $lpm = $this->db->insert_id();

        return $lpm;

    }


    public function delete_price($id = null)
    {
        $this->db->where('package_id',$id)
            ->update('package',['delete_status'=>1]);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    } 

    public function update_price($data = array())
    {
        return $this->db->where('package_id', $data["package_id"])
            ->update("package", $data);
    }

    public function price_updateForm($id){
        $this->db->where('package_id',$id);
        $query = $this->db->get('package');
        return $query->row();
    }

    public  function get_id($id)
    {
        $query=$this->db->get_where('package',array('package_id'=>$id));
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
