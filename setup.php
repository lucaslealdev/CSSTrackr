<?php
declare(strict_types=1);
$finish = false;
if (isset($_POST) && !empty($_POST)){
	if (!isset($_POST['finish']) && isset($_POST['user'])){
		/*testing connection to DB*/
		$my = @mysqli_connect($_POST['host'],$_POST['user'],$_POST['pass'],$_POST['db']);

		header('Content-Type: application/json');
		if(!$my){
			echo json_encode(array('status'=>'error','msg'=>utf8_encode(mysqli_connect_error())));
			exit;
		}
		mysqli_close($my);
		echo json_encode(array('status'=>'success'));
		exit;
	}elseif(isset($_POST['finish'])){
		$config = file_get_contents('config-example.php');
		$config = str_replace("define('DB_HOSTNAME','localhost');", "define('DB_HOSTNAME','".addslashes($_POST['host'])."');", $config);
		$config = str_replace("define('DB_USERNAME','root');", "define('DB_USERNAME','".addslashes($_POST['user'])."');", $config);
		$config = str_replace("define('DB_PASSWORD','');", "define('DB_PASSWORD','".addslashes($_POST['pass'])."');", $config);
		$config = str_replace("define('DB_DATABASE','trackr');", "define('DB_DATABASE','".addslashes($_POST['db'])."');", $config);
		$_POST['prefix'] = preg_replace('/(?![a-z_])/m', '', strtolower($_POST['prefix']));
		$config = str_replace("define('DB_PREFIX','');", "define('DB_PREFIX','".addslashes($_POST['prefix'])."');", $config);

		$my = mysqli_connect($_POST['host'],$_POST['user'],$_POST['pass'],$_POST['db']);
		$sql = file_get_contents('database.sql');
		$sql = str_replace("CREATE TABLE IF NOT EXISTS `", "CREATE TABLE IF NOT EXISTS `".$_POST['prefix'], $sql);
		$sql = str_replace("REFERENCES `", "REFERENCES `".$_POST['prefix'], $sql);
		$sql = str_replace("INDEX `", "INDEX `".$_POST['prefix'], $sql);
		$sql = str_replace("CONSTRAINT `", "CONSTRAINT `".$_POST['prefix'], $sql);
		mysqli_multi_query($my,$sql);
		mysqli_close($my);

		$actions = array();

		foreach($_POST['action'] as $key=>$action){
			if (!isset($actions[$action])) $actions[$action] = array();
			$selector = $_POST['selector'][$key];
			$value = $_POST['value'][$key];

			$actions[$action][$selector] = $value;
		}

		$config = preg_replace('/\$actions = array\(\X*?;/m', '$actions = '.var_export($actions,TRUE).";", $config);
		file_put_contents('config.php', $config);
		$finish = true;
	}
}elseif (file_exists('config.php')){
	echo 'Config file already exists. Exiting installation script.';
	exit;
}
?><!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.footer{
			margin-top:30px;
		}
		code{
			word-break: break-word;
		}
		.footer > div{
			background:#F4F4F4;
			padding:10px;
		}
		.page{
			height: 100%;
		}
		body h4{
			margin-bottom: 30px;
			margin-top:30px;
		}
		html .bright{
			border-right: 1px solid silver;
			background-color: #F4F4F4;
			height: 100%;
			display: block;
		}
		html .rb{
			height: 100%;
		}
		.tline{
			border:1px solid silver;
		}
		.tline .row{
			height: 500px;
			position: relative;
		}
		body h1{
			text-align: center;
			margin-bottom: 30px;
			display: block;
		}
		li.selected{
			color:#09A9C6;
			font-weight: bold;
		}
		li{
			padding-top:10px;
			padding-bottom: 10px;
		}
		span.ok{
			color:#31BA27;
		}
		span.notok{
			color:#D81F1F;
			font-weight: bold;
		}

		.bar{
			position: absolute;
			bottom:0px;
			right: 0px;
			padding-top:10px;
			border-top:1px solid silver;
			width: 100%;
			padding-right: 10px;
			text-align: right;
			padding-bottom: 10px;
		}
		.page{display: none;}
		.form-control{
			margin-bottom: 12px;
		}

		/* xs sm */
		@media (max-width: 991px) {
		  .bright{height: auto;border:none;}
		  .bright li{display:inline-block;width:auto;border-right: 1px solid silver;padding-left:10px;padding-right: 20px;}
		  .bright ul{padding:0px;}
		  .tline .row{height: auto;}
		  html .rb{
		  	padding-bottom: 100px;
		  }
		}
	</style>
	<title>CSSTrackr Setup</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<h1><img src="csstrackr-logo.svg" style="height: 53px;vertical-align: middle;"> CSSTrackr Setup Script</h1>
	<?php if(!$finish){?>
	<div class="container tline">
		<div class="row">
			<div class="col-md-3 bright">
				<ul>
					<li class="selected" data-for="#first">1. Requirements</li>
					<li data-for="#second">2. Database connection</li>
					<li data-for="#third">3. User actions</li>
				</ul>
			</div>
			<div class="col-md-9 rb">
				<form method="POST" id="form">
					<input type="hidden" name="finish">
					<div id="first" class="page" style="display: block;">
						<h4>Welcome to CSSTrackr Setup Script. Below you will find a pre-scan of our needed functions.</h4>
						<?php
						$errors = array();
						if (!file_exists('vendor/lucaasleaal/mysqlucas/mysqlucas.php')){
							$errors['composer'] = 'You need to install my dependencies with composer. <a target="_blank" href="https://github.com/lucaasleaal/csstrackr">Check the repo</a> for instructions.';
						}
						if (!file_exists('config-example.php')){
							$errors['configexample'] = 'The config-example.php file is missing!';
						}
						if (!defined('PHP_VERSION')){
							if (function_exists('phpversion')){
								define('PHP_VERSION',phpversion());
							}else{
								define('PHP_VERSION','3.0.0');
							}
						}
						if (version_compare(PHP_VERSION, '5.4.0', '<')) {
						    $errors['php_version'] = 'Your PHP version is '.PHP_VERSION.' but it should be at least 5.4.0';
						}
						if (!function_exists('mysqli_query')){
							$errors['mysqli'] = 'You don\' have mysqli extension enabled. You need to enable <strong>mysqli</strong>.';
						}
						if (!fopen('config.php','w') || !is_writable('config.php')){
							$errors['write'] = 'This script has no permission to edit the config.php file. You need to grant it, please.';
						}
						if (file_exists('config.php')){
							unlink('config.php');
						}
						?>
						<ol>
							<li>Config example ... <?php echo isset($errors['configexample'])?'<span class="notok">'.$errors['configexample'].'</span>':'<span class="ok">OK</span>'?></li>
							<li>Composer setup ... <?php echo isset($errors['composer'])?'<span class="notok">'.$errors['composer'].'</span>':'<span class="ok">OK</span>'?></li>
							<li>PHP 5.4+ ... <?php echo isset($errors['php_version'])?'<span class="notok">'.$errors['php_version'].'</span>':'<span class="ok">OK</span>'?></li>
							<li>mysqli extension ... <?php echo isset($errors['mysqli'])?'<span class="notok">'.$errors['mysqli'].'</span>':'<span class="ok">OK</span>'?></li>
							<li>Write permissions ... <?php echo isset($errors['write'])?'<span class="notok">'.$errors['write'].'</span>':'<span class="ok">OK</span>'?></li>
						</ol>
						<div class="bar">
							<?php if(empty($errors)){?><button class="btn btn-success" onclick="step('#second')" type="button">Next</button><?php }?>
						</div>
					</div>
					<div id="second" class="page">
						<h4>Now that your server is ready, show me your database.</h4>
						<fieldset class="form-horizontal">

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-2 control-label" for="host">Host</label>
						  <div class="col-md-2">
						  <input id="host" name="host" value="localhost" type="text" placeholder="ex: localhost" class="form-control input-md">

						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-2 control-label" for="user">User</label>
						  <div class="col-md-4">
						  <input id="user" value="root" name="user" type="text" placeholder="user from database" class="form-control input-md">

						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-2 control-label" for="pass">Password</label>
						  <div class="col-md-4">
						  <input id="pass" name="pass" type="text" placeholder="*it will be visible as you type*" class="form-control input-md">

						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-2 control-label" for="db">Database</label>
						  <div class="col-md-4">
						  <input id="db" name="db" value="csstrackr" type="text" placeholder="database name" class="form-control input-md">

						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label" for="db">Database prefix</label>
						  <div class="col-md-4">
						  <input id="prefix" name="prefix" value="trk_" type="text" placeholder="tables prefix" class="form-control input-md">

						  </div>
						</div>
						</fieldset>
						<div class="clearfix"></div>
						<div class="bar">
							<?php if(empty($errors)){?><button class="btn btn-default" onclick="step('#first');" type="button" id="btn-test">Back</button><?php }?>
							<?php if(empty($errors)){?><button class="btn btn-success" onclick="checkdb();" type="button" id="btn-test">Test database</button><?php }?>
						</div>
					</div>
					<div id="third" class="page">
						<h4>Everything working! Now tell me which elements you want to track.</h4>
						<fieldset class="form-horizontal">
							<div class="form-group">
							  <div class="col-sm-3">
							  	<select name="action[]" class="form-control">
							  		<option value='click'>Click</option>
							  		<option value='hover'>Hover</option>
							  		<option value='hoverhold'>Hover-hold</option>
							  		<option value='check'>Check</option>
							  	</select>
							  </div>
							  <div class="col-sm-3">
							  	<input type="text" required name="selector[]" placeholder="selector" class="form-control"/>
							  </div>
							  <div class="col-xs-9 col-sm-3">
							  	<input type="text" required name="value[]" placeholder="description" class="form-control"/>
							  </div>
							  <div class="col-xs-3 col-sm-3"><button type="button" onclick="if($('.remove').length>1){$(this).closest('.form-group').remove();}" class="remove btn btn-danger">x</button></div>
							</div>
						</fieldset>

						<button type="button" id="more" onclick="addmore()" class="btn btn-success">+</button>

						<div class="bar">
							<?php if(empty($errors)){?><button class="btn btn-default" onclick="step('#second');" type="button" id="btn-test">Back</button><?php }?>
							<?php if(empty($errors)){?><button class="btn btn-success" type="submit" id="btn-submit">Save</button><?php }?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	    var form = document.getElementById("form");
	    form.noValidate = true; // turn off default validation

	    form.onsubmit = function(e) {
	      e.preventDefault(); // preventing default behaviour
	      this.reportValidity(); // run native validation manually

	      // runs default behaviour (submitting) in case of validation success
	      if (this.checkValidity()) return form.submit();

	      $('.bar:visible .btn-success[type="button"]').click();
	    }
		function addmore(){
			var html = "<div class='form-group'>"+$('#third fieldset .form-group:first-child').html()+"</div>";
			$('#third fieldset').append(html);
		}
		function step($to){
			$('.page').hide();
			$($to).show();
			$('[data-for]').removeClass('selected');
			$('[data-for="'+$to+'"]').addClass('selected');
		}
		function blockinput(){
			$('body').css('opacity','0.5').css('pointer-events','none');
		}
		function unblockinput(){
			$('body').css('opacity','').css('pointer-events','');
		}
		function checkdb(){
			var btn = $('#btn-test');
			var text = btn.html();
			btn.text('loading...');
			blockinput();
			$.ajax({
				url: 'setup.php',
				type: 'POST',
				data: $('#host,#user,#pass,#db').serialize(),
			})
			.done(function(data) {
				if (data.status=='error'){
					alert(data.msg);
					return;
				}else{
					step('#third');
				}
			})
			.fail(function(data) {
				alert('It was not possible to even test. Check your internet connection.');
				alert(data);
			})
			.always(function(){
				unblockinput();
				btn.html(text);
			});
		}
	</script>
	<?php }else{?>
	<div class="container">
		<div class="col-xs-12">
			<h4>Done!</h4>
			<p>Now you just need to put the css file in all pages you want to track users.</p>
			<p>Put the code below before the <?php echo htmlentities("</head>")?> tag:</p>
			<?php
			$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$actual_link = str_replace('setup.php','csstrackr.css.php',$actual_link);
			?>
			<code>
				<?php echo htmlentities('<link rel="stylesheet" href="'.$actual_link.'" type="text/css" media="all">')?>
			</code>
		</div>
	</div>
	<?php }?>
	<div class="container footer">
		<div class="row"><div class="col-xs-12">
					<div class="pull-left"><a href="https://github.com/lucaasleaal/csstrackr" target="_blank">Fork on Github</a></div>
					<div class="pull-right">This project is licenced by MIT License.</div>
				</div></div>
	</div>
</body>
</html>