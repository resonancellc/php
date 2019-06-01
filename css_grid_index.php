<?php
ob_start(function ($buffer){
	$search = [ '/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s','/<!--(.|\s)*?-->/'];
	$replace = ['>','<','\\1','',];
	return preg_replace($search, $replace, $buffer);
});
	
	include "resonance_library.php";
	$html=new htmlgen();

	$html->build('html', ['lang'=>'en','xmlns'=>'http://www.w3.org/1999/xhtml'], [
		['head', [], [
			['style', [], '
				body{
					height: 100vh;
					width: 100vw;
					padding: 0px;
					margin: 0px;
				}
				.grid-container {
					display: grid;
					height: 100vh;
					width: 100vw;
					grid-template-columns: 1fr 1fr 1fr 1fr;
					grid-template-rows: 1fr .1fr 1fr 1fr .1fr 1fr;
					grid-template-areas: "top top top top" "spacer1 spacer1 spacer1 spacer1" "content content content content" "content content content content" "spacer2 spacer2 spacer2 spacer2" "bottom bottom bottom bottom";
				}
				.top {
					display: grid;
					grid-template-columns: 1fr 1fr 1fr 1fr;
					grid-template-rows: 1fr 1fr;
					grid-template-areas: ". logo logo login" "navigation navigation navigation login";
					grid-area: top;
				}

				.logo {grid-area: logo;} .login { grid-area: login; } .spacer1{ grid-area: spacer1; } .spacer2{ grid-area: spacer2; } .navigation { grid-area: navigation; } .bottom { grid-area: bottom; } .content { grid-area: content; }

				div {
					background: #b6ff00;
					outline: 1px solid #000000;
					box-shadow: 0px 0px 10px 0px black;
				}'
			]
		]],
		['body', [], [
			['div', ['class'=>'grid-container'], [
				['div', ['class'=>'top'], [
					['div', ['class'=>'logo'],"Logo"],
					['div', ['class'=>'navigation'], []],
					['div', ['class'=>'login'],
					//	FORM::SELECT('test',CreateArray('m',2,'h,search3,e,episodes3,s,series3'))
					]
				]],
				['div', ['class'=>'spacer1'], []],
				['div', ['class'=>'content'], []],
				['div', ['class'=>'spacer2'], []],
				['div', ['class'=>'bottom'], []],
			]]
		]]
	]);
	echo "<!DOCTYPE html>";
	echo $html->output();

?>
