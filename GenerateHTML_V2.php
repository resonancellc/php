
<?php
/*
class htmlgen
{
	private $output;
	
	function __destruct()
	{
		unset ($this->output);
	}
	
	public function build($tagName, array $attributes = [], $children = ''): void
	{
		$isSelfClosingTag = in_array($tagName, self_closers, true);
		$this->output .= ($isSelfClosingTag ? rn : ''). LeftHtml.$tagName;
		
		foreach($attributes as $key => $value)
		{
			$this->output .= space.$key.Equal.SDQ.$value.SDQ;
		}
		
		$this->output .= ($isSelfClosingTag ? HtmlSelfTerm : HtmlGT).rn;
		
		if(is_array($children))
		{
			foreach($children as $child)
			{
				$this->build($child[0], $child[1], $child[2] ?? '');
			}
		}
		else
		{
			$this->output .= $children;
		}
		
		$this->output .= $isSelfClosingTag	? rn	: HtmlSelfTermTerm.$tagName.HtmlGT;
	}
	
	public function output():string
	{
		return $this->output;
	}
}
*/



/*════════════════════════════════════════════════════════════════════════╝╚══════════════▓▒░ HISTORY ░▒▓══════════════╝
══════════════════════════════════════════════════════════▓▒░ V2 ░▒▓════════════════════════════════════════════════════
ORIGINAL - Dec 2018



═════════════════════════════════════════════════════════▓▒░ V2.2 ░▒▓═══════════════════════════════════════════════════

/* created by https://github.com/ljosberinn

class HTMLGenerator {

	private const SELF_CLOSERS = [
	'area',
	'base',
	'br',
	'col',
	'command',
	'embed',
	'hr',
	'iframe',
	'img',
	'input',
	'keygen',
	'link',
	'menuitem',
	'meta',
	'param',
	'source',
	'track',
	'wbr',
	];
	
	/** @var string $output
	private $output = '';
	
	public function build(string $tagName, array $attributes = [], $children = ''): void {
		$isSelfClosingTag = in_array($tagName, self::SELF_CLOSERS, true);
	
		if($isSelfClosingTag) {
			$this->output .= "\r\n";
		}
	
		$this->output .= '<' . $tagName;
	
		foreach($attributes as $key => $value) {
			$this->output .= ' ' . $key . '=' . '"' . $value . '"';
		}
	
		$this->output .= $isSelfClosingTag ? '/>' : '>';
		$this->output .= "\r\n";
	
		if(is_array($children)) {
			foreach($children as $child) {
				$this->build($child[0], $child[1], $child[2] ?? '');
			}
		} else {
			$this->output .= $children;
		}
		
		$this->output .= $isSelfClosingTag ? "\r\n" : el . $tagName . '>';
		}
	
	public function getOutput(): string {
		return $this->output;
	}
}
