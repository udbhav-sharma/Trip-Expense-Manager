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

    public function getTripOb(){
        $userId = $this->session->userdata('user_id');
        $obType = $this->input->post('obType');

        $tripOb = new stdClass();
        if($obType==1){
            $tripOb->tripId = '';
            $tripOb->tripName = '';
            $tripOb->obType = 1;
            $tripOb->tripDate = date("Y-m-d");
            echo $this->helper->showSuccess($this->lang->line('SuccessFormTripObject'),$tripOb);
        }
        elseif($obType==2){
            $tripId = $this->input->post('tripId');

            if(empty($tripId)){
                echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
                return;
            }

            $trip = $this->trips_model->getTripDetails($userId,$tripId);

            $tripOb->tripId = $trip['tripId'];
            $tripOb->tripName = $trip['tripName'];
            $tripOb->obType = 2;
            $tripOb->tripDate = $trip['tripDate'];
            echo $this->helper->showSuccess($this->lang->line('SuccessFormTripObject'),$tripOb);
        }
        else{
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
        }
    }

    public function addTrip(){

        $userId = $this->session->userdata('user_id');

        $trip = json_decode($this->input->post('trip'));

        $tripName = $trip->tripName;
        $tripDate = $trip->tripDate;
        $obType = $trip->obType;

        if(empty($tripName) || empty($tripDate)){
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
            return;
        }

        if($obType==1) {
            $tripId = $this->trips_model->addTrip( $userId, $tripName, $tripDate );
            if ($tripId) {
                $newTrip = $this->trips_model->getTripDetails( $userId, $tripId );
                echo $this->helper->showSuccess($this->lang->line('SuccessTripCreation'),$newTrip);
                return;
            }
            echo $this->helper->showError($this->lang->line('ErrorTripCreation'));
            return;
        }
        elseif($obType==2){
            $tripId = $trip->tripId;
            if ($tripId) {
                if($this->trips_model->updateTrip( $userId, $tripId, $tripName, $tripDate )) {
                    $updatedTrip = $this->trips_model->getTripDetails( $userId, $tripId );
                    echo $this->helper->showSuccess($this->lang->line('SuccessTripUpdate'),$updatedTrip);
                    return;
                }
            }
            echo $this->helper->showError($this->lang->line('ErrorTripUpdate'));
            return;
        }
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
        if($obType==1){
            $expenseOb->expenseId = '';
            $expenseOb->members = $members;
            $expenseOb->amount = '';
            $expenseOb->expenseName = '';
            $expenseOb->expenseOption = 1;
            $expenseOb->obType = 1;
            $expenseOb->expenseDate = date("Y-m-d");
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

            $expenseOb->expenseId = $expense['expenseId'];
            $expenseOb->members = $members;
            $expenseOb->amount = $expense['amount'];
            $expenseOb->expenseName = $expense['expenseName'];
            $expenseOb->expenseOption = $expense['expenseOption'];
            $expenseOb->obType = 2;
            $expenseOb->expenseDate = $expense['expenseDate'];
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

        if (empty($expenseName) || empty($amount) || empty($expenseOption) || empty($expenseDate)) {
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
            return;
        }

        $memberIds = array();
        foreach($members as $member){
            if($member->flag)
                array_push($memberIds,$member->memberId);
        }

        if($obType==1) {
            $expenseId = $this->expenses_model->addExpense($tripId, $expenseName, $amount, $expenseOption, $expenseDate);
            if ($expenseId) {
                if ($this->member_expense_model->addMemberToExpense($expenseId, $memberIds)) {
                    $newExpense = $this->expenses_model->getExpenseDetails($expenseId);
                    echo $this->helper->showSuccess($this->lang->line('SuccessExpenseCreation'),$newExpense);
                    return;
                }
            }
            echo $this->helper->showError($this->lang->line('ErrorExpenseCreation'));
            return;
        }
        elseif($obType==2){
            $expenseId = $expense->expenseId;
            if ($expenseId) {
                if($this->expenses_model->updateExpense( $expenseId, $expenseName, $amount, $expenseOption, $expenseDate )) {
                    if ($this->member_expense_model->updateMapping($expenseId, $memberIds)) {
                        $updatedExpense = $this->expenses_model->getExpenseDetails($expenseId);
                        echo $this->helper->showSuccess($this->lang->line('SuccessExpenseUpdate'),$updatedExpense);
                        return;
                    }
                }
            }
            echo $this->helper->showError($this->lang->line('ErrorExpenseUpdate'));
            return;
        }
    }

    public function deleteExpense(){
        $expenseId = $this->input->post('expenseId');

        if(empty($expenseId)){
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
            return;
        }

        if($this->expenses_model->deleteExpense( $expenseId )){
            echo $this->helper->showSuccess($this->lang->line('SuccessExpenseDeletion'));
            return;
        }

        echo $this->helper->showError($this->lang->line('ErrorExpenseDeletion'));
        return;
    }

	private function parseTrips( $trips ){
		$data=array();
		$row=array();
		foreach($trips as $trip){
			$row['tripId'] = $trip['tripId'];
			$row['tripName'] = $trip['tripName'].' | '.$trip['tripDate'];
			array_push($data,$row);
		}
		return $data;
	}

    public function tripStats(){
        $userId = $this->session->userdata('user_id');
        $trips = $this->trips_model->getTrips($userId);
        $data = array();
        $data['trips'] = $this->parseTrips($trips);
        $data['tab']='trip stats';
        $this->helper->_render_page('main/trip_stats',$data);
    }

    public function getTripExpensesStats(){
        $userId = $this->session->userdata('user_id');
        $tripId = $this->input->post('tripId');

        if(empty($tripId)){
            echo $this->helper->showError($this->lang->line('ErrorInvalidParameter'));
            return;
        }

        $data=array();
        $data['trip'] = $this->trips_model->getTripDetails( $userId, $tripId );
        $data['graphData'] = $this->expenses_model->getTripExpensesStats( $tripId );

        if(!$data){
            echo $this->helper->showError($this->lang->line('ErrorTripStats'));
            return;
        }
        echo $this->helper->showSuccess($this->lang->line('SuccessTripStats'),$data);
        return;
    }

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */