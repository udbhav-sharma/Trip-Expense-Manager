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
                                            trip_id as tripId,
                                            name as memberName
                                        ')
                                ->where(array( 'trip_id' => $tripId ))
                                ->get($this->tables['members']);
        if($isObject)
            return $query->result();
        elseif($isJson)
            return json_encode($query->result('array'));
        return $query->result('array');
    }

    public function getMemberDetails( $memberId, $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            id as memberId,
                                            trip_id as tripId,
                                            name as memberName
                                        ')
            ->where(array( 'id' => $memberId ))
            ->get($this->tables['members']);
        if($query->num_rows==1) {
            if ($isObject)
                return $query->first_row();
            elseif ($isJson)
                return json_encode($query->first_row('array'));
            return $query->first_row('array');
        }
        return false;
    }

    public function addMember( $tripId, $memberName ){
        $data = array(
            'trip_id' => $tripId,
            'name' => $memberName
        );

        $this->db_trips->insert($this->tables['members'],$data);
        if($this->db_trips->affected_rows() > 0 )
            return $this->db_trips->insert_id();
        return FALSE;
    }

    public function deleteMember( $memberId ){
        $this->db_trips->delete($this->tables['members'],array('id' => $memberId));
        if($this->db_trips->affected_rows()>0)
            return true;
        return false;
    }

    public function updateMember($memberId, $memberName ){
        $data = array(
            'name' => $memberName
        );

        $this->db_trips->where(array('id'=>$memberId))
            ->update($this->tables['members'],$data);

        if($this->db_trips->affected_rows() > 0 )
            return true;
        return FALSE;
    }

}
?>