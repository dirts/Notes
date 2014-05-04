<?php

	function clog($s){
		var_dump($s);
	}

	$a = microtime(true);

	for($i = 0; $i < 3; $i++){	
		$bool = include('./a.php');
	}

	clog(html_entity_decode(htmlentities('<div><a href="http://www.baidu.com/?index.php&a=1#mark">中文</div>')));
	clog(htmlspecialchars_decode(htmlspecialchars('<div><a href="http://www.baidu.com/?index.php&a=1#mark">中文</div>')));

	clog($argv[1]);


	$curl = curl_init($argv[1]);
	
	//curl_setopt($curl, CURLOPT_GET, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	$res = curl_exec($curl);
	$status_code    = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	clog($res);
/*
1. 错误处理不同
* include 报错后仍然继续执行， require不在继续执行后面的代码; 
*/
?>
