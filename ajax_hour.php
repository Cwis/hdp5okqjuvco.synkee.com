<?php	
	$curr_hour = new DateTime();	
	echo "<div id='hour' style='font-size:4em; line-height: 1.2em; text-align: center;'>&#8986; ".$curr_hour->format("H:i:s")."</div>";	
?>