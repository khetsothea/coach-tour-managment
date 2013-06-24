<?php
class tour_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_tour($tour_id = FALSE)
{
	if ($tour_id === FALSE)
	{
		
		$this->db->select('tour.tour_ID,driver.name as dname,tour.coach_ID,tour.start_Date,individual.name as iname,tour.no_of_passengers,trip.route_ID');
		$this->db->from('tour');
		$this->db->join('driver','driver.driver_ID=tour.driver_ID');
		$this->db->join('trip','trip.trip_ID=tour.trip_ID');
		//$this->db->join('hotel','hotel.town_ID=tour.overnight_stop');
		$this->db->join('individual','individual.individual_ID=tour.individual_ID');

		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	$query = $this->db->get_where('tour', array('tour_ID' => $tour_id));
	return $query->row_array();
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

	$dataphone= array(
		'telephonNum' => $this->input->post('phoneNo')
			
	);
	$this->db->insert('telephone',$dataphone);
	$this->db->select_max('telNo_ID');
$querytele = $this->db->get('telephone');
$row2=$querytele->first_row();

	$data = array(
		'driver_ID' => $this->input->post('driverID'),
		'name' => $this->input->post('name'),
		'address_ID' => $row1->address_ID,
		'telNo_ID' => $row2->telNo_ID
		
	);
	
	return $this->db->insert('driver', $data);
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