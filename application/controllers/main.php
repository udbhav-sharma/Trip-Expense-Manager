<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('helper');
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
		$this->load->model(array(
			'trips_model'
		));
	}

	public function index(){
		$trips = $this->trips_model->getTrips();
		$data = array();
		$data['tab'] = 'my trips';
		$data['trips'] = $trips;
		$this->helper->_render_page('main/trips',$data);
	}

	public function newTrip(){
		$data = array();
		$data['tab']='new trip';
		$this->helper->_render_page('main/new_trip',$data);
	}

	public function editTrip(){
		$data = array();
		$data['tab']=null;
		$this->helper->_render_page('main/edit_trip',$data);
	}

	public function deleteTrip(){

	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */