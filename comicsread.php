<?php
	session_start();
	
	if (!isset($_GET['cName']))
		{
			header ("Location: index.php");
			exit;
		}
		
	include_once "db.php";
	
	$comicsName = db_escape($_GET['cName']);
	
	$query = "SELECT id FROM comics WHERE name = '$comicsName'";
	$result = db_query($query);
	
	if ($result->num_rows == 0) {
		header ("Location: login.php");
		exit;
	}
	
	$row = db_get_row($result);
	$comicsId = $row['id'];
	
		
?>


<html>
	<head>
		<title></title>
		<meta charset="UTF-8">
		<link  rel="Stylesheet" href="Styles/reading_styles.css" type="text/css" media="all">
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/loadXML.js"></script>
		
		<?php echo "<script type='text/javascript'> comicsName ='$comicsName'; </script>" ?>
		<script type="text/javascript">
			string = "Comics/" + comicsName + "/" + comicsName + ".xml";
			xmlDoc = loadXMLDoc(string);
			pageList = xmlDoc.getElementsByTagName("page");
			pagewidth = xmlDoc.getElementsByTagName("pagewidth");
			pageheight = xmlDoc.getElementsByTagName("pageheight");
			pageNum=0;
			sectionId=-1;
			rectList = pageList[pageNum].getElementsByTagName("rectangle");
			
			
			function showSection(){
				$('div#goback').css("visibility","visible");
				if (pageNum == 0 && sectionId == -1) $('div#goback').css("visibility","hidden");
				if (sectionId < -1 ){
					if (pageNum > 0){
						pageNum--;
						rectList = pageList[pageNum].getElementsByTagName("rectangle");
						sectionId = rectList.length-1;
					}
					else{
						sectionId= -1;
					}
				}
				
				if (sectionId > rectList.length-1 ){
					if (pageNum < pageList.length - 1){
						pageNum++;
						rectList = pageList[pageNum].getElementsByTagName("rectangle");
						sectionId = -1;
					}
					else{
						sectionId = rectList.length-1;
					}
				}
				
				if (sectionId == -1) {
					//newWidth= pageList[pageNum].getElementsByTagName("imagewidth")[0].childNodes[0].nodeValue;
					//newHeight= pageList[pageNum].getElementsByTagName("imageheight")[0].childNodes[0].nodeValue;
					$("#pages").width("400px");
					$("#pages").height("600px");
					tempstring= "url('Comics/" + comicsName + "/image" + pageNum + ".jpg')";
					$("#pages").css({"background":tempstring,"background-repeat":"no-repeat","background-size":"cover","-o-background-size":"cover"});
					//tempstring = "<img src='Comics/" + comicsName + "/image" + pageNum + ".jpg' width='400px' height='600px' />";
					//$("#pages").html(tempstring);

				    //$("#pages").css("margin-top","200px");
				} 
				if (sectionId >=0 && sectionId < rectList.length){
					newX = rectList[sectionId].getElementsByTagName("x")[0].childNodes[0].nodeValue;
					newY = rectList[sectionId].getElementsByTagName("y")[0].childNodes[0].nodeValue;
					newWidth = rectList[sectionId].getElementsByTagName("width")[0].childNodes[0].nodeValue;
					newHeight = rectList[sectionId].getElementsByTagName("height")[0].childNodes[0].nodeValue;
					$("#pages").animate({height:newHeight + "px",width:newWidth + "px" },"slow");
					//$("#pages").width(newWidth + "px");
					//$("#pages").height(newHeight + "px");
				//	$("#pages").css("margin-top","200px");
					$("#pages").html("");
					tempstring= "url('Comics/" + comicsName + "/image" + pageNum + ".jpg') -" + newX + "px -" + newY + "px";
					
					$("#pages").css("background", tempstring);
					$("#pages").css("background-size", "auto auto");
				//	$("#pages").css({"background-size":pagewidth[pageNum].childNodes[0].nodeValue+"px "+pageheight[pageNum].childNodes[0].nodeValue+"px"});
				//	$("#pages").css({"background-size":pagewidth[pageNum].childNodes[0].nodeValue+"px "+pageheight[pageNum].childNodes[0].nodeValue+"px","-moz-background-size":pagewidth[pageNum].childNodes[0].nodeValue+"px "+pageheight[pageNum].childNodes[0].nodeValue+"px"});
			//		$("#pages").css("background","url('Comics/Naruto590/naruto-1.jpg') -434px -0px");
					
					
					}
					$('#pagecount').html("Page "+(pageNum+1)+" of "+pageList.length);
				}
			
			function next(){
				sectionId++;
				showSection();
			}	
			
			function previous(){
				sectionId--;
				showSection();
			}
		</script>
	</head>
	
	<body>
		<div id="goback" onclick="previous()"><img src="Resources/GoBack.png" width="100px" height="50px" /></div>
		<div id="container" onclick="next()">
			<h1> <script type="text/javascript"> document.write(comicsName); </script></h1>
			<h7 id="pagecount"></h7>
			<script type="text/javascript"> $('div#goback').css("visibility","hidden");</script>
			<?php
				if (!isset($_SESSION['uid'])){
					echo "You have to login in order to read this comics!";
					exit;
				}
			
				$userId = $_SESSION['uid'];
				$query = "SELECT * FROM usercomics where u_id = $userId and c_id = $comicsId";
				$result = db_query($query);
				if ($result->num_rows == 0){
					echo "You have to buy this comics in order to read it!";
					exit;
				}
			?>
			<div id="pages" >
				
			</div>
		</div>
		<div id="loader"></div>
	</body>
</html>

<script type="text/javascript">
	showSection();	
	for (i = 0; i < pageList.length; i++){
				str123 = "Comics/" + comicsName + "/image" + i + ".jpg";
				$('#loader').html('<img src ="' + str123 + '" />');
			}	
	$('#loader').html("");		
	
</script>