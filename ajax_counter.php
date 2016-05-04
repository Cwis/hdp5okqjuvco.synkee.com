<?php
	
	/* PHP version < 5.3 */
	function DEFINE_date_create_from_format() {
		function date_create_from_format( $dformat, $dvalue ) {
			$schedule = $dvalue;
			$schedule_format = str_replace(array('Y','m','d', 'H', 'i','a'),array('%Y','%m','%d', '%I', '%M', '%p' ) ,$dformat);
			// %Y, %m and %d correspond to date()'s Y m and d.
			// %I corresponds to H, %M to i and %p to a
			$ugly = strptime($schedule, $schedule_format);
			$ymd = sprintf(
				// This is a format string that takes six total decimal
				// arguments, then left-pads them with zeros to either
				// 4 or 2 characters, as needed
				'%04d-%02d-%02d %02d:%02d:%02d',
				$ugly['tm_year'] + 1900,  // This will be "111", so we need to add 1900.
				$ugly['tm_mon'] + 1,      // This will be the month minus one, so we add one.
				$ugly['tm_mday'], 
				$ugly['tm_hour'], 
				$ugly['tm_min'], 
				$ugly['tm_sec']
			);
			$new_schedule = new DateTime($ymd);
			return $new_schedule;
		}
	}

	if( !function_exists("date_create_from_format") )
	 DEFINE_date_create_from_format();
	/* ***************** */
	
	$curr_hour = new DateTime();
	//echo "<h2>Heure courante = ".$curr_hour->format("H:i:s")."</h2><br />";
	
	$start_hour = DateTime::createFromFormat("H:i:s", "7:30:00");
	//echo "<h3>Heure de départ = ".$start_hour->format("H:i:s")."</h3>";
	
	$end_hour = DateTime::createFromFormat("H:i:s", "16:30:00");
	//echo "<h3>Heure de fin = ".$end_hour->format("H:i:s")."</h3>";
	
	$post_duration = new DateInterval("PT13M");
	//echo "<h3>Durée d'un poste = ".$post_duration->format("%H:%I:%S")."</h3>";
	
	$change_duration = new DateInterval("PT2M");
	//echo "<h3>Durée d'un changement de poste = ".$change_duration->format("%H:%I:%S")."</h3><br />";
			
	$alert1 = DateTime::createFromFormat("H:i:s", "0:02:00");
	//echo "<h3>Alert1 = ".$alert1->format("H:i:s")."</h3><br />";
	
	$alert2 = DateTime::createFromFormat("H:i:s", "0:01:00");
	//echo "<h3>Alert2 = ".$alert2->format("H:i:s")."</h3><br />";
	
	$start = false;
	if ($curr_hour->format("H:i:s") >= $start_hour->format("H:i:s") && $curr_hour->format("H:i:s") <= $end_hour->format("H:i:s")) {
		
		$sum_hour = clone $start_hour;
		$in_post = true;
		
		$cPost = 0;
		$cChange = 0;
		
		while ($sum_hour < $curr_hour) {
			//echo "<p>sum hour ($cPost poste / $cChange change) = ".$sum_hour->format("H:i:s")."</p>";
		
			if ($in_post) {
				$sum_hour = $sum_hour->add($post_duration);
				$in_post = false; $cPost++;
			} else {
				$sum_hour = $sum_hour->add($change_duration);
				$in_post = true; $cChange++;
			}
		
			/*
			if (!$in_post) 
				echo "<h3>Dans le poste #$cPost</h3>";
			else
				echo "<h3>En changement #$cChange entre les poste #$cPost et #".($cPost+1)."</h3>";
			echo "<br />";
			*/
		}
		
		$diff = $sum_hour->diff($curr_hour);
		echo "<div id='counter' style='font-size:8em; line-height: 1.2em; text-align: center;";
		if (!$in_post) {
			if (DateTime::createFromFormat("H:i:s", $diff->format("%H:%I:%S")) < $alert2)
				echo "color: red;'>Poste en cours<br />";
			elseif (DateTime::createFromFormat("H:i:s", $diff->format("%H:%I:%S")) < $alert1)
				echo "color: orange;'>Poste en cours<br />";
			else
				echo "color: green;'>Poste en cours<br />";
		} else {
			echo "color: black;'>Changement de poste<br />";
		}
		echo "&#8987; ".$diff->format("%i:%S");
		echo "</div>";
		
	}
	//echo "<div id='hour' style='font-size:8em; line-height: 1.2em; text-align: center;'>".$curr_hour->format("H:i:s")."</div>";
	
?>