<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Journey_list_model extends CI_Model
{
    public function getFleetType()
    {
        $this->db->where('status', 1);
        $query = $this->db->get('fleet_type');
        return $query->result_array();
    }

    public function getRoutType()
    {
        $this->db->where('status', 1);
        $query = $this->db->get('trip_route');
        return $query->result_array();
    }

    // public function passengerList($limit,$start,$date,$vehicelid)
    public function passengerList($date,$vehicelid,$triptypeId)
    {
        
        $this->db->where('status', 1);
        $this->db->where('fleet_registration_id', $vehicelid);
        $this->db->where('trip', $triptypeId);
        $this->db->where('closed_by_id',0);
        $query = $this->db->get('trip_assign');

        $tripidNumber = $query->row();
        $tripidNumber = $tripidNumber->id;

        // var_dump($tripidNumber);
        // exit;
      

        $this->db->select('tkt_booking.payment_status,
                            tkt_booking.booking_delete_status,
                            tkt_booking.tkt_refund_id,
                            tkt_booking.trip_id_no,
                            tkt_booking.booking_date,
                            tkt_booking.id_no as customerbookingId,
                            tkt_booking.seat_numbers,
                            tkt_passenger.firstname,
                            tkt_passenger.lastname,
                            tkt_passenger.phone,
                            tkt_passenger.nid,
                            tkt_passenger.id_no as customerId,
                            tkt_booking.pickup_trip_location,
                            tkt_booking.drop_trip_location');

        $this->db->from('tkt_booking'); 
        $this->db->join('tkt_passenger', 'tkt_passenger.id_no = tkt_booking.tkt_passenger_id_no', 'left');
        // $this->db->join('child_passenger', 'child_passenger.booking_id = tkt_booking.id_no', 'left');
        $this->db->where('trip_id_no', $tripidNumber);
        $this->db->where('booking_date', $date);

        
       

        $this->db->where('tkt_booking.tkt_refund_id', NULL);
        $this->db->where('tkt_booking.payment_status', 'NULL');
        $this->db->where('tkt_booking.booking_delete_status', 0);
        // $this->db->where('tkt_booking.tkt_refund_id', 'NULL');

        // $this->db->limit($limit, $start);

        // client 2022 project update
        $this->db->order_by("seat_numbers", "asc");
        // client 2022 project update
        
        $query=$this->db->get();
        if($query->num_rows() > 0){

        return $query->result();
        }
        return false;	
			
	
    }

    public function passengerListpdf($date,$vehicelid,$triptypeId)
    {
        $this->db->where('status', 1);
        $this->db->where('fleet_registration_id', $vehicelid);
        $this->db->where('trip', $triptypeId);
        $this->db->where('closed_by_id',0);
        $query = $this->db->get('trip_assign');

        $tripidNumber = $query->row();
        $tripidNumber = $tripidNumber->id;

        $this->db->select('tkt_booking.payment_status,
        tkt_booking.booking_delete_status,
        tkt_booking.tkt_refund_id,
        tkt_booking.trip_id_no,
        tkt_booking.booking_date,
        tkt_booking.id_no as customerbookingId,
        tkt_booking.seat_numbers,
        tkt_passenger.firstname,
        tkt_passenger.lastname,
        tkt_passenger.phone,
        tkt_passenger.nid,
        tkt_passenger.id_no as customerId,
        tkt_booking.pickup_trip_location,
        tkt_booking.drop_trip_location');
       
        $this->db->from('tkt_booking'); 
        $this->db->join('tkt_passenger', 'tkt_passenger.id_no = tkt_booking.tkt_passenger_id_no', 'left');
        // $this->db->join('child_passenger', 'child_passenger.booking_id = tkt_booking.id_no', 'left');
        $this->db->where('trip_id_no', $tripidNumber);
        $this->db->where('booking_date', $date);

        $this->db->where('tkt_booking.tkt_refund_id', NULL);
        $this->db->where('tkt_booking.payment_status', 'NULL');
        $this->db->where('tkt_booking.booking_delete_status', 0);
        // $this->db->where('tkt_booking.tkt_refund_id', 'NULL');

        // client 2022 project update
        $this->db->order_by("seat_numbers", "asc");
        // client 2022 project update
        $query=$this->db->get();
        if($query->num_rows() > 0){
        return $query->result();
        }
        return false;	
			
	
    }

    
    public function passengerListRowCount($vehicleid = null)
    {
        $this->db->where('status', 1);
        $this->db->where('fleet_registration_id', $vehicleid);
        $query = $this->db->get('trip_assign');
        $tripidNumber = $query->row();
        $tripidNumber = $tripidNumber->id;
        $this->db->select('*');
        $this->db->from('tkt_booking'); 
        $this->db->where('trip_id_no', $tripidNumber);
        $query = $this->db->get();
        
        return $query->num_rows();
        
        
      
    }

    public function startLocation($vehicleid)
    {
        $picupLocation="";
        $this->db->where('status', 1);
        $this->db->where('fleet_registration_id', $vehicleid);
        $query = $this->db->get('trip_assign');
        $tripidNumber = $query->row();
        $tripidNumber = $tripidNumber->id;

       

        $this->db->select('*');
        $this->db->from('tkt_booking'); 
        $this->db->where('trip_id_no', $tripidNumber);
        $query = $this->db->get();
        $tripidNumber = $query->result_array();
        foreach ($tripidNumber as $key => $value) {
            $picupLocation = $value['pickup_trip_location'];
        }
         $this->db->where('id',$picupLocation);
        $query = $this->db->get('trip_location');
        
        return $query->result_array();

    }

    public function endLocation($vehicleid)
    {
        
       

        $picupLocation="";
        $this->db->where('status', 1);
        $this->db->where('fleet_registration_id', $vehicleid);
        $query = $this->db->get('trip_assign');
        $tripidNumber = $query->row();
        $tripidNumber = $tripidNumber->id;

         $this->db->select('*');
        $this->db->from('tkt_booking'); 
        $this->db->where('trip_id_no', $tripidNumber);
        $query = $this->db->get();
        $tripidNumber = $query->result_array();
        foreach ($tripidNumber as $key => $value) {
            $picupLocation = $value['drop_trip_location'];
        }
         $this->db->where('id',$picupLocation);
        $query = $this->db->get('trip_location');
        
        return $query->result_array();

    }

    public function getLocation()
    {

        $this->db->select('*');
        $this->db->from('tkt_booking'); 
        $query = $this->db->get('trip_location');
        return $query->result();

    }
}
 