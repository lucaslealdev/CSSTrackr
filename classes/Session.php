<?php
declare(strict_types=1);
namespace trackr;

class Session{

	private $db;

	function __construct(string $ip = ''){
		$this->db = \mysqlucas::getInstance(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if (empty($ip)) return $this;

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
		return $this;
	}

	function list_today() : array{
		$result = $this->db->mysqli_prepared_query("SELECT
			".DB_PREFIX."session.id,
			email,
			ip,
			browser,
			viewport_width,
			orientation,
			updated,
			".DB_PREFIX."session.created,
			count(".DB_PREFIX."action.id) as n_actions
			FROM ".DB_PREFIX."session
			left join ".DB_PREFIX."action on ".DB_PREFIX."action.session_id=".DB_PREFIX."session.id
			WHERE ".DB_PREFIX."session.created between curdate() and now()
			group by ".DB_PREFIX."session.id"
		);

		if (empty($result)) $result = array();

		return $result;
	}
}