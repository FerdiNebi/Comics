<?php session_start() ?>
<html>
<head>
<TITLE>Comics Land</TITLE>
<meta charset="utf-8">
<meta http-equiv="refresh" content="2; URL=mycomics.php">
<link  rel="Stylesheet" href="Styles/my_styles.css" type="text/css" media="all">
</head>
<body>

<?php include "logo.php" ?>

<div id="welcome"><?php include "userInfo.php" ?></div>
<div id="container">
	<?php include "infobar.php" ?>
	<div id="registered">
	Congratulations! You have registered successfully.
	</div>
</div>

<?php include "footer.php" ?>

</body>
</html>
