<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxiweb extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('PilotModel');
    $this->load->model('ManagerModel');
    $this->load->library('Mobile_Detect');
    $this->load->library('session');
    
  }

  private function init_with_session(){
    $bicycle_id = $this->session->userdata('bicycle_id');

    if($bicycle_id && !$this->ManagerModel->is_garage($bicycle_id)) {
      $this->PilotModel->init($bicycle_id);
    }else
      return FALSE;

    return $bicycle_id;
  }

	public function index()
	{
    if($bicycle_id=$this->init_with_session()) {
      $data['name'] = $this->PilotModel->get_pilot_name();
      $data['title'] = $data['name'];
      $data['state'] = $this->PilotModel->get_pilot_state();
      $data['pending_journeys'] = $this->PilotModel->get_pending_journeys();
      $data['current_journey'] = $this->PilotModel->get_current_journey();
      $data['request_journeys'] = $this->PilotModel->get_request_journeys();

		  $this->load->view('templates/header',$data);
		  $this->load->view('pilot',$data);
		  $this->load->view('templates/footer');

    }else {
      $data['title'] = 'Identification';
      $data['name'] = $this->session->userdata('pilot_name');
      $data['bicycles'] = $this->ManagerModel->get_bicycle_states();
		  $this->load->view('templates/header',$data);
		  $this->load->view('identification',$data);
		  $this->load->view('templates/footer');      
    }
	}

	private function manager_full($data)
	{
    $data['title'] = 'Manager';
    $date_add_journey['prefix_class'] = "modal";
    $date_add_journey['main_class'] = "modal fade";

		$this->load->view('templates/header',$data);
    $this->load->view('manager/bicycles',$data);
    $this->load->view('manager/buttons',$data);
    $this->load->view('manager/journeys',$data);
    $this->load->view('manager/add_journeys',$date_add_journey);
    $this->load->view('manager/update_journeys',$date_add_journey);
		$this->load->view('templates/footer');
  } 


	private function manager_mini($data)
	{
    $data['title'] = 'Ajouter une course';
    $date_add_journey['prefix_class'] = "form";
    $date_add_journey['main_class'] = "form";

		$this->load->view('templates/header',$data);
    $this->load->view('manager/add_journeys',$date_add_journey);
    $this->load->view('manager/update_journeys',$date_add_journey);
    $this->load->view('manager/journeys',$data);
		$this->load->view('templates/footer');
  } 

  public function manager(){
    $this->detect = new Mobile_Detect;
    $data['bicycles'] = $this->ManagerModel->get_bicycle_states();
    $data['unaffected_journeys'] = $this->ManagerModel->get_unaffected_journeys();
    $data['pending_journeys'] = $this->ManagerModel->get_pending_journeys();
    $data['inprogress_journeys'] = $this->ManagerModel->get_inprogress_journeys();
    $data['request_journeys'] = $this->ManagerModel->get_request_journeys();

    if ( $this->mobile_detect->isMobile() ) 
     $this->manager_mini($data);
    else
     $this->manager_full($data);
  }

  public function history()
  {
    $data['title'] = 'History';
    $data['history'] = $this->ManagerModel->get_ended_journeys();

		$this->load->view('templates/header',$data);
    $this->load->view('history',$data);
		$this->load->view('templates/footer');
  }



  private function api_ret_err($code, $debug) {
      $this->output
              ->set_content_type('application/json')
              ->set_status_header(200)
              ->set_output(json_encode(array('status' => "Err",'code' => $code,'err'=>$this->db->error(),'req' => $debug))."\n");
  }

  private function api_ret_ok() {
      $this->output
              ->set_content_type('application/json')
              ->set_status_header(200)
              ->set_output(json_encode(array('status' => 'OK'))."\n");
  }

  private function api_set_pos($in) {
    
    if(key_exists("lat",$in) && key_exists("long",$in)){
      if($this->init_with_session() 
      && $this->PilotModel->set_pilot_pos($in->lat,$in->long))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    }
  }

  private function api_set_bicycle_id($in) {
    if(key_exists("bicycle_id",$in) 
    && key_exists("pilot_name",$in) 
    && $this->ManagerModel->is_garage($in->bicycle_id)){
      $this->PilotModel->init($in->bicycle_id);
      $this->PilotModel->set_pilot_state(1);
      $this->PilotModel->set_pilot_name($in->pilot_name);
      $this->session->set_userdata('bicycle_id', $in->bicycle_id);
      $this->session->set_userdata('pilot_name', $in->pilot_name);
      $this->api_ret_ok();
    }else{
      $this->api_ret_err(11,$in);
    }    
  }

  private function api_unset_bicycle_id($in) {
    $this->init_with_session();
    $this->PilotModel->set_pilot_name(NULL);
    $this->PilotModel->set_pilot_state(0);
    $this->session->unset_userdata('bicycle_id');
  }

  private function api_set_pilot_state($in) {
    if(key_exists("state",$in)){
      if($this->init_with_session() && $this->PilotModel->set_pilot_state($in->state))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    }    
  }

  private function decode_date($str) {
    if ($str === '') return NULL;
    $t = strtotime($str);
    if($t===FALSE)
      return NULL;
    else
      return date('Y-m-d H:i:s',$t);
  }

  private function api_add_journey($in) {
    if(key_exists("customer_name",$in)
    && key_exists("start_addr",$in)
    && key_exists("destination_addr",$in)
    && key_exists("start_time",$in)
    && key_exists("state",$in)
    ){   
      if($this->init_with_session() && $this->PilotModel->add_journey($in->customer_name, $in->start_addr, $in->destination_addr,  $this->decode_date($in->start_time), $in->state))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    } 
   }


  private function api_manager_add_journey($in) {
    if(key_exists("customer_name",$in)
    && key_exists("bicycle_id",$in)
    && key_exists("start_addr",$in)
    && key_exists("destination_addr",$in)
    && key_exists("start_time",$in)
    && key_exists("end_time",$in)
    ){   
      if($this->ManagerModel->add_journey(intval($in->bicycle_id),$in->customer_name, $in->start_addr, $in->destination_addr,  $this->decode_date($in->start_time),$this->decode_date($in->end_time)))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    } 
   }

  private function api_manager_end_journey($in) {
    if(key_exists("id",$in)) {
      $this->ManagerModel->end_journey($in->id);
      $this->api_ret_ok();
    }else{
      $this->api_ret_err(11,$in);
    } 
  }

  private function api_manager_garage($in) {
    if(key_exists("id",$in)) {
      $this->ManagerModel->garage($in->id);
      $this->api_ret_ok();
    }else{
      $this->api_ret_err(11,$in);
    } 
  }

  private function api_manager_affecte_journey($in) {
    if(key_exists("id",$in) 
    && key_exists("bicycle_id",$in)
    ) {
      $this->ManagerModel->affecte_journey($in->id,$in->bicycle_id);
      $this->api_ret_ok();
    }else{
      $this->api_ret_err(11,$in);
    } 
  }


  private function api_set_current_journey($in) {
    if(key_exists("id",$in)){
      if($this->init_with_session() 
      && $this->PilotModel->end_current_journey() 
      && $this->PilotModel->set_current_journey($in->id) 
      && $this->PilotModel->set_pilot_state(2))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    }    
  }

  private function api_confirm_journey($in) {
    if(key_exists("id",$in)){
      if($this->init_with_session() && $this->PilotModel->confirm_journey($in->id) )
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    }    
  }

  private function api_pending_current_journey() {
    if($this->init_with_session() 
    && $this->PilotModel->pending_current_journey() 
    && $this->PilotModel->set_pilot_state(1))
      $this->api_ret_ok();
    else
      $this->api_ret_err(12,""); 
  }

  private function api_end_current_journey() {
    if($this->init_with_session() 
    && $this->PilotModel->end_current_journey() 
    && $this->PilotModel->set_pilot_state(1))
      $this->api_ret_ok();
    else
      $this->api_ret_err(12,""); 
  }

  public function api() {
    $in = json_decode($this->input->post('req'));

    if($in != null && key_exists("f",$in)) {
      if($in->f === "setPos") 
        $this->api_set_pos($in);
      else if($in->f === "setPilotState") 
        $this->api_set_pilot_state($in);
      else if($in->f === "setBicycleId") 
        $this->api_set_bicycle_id($in);
      else if($in->f === "unsetBicycleId") 
        $this->api_unset_bicycle_id();
      else if($in->f === "confirmJourney") 
        $this->api_confirm_journey($in);
      else if($in->f === "setCurrentJourney") 
        $this->api_set_current_journey($in);
      else if($in->f === "pendingCurrentJourney") 
        $this->api_pending_current_journey();
      else if($in->f === "endCurrentJourney") 
        $this->api_end_current_journey();
      else if($in->f === "managerEndJourney") 
        $this->api_manager_end_journey($in);
      else if($in->f === "addJourney") 
        $this->api_add_journey($in);
      else if($in->f === "managerAddJourney") 
        $this->api_manager_add_journey($in);
      else if($in->f === "affecteJourney") 
        $this->api_manager_affecte_journey($in);
      else if($in->f === "garage") 
        $this->api_manager_garage($in);
      else $this->api_ret_err(2,$in);
    }else $this->api_ret_err(1,$in);
  }

  public function test()
  {
    //$data['name'] = 'florent';
    /*$this->PilotModel->set_pilot_name($data['name']);
    $this->PilotModel->set_pilot_state(0);*/
    /*$data['state'] = $this->PilotModel->get_pilot_state();
    $data['pending_journeys'] = $this->PilotModel->get_pending_journeys();
    $data['current_journey'] = $this->PilotModel->get_current_journey();*/
    return $this->load->view('test');

  }
}
