<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    $redis = new Redis();
    $conn = $redis->connect('127.0.0.1', 6379);

    function lua_script_add_msg_num($key, $field, $inc) {
        $lua_script =
            "if redis.call('hincrby', $key, $field, $inc) ~= 0 then \n".
            "   return redis.call('hincrby', $key, 'total', $inc) \n".
            "end\n".
            "return nil \n";
        return $lua_script;
    }

    function lua_script_remove_msg_num($key, $field) {
        $lua_script =
            "local msg_num = redis.call('hget', $key, $field)\n".
            "if redis.call('hdel', $key, $field) ~= 0 then \n".
            "   return redis.call('hincrby', $key, 'total', -msg_num) \n".
            "end\n".
            "return nil \n";
            return $lua_script;
    }

    $lua_add_msg = lua_script_add_msg_num(71330941, 766, 1);
    $lua_remove_msg = lua_script_remove_msg_num(71330941, 766);

    //$res = $redis->eval($lua_remove_msg);

    for($i = 0; $i < 120000; $i++) {
        $res = $redis->eval($lua_add_msg);
    }

?>
