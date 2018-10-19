<?php
namespace trackr;

class Stats{

	private $db;
	public $id;
	public $username;

	function __construct(){
		$this->db = \mysqlucas::getInstance(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	}

	function actions_week_compare() {
		$data = $this->db->mysqli_prepared_query("SELECT
			(
			SELECT
			COUNT(*)
			FROM ".DB_PREFIX."action
			WHERE created BETWEEN DATE_SUB(now(), interval 2 week) AND DATE_SUB(now() , interval 1 week)
			) as last_week,
			(
			SELECT
			COUNT(*)
			FROM ".DB_PREFIX."action
			WHERE created BETWEEN DATE_SUB(now(), interval 1 week) AND now()
			) as this_week");

		$data = $data[0];
		$data['this_week'] = $data['this_week']===0?1:$data['this_week'];
		$data['last_week'] = $data['last_week']===0?1:$data['last_week'];

		$data['variation'] = round(100*$data['this_week']/$data['last_week']-100,2);

		switch (true) {
			case ($data['this_week']>9999 && $data['this_week']<=999999):
				$data['this_week']=number_format($data['this_week']/1000,2).'K';
				break;
			case ($data['this_week']>9999 && $data['this_week']<=9999999):
				$data['this_week']=number_format($data['this_week']/1000000,2).'M';
				break;
			case ($data['this_week']>9999999):
				$data['this_week']=number_format($data['this_week']/1000000000,2).'B';
				break;
		}
		switch (true) {
			case ($data['last_week']>9999 && $data['last_week']<=999999):
				$data['last_week']=number_format($data['last_week']/1000,2).'K';
				break;
			case ($data['last_week']>9999 && $data['last_week']<=9999999):
				$data['last_week']=number_format($data['last_week']/1000000,2).'M';
				break;
			case ($data['last_week']>9999999):
				$data['last_week']=number_format($data['last_week']/1000000000,2).'B';
				break;
		}

		return $data;
	}
	function sessions_week_compare() {
		$data = $this->db->mysqli_prepared_query("SELECT
			(
			SELECT
			COUNT(*)
			FROM ".DB_PREFIX."session
			WHERE created BETWEEN DATE_SUB(now(), interval 2 week) AND DATE_SUB(now() , interval 1 week)
			) as last_week,
			(
			SELECT
			COUNT(*)
			FROM ".DB_PREFIX."session
			WHERE created BETWEEN DATE_SUB(now(), interval 1 week) AND now()
			) as this_week");

		$data = $data[0];
		$data['this_week'] = $data['this_week']===0?1:$data['this_week'];
		$data['last_week'] = $data['last_week']===0?1:$data['last_week'];

		$data['variation'] = round(100*$data['this_week']/$data['last_week']-100,2);

		switch (true) {
			case ($data['this_week']>9999 && $data['this_week']<=999999):
				$data['this_week']=number_format($data['this_week']/1000,2).'K';
				break;
			case ($data['this_week']>9999 && $data['this_week']<=9999999):
				$data['this_week']=number_format($data['this_week']/1000000,2).'M';
				break;
			case ($data['this_week']>9999999):
				$data['this_week']=number_format($data['this_week']/1000000000,2).'B';
				break;
		}
		switch (true) {
			case ($data['last_week']>9999 && $data['last_week']<=999999):
				$data['last_week']=number_format($data['last_week']/1000,2).'K';
				break;
			case ($data['last_week']>9999 && $data['last_week']<=9999999):
				$data['last_week']=number_format($data['last_week']/1000000,2).'M';
				break;
			case ($data['last_week']>9999999):
				$data['last_week']=number_format($data['last_week']/1000000000,2).'B';
				break;
		}

		return $data;
	}
	function actions_week_compare_list() {
		$data = $this->db->mysqli_prepared_query("SELECT
		A.value,
		count(*) as this_week,
		(
			SELECT
			count(*)
			from ".DB_PREFIX."action WHERE
			created BETWEEN DATE_SUB(now(), interval 2 week) AND DATE_SUB(now() , interval 1 week)
			and value=A.value
		) as last_week
		FROM ".DB_PREFIX."action A
		WHERE
		A.created BETWEEN DATE_SUB(now(), interval 1 week) AND now()

		group by A.value

		order by this_week desc");

		foreach($data as &$linha){
			$linha['this_week'] = $linha['this_week']===0?1:$linha['this_week'];
			$linha['last_week'] = $linha['last_week']===0?1:$linha['last_week'];

			$linha['variation'] = round(100*$linha['this_week']/$linha['last_week']-100,2);

			switch (true) {
				case ($linha['this_week']>9999 && $linha['this_week']<=999999):
					$linha['this_week']=number_format($linha['this_week']/1000,2).'K';
					break;
				case ($linha['this_week']>9999 && $linha['this_week']<=9999999):
					$linha['this_week']=number_format($linha['this_week']/1000000,2).'M';
					break;
				case ($linha['this_week']>9999999):
					$linha['this_week']=number_format($linha['this_week']/1000000000,2).'B';
					break;
			}
			switch (true) {
				case ($linha['last_week']>9999 && $linha['last_week']<=999999):
					$linha['last_week']=number_format($linha['last_week']/1000,2).'K';
					break;
				case ($linha['last_week']>9999 && $linha['last_week']<=9999999):
					$linha['last_week']=number_format($linha['last_week']/1000000,2).'M';
					break;
				case ($linha['last_week']>9999999):
					$linha['last_week']=number_format($linha['last_week']/1000000000,2).'B';
					break;
			}
		}

		return $data;
	}
	function browsers() {
		$data = $this->db->mysqli_prepared_query("SELECT
		case when browser is null then 'N/A' else browser END as 'browser',
		count(*) as 'count'
		from ".DB_PREFIX."session
		where created BETWEEN DATE_SUB(now(), interval 1 week) AND now()
		group by browser");

		if (empty($data)) $data = array();

		return $data;
	}
	function viewports() {
		$data = $this->db->mysqli_prepared_query("SELECT
		case when viewport_width is null then 'N/A' else viewport_width END as 'viewport_width',
		count(*) as 'count'
		from ".DB_PREFIX."session
		where created BETWEEN DATE_SUB(now(), interval 1 week) AND now()
		group by viewport_width");

		if (empty($data)) $data = array();

		return $data;
	}
}