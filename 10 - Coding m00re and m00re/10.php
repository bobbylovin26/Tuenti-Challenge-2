<?php

$lines = array();
while(!feof(STDIN)){
	$lines[] = explode(" ", trim(str_replace(array("\r", "\n") , "", fgets(STDIN))));
}

foreach($lines as $tokens){
	$numbers = array();
	foreach($tokens as $tok){
		$c = count($numbers) - 1;
		switch($tok){
			case "dance": //interchange numbers
				$tmp = $numbers[$c];
				$numbers[$c] = $numbers[$c - 1];
				$numbers[$c - 1] = $tmp;
				break;
			case "mirror": // * -1
				$numbers[$c] = bcmul(array_pop($numbers), "-1");
				break;
			case "conquer": //module
				$numbers[$c - 1] = $numbers[$c - 1] % array_pop($numbers);
				break;
			case "breadandfish": //same number
				$numbers[$c + 1] = $numbers[$c];
				break;
			case "fire": //delete!
				array_pop($numbers);
				break;
			case '$': //substract
				$numbers[$c - 1] = bcsub($numbers[$c - 1], array_pop($numbers));
				break;
			case '@': //add
				$numbers[$c - 1] = bcadd($numbers[$c - 1], array_pop($numbers));
				break;
			case '#': //multiplicate
				$numbers[$c - 1] = bcmul($numbers[$c - 1], array_pop($numbers));
				break;
			case '&': //divide
				$numbers[$c - 1] = bcdiv($numbers[$c - 1], array_pop($numbers));
				break;
			case '.': //end of line!
				echo $numbers[$c],PHP_EOL;
				break;
			default: //add numbers
				$numbers[] = $tok;
				break;
		}
	}
}