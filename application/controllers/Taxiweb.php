<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxiweb extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('PilotModel');
    $this->load->model('ManagerModel');
    $this->PilotModel->init(1);
  }

	public function index()
	{
    $data['name'] = 'florent';
    $data['state'] = $this->PilotModel->get_pilot_state();
    $data['pending_journeys'] = $this->PilotModel->get_pending_journeys();
    $data['current_journey'] = $this->PilotModel->get_current_journey();
    $data['request_journeys'] = $this->PilotModel->get_request_journeys();

		$this->load->view('pilot',$data);
	}

	public function manager()
	{
    $data['bicycles'] = $this->ManagerModel->get_bicycle_states();

    $data['unaffected_journeys'] = $this->ManagerModel->get_unaffected_journeys();
    $data['pending_journeys'] = $this->ManagerModel->get_pending_journeys();
    $data['inprogress_journeys'] = $this->ManagerModel->get_inprogress_journeys();
    $data['request_journeys'] = $this->ManagerModel->get_request_journeys();

    $this->load->view('manager',$data);
  } 

  public function history()
  {
    $data['history'] = $this->ManagerModel->get_ended_journeys();
    $this->load->view('history',$data);
  }

  private function api_ret_err($code, $debug) {
      $this->output
              ->set_content_type('application/json')
              ->set_status_header(400)
              ->set_output(json_encode(array('status' => "Err",'code' => $code,'debug' => $debug))."\n");
  }

  private function api_ret_ok() {
      $this->output
              ->set_content_type('application/json')
              ->set_status_header(200)
              ->set_output(json_encode(array('status' => 'OK'))."\n");
  }

  private function api_set_pos($in) {
    
    if(key_exists("lat",$in) && key_exists("long",$in)){
      if($this->PilotModel->set_pilot_pos($in->lat,$in->long))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    }
  }

  private function api_set_pilot_state($in) {
    if(key_exists("state",$in)){
      if($this->PilotModel->set_pilot_state($in->state))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    }    
  }

  private function api_add_journey($in) {
    if(key_exists("customer_name",$in)
    && key_exists("start_addr",$in)
    && key_exists("destination_addr",$in)
    && key_exists("start_time",$in)
    ){   
      if($this->PilotModel->add_journey($in->customer_name, $in->start_addr, $in->destination_addr,  date('Y-m-d H:i:s',strtotime($in->start_time))))
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
      if($this->ManagerModel->add_journey(intval($in->bicycle_id),$in->customer_name, $in->start_addr, $in->destination_addr,  date('Y-m-d H:i:s',strtotime($in->start_time)),date('Y-m-d H:i:s',strtotime($in->end_time))))
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    } 
   }

  private function api_set_current_journey($in) {
    if(key_exists("id",$in)){
      if($this->PilotModel->end_current_journey() 
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
      if($this->PilotModel->confirm_journey($in->id) )
        $this->api_ret_ok();
      else
        $this->api_ret_err(12,$in);
    }else{
      $this->api_ret_err(11,$in);
    }    
  }

  private function api_pending_current_journey() {
    if($this->PilotModel->pending_current_journey() 
    && $this->PilotModel->set_pilot_state(1))
      $this->api_ret_ok();
    else
      $this->api_ret_err(12,""); 
  }

  private function api_end_current_journey() {
    if($this->PilotModel->end_current_journey() 
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
      else if($in->f === "confirmJourney") 
        $this->api_confirm_journey($in);
      else if($in->f === "setCurrentJourney") 
        $this->api_set_current_journey($in);
      else if($in->f === "pendingCurrentJourney") 
        $this->api_pending_current_journey();
      else if($in->f === "endCurrentJourney") 
        $this->api_end_current_journey();
      else if($in->f === "addJourney") 
        $this->api_add_journey($in);
      else if($in->f === "managerAddJourney") 
        $this->api_manager_add_journey($in);
      else    $this->api_ret_err(2,$in);
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
