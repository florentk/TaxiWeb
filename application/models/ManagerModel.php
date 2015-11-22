<?php
class ManagerModel extends CI_Model {
  public function __construct()
  {
     $this->load->database();
  }

	public function get_bicycle_states(){
	   $query = $this->db->get('tw_manager_bicycle_states_view');
     return $query->result();
  }

  /*
    Get fonctions
  */

}
?>




