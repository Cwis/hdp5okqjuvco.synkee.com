<!DOCTYPE html>
<html>
	<head>		
		<title>TRM - ECOS</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css" /> 
	</head>
		
	<body>	
	
		<div id="title">
			<div id="title_logo">
			</div>
			<div id="title_text">
				<h1>TRM - ECOS</h1>
			</div>
		</div>
	
		<div id="content">
			<div class="content_box">
				<div class="content">
					<div id="counter"></div>
				</div>
			</div>	
			
			<div class="content_box">
				<div class="content">
					<div id="hour"></div>
				</div>
			</div>
		</div>
		
		<div id="footer">
			<div id="footer_logo">
			</div>
			<div id="footer_text">
				<h1>Evaluation BSc3 - 11 mai 2016</h1>
			</div>
		</div>
		
	</body>	
</html>


<script type="text/javascript" src="jquery-1.11.3.js"></script>
<script type="text/javascript">

	$(document).ready(function() {	
		var time=setInterval(function(){
			$.ajax({
				url: "ajax_hour.php",
				success: function(time) {
					$('#hour').html(time);
				}
			});	
		},1000);
	});
	
	$(document).ready(function() {	
		var time=setInterval(function(){
			$.ajax({
				url: "ajax_counter.php",
				success: function(time) {
					$('#counter').html(time);
				}
			});	
		},1000);
	});
	
</script>