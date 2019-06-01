<?php
/*╚═══════════════════════════════════════════════════════════════════════╝╚══════════════▓▒░ Class ArrayBuilder ░▒▓═══╝
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ CATEGORY:            ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  ARRAYS             ▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ CLASS NAME:          ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  ARRAYBUILDER       ▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ Author:              ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  Gavin Campbell     ▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ LAST REVISION DATE:  ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  MARCH 11th 2019    ▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ Current Version:     ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  V3                 ▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼
■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░░░░░░ EXAMPLE USAGE ░░░░░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■
*/
$genray = new ArrayBuilder(); $genray->delimiter=','; $genray->type='multi';$genray->genArray();
$holder=$genray->output();

$genray->type='single'; $genray->delimiter=' '; $genray->input='check on it for me'; $genray->genArray();
$holder2=$genray->output();

$genray->type='multiassoc'; $genray->delimiter='_'; $genray->input='check_on_it_for_me_me'; $genray->genArray();
$holder3=$genray->output();

echo "<pre>"; var_dump($holder); var_dump($holder2); var_dump($holder3); echo "</pre>";
/*
■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░  OUTPUT FROM EXAMPLE USAGE ░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■
array(3) { [0]=> array(2) { [0]=> string(1) "h" [1]=> string(6) "search" }[1]=>  array(2) { [0]=> string(1) "e"
[1]=> string(8) "episodes" }	[2]=>  array(2) { [0]=> string(1) "s" [1]=>    string(6) "series"  } }

array(5) {  [0]=>  string(5) "check"  [1]=>  string(2) "on"  [2]=>  string(2) "it"[3]=>  string(3) "for"
[4]=>  string(2) "me"}

array(3) {  ["check"]=>  string(2) "on"  ["it"]=>  string(3) "for"  ["me"]=>  string(2) "me"}
*/

/*▲▼ 03 11 2019 ═════════╝▀▀▀▀▀▀▀▀▀▀▀▀▀▀■▓▒░ Class ArrayBuilder ░▒▓■▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█╚═══▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲  V3 ══▀ */
class ArrayBuilder{
	private $temp=['delimiter'=>',','type'=>'single', 'input'=>'h,search,e,episodes,s,series'];
	private $output=[];
	
	public function __get($var) { if(array_key_exists($var,$this->temp)) { return $this->temp[$var]; } }
	public function __set($var,$value):void { if(array_key_exists($var,$this->temp)) { $this->temp[$var]=$value; } }
	public function __isset($var):bool	{ return isset($this->temp[$var]);	}
	public function output():array { return $this->output;	}
	public function genArray() {
		$tmpout = array_map('trim', explode($this->temp['delimiter'], $this->temp['input']));
		
		if($this->temp['type'] === "multi" or $this->temp['type'] === "multiassoc"){
			$tmpout = array_chunk($tmpout, 2);
		}
		
		if($this->temp['type'] === 'multiassoc') {
			$tmpout = array_combine(array_column($tmpout, 0), array_column($tmpout, 1));
		}
		$this->output = $tmpout;
		return $this;
	}
}/*════════════════════════════════════════════════════════════╝╚══════════════▓▒░ Class ArrayBuilder ░▒▓══════════════╝

unset($tmpout) in genArray() is unnecesssary


/*════════════════════════════════════════════════════════════════════════╝╚══════════════▓▒░ HISTORY ░▒▓══════════════╝
═════════════════════════════════════▓▒░ function CreateArray & class ResArrayBuilder ░▒▓═══════════════════════════════
ORIGINAL - Dec 2018
■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░░░░░░ EXAMPLE USAGE ░░░░░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■
$choices=CreateArray('s',2,'h,search,e,episodes,s,series');
echo "<pre>"; var_dump($choices);echo "</pre>";
■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░  OUTPUT FROM EXAMPLE USAGE ░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■
array(1) {[0]=>  string(28) "h,search,e,episodes,s,series"}
■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░░░░░░░░░░ CODE ░░░░░░░░░░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■
function CreateArray($option, $chunk, $incoming)
{
	if($option == "s"){
		$temp = new ResArrayBuilder($chunk, $incoming);
		return $temp->outputArray();
	}
	if($option == "m"){
		$temp = new ResArrayBuilder(d, $incoming);
		$temp = $temp->outputArray();
		return array_chunk($temp, $chunk);
	}
	if($option == "ma"){
		$temp = new ResArrayBuilder(d, $incoming);
		$temp = $temp->outputArray();
		$temp = array_chunk($temp, $chunk);
		$temp = array_combine(array_column($temp, 0), array_column($temp, 1));
		return $temp;
	}
}
class ResArrayBuilder
{
	public $incoming, $delim, $arrayComplete, $check;
	
	function __construct($delim, $incoming) {
		$this->incoming = $incoming;	$this->delim = $delim; $check = $this->checkchar($delim); $this->genArray();
	}
	
	function __destruct() {
		unset($this->incoming);	unset($this->delim); unset($this->check); unset($this->arrayComplete);
	}
	
	function checkchar($incoming)	{ return ord($incoming);	}
	
	function genArray() {
		$this->arrayComplete = array_map('trim', explode($this->delim, $this->incoming));
	}
	
	function outputArray() {	return $this->arrayComplete;	}
}

╚═════════════════════════════════════════╝╚════════════════════▓▒░ function CreateArray & class ResArrayBuilder ░▒▓═══╝
═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════▀
═════════════════════════════════════════════════════════════════════════════════════════════════════════════════▀
═══════════════════════════════════════════════════════════════════════════════════════════════════════════════▀
═════════════════════════════════════════════════════════════════════════════════════════════════════════════▀
═══════════════════════════════════════════════════════════════════════════════════════════════════════════▀
═════════════════════════════════════════════════════════════════════════════════════════════════════════▀*/
