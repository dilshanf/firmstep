<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Home extends CI_Controller {
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('customer_model');
			
		}
		
		public function index()
		{
			$this->load->view('home');
		}
		
		public function submit_ajax()
		{
			$customer_type = $this->input->post('customer_type');
			$service_type = $this->input->post('service_type');
			$customer_type = $this->input->post('customer_type');
			$fname = ''; $lname = ''; $title = ''; $org_name = '';
			switch ($customer_type) {
				case 'Citizen':
				
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$title = $this->input->post('title');
				
				break;
				case 'Organisation':
				$org_name = $this->input->post('org_name');
				break;
				case 'Anonymous':
				$org_name = 'Anonymous';
				break;
				
				default:
				
			}
			
			$date = date("Ymd");
            $time = date("H:i");
			
			$data = array(
			'service_type' => $service_type,
			'customer_type' => $customer_type,
			'fname' => $fname,
			'lname' => $lname,
			'title' => $title,
			'org_name' => $org_name,
			'date' => $date,
			'time' => $time
			);
			
			$insert = $this->customer_model->save($data);
			$status = true;
			echo json_encode($status);
		}
		
		public function get_ajax()
		{
			$data = $this->customer_model->get($data);
			echo json_encode($data);
		}
		
	}
