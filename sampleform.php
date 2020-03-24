<?php
/*  Gavin Campbell 2020, (C)Resonacne LLC For anyone to abuse and expand on knowing this isnt secure*/
highlight_file (__FILE__);
$data = (!empty($_POST)) ? $_POST : 'nodata';

$form=<<<FORM
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<form action="" method="post">
<input type="text" name="control1" id="control1" placeholder="control1">
<input type="radio" id="one" name="control2" data-value="one" value="one"/><label for="one">one</label>
<input type="radio" id="two" name="control2" data-value="two" value="two"/><label for="two">two</label>
<input type="radio" id="three" name="control2" data-value="three" value="three" checked="true"/><label for="three">three</label>
<select name="control3" id="control4">
<option value="one">Un!</option>
<option value="two">Duex</option>
<option value="three">Trois</option>
</select>
<textarea name="control4" id="control4" rows="3" cols="40" placeholder="name"></textarea>
<button type="submit">Submit</button>
</form>
</body>
</html>
FORM;

if($data != 'nodata'){
 $submit= new submitform($data);
 var_dump($submit);
 echo "<br>control 1 is ".$submit->control1;
}
echo $form;

class submitform{
public array $datain;
protected array $data;

public function __construct(array $datain){
 $this->datain=$datain;
 $this->processdata();
}
protected function processdata(){
 //dont do this! sanitize data first
 $this->data=$this->datain;
}

public function __set($property, $value){
 return $this->data[$property] = $value;
}

public function __get($property){
 return array_key_exists($property, $this->data) ? $this->data[$property]: null;
} 
