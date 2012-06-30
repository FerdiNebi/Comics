<?php
	session_start();
	
	if (!isset($_SESSION['uid']) || $_SESSION['level'] != 1){
		header("Location: index.php");
	}
	
	include_once "db.php";
	
	
	
?>


<html>
<head>
<TITLE>Comics Land</TITLE>
<meta charset="utf-8">
<link  rel="Stylesheet" href="Styles/my_styles.css" type="text/css" media="all">
</head>
<body>

<?php include "logo.php" ?>

<div id="welcome"><?php include "userInfo.php" ?></div>
<div id="container">
	<?php include "infobar.php" ?>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
		$('#adminadd').css({"background":"url('Resources/fadedBar2.png')"});
	</script>
	<div id="addcomics">
	<?php	
		if (isset($_POST['add'])){
		$cName = db_escape($_POST['cName']);
		$price = db_escape($_POST['price']);
		$desc = db_escape($_POST['desc']);
		
		$query = "INSERT INTO comics (`name`,`price`,`description`) VALUES('$cName',$price,'$desc')";
		db_query($query);
	?>
	<h1>Comics added succesfully!</h1>
	<?php
		}
		else{
	?>
	<h1>Add comics</h1>
	<form action="" method="post">
		<table>
		<tr>
		<td><label for="cName">Comics name:</label> </td>
		<td><input type="text" name="cName" id="cName" placeholder="Comics name" required autofocus/></td></tr>
		<tr>
		<td> <label for="price">Price:</label></td>
		<td><input type="text" name="price" id="price" placeholder="Price" required/></td></tr>
		<tr>
		<td> <label for="desc">Description:</label></td>
		<td><textarea name="desc" id="desc" placeholder="Type a description of the comics here..."  rows="5" cols = "16" required></textarea></td></tr></table>
		<p><input type="submit" name="add" id="submit" value="Go" /></p>
	</form>
	<?php } ?>
	</div>	
</div>

<?php include "footer.php" ?>

</body>
</html>