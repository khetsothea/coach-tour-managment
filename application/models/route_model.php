<?php
class route_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
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
	
	//$query = $this->db->get_where('driver', array('driver_id' => $driver_id));
	return $query->row_array();
}
public function get_town_list()
{
	
		
		$this->db->select('*');
		$this->db->from('town');
		
		$query = $this->db->get();
		
		return $query->result_array();
	
	
	
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

public function set_route($town_l)
{
	$this->load->helper('url');
	$dis=$this->input->post('distance');
		$this->db->select_max('route_ID');
$nor = $this->db->get('route')->first_row();
$no=$nor->route_ID;
$no=$no+5;
foreach($town_l as $townid)
{
	$order=$this->input->post('order'.$townid);
	$this->db->set('route_NO',$no);
	$this->db->set('town_ID',$townid);
	$this->db->set('order_of_route',$order);
	$this->db->insert('towns_of_route'); 
}
	$this->db->set('distance', $dis); 
	$this->db->set('route_NO', $no); 
	$this->db->insert('route'); 
	
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