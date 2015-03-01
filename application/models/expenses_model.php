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
                                            DATE(date) as date
                                        ')
            ->where(array( 'tripId' => $tripId ))
            ->get($this->tables['expenses']);
        if($isObject)
            return $query->result();
        elseif($isJson)
            return json_encode($query->result('array'));
        return $query->result('array');
    }
}
?>