<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxiweb extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('PilotModel');
    $this->PilotModel->init(1);
  }

	public function index()
	{
    $data['name'] = 'florent';
    $data['state'] = $this->PilotModel->get_pilot_state();
    $data['pending_journeys'] = $this->PilotModel->get_pending_journeys();
    $data['current_journey'] = $this->PilotModel->get_current_journey();
		$this->load->view('pilot',$data);
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

  public function api() {
    $in = json_decode($this->input->post('req'));

    if($in != null && key_exists("f",$in)) {
      if($in->f === "setPos") 
        $this->api_set_pos($in);
      else  
        $this->api_ret_err(2,$in);
    }else $this->api_ret_err(1,$in);
  }

  public function test()
  {
    //$data['name'] = 'florent';
    /*$this->PilotModel->set_pilot_name($data['name']);
    $this->PilotModel->set_pilot_state(0);*/
    /*$data['state'] = $this->PilotModel->get_pilot_state();
    $data['pending_journeys'] = $this->PilotModel->get_pending_journeys();
    $data['current_journey'] = $this->PilotModel->get_current_journey();
    return $this->load->view('test',$data);*/

  }
}
