<?php
class coach_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_coach($coach_id = FALSE)
{
	if ($coach_id === FALSE)
	{
		
		$this->db->select('*');
		$this->db->from('coach');
		
		

		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	$query = $this->db->get_where('coach', array('coach_ID' => $coach_id));
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
public function set_coach()
{
;

	$data = array(
		'capacity' => $this->input->post('capacity'),
		'date_of_last_service' => $this->input->post('date_of_last_service'),
		'mileage' => $this->input->post('mileage')
		
	);
	
	return $this->db->insert('coach', $data);
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