<?php /*╚══════════════════════════════════════════════════════════════════════╝╚══════════════▓▒░ Class HTMLgen ░▒▓═══╝
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ CATEGORY:            ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  HTML GENERATOR     ▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ CLASS NAME:          ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  HTMLgen            ▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ Author:              ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  Gavin Campbell     ▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ LAST REVISION DATE:  ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  MARCH 11th 2019    ▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲
▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█▓▒░ Current Version:     ░▒▓▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀  V3                 ▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼
//_______________________________________________________________________________________________________CONSTANTS____*/
const self_closers = array('area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'iframe', 'img', 'input', 'keygen',
                           'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr');
const rn="\r\n", Equal='=' , HtmlSelfTermTerm='</', HtmlSelfTerm='/>', LeftHtml='<', HtmlGT='>', SDQ='"', space=' ';
//___CONSTANTS________________________________________________________________________________________________________*/


/*▲▼ 03 11 2019 ═══════════╝▀▀▀▀▀▀▀▀▀▀▀▀▀▀■▓▒░  Class HTMLgen ░▒▓■▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█╚═══▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲▼▲  V3 ══▀ */
class htmlgen
{
	private $output;
	
	function __destruct() { unset ($this->output); }
	
	public function build($tagName, array $attributes = [], $children = ''): void
	{
		$isSelfClosingTag = in_array($tagName, self_closers, true);
		$this->output .= ($isSelfClosingTag ? rn : ''). LeftHtml.$tagName;
		
		foreach($attributes as $key => $value) {
			$this->output .= space.$key.Equal.SDQ.$value.SDQ;
		}
		
		$this->output .= ($isSelfClosingTag ? HtmlSelfTerm : HtmlGT).rn;
		
		if(is_array($children)) {
			foreach($children as $child) {
				$this->build($child[0], $child[1], $child[2] ?? '');
			}
		}
		else	{
			$this->output .= $children;
		}
		
		$this->output .= $isSelfClosingTag	? rn	: HtmlSelfTermTerm.$tagName.HtmlGT;
	}
	
	public function output():string { return $this->output; }
}/*═══════════════════════════════════════════════════════════════╝╚══════════════▓▒░ Class HTMLgen ░▒▓══════════════╝*/



/*■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░░░░░ EXAMPLE USAGE ░░░░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■*/
$form=new htmlgen();
$form->build('form', ['action'=>'index.php'],[
	['input', ['type'=>'text'],[]],
	['input', ['type'=>'text'],[]]
]);

$html=new htmlgen();
$html->build('div', ['class'=>'logo'],[
		['div', ['class'=>'logo2'],"Logo2"],
		['div', ['class'=>'logo3'],[
			['p', ['class'=>'big'],'<br>red'],
			['p', ['class'=>'big'],$form->output()],
		]
		]
	]
);
echo $html->output();
/*■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░■▓▒░░  OUTPUT FROM EXAMPLE USAGE ░░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■░▒▓■

<div class="logo"><div class="logo2">Logo2</div>
<div class="logo3"><p class="big"><br>red</p><p class="big">
<form action="index.php"><input type="text"/><input type="text"/></form></p>
</div></div>*/
