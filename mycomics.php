<?php
		session_start();
		
		if (!isset($_SESSION['uid'])){
			header("Location: comicslist.php");
			exit;
		}
		include_once "db.php";
		$userID = $_SESSION['uid'];
		$query = "Select name FROM usercomics JOIN comics on usercomics.c_id=comics.id where u_id = $userID  ORDER BY name";
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
		$('#mycomics').css({"background":"url('Resources/fadedBar2.png')"});
	</script>
	<div id="innerContainer">
	<table id="list">
	<?php 

		for ($i = 0; $i < $size ; $i++){
			$row = db_get_row($result);
			$string = "<tr><td>".$row['name'] ."</td><td>
			<a href='comicsread.php?cName=".$row['name']."' target='_blank'>
			<img src='Comics/" . $row['name'] . "/cover.jpg' width='150px' height='150px' title='Clic to read'/></a></td>
			<td><a href='deleteComics.php?cDelete=".$row['name']."'> Delete </a></td>";
			printf($string);
		}
	?>
	</table>
	</div>
</div>

<?php include "footer.php" ?>

</body>
</html>