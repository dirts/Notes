<?php

	function clog($msg){
		var_dump($msg);
	}

	$str = chunk_split('abcdefg', 3);
	$str = nl2br($str);
	//$str = html_entity_decode("<div><span><a href='http://www.baidu.com'>contents</a></span></div>");
	//$str = htmlspecialchars_decode("<div><span><a href='http://www.baidu.com'>contents</a></span></div>");
	$str = strip_tags("<div><span><a href='http://www.baidu.com'>contents</a></span></div>");
	$str1 = stristr( 'http://www.baidu.com', 'baidu');
	$str2 = strchr( 'http://www.baidu.com', 'baidu');
	
	$offset = strripos('abcdefaAg', 'a');

	$str = crypt('abc', 'A');


	//$of = strchr('abc defg', 'e');
	$log = svn_log('svn://192.168.2.80/zhisland/trunk/code/website/api.zhisland.com/branches/api_1', 24378);
	clog($log);
	$content = svn_cat('svn://192.168.2.80/zhisland/trunk/code/website/api.zhisland.com/branches/api_1/function/action/client/credit.fun.php', 24378);
	//clog($content);
?>

