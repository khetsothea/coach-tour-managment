<?php
class driver_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_driver($driver_id = FALSE)
{
	if ($driver_id === FALSE)
	{
		
		$this->db->select('*');
		$this->db->from('driver');
		//$this->db->join('telephone','telephone.telNo_ID=driver.telNo_ID');
		$this->db->join('address','address.address_ID=driver.address_ID');
		$query = $this->db->get();
		
		
		return $query->result_array();
	}
	
	//$query = $this->db->get_where('driver', array('driver_id' => $driver_id));
	return $query->row_array();
}
	public function get_driver_tel($telno)
{
	
		
		$this->db->select('telephonNum');
		$this->db->from('telephone');
		$this->db->where('telNO_ID',$telno);
		$query = $this->db->get();
		
		
		return $query->result_array();
	
	
	//$query = $this->db->get_where('driver', array('driver_id' => $driver_id));
	
}
public function get_driver_route($driver_id = FALSE)
{
	if ($driver_id === FALSE)
	{
		return false;
	}
		
		$this->db->select('route_ID');
		$this->db->from('driver_route');
		$this->db->where('driver_ID',$driver_id);
			$query = $this->db->get();

		//$query = $this->db->get();
		
		return $query->result_array();
	
	}
public function get_route($route_id = FALSE)
{
	if ($route_id === FALSE)
	{
		
		$this->db->select('*');
		$this->db->from('route');
		

		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	$query = $this->db->get_where('route', array('route_ID' => $route_id));
	return $query->row_array();
}
public function get_route_town($route_no = FALSE)
{
	if ($route_no === FALSE)
	{
		return false;
	}
		
		$this->db->select('*');
		$this->db->from('towns_of_route');
		$this->db->join('town','town.town_ID=towns_of_route.town_ID');
		$this->db->where('route_NO',$route_no);
		$this->db->order_by("order_of_route", "asc");
			$query = $this->db->get();

		//$query = $this->db->get();
		
		return $query->result_array();
	
	}
public function set_driver()
{
	$this->load->helper('url');
	
	$dataadd= array(
		'num' => $this->input->post('number'),
		'street' => $this->input->post('street'),
		'city' => $this->input->post('city')
		
	);
	$this->db->insert('address',$dataadd);
	$this->db->select_max('address_ID');
$queryaddress = $this->db->get('address');
$row1=$queryaddress->first_row();
$this->db->select_max('telNo_ID');
$querytele = $this->db->get('telephone');
$row2=$querytele->first_row();
$telno=$row2->telNo_ID+1;
	$dataphone= array(
		'telNo_ID'=>$telno,
		'telephonNum' => $this->input->post('phoneNo')
			
	);
	$this->db->insert('telephone',$dataphone);
	

	$data = array(
		'driver_ID' => $this->input->post('driverID'),
		'name' => $this->input->post('name'),
		'address_ID' => $row1->address_ID,
		'telNo_ID' => $telno
		
	);
	
	return $this->db->insert('driver', $data);
}
function set_route_list($route_list,$driver_id)
{
echo $driver_id;
	foreach($route_list as $route){
		$this->db->set('driver_ID', $driver_id);
		$this->db->set('route_ID', $route);
		$this->db->insert('driver_route');
	}
}
function delete_list($customer_ids)
	{
		$this->db->where_in('driver_ID',$customer_ids);
		return $this->db->delete('driver');
 	}
	function search($search)
	{
		$this->db->from('driver');
		$this->db->join('telephone','telephone.telNo_ID=driver.telNo_ID');
		$this->db->join('address','address.address_ID=driver.address_ID');	
		$this->db->where("(name LIKE '%".$this->db->escape_like_str($search)."%' or 
		driver_ID LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");		
		$this->db->order_by("driver_ID", "asc");
		
		return $this->db->get();	
	}
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('driver');
			
		$this->db->where("(name '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->name;		
		}
		
		$this->db->from('driver');	
		$this->db->where('deleted',0);		
		$this->db->like("driver_ID",$search);
		$this->db->order_by("driver_ID", "asc");		
		$by_email = $this->db->get();
		foreach($by_email->result() as $row)
		{
			$suggestions[]=$row->driver_ID;		
		}

		/*$this->db->from('driver');
		$this->db->join('telephone','telephone.telNo_ID=driver.telNo_ID');	
		$this->db->where('deleted',0);		
		$this->db->like("telephonNum",$search);
		$this->db->order_by("telephonNum", "asc");		
		$by_phone = $this->db->get();
		foreach($by_phone->result() as $row)
		{
			$suggestions[]=$row->telephonNum;		
		}*/
		
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	
	}
}