<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

@session_start();

require('vendor/autoload.php');
require('config.php');
require('functions.php');

/*get real user IP*/
$_SERVER['REMOTE_ADDR'] = getRequestIP();

if(isset($_SERVER['HTTP_USER_AGENT']) && in_array(strtolower($_SERVER['HTTP_USER_AGENT']),$banned_agents)){
    echo 'no';exit;
}else if (in_array($_SERVER['REMOTE_ADDR'],$banned_ips)){
	echo 'no.';exit;
} else {
	foreach($banned_ips as $ip) {
		if(eregi($ip,$_SERVER['REMOTE_ADDR'])) {
			echo 'no..';exit;
		}
	}
}

if (isset($_GET) && !empty($_GET)){
	if (!isset($_SESSION[S])){
		/* new session */
		$_SESSION[S] = array();

		/*create the session @ database*/
		$session = new \trackr\Session($_SERVER['REMOTE_ADDR']);
		$_SESSION[S]['id'] = $session->id;
	}
	$action = new \trackr\Action($_SESSION[S]['id'],$_GET['action'],$_GET['value']);
}