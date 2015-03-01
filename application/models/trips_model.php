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

    public function getTrips( $isJson=false, $isObject = false ){
        $query = $this->db_trips->select('
                                            id as tripId,
                                            DATE(date) as date,
                                            name as tripName
                                        ')
                                ->get($this->tables['trips']);
        if($isObject)
            return $query->result();
        elseif($isJson)
            return json_encode($query->result('array'));
        return $query->result('array');
    }
}

?>