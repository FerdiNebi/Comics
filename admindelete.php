<?php
		session_start();
		
		if (!isset($_SESSION['uid']) || $_SESSION['level'] != 1){
			header("Location: comicslist.php");
			exit;
		}
		include_once "db.php";
		
		if (isset($_GET['cDelete'])){
			$cDel = $_GET['cDelete'];
			
			$query = "SELECT id,price FROM comics WHERE name = '$cDel' LIMIT 1";
			$result = db_query($query);
			
			if ($result->num_rows != 0){
				$row = db_get_row($result);
				$cId = $row['id'];
				$cPrice = $row['price'];
				
				$query = "DELETE FROM comics WHERE id = $cId";
				db_query($query);
				
				$query = "SELECT u_id FROM usercomics WHERE c_id = $cId";
				$result = db_query($query);
				
				for ($i = 0; $i < $result->num_rows ; $i++){
					$row = db_get_row($result);
					$uId = $row['u_id'];
					$query = "UPDATE users SET credits = credits + $cPrice WHERE id = $uId ";
					db_query($query);
				}
			}
		}
		$userID = $_SESSION['uid'];
		$query = "Select id,name FROM  comics ORDER BY name";
		$result = db_query($query);
		$size = $result->num_rows;
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
		$('#admindelete').css({"background":"url('Resources/fadedBar2.png')"});
	</script>
	<div id="innerContainer">
	<table id="list">
	<?php 

		for ($i = 0; $i < $size ; $i++){
			$row = db_get_row($result);
			if ($row['id'] != 1) {
			$string = "<tr><td>".$row['name'] ."</td><td>
			<a href='comicsread.php?cName=".$row['name']."' target='_blank'>
			<img src='Comics/" . $row['name'] . "/cover.jpg' width='150px' height='150px' title='Clic to read'/></a></td>
			<td><a href='admindelete.php?cDelete=".$row['name']."'> Delete </a></td>";
			printf($string);
			}
		}
	?>
	</table>
	</div>
</div>

<?php include "footer.php" ?>

</body>
</html>