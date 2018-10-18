<?php
if (isset($_POST) && isset($_POST['username']) && isset($_POST['password'])){
	require('../vendor/autoload.php');
	require('../config.php');
	$admin = new \trackr\Admin();
	$access = $admin->login($_POST['username'],$_POST['password']);
	if ($access){
		@session_start();
		$_SESSION[S]['admin'] = array('id'=>$admin->id,'username'=>$admin->username);
		header('Location: index.php');
		exit;
	}
}else{
	@session_start();
	@session_destroy();
}
?><!DOCTYPE html>
<html>
  <head>
    <title>CSSTrackr</title>
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
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.php"><img src="../csstrackr-logo.svg" style="height: 30px;filter: invert(100%);vertical-align: bottom;"> CSSTrackr</a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <form class="box" method="POST">
			            <div class="content-wrap">
			                <h6>Sign In</h6>
			                <input class="form-control" name="username" type="text" placeholder="Username" value="<?= (isset($_POST) && isset($_POST['username']))?$_POST['username']:''?>">
			                <input class="form-control" name="password" type="password" placeholder="Password">
			                <div class="action">
			                    <button class="btn btn-primary signup" type="submit">Login</a>
			                </div>
			            </div>
			        </form>
			    </div>
			</div>
		</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>