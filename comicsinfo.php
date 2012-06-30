<?php
		session_start();
		
		include_once "db.php";
		if (isset($_GET['comName'])){
			$comName = db_escape($_GET['comName']);
		}
		$query = "Select id,name,price,description,rating,votes FROM comics WHERE name = '$comName'";
		$result = db_query($query);
		$row = db_get_row($result);
		$rating = $row['rating'];		
		$voteCount = $row['votes'];
		
		$comId = $row['id'];
		
		if (isset($_SESSION['uid'])){
		$userId = $_SESSION['uid'];
		
		$query = "Select vote FROM usercomics WHERE u_id = $userId and c_id = $comId";
		$result = db_query($query);
		if ($result->num_rows > 0){
			$row2 = db_get_row($result);
			$vote = $row2['vote'];

			if ($vote == 0){
				if (isset($_POST['voteSubmit'])){
					$voteValue = $_POST['vote'];

					$rating = $rating + ($voteValue - $rating) / $voteCount;
				
					$query = "UPDATE usercomics SET vote = 1 WHERE u_id = $userId and c_id = $comId";
					db_query($query);
				
					$query = "UPDATE comics SET rating = $rating , votes = votes + 1 WHERE id = $comId";
					db_query($query);
					
					$vote = 1;
				}
			}
		
			}
else{$vote = 1;}}

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
	
	<div id="infoContainer">
	<?php 
		printf("<img src='Comics/" . $row['name'] . "/cover.jpg' width='250px' height='250px'/>");
		printf("<h1>".$row['name']."</h1>");
		printf("<p>".$row['description']."</p>");
	?>
		<div id="rating">
			<?php
				$string = number_format($rating,2);
				printf("<h2>Rating: "."$string"."</h2>");	
				if (isset($_SESSION['uid'])){
					if ($vote == 0){
						?>
					<form action="" method="post">
						<select name="vote" id="vote">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5" selected="selected">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
						<input type="submit" name="voteSubmit" id="voteSubmit" value="Vote"/>
					</form>	
					
						<?php
					}
				}
				printf("<a id='read' href='comicsread.php?cName=$comName' target='_blank'>Click to read online!</a>");
			?>
		</div>
	</div>

</div>

<?php include "footer.php" ?>

</body>
</html>