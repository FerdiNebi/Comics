<?php
		session_start();
		
		include_once "db.php";
		if (isset($_GET['search'])){
			$str = $_GET['search'];
			$query = "Select name,price FROM comics WHERE name REGEXP '$str' ORDER BY name";
		}
		else {
			$query = "Select name,price FROM comics ORDER BY name";
		}
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
		$('#comics').css({"background":"url('Resources/fadedBar2.png')"});
	</script>
	
	<div id="innerContainer">
	<table id="list">
	<?php 
		for ($i = 0; $i < $size ; $i++){
			$row = db_get_row($result);
			$string = "<tr><td>".$row['name'] ."</td><td><a href='comicsinfo.php?comName=".$row['name']."' >
			<img src='Comics/" . $row['name'] . "/cover.jpg' width='150px' height='150px' title='Click to see description' /></a></td>
			<td>$".number_format($row['price'],2)."</td><td><a href='buy.php?cBuy=".$row['name']."'> Buy </a></td>";
			printf($string);
		}
	?>
	</table>
	</div>
</div>

<?php include "footer.php" ?>

</body>
</html>
