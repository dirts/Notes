<?php
	
	$redis = new redis;
	$redis->connect('127.0.0.1', 6379);
	$foo = $redis->get('foo');
	$foo = $redis->lRange('mykey1', 0, 10);
	var_dump($foo);
?>
