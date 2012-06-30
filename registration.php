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
			url: "submit.php",
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
	<div id="container">
	<?php include "infobar.php" ?>

	<div id="registration">
	<h1>Sign up!</h1>
	<form id="regform" action="submit.php" method="post">
		<table>
		<tr>
		<td><label for="name">Name:</label> </td>
		<td><input type="text" name="name" id="name" placeholder="Name" required autofocus/></td></tr>
		<tr>
		<td><label for="username">Username:</label> </td>
		<td><input type="text" name="username" id="username" placeholder="Username" required /></td></tr>
		<tr>
		<td><label for="password">Password:</label></td>
		<td><input type="password" name="password" id="password" placeholder="Password" required/></td></tr>
		<tr>
		<td><label for="Rpassword">Repeat password:</label></td>
		<td><input type="password" name="Rpassword" id="Rpassword" placeholder="Repeat password" required/></td></tr></table>
		<p><input type="submit" id="submit" value="Go" /></p>
	</form>
	</div>	
	<div id="error">&nbsp;</div>
</div>


<?php include "footer.php" ?>

</body>
</html>