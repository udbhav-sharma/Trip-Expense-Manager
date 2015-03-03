<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: UDBHAV
 * Date: 3/1/2015
 * Time: 5:53 PM
 */

class Trips_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->db_trips = $this->load->database('tep',TRUE);
        $this->load->config('database_tables', TRUE);
        $this->tables = $this->config->item('tables', 'database_tables');
    }

    public function getTrips( $userId, $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            id as tripId,
                                            date as tripDate,
                                            name as tripName
                                        ')
                                ->where(array('user_id'=>$userId))
                                ->get($this->tables['trips']);
        if($isObject)
            return $query->result();
        elseif($isJson)
            return json_encode($query->result('array'));
        return $query->result('array');
    }

    public function getTripDetails( $userId, $tripId, $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            id as tripId,
                                            date as tripDate,
                                            name as tripName
                                        ')
                                ->where(array('id' => $tripId, 'user_id' => $userId))
                                ->get($this->tables['trips']);
        if($query->num_rows==1) {
            if ($isObject)
                return $query->first_row();
            elseif ($isJson)
                return json_encode($query->first_row('array'));
            return $query->first_row('array');
        }
        return false;
    }

    public function addTrip( $userId, $tripName, $tripDate ){
        $tripDate = strtotime($tripDate);
        $tripDate = date('Y-m-d',$tripDate);

        $data = array(
            'user_id' => $userId,
            'name' => $tripName,
            'date' => $tripDate
        );

        $this->db_trips->insert($this->tables['trips'],$data);
        if($this->db_trips->affected_rows() > 0 )
            return $this->db_trips->insert_id();
        return FALSE;
    }

    public function deleteTrip( $userId, $tripId ){
        $this->db_trips->delete($this->tables['trips'],array('id' => $tripId, 'user_id' => $userId));
        if($this->db_trips->affected_rows()>0)
            return true;
        return false;
    }

    public function updateTrip( $userId, $tripId, $tripName, $tripDate ){
        $tripDate = strtotime($tripDate);
        $tripDate = date('Y-m-d',$tripDate);

        $data = array(
            'name' => $tripName,
            'date' => $tripDate
        );

        $this->db_trips->where(array('id'=>$tripId,'user_id'=>$userId))
            ->update($this->tables['trips'],$data);

        if($this->db_trips->affected_rows() > 0 )
            return true;
        return FALSE;
    }
}

?>