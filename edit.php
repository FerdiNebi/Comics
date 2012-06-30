<?php
	session_start();
	
	if (!isset($_SESSION['uid'])){
		header("Location: index.php");
	}

	include_once "db.php";
	
	if (empty($_POST['oldpass']) ){
		die('{status:0,txt:"Please type your password!"}');
	}
	
	$passcheck = md5($_POST['oldpass']);
	$query = "SELECT name,password FROM users WHERE id =".$_SESSION['uid'];
	$result = db_query($query);
	$row = db_get_row($result);
	
	if ($passcheck != $row['password']){
		die('{status:0,txt:"Your password is incorrect!"}');
	}
	
	if (!empty($_POST['newpass'])){
		$pass = strlen($_POST['newpass']);
	
		if ($pass < 3) {
			die('{status:0,txt:"Your password has to be at least 3 symbols!"}');
		}
	
		if ($_POST['newpass'] != $_POST['Rnewpass']) {
			$string = "Password fields don't match!";
			die('{status:0,txt:"'.$string.'"}');
		}
	}
	if (!empty($_POST['name'])){
		if (preg_match('/^[A-Za-z ]+$/',$_POST['name']) === 0){
				die('{status:0,txt:"Not a valid name!"}');
 		}
	
	}

	if (!empty($_POST['name'])){
		$name = db_escape($_POST['name']);
	}
	else{
		$name = $row['name'];
	}
	
	if (!empty($_POST['newpass'])){
		$password = md5(db_escape($_POST['newpass']));
	}
	else{
		$password = $row['password'];
	}

	
	
	$query = "UPDATE users SET name = '$name' , password = '$password' WHERE id = ". $_SESSION['uid'];
	db_query($query);
	
	
	$_SESSION['username'] = $name;


	echo '{status:1,txt:"editedsucc.php"}';
?>