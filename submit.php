<?php

	if (empty($_POST['name']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['Rpassword']) ){
		die('{status:0,txt:"Please fill all the fields!"}');
	}
	
	$pass = strlen($_POST['password']);
	
	if ($pass < 3) {
		die('{status:0,txt:"Your password has to be at least 3 symbols!"}');
	}
	
	if ($_POST['password'] != $_POST['Rpassword']) {
		$string = "Password fields don't match!";
		die('{status:0,txt:"'.$string.'"}');
	}
	
	if (preg_match('/^[A-Za-z ]+$/',$_POST['name']) === 0){
			die('{status:0,txt:"Not a valid name!"}');
 	}
	if (preg_match('/^[A-Za-z][A-Za-z0-9_\-\.]+$/',$_POST['username']) === 0){
			die('{status:0,txt:"Not a valid username! Only letters,digits , _ , - , . are allowed."}');
 	}
	
	include_once "db.php";
	
	$name = db_escape($_POST['name']);
	$username = db_escape($_POST['username']);
	$password = db_escape($_POST['password']);
	
	
	
	$query = "SELECT * FROM users WHERE username = '$username'";
	$result = db_query($query);
	if ($result->num_rows != 0){
		die('{status:0,txt:"Username '.$username.' is already taken!"}');
	}
	
	$query = "INSERT INTO users (`username`, `password`, `name`) VALUES ('$username',MD5('$password'),'$name')";
	db_query($query);
	
	
	$query = "SELECT id,name FROM users WHERE username = '$username'";
	$result = db_query($query);
	$row = db_get_row($result);
	

    session_start();
			
	$_SESSION['uid'] = $row['id'];
	$_SESSION['username'] = $row['name'];

	$query = "INSERT INTO usercomics (`u_id`,`c_id`) VALUES(".$_SESSION['uid'].",1)";
	db_query($query);
	
	echo '{status:1,txt:"registered.php"}';
?>
