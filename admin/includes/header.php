<?php
@session_start();
require_once('../config.php');
if (!isset($_SESSION[S]['admin']['id'])){
	header('Location: login.php');
	exit;
}
require('../vendor/autoload.php');
?><!DOCTYPE html>
<html>
<head>
	<title>CSSTrackr</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- styles -->
	<link href="css/styles.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<div class="header">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="logo">
						<h1><a href="index.php"><img src="../csstrackr-logo.svg" style="height: 30px;filter: invert(100%);vertical-align: bottom;"> CSSTrackr</a></h1>
					</div>
				</div>
				<div class="col-xs-12-pull-left col-sm-6-pull-right">
					<div class="navbar navbar-inverse" role="banner">
						<nav class="navbar-collapse bs-navbar-collapse navbar-right in" role="navigation" id="navs">
							<ul class="nav navbar-nav">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $_SESSION[S]['admin']['username']?> <b class="caret"></b></a>
									<ul class="dropdown-menu animated fadeInUp">
										<li><a href="login.php">Logout</a></li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>