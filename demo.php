<!DOCTYPE html>
<html>
<head>
	<title>Test file</title>
	<link rel="stylesheet" type="text/css" href="csstrackr.css.php">
</head>
<body>
	<img src="https://image.shutterstock.com/image-illustration/golden-bear-260nw-127529009.jpg"><br>
	<a href="#" class="modal">Open modal</a><br><br>
	<a href="#" class="modalclose">Close modal</a><br><br>
	<button id="subscribe">Subscribe</button><br><br>
	<button id="unsub">Unsubscribe</button><br><br>
	<label><input type="checkbox">I'm sure</label><br><br>
	<pre>
		<?php session_start();print_r($_SESSION);?>
	</pre>
</body>
</html>