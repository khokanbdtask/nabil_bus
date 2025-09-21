<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
 
	public function create($data = array())
	{
		 // print_r($data);exit();
		return $this->db->insert('api_user', $data);
	}

	public function read()
	{
		return $this->db->select("a.*, 
				CONCAT_WS(' ', b.firstname, b.lastname) AS createby")
			->from('api_user a')
			->join('user b','b.id = a.create_by')
			->order_by('a.id', 'desc')
			->get()
			->result();
	}

		public function delete($id = null)
	{
		return $this->db->where('id', $id)
			            ->delete("api_user");
	}

	public function check_key($key){
		 return $data = $this->db->select('*')
		          ->from('api_user')
		          ->where('secret_key',$key)
		          ->get()
		          ->num_rows();
	}

}