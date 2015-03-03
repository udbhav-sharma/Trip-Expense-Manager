<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/2/2015
 * Time: 12:05 AM
 */
class Expenses_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->db_trips = $this->load->database('tep', TRUE);
        $this->load->config('database_tables', TRUE);
        $this->tables = $this->config->item('tables', 'database_tables');
    }

    public function getTripExpenses( $tripId, $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            id as expenseId,
                                            tripId,
                                            name as expenseName,
                                            amount,
                                            option as expenseOption,
                                            date as expenseDate
                                        ')
                                ->where(array( 'tripId' => $tripId ))
                                ->order_by('date desc')
                                ->get($this->tables['expenses']);
        if($isObject)
            return $query->result();
        elseif($isJson)
            return json_encode($query->result('array'));
        return $query->result('array');
    }

    public function getExpenseDetails( $expenseId, $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            id as expenseId,
                                            tripId,
                                            name as expenseName,
                                            amount,
                                            option as expenseOption,
                                            date as expenseDate
                                        ')
                                ->where(array( 'id' => $expenseId ))
                                ->get($this->tables['expenses']);
        if($query->num_rows==1) {
            if ($isObject)
                return $query->first_row();
            elseif ($isJson)
                return json_encode($query->first_row('array'));
            return $query->first_row('array');
        }
        return false;
    }

    public function addExpense( $tripId, $expenseName, $amount, $expenseOption, $expenseDate ){
        $expenseDate = strtotime($expenseDate);
        $expenseDate = date('Y-m-d',$expenseDate);

        $data = array(
            'tripId' => $tripId,
            'name' => $expenseName,
            'amount' => $amount,
            'option' => $expenseOption,
            'date' => $expenseDate
        );

        $this->db_trips->insert($this->tables['expenses'],$data);
        if($this->db_trips->affected_rows() > 0 )
            return $this->db_trips->insert_id();
        return FALSE;
    }

    public function deleteExpense( $expenseId ){
        $this->db_trips->delete($this->tables['expenses'],array('id' => $expenseId));
        if($this->db_trips->affected_rows()>0)
            return true;
        return false;
    }

    public function updateExpense($expenseId, $expenseName, $amount, $expenseOption, $expenseDate ){
        $expenseDate = strtotime($expenseDate);
        $expenseDate = date('Y-m-d',$expenseDate);

        $data = array(
            'name' => $expenseName,
            'amount' => $amount,
            'option' => $expenseOption,
            'date' => $expenseDate
        );

        $this->db_trips->where(array('id'=>$expenseId))
                       ->update($this->tables['expenses'],$data);

        if($this->db_trips->affected_rows() > 0 )
            return true;
        return FALSE;
    }

    public function getTripExpensesStats($tripId, $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            sum(amount) as amount,
                                            date
                                        ')
            ->where(array( 'tripId' => $tripId ))
            ->group_by('date')
            ->order_by('date asc')
            ->get($this->tables['expenses']);

        if($query->num_rows()>0) {
            if ($isObject)
                return $query->result();
            elseif ($isJson)
                return json_encode($query->result('array'));
            return $query->result('array');
        }
        return false;
    }

}
?>