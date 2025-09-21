<?php defined('BASEPATH') or exit('No direct script access allowed');

class Agent_model extends CI_Model
{
// Agent Log/Agent summary
    public function agent_log($limit, $start)
    {
        $this->db->select('a.*,count(b.booking_id) as booking_id,sum(b.total_price*b.	commission_rate/100) as total_commission,sum(b.total_price) as total_amount');
        $this->db->from('agent_info a');
        $this->db->join('agent_ledger b', 'b.agent_id=a.agent_id', 'left');
        $this->db->join('tkt_booking c', 'c.id_no=b.booking_id');
        if ($this->session->userdata('isAdmin') == 0) {
            $this->db->where('a.agent_id', $this->session->userdata('id'));
        }
        $this->db->where('b.booking_id !=', '');
        $this->db->where('c.tkt_refund_id', 'NULL');
        $this->db->limit($limit, $start);
        $this->db->group_by('b.agent_id');
        $this->db->order_by('a.agent_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function count_agent_log()
    {
        $this->db->select('a.*,count(b.booking_id) as booking_id,sum(b.total_price*b. commission_rate/100) as total_commission,sum(b.total_price) as total_amount');
        $this->db->from('agent_info a');
        $this->db->join('agent_ledger b', 'b.agent_id=a.agent_id', 'left');
        $this->db->join('tkt_booking c', 'c.id_no=b.booking_id');
        if ($this->session->userdata('isAdmin') == 0) {
            $this->db->where('a.agent_id', $this->session->userdata('id'));
        }
        $this->db->where('b.booking_id !=', '');
        $this->db->where('c.tkt_refund_id', 'NULL');
        $this->db->group_by('b.agent_id');
        $this->db->order_by('a.agent_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

// Agent drop down
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
                $list[$value->agent_id] = $value->agent_first_name . ' ' . $value->agent_second_name;
            }

            return $list;
        } else {
            return false;
        }

    }
// Agent date to date report
    public function agent_details($id, $start_date, $end_date, $booking_type = null)
    {

        if ($booking_type === 1) {
            $this->db->select("a.*,b.tkt_refund_id,b.date as create_date");
            $this->db->from('agent_ledger a');
            $this->db->join('tkt_booking b', 'b.id_no = a.booking_id', 'left');

            // New code 2021 show all data of all agent

            if ($id == "all") {

            } else {
                $this->db->where('a.agent_id', $id);
            }

            // New code 2021 show all data of all agent

            $this->db->where('DATE(b.date) >=', $start_date);
            $this->db->where('DATE(b.date) <=', $end_date);
            $this->db->where('a.booking_id !=', '');
            $this->db->like('a.booking_id', 'B', 'after');
            $this->db->order_by('b.date', 'desc');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;

            // return $this->db->query("SELECT * FROM `agent_ledger` WHERE agent_id = '$id' AND booking_id != '' AND date >= '$start_date' AND date <= '$end_date' AND booking_id LIKE 'B%' ")->result();
        } elseif ($booking_type === 2) {

            $this->db->select("a.*,b.luggage_refund_id as tkt_refund_id,b.create_date as create_date");
            $this->db->from('agent_ledger a');
            $this->db->join('luggage_booking b', 'b.id_no = a.booking_id', 'left');

            // New code 2021 show all data of all agent
            if ($id == "all") {

            } else {
                $this->db->where('a.agent_id', $id);
            }

            // New code 2021 show all data of all agent

            $this->db->where('DATE(b.create_date)>=', $start_date);
            $this->db->where('DATE(b.create_date)<=', $end_date);
            $this->db->where('a.booking_id !=', '');
            $this->db->like('a.booking_id', 'LB', 'after');
            $this->db->order_by('b.create_date', 'desc');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;

            // return $this->db->query("SELECT * FROM `agent_ledger` WHERE agent_id = '$id' AND booking_id != '' AND date >= '$start_date' AND date <= '$end_date' AND booking_id LIKE 'LB%' ")->result();
        } else {

            $this->db->select("a.*,b.tkt_refund_id,b.date as create_date");
            $this->db->from('agent_ledger a');
            $this->db->join('tkt_booking b', 'b.id_no = a.booking_id', 'left');

            // New code 2021 show all data of all agent
            if ($id == "all") {

            } else {
                $this->db->where('a.agent_id', $id);
            }
            // New code 2021 show all data of all agent

            $this->db->where('DATE(b.date) >=', $start_date);
            $this->db->where('DATE(b.date) <=', $end_date);
            $this->db->where('a.booking_id !=', '');
            $this->db->order_by('b.date', 'desc');
            $query = $this->db->get();
            var_dump($query->result());
            exit;
            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
            // return $this->db->query("SELECT * FROM `agent_ledger` WHERE agent_id = '$id' AND booking_id != '' AND date >= '$start_date' AND date <= '$end_date'")->result();
        }

    }

    public function agent_inf($id)
    {

        return $this->db->select('*')
            ->from('agent_info')
            ->where('agent_id', $id)
            ->get()
            ->row();
    }

}
