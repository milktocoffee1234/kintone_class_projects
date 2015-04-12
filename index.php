<?php
	require_once("class.php");
	$test = new Util($_POST);
	$valid = new Validation();

	$staffId = $test -> get_post_string("staffId");
	$cc = $test -> get_post_array("cc");
	print_r($cc);

?>