<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('session.save_path',realpath('sessions'));
ini_set('session.gc_probability', "1");
ini_set('session.cookie_lifetime', strval(3600*24*7));
ini_set('session.gc_maxlifetime', strval(3600*24*7));
@session_set_cookie_params(strval(3600*24*7),"/"); //seven days
@session_start();

if (!file_exists('config.php')){
	header('Location: setup.php');
	exit;
}

require('vendor/autoload.php');
require('config.php');
require('functions.php');

/*get real user IP*/
$_SERVER['REMOTE_ADDR'] = getRequestIP();

if(isset($_SERVER['HTTP_USER_AGENT']) && in_array(strtolower($_SERVER['HTTP_USER_AGENT']),$banned_agents)){
  exit;
}else if (in_array($_SERVER['REMOTE_ADDR'],$banned_ips)){
  exit;
} else {
  foreach($banned_ips as $ip) {
    if($ip==substr($_SERVER['REMOTE_ADDR'], 0,strlen($ip))){
      exit;
    }
  }
}

if (isset($_GET) && !empty($_GET) && isset($_GET['action']) && isset($_GET['value'])){
	if (!isset($_SESSION[S]['id'])){
		/* new session */
		if (!isset($_SESSION[S])) $_SESSION[S] = array();

		/*create the session @ database*/
		$session = new \trackr\Session($_SERVER['REMOTE_ADDR']);
		$_SESSION[S]['id'] = $session->id;
	}
	if (isset($_SESSION[S]['id'])) $action = new \trackr\Action($_SESSION[S]['id'],$_GET['action'],$_GET['value']);
}