<?php
declare(strict_types=1);
namespace trackr;

class Action{

	private $db;

	function __construct(int $id, string $action,string $value){
		$this->db = \mysqlucas::getInstance(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		switch ($action) {
			case 'browser':
				$this->db->update(DB_PREFIX.'session',
					array(
						'browser'=>$value,
						'updated'=>'now()'
					),
					array('id'=>$id),
					array('updated')
				);
				break;
			case 'viewport':
				$this->db->update(DB_PREFIX.'session',
					array(
						'viewport_width'=>$value,
						'updated'=>'now()'
					),
					array('id'=>$id),
					array('updated')
				);
				break;
			case 'orientation':
				$this->db->update(DB_PREFIX.'session',
					array(
						'orientation'=>$value,
						'updated'=>'now()'
					),
					array('id'=>$id),
					array('updated')
				);
				break;

			default:
				if (in_array($action,array('click', 'hover', 'check'))){
					$this->db->insert(DB_PREFIX.'action',
						array(
							'type'=>$action,
							'session_id'=>$id,
							'value'=>$value,
							'referer'=>((isset($_SERVER["HTTP_REFERER"]) && ".css"!==substr($_SERVER["HTTP_REFERER"],-4))?$_SERVER["HTTP_REFERER"]:null),
							'domain_origin'=>(isset($_SERVER["HTTP_REFERER"])?parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST):null)
						),
						array('updated')
					);
				}
				break;
		}

		if(!empty($this->db->error_mysqlucas)){
			echo $this->db->error_mysqlucas;exit;
		}
		return $this;
	}
}