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
			'trips_model',
			'members_model',
			'expenses_model'
		));

		$this->lang->load('error_success_messages');
	}

	public function index(){
		$trips = $this->trips_model->getTrips();
		$data = array();
		$data['tab'] = 'my trips';
		$data['trips'] = $trips;
		$this->helper->_render_page('main/trips',$data);
	}

	public function tripDetails(){
		$trips = $this->trips_model->getTrips();
		$data = array();
		$data['trips'] = $this->parseTrips($trips);
		$data['tab']='trip details';
		$this->helper->_render_page('main/trip_details',$data);
	}

	public function deleteTrip(){

	}

	public function getTripData(){
		$tripId = json_decode($this->input->post('tripId'));

		if(empty($tripId)) {
			echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
			return;
		}

		$trip = $this->trips_model->getTripDetails($tripId);
		$members = $this->members_model->getTripMembers($tripId);
		$expenses = $this->expenses_model->getTripExpenses($tripId);

        $this->session->set_userdata(array('tripId'=>$tripId));

		$data=array();
		$data['trip'] = $trip;
		$data['members'] = $members;
		$data['expenses'] = $expenses;
		echo $this->helper->showSuccess($this->lang->line('SuccessDataRetrieval'),$data);
		return;
	}

	public function getNewExpense(){
        $members = $this->members_model->getTripMembers($this->session->userdata('tripId'));

        $data=array();
        $data['members'] = $members;

        $this->load->view('main/new_expense',$data);
    }

	private function parseTrips( $trips ){
		$data=array();
		$row=array();
		foreach($trips as $trip){
			$row['tripId'] = $trip['tripId'];
			$row['tripName'] = $trip['tripName'].' | '.$trip['date'];
			array_push($data,$row);
		}
		return $data;
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */