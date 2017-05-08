<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Customer_model extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function save($data)
		{
			$this->db->insert('customer_queue', $data);
			return $this->db->insert_id();
		}
		
		public function get()
		{
			$this->db->select('*');
			
			$this->db->from('customer_queue');

			$query = $this->db->get();

			if($query->num_rows()>0){
				return $query->result_array();
			}
		}
	}
