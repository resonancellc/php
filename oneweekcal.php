<style>
	.timetable {
		width:100%;
	}
	
	.timeslot {
		text-align: center;
	}
	
	.timetable tr td{
		padding: 5px;
		border: #000 solid 1px;
	}
	
	.dayheader {
		text-align: center;
	}
	
	.timecol {
		text-align: right;
	}
	</style>
<?php
	//ORIGINAL https://github.com/CriketX/OneWeekScrollingCalendar
	//TODO: make this LESS bad
	/*Set $startTime and $endTime to establish calendar length*/
	$startTime = 5;
	$endTime = 20;
	/*Create an array of timeslots.
	This script is dependent on half hour blocks, so I'm using 2*/
	$arrayLength = ($endTime - $startTime) * 2;
	/*Set the local timezone*/
	date_default_timezone_set('America/Phoenix');
	/*The while loop populates the array with half hour times*/
	$i=0; //the counter
	$timeArray = array(); //declare the array
	while($i < $arrayLength) {
		if(($i % 2) == 0) { //if the time is even
			$time = $startTime + ($i*.5); //since each slot is a half hour, multiply by 1/2 to find the hour we're adding
			if($time < 12) { //figure out if it's morning
				$suffix = ' am';
			} else {
				if($time > 12) {
					$time -= 12; //remove 12 hours to fit the 12 hour clock
				}
				$suffix = ' pm';
			}
			$count = strval($time); //convert to string
			$count .= ':00'.$suffix; //add the :00 and am/pm
			$timeArray[$i] = $count;
		} else { //if the time is odd
			$time = $startTime + ($i*.5);
			if($time < 12) {
				$suffix = ' am';
			} else {
				if($time > 12.5) { //use 12.5 or 12:30 pm will with display as 0:30pm
					$time -= 12;
				}
				$suffix = ' pm';
			}
			$count = $time-.5; //take off the half hour
			$count = strval($count); //convert to string
			$count .= ':30'.$suffix; //replace the half hour with :30 and add am/pm
			$timeArray[$i] = $count; //add the timeslot to the array
		}
		$i++;
	}
	$dayz=date('l'); //find the current day of the week
	global $dayznum;
	/*Assign a numerical value to our day*/
	if($dayz=='Sunday'){ $dayznum=0; }
	if($dayz=='Monday'){ $dayznum=1; }
	if($dayz=='Tuesday'){ $dayznum=2; }
	if($dayz=='Wednesday'){ $dayznum=3; }
	if($dayz=='Thursday'){ $dayznum=4; }
	if($dayz=='Friday'){ $dayznum=5; }
	if($dayz=='Saturday'){ $dayznum=6; }
	/*Build an array containing the weekdays*/
	$weekarray = array(
		0 => "Sunday",
		1 => "Monday",
		2 => "Tuesday",
		3 => "Wednesday",
		4 => "Thursday",
		5 => "Friday",
		6 => "Saturday"
	);
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP Calendar</title>
	<link type="text/css" rel="stylesheet" href="style.css" />
</head>
<body>
<table class="timetable">
	<tr>
		<td></td>
		<?php
			$i = $dayznum; //start with the current day
			$count = 0; //count the number of days to ensure we populate one full week starting with today
			/*Start with today and print out to Saturday*/
			while($i < 7) {
				print '<td class="dayheader">'.$weekarray[$i].'</td>';
				$i++;
				$count++;
			}
			
			/*If we haven't printed 7 days, start at Sunday and print the rest*/
			$i = 0;
			if($count < 7) {
				while($count < 7) {
					print '<td class="dayheader">'.$weekarray[$i].'</td>';
					$i++;
					$count++;
				}
			}
		?>
	</tr>
	<?php
		/*This while loop will print each row until we have one for each half hour as defined above*/
		$i = 0;
		while($i < $arrayLength) {
			/*The first cell contains the time*/
			print '<tr><td class="timecol">'.$timeArray[$i].'</td>';
			$daycount = 0;
			$date = date('j');
			/*Set the date. I built it as an array to manipulate*/
			$dateArray = array();
			$dateArray[0] = date('j');
			$dateArray[1] = date('n');
			$dateArray[2] = date('Y');
			
			while($daycount < 7) {
				$day = intval($dateArray[0])+$daycount;
				$cellday = $dateArray[1].'-'.$day.'-'.$dateArray[2];
				
				print '<td class="timeslot">';
				/*Insert a function here to fill your table with data*/
				
				print '</td>';
				$daycount++;
			}
			$i++;
		}
	?>
</table>
