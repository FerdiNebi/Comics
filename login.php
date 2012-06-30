<?php

	include_once "db.php";
	session_start();
	
	if (isset($_SESSION['uid']))
		header("Location: index.php");
	if (isset($_POST["login"])) {
		
		$user = db_escape($_POST['username']);
		$pass = db_escape($_POST['password']);
		$query = "SELECT id,name,credits,level FROM users WHERE username='$user' AND  password=MD5('$pass') LIMIT 1";

		$result = db_query($query);
		
		if ($result->num_rows > 0)
			{
			$row = db_get_row($result);
			
			$_SESSION['uid'] = $row['id'];
			$_SESSION['username'] = $row['name'];
			$_SESSION['level'] = $row['level'];
			
			$query = "UPDATE users SET credits = credits + 10 WHERE username ='$user' ";
			db_query($query);
			//$_SESSION['credits'] = $row['credits'] + 10;
			
			if ($_SESSION['level'] != 1){
			header("Location: mycomics.php");
			exit;
			}
			else{
				header("Location: adminadd.php");
				exit;
			}
		}
	}
	?>
<html>
<head>
<TITLE>ComicsLand</TITLE>
<meta charset="utf-8">
<link  rel="Stylesheet" href="Styles/my_styles.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>

<?php include "logo.php" ?>

<a name="beginning"></a>
<div id="container">
	<?php include "infobar.php" ?>

	<div id="registration">
	<h1>Login</h1>
	<form action="" method="post">
		<table>
		<tr>
		<td><label for="username">Username:</label> </td>
		<td><input type="text" name="username" id="username" placeholder="Username" required autofocus/></td></tr>
		<tr>
		<td> <label for="password">Password:</label></td>
		<td><input type="password" name="password" id="password" placeholder="Password" required/></td></tr></table>
		<p><input type="submit" name="login" id="submit" value="Go" /></p>
	</form>
	</div>	
	<div id="error">&nbsp;</div>
	<span id="reglink"><a href="registration.php#beginning">Not Registered?</a></span>
</div>
<?php  if (isset($_POST['login']) && $result->num_rows == 0) print('<script>$("#error").html("Wrong username or password!");</script>'); ?>	

<?php include "footer.php" ?>

</body>
</html>