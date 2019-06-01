<?php
══════════════════════════════════════════════════════════▓▒░ V1 ░▒▓════════════════════════════════════════════════════
"t function" Based on spoopys php idea on mustashe
■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░░░░░░ EXAMPLE USAGE ░░░░░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■
echo t('html', [], [
		t('head', [], [
		t('link', ['href'=>'./raas/cal.css','type'=>'text/css','rel'=>'stylesheet'],[]),
		t('style', [], [])
			//.'.today{background-color:red!important;}')
	]),
	t('body', [], [
		t('span', ['style'=>"color:green;"], [
		t('p', [], dirname(__FILE__)), //t('p', [], __DIR__),
		t('p', [], dirname($_SERVER['PHP_SELF'])),
		t('p', [], ($_SERVER['PHP_SELF'])),
			t('form', [], [
				FORM::SELECT('test',$choices),
				FORM::SELECT('test',CreateArray('m',2,'h,search2,e,episodes2,s,series2')),
				$form,
				FORM::SELECT('test',CreateArray('m',2,'h,search3,e,episodes3,s,series3')),
			]),
		]),
		t('span', ['style'=>"color:red;"],
		[
			f($choices)
		]),
	])
]);
■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░  OUTPUT FROM EXAMPLE USAGE ░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■

■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░░░░░░░░░░ CODE ░░░░░░░░░░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■

e

function t($tagName, array $attributes = [], $children = '')
{
	$output=(in_array($tagName, self_closers) ? rn : '');
	$output.=lt.$tagName;
	foreach ($attributes as $key => $value)
	{
		$output .= ' '.$key.e.sq.$value.sq;
	}
	if (is_array($children))
	{
		$children = implode('', $children);
	}

	//	if ($enclosedtest)		{			$output .= "/>$children".rn;	  	}
	//	else		{	  		$output .= ">$children</$tagName>".rn;		}
	
	$output .= (in_array($tagName, self_closers)	? er.rn.$children
		: rt.$children.el.$tagName.rt.rn);
	return $output;
}
