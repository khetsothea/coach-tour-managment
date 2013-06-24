<?php
class route extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('route_model');
	}

	public function index($d=null)
{
	if($d==null){
	$data['route'] = $this->route_model->get_route();
	foreach($data['route'] as $route){
		$r=$this->route_model->get_route_town($route['route_NO']);
		$st="";
		foreach($r as $ra){
		$st=$st.$ra['name'].",";
		}
		$route_d[$route['route_ID']]=$st;
	}
	$data['route_towns']=$route_d;
	$data['title'] = 'Drivers Detail';
	}
	else
	$data=$d;
	//var_dump($data['driver']);
	$this->load->view('templates/header',$data);
	$this->load->view('route/index', $data);
	$this->load->view('templates/footer');
}

	public function view($route_id)
	{
		$data['route'] = $this->route_model->get_route($route_id);
	}
	public function newRoute()
{
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$data['title'] = 'Enter new Route Detail';
	$data['town']=$this->route_model->get_town_list();
	
	$this->form_validation->set_rules('distance', 'Distance', 'required');
	
	
	
	if ($this->form_validation->run() === FALSE)
	{
			
		$this->load->view('route/newRoute',$data);
		$this->load->view('templates/footer');
		
	}
	else
	{
		$town_l=$this->input->post('idd');
		$this->route_model->set_route($town_l);
		$this->load->view('driver/success');
		$this->index();
	}
}
function delete()
	{
		$delete_list=$this->input->post('idd');
		$delete_list=(array)$delete_list;
		$N=count($delete_list);
		var_dump($delete_list);
			for($i=0; $i < $N; $i++)
			{
			echo "gona"; 
			echo $N;
			echo $delete_list[$i] . "<br/>";
			}
		if($this->driver_model->delete_list($delete_list))
		{
		
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_deleted').' '.
			count($delete_list).' '.$this->lang->line('customers_one_or_multiple')));
			
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
		
		$data_rows=get_people_manage_table_data_rows($this->driver_model->search($search),$this);
		$this->load->view('driver/success');
		echo $data_rows;
	
		
	}
	function suggest()
	{
		$suggestions = $this->driver_model->get_search_suggestions($this->input->post('search'));
		echo implode("\n",$suggestions);
	}
	
	public function addRoute($driver_id)
{
$driver_id_route=$driver_id;
echo $driver_id;
$data['driver_id']=$driver_id;
$data['route'] = $this->driver_model->get_route();

	$data['title'] = 'Available route';

	$this->load->view('templates/header', $data);
	$this->load->view('driver/route', $data);
	$this->load->view('templates/footer');
	
}
	public function setroute($driver_id)
{

$route_list=$_POST['routeid'];
		$N=count($route_list);
			for($i=0; $i < $N; $i++)
			{
			echo "gona"; 
			echo $N;
			echo $route_list[$i] . "<br/>";
			}
	
}
}