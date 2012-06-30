<html>

	<body></body>
	
	<script>
		comicsName = "<?php echo $_GET['cName']; ?>" ;
		imgNum = "<?php echo $_GET['iNum']; ?>" ;
		document.body.background = "Comics/" + comicsName + "/image" + imgNum + ".jpg";
	</script>
	&nbsp;
</html>