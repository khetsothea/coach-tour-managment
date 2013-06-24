<?php

class Pages extends CI_Controller {
	public function __construct()
	{
		require_once('driver.php');
		parent::__construct();
		$this->load->model('booking_modle');
	}

	public function view($page = 'logging')
	{
		if ( ! file_exists('application/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter
		$starting=$this->booking_modle->get_data();
		$data['sss'] = $starting;
		$this->load->view('templates/header1', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}


	public function log()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Logging window';

		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header1', $data);
			$this->load->view('pages/logging');
			$this->load->view('templates/footer');

		}
		else
		{	if($this->input->post('username')=="scheduling"){
			$this->book();
		}
		else if($this->input->post('username')=="booking"){
			$this->getassign();
		}
		else if($this->input->post('username')=="admin"){
			$dri = new driver();
			$dri->index();
		}

		else{
			$this->load->view('templates/header1', $data);
			$this->load->view('pages/logging');
			$this->load->view('templates/footer');
		}
		}
	}

	public function getend($id){
		$data['idd']=$id;
		$starting=$this->booking_modle->get_data();
		$data['sss'] = $starting;
		foreach ($starting as $qq){
			$tw=$qq['id'];
			$data['mmm'][$tw]=$this->booking_modle->get_end($tw);
		}

		$this->load->view('pages/end',$data);
	}

	public function gettime($id){
		$data['hhh']=$this->booking_modle->get_time($id);
		$this->load->view('pages/time',$data);
	}
	
	public function getdetails($id){
		$data['zzz']=$this ->booking_modle->get_details($id);
		$this->load->view('pages/details',$data);
	}

	public function book(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'name', 'required');

		$data['title'] = ucfirst('schedule'); // Capitalize the first letter
		$starting=$this->booking_modle->get_data();
		$data['sss'] = $starting;

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header1', $data);
			$this->load->view('pages/scheduling', $data);
			$this->load->view('templates/footer', $data);

		}
		else{
			$name=$this->input->post('name');
			$number=$this->input->post('number');
			$street=$this->input->post('street');
			$city=$this->input->post('city');
			$telHome=$this->input->post('telHome');
			$telOffice=$this->input->post('telOffice');
			$telMoblile=$this->input->post('telMoblile');
			$trip=$this->input->post('time');
			$passengers=$this->input->post('passengers');
			$date=$this->input->post('date');

			$this->booking_modle->add_individual($name,$number,$street,$city,$telHome,$telOffice,$telMoblile,$trip,$passengers,$date);
			
			$this->load->view('templates/header1', $data);
			$this->load->view('pages/scheduling', $data);
			$this->load->view('templates/footer', $data);
		}
	}
	public function getassign(){
		$this->load->helper('form');
		$assign=$this->booking_modle->get_assign();
		foreach ($assign as $item){
			$coach[$item['tour_id']]=$this->booking_modle->get_coach($item['tour_id']);
			$driver[$item['tour_id']]=$this->booking_modle->get_driver($item['tour_id']);
		}
		
		$data['assign']=$assign;
		$data['coach']=$coach;
		$data['driver']=$driver;
		$data['title']='Assign';
		$this->load->view('templates/header1', $data);
		$this->load->view('pages/assign',$data);
		$this->load->view('templates/footer');
	}
	public function submitvalue($id){
		$driver=$this->input->post('driver');
		$coach=$this->input->post('coach');
		$this->booking_modle->update_tour($id,$driver,$coach);
		$this->getassign();
	}
}

