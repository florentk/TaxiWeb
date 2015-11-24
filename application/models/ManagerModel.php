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

  public function get_unaffected_journeys() {
	   $query = $this->db->get_where('tw_manager_current_journey_view',array('pilot' => NULL));
     return $query->result();    
  }

  public function get_pending_journeys() {return  $this->get_journeys(0);}
  public function get_inprogress_journeys() {return  $this->get_journeys(2);}
  public function get_request_journeys() {return  $this->get_journeys(1);}

  public function get_ended_journeys() {
    $query = $this->db->get('tw_manager_ended_journey_view');
    return $query->result();    
  }


	private function get_journeys($state){
	   $query = $this->db->get_where('tw_manager_current_journey_view',array('fleet_id' => $this->fleet_id, 'state' => $state));
     return $query->result();
  }

}
?>




