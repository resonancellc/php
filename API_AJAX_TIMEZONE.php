<?php
	$function = $_GET['f'] ?? "default";
	$timezone = $_GET['timezone'] ?? "nozone";

	//if ($timezone=="nozone"){ $function="time";}
	$today = date("d-m-Y");
	//echo $function;
	//echo $timezone;
	$out=[];
	switch($function)
	{
		case "time":
		{
			$out= array('timezone' => reduce($timezone));
			break;
		}
		case "default":
		{
			$out= array('out' => reduce($function));
		}
	}

	echo json_encode($out);

function reduce($stringin)
{
	$stringout = trim($stringin);
	$stringout = str_replace("\n","", $stringout);
	$stringout = str_replace("\r","", $stringout);
	$stringout = str_replace("\n",'', $stringout);
	$stringout = str_replace("\t",'', $stringout);
	$stringout = rtrim($stringout, "\x00..\x1F");
	return $stringout;
}

?>
