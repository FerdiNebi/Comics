<?php

	session_start();
	
	include_once "db.php";
	
	if (!isset($_GET['cBuy']) || !isset($_SESSION['uid'])){
		header("Location: login.php#beginning");
		exit;
	}
	
	$comicsName = db_escape($_GET['cBuy']);
	$userId = $_SESSION['uid'];
	
	$query = "SELECT id,price FROM comics WHERE name = '$comicsName' limit 1";
	
	$result = db_query($query);
	
	if ($result->num_rows == 0){
		header("Location: index.php");
		exit;
	}
	
	$row = db_get_row($result);
	
	$price = $row['price'];
	$comicsId = $row['id'];
	
	$query = "SELECT * FROM usercomics WHERE u_id = $userId AND c_id = $comicsId";
	$result = db_query($query);
	
	if ($result->num_rows > 0){
		header("Location: mycomics.php");
		exit;
	}
	
	$query2 = "SELECT credits FROM users WHERE id = ". $_SESSION['uid'] ;
	$result2 = db_query($query2);
	$row2 = db_get_row($result2);
	$credits =  $row2['credits'];
	
	if ($credits >= $price){
		$query = "INSERT INTO usercomics (`u_id`, `c_id`) VALUES('$userId','$comicsId')";
		$result = db_query($query);
		
		if (!$result) {
			header("Location: mycomics.php");
			exit;
		}
		
		$query = "UPDATE users SET credits = credits - $price WHERE id = $userId";
		db_query($query);
		$query = "UPDATE comics SET sold = sold + 1 WHERE id = $comicsId";
		db_query($query);
		header("Location: mycomics.php");
	}
	else {
		header("Location: comicslist.php");
	}
?>