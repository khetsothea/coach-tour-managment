<?php
class driver extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('driver_model');
	}

	public function index($d=null)
	
{
	if($d==null){
	$data['driver'] = $this->driver_model->get_driver();
	foreach($data['driver'] as $driver){
		$r=$this->driver_model->get_driver_route($driver['driver_ID']);
		$tel=$this->driver_model->get_driver_tel($driver['driver_ID']);
		//var_dump($tel);
		$st="";
		foreach($r as $ra){
		$st=$st.$ra['route_ID'].",";
		}
		$route_d[$driver['driver_ID']]=$st;
		$tel_d[$driver['driver_ID']]=$tel;
		
	}
	$data['driver_route']=$route_d;
	$data['driver_tel']=$tel_d;
	$data['title'] = 'Drivers Detail';
	}
	else
	$data=$d;
	//var_dump($data['driver']);
	$this->load->view('templates/header',$data);
	$this->load->view('driver/index', $data);
	$this->load->view('templates/footer');
}

	public function view($slug)
	{
		$data['driver'] = $this->driver_model->get_driver($driver_id);
	}
	public function newDriver()
{
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$data['title'] = 'Enter new Driver Detail';
	
	
	$this->form_validation->set_rules('name', 'name', 'required');
	
	$this->form_validation->set_rules('number', 'Number', 'required');
	$this->form_validation->set_rules('street', 'Street', 'required');
	$this->form_validation->set_rules('city', 'City', 'required');
	$this->form_validation->set_rules('phoneNo', 'Phone Number', 'required');
	
	
	if ($this->form_validation->run() === FALSE)
	{
			
		$this->load->view('driver/newDriver');
		$this->load->view('templates/footer');
		
	}
	else
	{
		$this->driver_model->set_driver();
		$this->load->view('driver/success');
		$this->index();
	}
}
function delete()
	{
		$delete_list=$this->input->post('ids');
		$delete_list=(array)$delete_list;
		//var_dump($delete_list);
			
		if($this->driver_model->delete_list($delete_list))
		{
		
			//echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_deleted').' '.
			//count($delete_list).' '.$this->lang->line('customers_one_or_multiple')));
			$this->index();
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('customers_cannot_be_deleted')));
			
		}
	}
	function search()
	{
		$this->load->helper('table_helper');
		$search=$this->input->post('search');
		var_dump($search);
		$delete_list=$this->input->post('idd');
		$delete_list=(array)$delete_list;
		$N=count($delete_list);
		var_dump($delete_list);
		$data_rows=get_people_manage_table_data_rows($this->driver_model->search($search),$this);
		$this->load->view('driver/success');
		echo $data_rows;
	
		
	}
	function suggest()
	{
		echo "gona";
		$suggestions = $this->driver_model->get_search_suggestions($this->input->post('search'));
		echo implode("\n",$suggestions);
	}
	
	public function addRoute($driver_id=false)
{
$this->load->helper('form');
	$this->load->library('form_validation');
	
$driver_id_route=$driver_id;
$data['driver_id']=$driver_id;
$data['route'] = $this->driver_model->get_route();
foreach($data['route'] as $route){
		$r=$this->driver_model->get_route_town($route['route_NO']);
		$st="";
		foreach($r as $ra){
		$st=$st.$ra['name'].",";
		}
		$route_d[$route['route_ID']]=$st;
	}
	$data['route_towns']=$route_d;
	$data['title'] = 'Available route';
	$this->form_validation->set_rules('routeid[]', 'need to select atleast one route', 'required|xss_clean'); 
if ($this->form_validation->run() === FALSE)
	{
			
		$this->load->view('templates/header', $data);
	$this->load->view('driver/route');
	$this->load->view('templates/footer');
		
	}
	else
	{
	$this->load->view('driver/success');
	$route_list=$this->input->post('routeid');
	$id=$this->input->post('driver_id');
		$this->driver_model->set_route_list($route_list,$id);
		$this->index();
	}
	
	
}
	
}