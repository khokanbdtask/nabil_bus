<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------    
    # Author: Bdtask Ltd
    # Author link: https://www.bdtask.com/
    # Dynamic style php file
    # Developed by :Isahaq
    #------------------------------------    

class Tax_model extends CI_Model {


    public function tax_setting_info(){
        $this->db->select('*');
        $this->db->from('tax_settings');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function taxsetup_create($data = array()){
        return $this->db->insert('payroll_tax_setup',$data);
    }

    public function viewTaxsetup()
    {
        return $this->db->select('*')   
            ->from('payroll_tax_setup')
            ->order_by('tax_setup_id', 'asc')
            ->get()
            ->result();
    }


    public function taxsetup_updateForm($id){
        $this->db->where('tax_setup_id',$id);
        $query = $this->db->get('payroll_tax_setup');
        return $query->result_array();
    }


    public function update_taxsetup($data = array())
    {
        return $this->db->where('tax_setup_id', $data["tax_setup_id"])
            ->update("payroll_tax_setup", $data);


    }

    public function taxsetup_delete($id = null){
        $this->db->where('tax_setup_id',$id)
            ->delete('payroll_tax_setup');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


        //tax report query
    public function taxdata($from_date,$to_date){
        return $this->db->select('a.*,b.invoice')
                        ->from('tax_collection a')
                        ->join('invoice b','a.relation_id = b.invoice_id','left')
                        ->where('a.date >=', $from_date)
                        ->where('a.date <=', $to_date)
                        ->get()
                        ->result_array();
    }

    public function tax_customer(){
        return $this->db->select('*')
                        ->from('tkt_passenger')
                        ->get()
                        ->result_array();
    }

    public function customer_taxdata($from_date,$to_date,$invoice_id){
        $this->db->select('a.*,b.invoice');
        $this->db->from('tax_collection a');
        $this->db->join('invoice b','a.relation_id = b.invoice_id','left');
        $this->db->where('a.date >=', $from_date);
        $this->db->where('a.date <=', $to_date);
        if (!empty($invoice_id)) {
            $this->db->where('b.invoice', $invoice_id);
            $this->db->or_where('a.relation_id', $invoice_id);
        }
        $query = $this->db->get();
        return $query->result_array();

    }


    public function tax_settings()
    {
        return $this->db->select('id,tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
    }

    public function tax_settings_dropdown()
    {
        $data = $this->db->select("id,tax_name")
            ->from("tax_settings") 
            ->order_by('tax_name', 'ASC')
            ->get()
            ->result();

        $list[''] = display('select_option');
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->id] = $value->tax_name;
            return $list;
        } else {
            return false;
        }
    }


    public function luggage_tax_paid($start='', $end='')
    {
        $this->db->select("id_no,booking_date,amount,total_tax,taxids");
        $this->db->from("luggage_booking");
        $this->db->where("payment_status", "NULL");
        $this->db->where("delete_status", 0);
        $this->db->where("luggage_refund_id", null);
        $this->db->where("total_tax >", 0.00);
        $this->db->where("taxids !=", null);
        if (!empty($start)) {
            $this->db->where('booking_date >=', $start);
        }

        if (!empty($end)) {
            $this->db->where('booking_date <=', $end);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    public function ticket_tax_paid($start='', $end='')
    {

        $this->db->select("id_no,booking_date,amount,total_tax,taxids");
        $this->db->from("tkt_booking");
        $this->db->where("payment_status", "NULL");
        $this->db->where("booking_delete_status", 0);
        $this->db->where("tkt_refund_id", null);
        $this->db->where("total_tax >", 0.00);
        $this->db->where("taxids !=", null);
        
        if (!empty($start)) {
            $this->db->where('booking_date >=', $start);
        }

        if (!empty($end)) {
            $this->db->where('booking_date <=', $end);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    // public function tax_rate_by_id($id='')
    // {
    //     return $this->db->select('default_value')->;
    // }

}

