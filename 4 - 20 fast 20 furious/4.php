<?php
while(1){
	$count = str_replace(array("\r", "\n") , "", fgets(STDIN));
	if($count != ""){
		break;
	}
}
$count = intval($count);

for($c = 0; $c < $count; ++$c){
	$line = explode(" ", str_replace(array("\r", "\n") , "", fgets(STDIN)));
	$races = intval($line[0]);
	$karts = intval($line[1]);
	$groupN = intval($line[2]);
	$groups = array_map("intval", explode(" ", str_replace(array("\r", "\n") , "", fgets(STDIN))));
	$liters = 0;

	$roundL = 0;
	$tmp = array(implode(" ", $groups) => true);
	$tmp2 = $groups;
	$iterations = 0;
	while($iterations < $races and $iterations >= 0 and (!isset($tmp[implode(" ",$groups)]) or $iterations == 0)){
		//get the repeated queue with !isset($tmp[implode(" ",$groups)])
		$tmp[implode(" ",$groups)] = array($iterations, $roundL);
		++$iterations;
		$fill = 0;
		$groupsR = array();
		while(count($groups) > 0 and ($fill + $groups[0]) <= $karts){
			$fill += $groups[0];
			$groupsR[] = array_shift($groups);
		}
		while(count($groupsR) > 0){
			$groups[] = array_shift($groupsR);
		}		
		$roundL += $fill;
		
	}
	$itt = 0;
	
	if(isset($tmp[implode(" ",$groups)])){ //use this algorithm if a repeating queue was found
		$itt = $tmp[implode(" ",$groups)][0];
		$roundL = $roundL - $tmp[implode(" ",$groups)][1];
		$tmp3 = implode(" ",$groups);
		$groups = $tmp2;
		for($r = 0; $r < $itt ; ++$r){ //sum repeats
			--$races;
			$fill = 0;
			$groupsR = array();
			while(count($groups) > 0 and ($fill + $groups[0]) <= $karts){
				$fill += $groups[0];
				$groupsR[] = array_shift($groups);
			}
			while(count($groupsR) > 0){
				$groups[] = array_shift($groupsR);
			}		
			$liters = bcadd($liters, $fill);
		}

		
	}
	
	
	$rou = floor($races / ($iterations - $itt)); //calculate restant rounds
	$liters = bcadd($liters, bcmul($roundL, $rou)); //calculate added liters
	
	
	//do the work
	for($r = 0; $r < ($races - $rou * ($iterations - $itt)); ++$r){
		$fill = 0;
		$groupsR = array();
		while(count($groups) > 0 and ($fill + $groups[0]) <= $karts){
			$fill += $groups[0];
			$groupsR[] = array_shift($groups);
		}
		while(count($groupsR) > 0){
			$groups[] = array_shift($groupsR);
		}		
		$liters = bcadd($liters, $fill);
	}
	
	echo $liters,PHP_EOL; // ;)
}