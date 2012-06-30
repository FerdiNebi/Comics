<?php session_start();?>
<html>
<head>
<TITLE>Comics Land</TITLE>
<meta charset="utf-8">
<link  rel="Stylesheet" href="Styles/my_styles.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
	
	
	function register(){
		$('#error').css("visibility","hidden");
		$.ajax({
			type: "POST",
			url: "edit.php",
			data: $('#regform').serialize(),
			dataType: "json",
			success: function(msg){
				if (parseInt(msg.status) == 1){
					window.location = msg.txt;
				}
				else{
					$('#error').css("visibility","visible");
					$('#error').html(msg.txt);
				}

			}
		});
	}
	
	$(document).ready(function(){
		
		$('#regform').submit(function(event){
			register();
			event.preventDefault();

		});
	});
</script>
</head>
<body>

<?php include "logo.php" ?>

<a name="beginning"></a>
	<div id="welcome"><?php include "userInfo.php" ?></div>
	<div id="container">
	<?php include "infobar.php" ?>

	<div id="registration">
	<h1>Edit your profile:</h1>
	<form id="regform" action="submit.php" method="post">
		<table>
		<tr>
		<td><label for="name">Name:</label> </td>
		<td><input type="text" name="name" id="name" placeholder="Type new name"  autofocus/></td></tr>
		<tr>
		<td><label for="oldpass">Password:</label> </td>
		<td><input type="password" name="oldpass" id="oldpass" placeholder="Password required" required /></td></tr>
		<tr>
		<td><label for="newpass">New password:</label></td>
		<td><input type="password" name="newpass" id="newpass" placeholder="Type new password" /></td></tr>
		<tr>
		<td><label for="Rnewpass">Repeat new password:</label></td>
		<td><input type="password" name="Rnewpass" id="Rnewpass" placeholder="Repeat new password" /></td></tr></table>
		<p><input type="submit" id="submit" value="Go" /></p>
	</form>
	</div>	
	<div id="error">&nbsp;</div>
</div>


<?php include "footer.php" ?>

</body>
</html>