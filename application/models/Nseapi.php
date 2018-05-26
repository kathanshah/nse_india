<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nseapi extends CI_Model {

    public function __construct(){
		parent::__construct();
	}
	
	function get(){
        $this->db->order_by("dt", "asc");
        $response = $this->db->get_where("sh_symbol_data",[
            'sid'=>1,
            'dt > '=> '2018-03-01'
        ])->result_array();

        return $response;
    }

    function getTrending(){
        $result = $this->db->query("SELECT symbol, sum(((close - pclose)/pclose)*100) trend, sum(tqty) tqty, sum(tval) tval
            from sh_symbol_data d 
            JOIN sh_symbols s on d.sid = s.id 
            where d.dt BETWEEN DATE_SUB(now(), INTERVAL 1 MONTH) AND now()
            GROUP BY s.id 
            ORDER BY trend DESC")->result_array();

        return $result;
    }
}