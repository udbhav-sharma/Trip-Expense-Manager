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
			'expenses_model',
            'member_expense_model'
		));

		$this->lang->load('error_success_messages');
	}

	public function index(){
        $userId = $this->session->userdata('user_id');
		$trips = $this->trips_model->getTrips($userId);
		$data = array();
		$data['tab'] = 'my trips';
		$data['trips'] = $trips;
		$this->helper->_render_page('main/trips',$data);
	}

	public function tripDetails(){
        $userId = $this->session->userdata('user_id');
		$trips = $this->trips_model->getTrips($userId);
		$data = array();
		$data['trips'] = $this->parseTrips($trips);
		$data['tab']='trip details';
		$this->helper->_render_page('main/trip_details',$data);
	}

    public function addTrip(){

        $userId = $this->session->userdata('user_id');

        $tripName = $this->input->post('tripName');
        $tripDate = $this->input->post('tripDate');

        if(empty($tripName) || empty($tripDate)){
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
            return;
        }

        $tripId = $this->trips_model->addTrip( $userId, $tripName, $tripDate );
        if($tripId) {
            echo $this->helper->showSuccess($this->lang->line('SuccessTripCreation'),array('tripId'=>$tripId,'date'=>$tripDate));
            return;
        }

        echo $this->helper->showError($this->lang->line('ErrorTripCreation'));
        return;
    }

	public function deleteTrip(){

        $userId = $this->session->userdata('user_id');
        $tripId = $this->input->post('tripId');

        if(empty($tripId)){
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
            return;
        }

        if($this->trips_model->deleteTrip( $userId, $tripId )){
            echo $this->helper->showSuccess($this->lang->line('SuccessTripDeletion'));
            return;
        }

        echo $this->helper->showError($this->lang->line('ErrorTripDeletion'));
        return;
	}

	public function getTripData(){
        $userId = $this->session->userdata('user_id');
		$tripId = json_decode($this->input->post('tripId'));

		if(empty($tripId)) {
			echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
			return;
		}

		$trip = $this->trips_model->getTripDetails( $userId, $tripId );
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

    public function addMember(){

    }

    public function deleteMember(){

    }

    public function getExpenseOb(){
        $obType = $this->input->post('obType');
        $tripId = $this->session->userdata('tripId');

        $members = $this->members_model->getTripMembers($tripId);

        foreach($members as $index => $value){
            $members[$index]['flag']=false;
        }

        $expenseOb = new stdClass();
        $expenseOb->expenseDate = date("Y-m-d");
        if($obType==1){
            $expenseOb->members = $members;
            $expenseOb->amount = '';
            $expenseOb->expenseName = '';
            $expenseOb->expenseOption = 1;
            $expenseOb->obType = 1;
            echo $this->helper->showSuccess($this->lang->line('SuccessFormExpenseObject'),$expenseOb);
        }
        elseif($obType==2){
            $expenseId = $this->input->post('expenseId');

            if(empty($expenseId)){
                echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
                return;
            }

            $expense = $this->expenses_model->getExpenseDetails($expenseId);
            $memberIds = $this->member_expense_model->getMemberOfExpense($expenseId);

            if($memberIds && $members)
            foreach($memberIds as $memberId){
                foreach($members as $index => $value){
                    if($value['memberId'] == $memberId['memberId'])
                        $members[$index]['flag'] = true;
                }
            }

            $expenseOb->members = $members;
            $expenseOb->amount = $expense['amount'];
            $expenseOb->expenseName = $expense['expenseName'];
            $expenseOb->expenseOption = $expense['expenseOption'];
            $expenseOb->obType = 2;
            echo $this->helper->showSuccess($this->lang->line('SuccessFormExpenseObject'),$expenseOb);
        }
        else{
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
        }
    }

    public function addExpense(){
        $tripId = $this->session->userdata('tripId');

        $expense = json_decode($this->input->post('expense'));

        $members = $expense->members;
        $expenseName = $expense->expenseName;
        $amount = $expense->amount;
        $expenseOption = $expense->expenseOption;
        $expenseDate = $expense->expenseDate;
        $obType = $expense->obType;

        $memberIds = array();
        foreach($members as $member){
            if($member->flag)
                array_push($memberIds,$member->memberId);
        }

        if($obType==1) {

            if (empty($expenseName) || empty($amount) || empty($expenseOption) || empty($expenseDate)) {
                echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
                return;
            }

            $expenseId = $this->expenses_model->addExpense($tripId, $expenseName, $amount, $expenseOption, $expenseDate);
            if ($expenseId) {
                if ($this->member_expense_model->addMemberToExpense($expenseId, $memberIds)) {
                    echo $this->helper->showSuccess($this->lang->line('SuccessExpenseCreation'));
                    return;
                }
            }

            echo $this->helper->showError($this->lang->line('ErrorExpenseCreation'));
            return;
        }
        elseif($obType==2){

        }
    }

    public function deleteExpense(){

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