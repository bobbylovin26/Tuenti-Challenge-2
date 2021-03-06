<?php

//php doesn't have a non-recursive replace function. so I had to write a custom one

/*
//old function (replaced with a best one!)
function non_recursive_replace($search, $replace, $str){
	$findings = array();
	$replaces = array();
	foreach($search as $i => $find){
		$replaces[$find] = array($replace[$i], strlen($find));
		preg_match_all("/$find/", $str, $matches, PREG_OFFSET_CAPTURE);
		foreach($matches[0] as $pos){
			$findings[$pos[1]] = $pos[0];
		}
	}
	ksort($findings);
	$offset = 0;
	$result = "";
	foreach($findings as $off => $find){
		$cnt = $off - $offset;
		if($cnt > 0){
			$result .= substr($str, $offset, $cnt);
		}
		$result .= $replaces[$find][0];
		$offset += $cnt + $replaces[$find][1];
	}
	$result .= substr($str, $offset);
	return $result;
}*/

//here are the function. but I made some improvements specific for THIS challenge, so this isn't used
/*
function non_recursive_replace($search, $replace, $str){
	$len = strlen($str);
	$result = "";
	$res = array();
	for($l = 0; $l < $len; ++$l){
		$char = $str{$l};
		if(!isset($res[$char])){
			$tmp = "";
			foreach(preg_grep("/$char/", $search) as $i => $find){
				$tmp .= $replace[$i];
			}
			$res[$char] = $tmp;
		}
		
		if($res[$char] === ""){
			$result .= $char;
		}else{
			$result .= $res[$char];
		}
	}
	unset($str);
	return $result;
}
*/

//the special function. I forgot to remove the $replace arg
function special_non_recursive_replace($search, $replace, $str, $len = -1){
	if(!isset($str{$len-1})){
		$len = strlen($str);
	}
	$result = "";
	for($l = 0; $l < $len; ++$l){ //char after char... this works best for this case rather than preg_grep
		$char = $str{$l};
		if(!isset($search[$char])){
			$result .= $char;
		}else{
			$result .= $search[$char];
		}
	}
	return $result;
}


$lines = array();
while(!feof(STDIN)){
	$lines[] = str_replace(array("\r", "\n") , "", fgets(STDIN));
}

ini_set("memory_limit", "2048M"); //just in case. It only takes about 100MB of memory

$outfile = dirname(__FILE__)."/out.tmp";

$queue = trim(array_shift($lines));
file_put_contents($outfile."0", $queue);

$lcnt = count($lines);
$search = array();
$special = array();
$replace = array();

for($l = 0; $l < $lcnt; ++$l){ //get all transformations first
	unset($transformations);
	$transformations = array();
	$tmp = array_map("trim", explode(",",$lines[$l]));
	foreach($tmp as $tf){
		$tf = explode("=>", $tf);
		if(!isset($transformations[trim($tf[0])])){
			$transformations[trim($tf[0])] = "";
		}
		$transformations[trim($tf[0])] .= trim($tf[1]);
	}
	$search[$l] = array();
	$replace[$l] = array();
	$i = 0;
	foreach($transformations as $chr => $add){
		$search[$l][$i] = $chr;
		if(!isset($special[$l][$chr])){
			$special[$l][$chr] = "";
		}
		$special[$l][$chr] .= $add;
		$replace[$l][$i] = $add;
		++$i;
	}
}

$fr = fopen($outfile."0", "r"); //open soruce file

$len = 1024 * 1024 * 16; //lenght to read (memory issues fixed with this. PHP does not handle well large amounts of data)
for($l = 0; $l < $lcnt; ++$l){
	$fw = fopen($outfile."".($l + 1)."", "w+");	 //open target file
	while(!feof($fr)){
		//direct write of replacement
		@fwrite($fw, special_non_recursive_replace($special[$l], $replace[$l], @fread($fr, $len), $len));
	}
	fclose($fr); //close read
	@unlink($outfile."$l"); //save space
	$fr = $fw; //reuse file pointer
	rewind($fr); //rewind, like in a casette or VHS xD
}

fclose($fr);
echo md5_file($outfile."$l"),PHP_EOL; //md5 of a file... I couldn't use here md5() because file size
@unlink($outfile."$l"); //free!!
?>