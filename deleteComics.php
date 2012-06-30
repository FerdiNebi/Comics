<?php

	session_start();
	
	include_once "db.php";
	
	if (!isset($_GET['cDelete']) || !isset($_SESSION['uid'])){
		header("Location: mycomics.php");
		exit;
	}
	
	$comicsName = db_escape($_GET['cDelete']);
	$userId = $_SESSION['uid'];
	
	$query = "SELECT id FROM comics WHERE name = '$comicsName' limit 1";
	
	$result = db_query($query);
	
	if ($result->num_rows == 0){
		header("Location: mycomics.php");
		exit;
	}
	
	$row = db_get_row($result);
	
	$price = $row['price'];
	$comicsId = $row['id'];
	
	$query = "DELETE FROM usercomics WHERE u_id = $userId and c_id = $comicsId";
	db_query($query);
	
	header("Location: mycomics.php");
	
?>