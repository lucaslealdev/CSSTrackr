<?php
declare(strict_types=1);
namespace trackr;

class Admin{

	private $db;
	public $id;
	public $username;

	function __construct(){
		$this->db = \mysqlucas::getInstance(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	}

	function login(string $user, string $pwd) : bool {
		$this->db->select(DB_PREFIX.'admin',array('username'=>$user));
		if (!isset($this->db->id)){
			return false;
		}elseif(password_verify($pwd,$this->db->password)){
			$this->id = $this->db->id;
			$this->username = $this->db->username;
			return true;
		}else{
			return false;
		}
	}
}