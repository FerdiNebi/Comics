<html>

<head>
<link  rel="Stylesheet" href="Styles/my_styles.css" type="text/css" media="all">
</head>

<body>
<div id="info_bar">
	
	<form id="search" action="comicslist.php" method="get">
		<input id="searchText" name="search" type="text" placeholder="Search"/>
		<input id="searchSubmit" type="submit" value="search"/>
			
	</form>
	<span>
	<?php
		
		
		if (!isset($_SESSION['uid'])) {
			?>
		<a id="home" href="index.php">Home</a>
		<a id="comics" href="comicslist.php">All Comics</a>
		<a href="login.php#beginning">Login/Sign up</a>
		<?php
		}
		else if (!isset($_SESSION['level']) || $_SESSION['level'] != 1){
			
			?>
		
		<a id="home" href="index.php">Home</a>
		<a id="comics" href="comicslist.php">All Comics</a>
		<a id="mycomics" href="mycomics.php">My Comics</a>
		<a href="logout.php">Logout</a>
		<?php
		}
		else{
			?>
		<a id="adminadd" href="adminadd.php">Add comics</a>
		<a id="admindelete" href="admindelete.php">Delete comics</a>
		<a id="adminsales" href="adminsales.php">Sales</a>
		<a href="logout.php">Logout</a>
		<?php
		}
		?>
	</span>
</div>
</body>
</html>