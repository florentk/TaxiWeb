<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxiweb extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

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

  public function test()
  {
    $data['name'] = 'florent';
    /*$this->PilotModel->set_pilot_name($data['name']);
    $this->PilotModel->set_pilot_state(0);*/
    $data['state'] = $this->PilotModel->get_pilot_state();
    $data['pending_journeys'] = $this->PilotModel->get_pending_journeys();
    $data['current_journey'] = $this->PilotModel->get_current_journey();
    return $this->load->view('test',$data);
  }
}
