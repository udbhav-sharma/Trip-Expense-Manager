<?php
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 11:24 PM
 */

class Members_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->db_trips = $this->load->database('tep', TRUE);
        $this->load->config('database_tables', TRUE);
        $this->tables = $this->config->item('tables', 'database_tables');
    }

    public function getTripMembers( $tripId, $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            id as memberId,
                                            tripId,
                                            name as memberName
                                        ')
                                ->where(array( 'tripId' => $tripId ))
                                ->get($this->tables['members']);
        if($isObject)
            return $query->result();
        elseif($isJson)
            return json_encode($query->result('array'));
        return $query->result('array');
    }

    public function deleteMember( $memberId ){
        $this->db_trips->delete($this->tables['members'],array('id' => $memberId));
        if($this->db_trips->affected_rows()>0)
            return true;
        return false;
    }

}
?>