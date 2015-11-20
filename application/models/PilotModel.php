<?php
class PilotModel extends CI_Model {
  private $id=0;  
  //private $name = "Didier super";

  public function __construct()
  {
     $this->load->database();
  }

  public function init($id)
  {
     $this->id = $id;
  }



  /*
    Get fonctions
  */

  public function get_pilot_state() {
    $this->db->select("state");
    $query = $this->db->get_where('tw_bicycle', array('bicycle_id' => $this->id));
    return $query->row()->state;
  }

	public function get_current_journey(){		
	   $query = $this->db->get_where('tw_pilot_view', array('bicycle_id' => $this->id, 'state' => 2));
     return $query->row();
  }

	public function get_pending_journeys(){		
	   $query = $this->db->get_where('tw_pilot_view', array('bicycle_id' => $this->id, 'state' => 0));
     return $query->result();
	}



  /*
    Set fonctions
  */

  public function set_pilot_name($name) {
    return $this->set_pilot_data(array(
            'pilot' => $name
    ));
  }

  public function set_pilot_state($state) {
    return $this->set_pilot_data(array(
            'state' => $state
    ));
  }

  public function set_pilot_pos($latitude,$longitude) {
    return $this->set_pilot_data(array(
            'latitude' => $latitude,
            'longitude' => $longitude
    ));
  }

  /*
    Private functions
  */

  private function set_pilot_data($data) {
    $this->db->where('bicycle_id', $this->id);
    return $this->db->update('tw_bicycle', $data);
  }
}
?>
