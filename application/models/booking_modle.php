<?php
class booking_modle extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_data()
	{	
		$this->db->distinct();
		$this->db->select('town.name,town.town_id as id');
		$this->db->from('town');
		$this->db->join('towns_of_route','towns_of_route.town_ID=town.town_ID');
		$this->db->where('order_of_route',1);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_end($st){
		$query =$this->db->query("select distinct name, m.route_no route from (select max(order_of_route) as k,route_no from (select * from (select route_no from towns_of_route where order_of_route=1 and town_id=".$st.") as s natural join towns_of_route) as a group by route_no) as l,towns_of_route as m,town as n where l.route_no=m.route_no and l.k=m.order_of_route and n.town_id=m.town_id");
		return $query->result_array();
	}
	
	public function get_time($st){
		$query=$this->db->query("select trip_ID trip,duration,startting_time starttime,overnight_stop overnight from trip join route using(route_id) where route_no=".$st);
		return $query->result_array();
	}
	
	public function get_details($st){
		$query=$this->db->query("select hotel_name,duration,town.name  from hotel,town,trip where trip.overnight_stop=town.town_ID and hotel.town_id=town.town_id and trip.trip_ID=".$st);
		return $query->result_array();
	}
	
	public function add_individual($name,$number,$street,$city,$telHome,$telOffice,$telMoblile,$trip,$passengers,$date){
		$address = array(
				'num' => $number ,
				'street' => $street,
				'city' => $city
		);
		$this->db->insert('address', $address); 
		
		$this->db->select_max('address_ID');
		$query=$this->db->get('address');
		$xxx=$query->row_array();
		
		$adID=$xxx['address_ID'];
		
		$this->db->select_max('telNo_ID');
		$query=$this->db->get('telephone');
		$xxx=$query->row_array();
		
		$tlID=$xxx['telNo_ID']+1; 
		
		if($telHome!=""){
			$tel=array('telephonNum' => (int)$telHome,'telNo_ID' =>$tlID);
			$this->db->insert('telephone', $tel);
		}
		if($telOffice!=""){
			$tel=array('telephonNum' => (int)$telOffice,'telNo_ID' =>$tlID);
			$this->db->insert('telephone', $tel);
		}
		if($telMoblile!=""){
			$tel=array('telephonNum' => (int)$telMoblile,'telNo_ID' =>$tlID);
			$this->db->insert('telephone', $tel);
		}
		
		$individual= array(
				'name' => $name ,
				'address_ID' => $adID,
				'telNo_ID' => $tlID
		);
		
		$this->db->insert('individual', $individual);
		
		$this->db->select_max('individual_ID');
		$query=$this->db->get('individual');
		$xxx=$query->row_array();
		
		$inID=$xxx['individual_ID'];
		
		$tour=array(
				'start_Date' => $date,
				'trip_ID' =>$trip,
				'individual_ID' =>$inID,
				'no_of_passengers' =>$passengers
		);
		
		$this->db->insert('tour',$tour);
		
	}
	public function get_assign(){
		$query=$this->db->query("select tour_id,trip_id,no_of_passengers from tour where driver_id is null");
		return $query->result_array();
	}
	
	public function get_coach($id){
		$query=$this->db->query("select coach_id from coach where mileage<10000");
		return $query->result_array();
	}
	
	public function get_driver($id){
		$query=$this->db->query("select name,driver_id from driver");
		return $query->result_array();
	}
	
	public function update_tour($tourID,$driverID,$coachID){
		$d=array(
				'driver_ID' => $driverID,
				'coach_ID' => $coachID
		);
		$this->db->where('tour_ID', $tourID);
		$this->db->update('tour', $d);
	}
	
}

