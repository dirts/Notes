CURL
==========

* resource curl_init( string $url ) 初始化一个实例

* bool curl_optset(resource $instance, int $opt, true )  设置选项:

		CURLOPT_NOSIGNAL 		忽略所有的curl传递给php进行的信号.
		CURLOPT_POST 			发送一个常规的POST请求，类型为:application/x-www-form-urlencoded.
		CURLOPT_PUT 			允许发送文件.
		CURLOPT_RETURNTRANSFER 	启用时允许发送文件.
		CURLOPT_SSL_VERIFYPEER 	
		CURLOPT_TRANSFERTEXT	产生的header中多个locatons中持续追加用户名和密码信息，即使域名已经发生改变.
		CURLOPT_UPLOAD 			允许文件传输.
		CURLOPT_VERBOSE			启用时会汇报所有的信息，存放在STDERR活指定的CURLOPT_STDRR 中.
		CURLOPT_BUFFERSIZE 		每次获取的数据中读入缓存大小，这个值每次都会被填满.
		CURLOPT_CLOSEPOLICY 	还存在另外3个，但是curl暂时还不支持.
		CURLOPT_CONNECTTIMEOUT	在发起连接前等待的时间，如果设置为0，则不等待.
		
	
* mixed curl_exec(resource $instance); 发出请求
* mixed curl_close(resource $instance); 关闭url

* string curl_escape(resource $instance, string $str) url encodes
* string curl_unescape(resource $instance, string $str) url decodes

* int curl_errno(resource $instance); 
* string curl_error(resource $instance); 

* mixed curl_getinfo(resource $instance, int $opt = 0);
