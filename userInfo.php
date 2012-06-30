<?php
	
	include_once "db.php";
	
	if (isset($_SESSION['uid']))
		{
			$username = $_SESSION['username'];
			$query2 = "SELECT credits FROM users WHERE id = ". $_SESSION['uid'] ;
			$result2 = db_query($query2);
			$row2 = db_get_row($result2);
			$credits =  $row2['credits'];
			$string = number_format($credits,2);
			echo "Welcome, $username  <span><a href='editprofile.php'>[profile]</a>  Account balance: $".$string." </span>";
		}
?>