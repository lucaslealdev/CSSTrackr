<?php
namespace trackr;


class Session{

// protected $db = null;

	function __construct($ip){
		$this->db = \mysqlucas::getInstance(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		$this->db->insert(DB_PREFIX.'session',
			array(
				'ip'=>$ip,
				'updated'=>'now()'
			),
			array('updated')
		);

		if (!isset($this->db->insert_id) || empty($this->db->insert_id)){
			echo $this->db->error_mysqlucas;
			echo $this->db->mysqli_error;
			@session_destroy();
			exit;
		}else{
			$this->id = $this->db->insert_id;
		}
	}
}