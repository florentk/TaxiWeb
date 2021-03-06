<?php
class ManagerModel extends CI_Model {
  private $fleet_id = 1;

  public function __construct()
  {
     $this->load->database();
  }

	public function get_bicycle_states(){
	   $query = $this->db->get('tw_manager_bicycle_states_view');
     return $query->result();
  }


  public function get_pending_journeys() {return  $this->get_journeys(0);}
  public function get_inprogress_journeys() {return  $this->get_journeys(2);}
  public function get_request_journeys() {return  $this->get_journeys(1);}

  public function get_ended_journeys() {
    $query = $this->db->get('tw_manager_ended_journey_view');
    return $query->result();    
  }

  public function get_unaffected_journeys() {
    $query = $this->db->get('tw_manager_unaffected_journey_view');
    return $query->result();    
  }

	private function get_journeys($state){
	   $query = $this->db->get_where('tw_manager_current_journey_view',array('fleet_id' => $this->fleet_id, 'state' => $state));
     return $query->result();
  }

  public function add_journey($bicycle_id,$customer_name, $start_addr, $destination_addr, $start_time, $end_time ){
    $this->db->insert('tw_customers', array('first_name' => $customer_name));
    $customer_id = $this->db->insert_id();

    $this->db->insert('tw_address', array('way' => $start_addr));
    $start_address_id = $this->db->insert_id();

    $this->db->insert('tw_address', array('way' => $destination_addr));
    $destination_address_id = $this->db->insert_id();

    if ($bicycle_id == 0)
      $bicycle_id = NULL;

    $data =  array(
      'bicycle_id' => $bicycle_id, 
      'state' => 1, 
      'customer_id' => $customer_id,
      'start_address_id' => $start_address_id,
      'destination_address_id' => $destination_address_id, 
      'start_time' => $start_time,
      'end_time' => $end_time
    );

    return $this->db->insert('tw_journey', $data);
  }

  public function end_journey($journey_id){
     $this->set_journey_state($journey_id,3);
  }

  public function affecte_journey($journey_id, $bicycle_id){
    $this->db->where('journey_id', $journey_id);
    if ($bicycle_id == 0)
      $bicycle_id = NULL;
    return $this->db->update('tw_journey', array(
            'bicycle_id' => $bicycle_id
    ));
  }

  public function garage($id){
    $data =  array(
      'state' => 0, 
      'pilot' => NULL
    );
    $this->set_pilot_data($id,$data);
  }

  public function is_garage($id){
    $this->db->where('bicycle_id', $id);
    $this->db->where('state', 0);
    $query = $this->db->get('tw_bicycle');
    return $query->num_rows() === 1;
  }

  private function set_journey_state($journey_id, $state){
    $this->db->where('journey_id', $journey_id);
    return $this->db->update('tw_journey', array(
            'state' => $state
    ));
  }

  private function set_pilot_data($id,$data) {
    $this->db->where('bicycle_id', $id);
    return $this->db->update('tw_bicycle', $data);
  }


}
?>




