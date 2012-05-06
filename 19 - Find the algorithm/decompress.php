<?php

function twoComplement($int){
	return (~$int) + 1;
}

function read_signed_sixint($str){
	$bits = array_map("intval",str_split($str,1));
	array_shift($bits); //delete a bit
	$v = 0;
	$x = 0;
	$inv = 0;
	if($bits[0] == 1){
		$inv = 1;
	}
	
	for($i = count($bits) - 1; $i > 0; --$i){
		$v += pow(2, $x) * ($bits[$i] ^ $inv);
		++$x;
	}	
	return $v;
}

function hexToBin($str){
	$ret = "";
	foreach(str_split($str, 2) as $hex){
		$ret .= str_pad(decbin(hexdec($hex)), 8, "0", STR_PAD_LEFT);
	}
	return $ret;
}

$out = "ZGUzY2Y4ODFiY2RiZmJjNzlmMGVhMzc3OGYzZTIxNGRiODdlZjFlN2M0ODM3OGYzZTI2MDczZGJjNzlmMTI5NDE4ZGUzY2Y4OTIyMDQwMjNiYWViYWM4ZGJjNzlmMTA5MjgzZGUzY2Y4ODEwYzZhMGE5ZTY5NjdlZjFlN2M1MDlhNzhjZGUzY2Y4OTkyOGZiYmJjNzlmMTEwMmQ5NjQ0NzQyZGUzY2Y4N2Y2ZjFlN2MzYjM3OGYzZTFiMmQ5YWQxMjNhNjMwNjVlZjFlN2MzN2I3OGYzZTE5NjEzZTkwZTAwMDgwNmI5ZWY5MDA2ZjFlN2MzNjU3MzVkNjRlN2MzMDM3OGYzZTFhNDRlZjFlN2MzYmI3OGYzZTFiOGZhNDM2ZjFlN2MzOWY3OGYzZTFmMDI4NGIxY2IzNDFlZjFlN2MzOTQxMzFjMDA1N2NmMTk4NTAyNGI3OGYzZTFmMWJjNzlmMTBhMzRhZGUzY2Y4OThiNWJjNzlmMTNmMmM0MzlhZGUzY2Y4YTI4Y2NlZjFlN2M1NjM3OGYzZTI4YzQyOGRhNjhiOGIyMmY5ZWI4ZGJjNzlmMGZjNGMxMDlkNzQxNGMzZGUzY2Y4N2E5MjAxZThhNjI4MDViZTk4MjcyYmJjNzlmMTA4MDA5ZGUzY2Y4N2ZiNjk4N2JjNzlmMTA0NjM3OGYzZTIxYmJjNzlmMGZiMjkxNzhkMDQ1ZGUzY2Y4OGNlZjFlN2M0YjUwNTlhMGI3OGYzZTFmYTkyNGNhMjA5MDgyNmY2ZjFlN2MzMjFiZGUzY2Y4NmE2ZjFlN2MzMDUxN2Q0MmQ1MmI3OGYzZTEzYTNlZjFlN2MyNDhjMTc3OGYzZTExZWJhODRlZjFlN2MyNWI3OGYzZTE0Y2Q4Mjk5Mjg4MGYzODliMg";

$out = hexToBin(base64_decode($out));
$len = strlen($out);