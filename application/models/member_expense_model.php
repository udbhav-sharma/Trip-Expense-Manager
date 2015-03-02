<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/2/2015
 * Time: 7:35 PM
 */
class Member_expense_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db_trips = $this->load->database('tep', TRUE);
        $this->load->config('database_tables', TRUE);
        $this->tables = $this->config->item('tables', 'database_tables');
    }

    public function addMemberToExpense($expenseId, $memberIds)
    {
        $data = array(
            'expenseId' => $expenseId
        );

        $this->db_trips->trans_begin();

        foreach ($memberIds as $memberId) {
            $data['memberId'] = $memberId;
            $this->db_trips->insert($this->tables['memberExpense'], $data);
            if ($this->db_trips->affected_rows() == 0) {
                $this->db_trips->trans_rollback();
                return FALSE;
            }
        }

        $this->db_trips->trans_commit();
        return true;
    }

    public function getMemberOfExpense($expenseId, $isJson = false, $isObject = false)
    {
        $query = $this->db_trips->select('memberId')
            ->where(array('expenseId' => $expenseId))
            ->get($this->tables['memberExpense']);
        if ($query->num_rows() > 0) {
            if ($isObject)
                return $query->result();
            elseif ($isJson)
                return json_encode($query->result('array'));
            return $query->result('array');
        }
        return false;
    }

    public function deleteMapping( $expenseId ){
        $this->db_trips->delete($this->tables['memberExpense'],array('expenseId' => $expenseId));
        if($this->db_trips->affected_rows()>0)
            return true;
        return false;
    }

    public function updateMapping( $expenseId, $memberIds ){
        if(!$this->deleteMapping($expenseId))
            return false;
        if(!$this->addMemberToExpense($expenseId,$memberIds))
            return false;
        return true;
    }
}
?>