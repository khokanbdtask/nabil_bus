<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_method_model extends CI_Model {
 
	private $table = "acc_payment_method";


	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}

	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->get()
			->result();
	} 

	public function findById($id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('id',$id) 
			->get()
			->row();
	} 
 
	public function update($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update($this->table,$data); 
	} 


	public function delete($id = null)
	{
		$this->db->where('id',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 

	public function dropdown()
	{
		$data = $this->db->select("*")
			->from($this->table)
			->get()
			->result();

		$list[''] = display('select_option');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->id] = $value->type;
			return $list;
		} else {
			return false; 
		}
	}
	public function paymentmethod()
	{
        $this->db->select('*');
        $this->db->from($this->table);
       
        $query = $this->db->get();
        $data  = $query->result();
        $list = array('' => 'Select One...');
        if (!empty($data)) {
            foreach ($data as $value) {
                $list[$value->id] = $value->payment_method;
            }
        }
        return $list;
    }

	public function paymentmethoddropdown()
	{
        $this->db->select('*');
        $this->db->from($this->table);
       
        $query = $this->db->get();
        $data  = $query->result();
       
        
        return $data;
    }


}
