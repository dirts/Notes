Index 索引
============

索引是快速搜索的关键。MySql索引的建立对于mysql的高效运行是很重要的，下面介绍几种常见的mysql索引类型

在数据库表中，对字段建立索引可以大大提高查询速度。例如我们创建了一个mytable表:

	CREATE TABLE mytable (id int not null, username varchar(16) not null);

我们随机向里面插入了10000条记录，其中有一条:5555,admin.   select * from mytable where username='admin'

如果在username上已经建立了索引，mysql无须任何扫描，即准确可找到该记录。相反，Mysql会扫描所有记录，即要查询10000条记录。

索引分为：单列索引，和组合索引。单列索引，即一个索引只包含单个列，一个表可以有多个单列索引，但这不是组合索引。组合索引，即一个索引包含多个列。


## 创建索引：

	CREATE INDEX index_name ON tablename( username(length) ); 	

## 修改表结构：

	ALTER tablename ( id int not null, username varchar(16) not null, )



## 查看索引
	
	mysql> show index from tblname;
	mysql> show keys from tblname;

* Table 表的名称。
* Non_unique 如果索引不能包括重复词，则为0。如果可以，则为1。
* Key_name 索引的名称。
* Seq_in_index 索引中的列序列号，从1开始。
* Column_name 列名称。
* Collation 列以什么方式存储在索引中。在MySQL中，有值‘A’（升序）或NULL（无分类）。
* Cardinality 索引中唯一值的数目的估计值。通过运行ANALYZE TABLE或myisamchk -a可以更新。基数根据被存储为整数的统计数据来计数，所以即使对于小型表，该值也没有必要是精确的。基数越大，当进行联合时，MySQL使用该索引的机 会就越大。
* Sub_part 如果列只是被部分地编入索引，则为被编入索引的字符的数目。如果整列被编入索引，则为NULL。
* Packed 指示关键字如何被压缩。如果没有被压缩，则为NULL。
* Null 如果列含有NULL，则含有YES。如果没有，则该列含有NO。
* Index_type 用过的索引方法（BTREE, FULLTEXT, HASH, RTREE）。
* Comment





http://downloads.skysql.com/archive/index/p/mysql/v/
http://mirror.switch.ch/ftp/mirror/mysql/Downloads/ 
http://mirrors.sohu.com/


mysql在遇到严重性能问题时，一般都有这么几种可能：
1、索引没有建好;
2、sql写法过于复杂;
3、配置错误;
4、机器实在负荷不了;

 

1.索引没建好，一个办法，后台执行脚本，show processlist 实时查看Mysql的工作情况，记录，锁死Mysql的语句。然后，desc（explain）语句，查看用到了什么索引，然后看情况建立合适的索引。（这个索引比较麻烦，有时候这里解决了，其他地方又慢了，所以要通盘考虑）

2.检查查询效率慢的SQL语句，看怎么优化，也是用desc或者explain来看。

3.配置：

配置里主要参数是key_buffer，sort_buffer_size，myisam_sort_buffer_size，
key_buffer=128M：全部表的索引都会尽可能放在这块内存区域内，索引比较大的话就开稍大点都可以，我一般设为128M，有个好的建议是把很少用到并且比较大的表想办法移到别的地方去，这样可以显著减少mysql的内存占用。
sort_buffer_size=1M：单个线程使用的用于排序的内存，查询结果集都会放进这内存里，如果比较小，mysql会多放几次，所以稍微开大一点就可以了，重要是优化好索引和查询语句，让他们不要生成太大的结果集。
另外一些配置：
thread_concurrency=8：这个配置标配=cpu数量x2
interactive_timeout=30
wait_timeout=30：这两个配置使用10-30秒就可以了，这样会尽快地释放内存资源，注意：一直在使用的连接是不会断掉的，这个配置只是断掉了长时间不动的连接。
query_cache：这个功能不要使用，现在很多人看到cache这几个字母就像看到了宝贝，这是不唯物主义的。mysql的query_cache 在每次表数据有变化的时候都会重新清理连至该表的所有缓存，如果更新比较频繁，query_cache不但帮不上忙，而且还会对效率影响很大。这个参数只适合只读型的数据库，如果非要用，也只能用query_cache_type=2自行用SQL_CACHE指定一些sql进行缓存。
max_connections：默认为100，一般情况下是足够用的，但是一般要开大一点，开到400-600就可以了，能超过600的话一般就有效率问题，得另找对策，光靠增加这个数字不是办法。
其它配置可以按默认就可以了，个人觉得问题还不是那么的大，提醒一下：1、配置虽然很重要，但是在绝大部分情况下都不是效率问题的罪魁祸首。2、mysql是一个数据库，对于数据库最重要考究的不应是效率，而是稳定性和数据准确性。

注意：这里wait_timeout，会kill超过这个时间sleep的语句，还需要改：interactive_timeout！

其他一些：

 back_log     　     指定到来的TCP/IP连接的侦听队列大小     因操作系统不同而不同，LINUX系统推荐小于512的整数，一般设置成300     
 key_buffer_size     索引缓存大小     优化索引的缓冲区大小     根据*.MYI的文件大小进行设置，没有MYISAM表的情况下保留16-32M提供磁盘临时表索引用     　
 max_connections     最大连接数     优化MYSQL的最大连接数     500     
 innodb_buffer_pool_size     INNODB缓冲池大小     用于缓存表的数据与索引     内存的80%     
 innodb_additional_mem_pool_size     INNODB附加内存缓存池大小     用于存放数据目录信息和其他内部数据结构     20M左右     
 innodb_log_file_size     每个日志文件大小     用于存放日志     64-512M     5242880  （5M）32位机器小于4G
 innodb_log_buffer_size     每个日志文件缓存大小     优化高强度写入与短事务处理能力     8-16M    
 innodb_flush_log_at_trx_commit     提交事务日志刷新方式     0.不刷新事务提交1.刷新到磁盘2.刷新到操作系统缓存     2.刷新到操作系统缓存.后果：除非操作系统崩溃或停电会损失1秒的事务提交记录     　
 table_cache     表缓存     缓存已打开的表     1024    
 thread_cache_size     线程缓存大小     它的目的是在通常的操作中无需创建新线程。     至少16  
 query_cache_size     查询缓存大小     提高缓存命中率     32-512M     
 sort_buffer_size     查询排序缓存大小     优化排序缓存空间     6M     
 read_buffer_size     读查询缓存大小     优化读查询操作缓存空间     4M     
 join_buffer_size     联合查询操作缓存大小     优化联合查询操作缓存空间     8M     
  
 4.Mysql负载不了

 A：通过mysql同步功能将数据同步到数台从数据库，由主数据库写入，从数据库提供读取。

 B：最靠谱的，使用memcachedb

 C：加入缓存（网上看到的，并没有研究）
 加入缓存之后，就可以解决并发的问题，效果很明显。如果是实时系统，可以考虑用刷新缓存方式使缓存保持最新。
 在前端加入squid的架构比较提倡使用，在命中率比较高的应用中，基本上可以解决问题。
 如果是在程序逻辑层里面进行缓存，会增加很多复杂性，问题会比较多而且难解决，不建议在这一层面进行调整。


	yum -y install gcc gcc-c++ make autoconf libtool-ltdl-devel gd-devel freetype-devel libxml2-devel libjpeg-devel libpng-devel openssl-devel curl-devel bison patch unzip libmcrypt-devel libmhash-devel ncurses-devel binutils compat-libstdc++-33 elfutils-libelf elfutils-libelf-devel glibc glibc-common glibc-devel libaio-devel libaio libgcc libstdc++ libstdc++-devel unixODBC unixODBC-devel numactl-devel glibc-headers sudo bzip2 mlocate flex lrzsz sysstat lsof setuptool  system-config-network-tui system-config-firewall-tui ntsysv ntp libaio-devel wget ntp pv lz4 vim rsync dstat iotop innotop telnet iftop expect nc
	



	我们为什么要使用PDO进行PHP程序开发

	PDO扩展为PHP定义了一个访问数据库的轻量的，持久的接口。实现了PDO接口的每一种数据库驱动都能以正则扩展的形式把他们各自的特色表现出来。注意；利用PDO扩展本身并不能实现任何数据库函数。你必须使用一个特定的数据库PDO驱动去访问数据库。
	PDO提供了一个数据访问抽象层，这就意味着，不管你使用的是哪种数据库，你都可以用同样的函数去进行查询的获取数据。PDO并不提供数据提取，它不会重写SQL语句，或者模仿这些功能。你需要使用一个成熟的提取层，如果你需要的话。
	怎么样，是不是看了译文就有一种恍然大悟的感觉了？
	没有？
	那说的再详细点。
	我们为什么要使用PDO？
	1、更换数据库时取得极大便利
	在PHP4/3时代，PHP要利用php_mysql.dll、php_pgsql.dll、php_mssql.dll、 php_sqlite.dll等等扩展来连接MySQL、PostgreSQL、MS SQL Server、SQLite，这其实也没什么。也就是在配置时多添句话就行了。
	可怕的是，这些扩展和各自对应的数据库打交道时，他们各自的函数有很多是不一样的。
	比如：
	PHP利用libmysql.dll和MYSQL打交道时，如果要从数据表中提取数据作为关联数组，用的是mysql_fetch_accoc，而如果要从postgre数据库取得同样的结果，你就不得不用pg_fetch_assoc。
	很简单的例子说明了很重要的问题，假如你要更换数据库类型，比如从MYSQL更换成POSTGRE，你就不得把你所有和数据库有关的程序都改一遍。这时候，你应该会明白，为什么我不用PDO？？
	2、极大提高程序运行效率 
	针对上面的情况，也许你会说，我可以使用ADODB(LITE)，PEAR::db来实现对不同类型数据库函数的封装啊。这样子，即使我更换数据库，也不需要修改程序。
	答：php代码的效率怎么能够和直接用C/C++写的扩展效率比较呢？根本不是一个数量级的。
	OK，从现在开始用PDO进行你的开发吧。
	安装
	PDO扩展为PHP访问数据库定义了一个轻量级的、一致性的接口，它提供了一个数据访问 抽象层，这样，无论你使用什么数据库，你都可以通过一致的函数执行查询和获取数据。注意，你并不能使用PDO扩展本身执行任何数据库操作，你必须使用一个database-specific PDO driver （针对特定数据库的PDO驱动）访问数据库服务器。
	PDO并不 提供数据库 抽象，它并不会重写SQL或提供数据库本身缺失的功能，如果你需要这种功能，你需要使用一个更加成熟的抽象层。
	PDO随PHP5.1发行，在PHP5.0的PECL扩展中也可以使用。PDO需要PHP5核心OO特性的支持，所以它无法运行于之前的PHP版本。
	 
	在Unix环境下PHP5.1以上版本中：
	如果你正在使用PHP5.1版本，PDO和PDO SQLITE已经包含在了此发行版中；当你运行configure时它将自动启用。推荐你将PDO作为共享扩展构建，这样可以使你获得通过PECL升级的 好处。推荐的构建支持PDO的PHP的configure line应该也要启用zlib。你也应该启用你选择的数据库的PDO驱动 ；关于这个的更多信息请查看database-specific PDO drivers ，但要注意如果你将PDO作为一个共享扩展构建，你必须也要将PDO驱动构建为共享扩展。SQLite扩展依赖于PDO，所以如果PDO作为共享扩展构建，SQLite也应当这样构建
	./configure --with-zlib --enable-pdo=shared --with-pdo-sqlite=shared --with-sqlite=shared

	   
	将 PDO安装为一个共享模块后，你必须编辑php.ini文件使得在PHP运行时自动载入PDO扩展。你同样需要启用那儿的特定数据库 驱动；确保他们列出在 pdo.so  行之后，因为PDO必须在特定数据库驱动载入之前初始化。如果你是以静态方式构建的PDO和特定数据库驱动扩展，你可以跳过这一步。
	Php代码  收藏代码
	extension=pdo.so  
	 
	让PDO作为一个共享的模块将使你可以在新版PDO发布时运行 pecl upgrade pdo  命令升级，而不用强制你重新构建整个PHP。注意如果你是这样做的，你也需要同时升级你的特定数据库驱动。
	在Windows环境下PHP5.1以上版本中：
	PDO和主要数据库的驱动同PHP一起作为扩展发布，要激活它们只需简单的编辑php.ini文件：
	Php.ini代码  收藏代码
	extension=php_pdo.dll   
	 
	然后，选择针对特定数据库的DLL文件使用 dl() 在运行时加载，或者在php.ini文件中 php_pdo.dll 行后启用它们，如：
	Php.ini代码  收藏代码
	extension=php_pdo.dll  
	extension=php_pdo_firebird.dll  
	extension=php_pdo_informix.dll  
	extension=php_pdo_mssql.dll  
	extension=php_pdo_mysql.dll  
	extension=php_pdo_oci.dll  
	extension=php_pdo_oci8.dll  
	extension=php_pdo_odbc.dll  
	extension=php_pdo_pgsql.dll  
	extension=php_pdo_sqlite.dll  
	 
	这些DLL文件应当存在于系统的 extension_dir 目录里。注意 PDO_INFORMIX 只能作为一个PECL扩展使用。
	修改php.ini后重启http服务器。
	OK，PDO安装完毕。
	PDO中包含三个预定义的类
	PDO中包含三个预定义的类，它们分别是 PDO 、PDOStatement  和 PDOException ，下面将分别简单介绍一下。后面的系列相关文章会使用若干示例介绍这几个类的使用。
	一、PDO 
	代表一个PHP和数据库之间的连接。

	方法：
	PDO - 构造器，构建一个新的PDO对象
	beginTransaction - 开始事务
	commit - 提交事务
	errorCode - 从数据库返回一个错误代号，如果有的话
	errorInfo - 从数据库返回一个含有错误信息的数组，如果有的话
	exec - 执行一条SQL语句并返回影响的行数
	getAttribute - 返回一个数据库连接属性
	lastInsertId - 返回最新插入到数据库的行（的ID）
	prepare - 为执行准备一条SQL语句，返回语句执行后的联合结果集(PDOStatement)
	query - 执行一条SQL语句并返回一个结果集
	quote - 返回添加了引号的字符串，以使其可用于SQL语句中
	rollBack - 回滚一个事务
	setAttribute - 设置一个数据库连接属性
	Php代码  收藏代码
	/* 通过 ODBC 驱动建立数据库连接 */     
	$dsn  =  'mysql:dbname=testdb;host=127.0.0.1' ;    
	$user  =  'dbuser' ;    
	$password  =  'dbpass' ;    
	try {
		    
		  $dbh  =  new  PDO( $dsn ,  $user ,  $password );    
	} catch (PDOException $e ) {
		    
		  echo   'Connection failed: '  .  $e ->getMessage();    
	}    
/* 事务处理开始，关闭自动提交事务(autocommit) */     
$dbh ->beginTransaction();    
/* 更改数据库结构 */     
$sth  =  $dbh -> exec ( "DROP TABLE fruit" );    
/* 提交事务 */     
$dbh ->commit();    
/* Database connection is now back in autocommit mode */   
 


二、PDOStatement 
代表一条预处理语句以及语句执行后的联合结果集（associated result set）。
方法：
bindColumn - 绑定一个PHP变量到结果集中的输出列
bindParam - 绑定一个PHP变量到一个预处理语句中的参数
bindValue - 绑定一个值到与处理语句中的参数
closeCursor - 关闭游标，使语句可以再次执行
columnCount - 返回结果集中的列的数量
errorCode - 从语句中返回一个错误代号，如果有的话
errorInfo - 从语句中返回一个包含错误信息的数组，如果有的话
execute - 执行一条预处理语句
fetch - 从结果集中取出一行
fetchAll - 从结构集中取出一个包含了所有行的数组
fetchColumn - 返回结果集中某一列中的数据
getAttribute - 返回一个 PDOStatement 属性
getColumnMeta - 返回结果集中某一列的结构(metadata?)
	nextRowset - 返回下一结果集
	rowCount - 返回SQL语句执行后影响的行数
	setAttribute - 设置一个PDOStatement属性
	setFetchMode - 为 PDOStatement 设定获取数据的方式
	三、PDOException 
	返回PDO触发的错误。你不能从你的代码中抛出一个PDOException异常。
	Php代码  收藏代码
	<?php    
	try {
		    
		  $dbh  =  new  PDO( 'mysql:host=localhost;dbname=test' ,  $user ,  $pass );    
		    foreach  ( $dbh ->query( 'SELECT * from FOO' )  as   $row ) {
				    
				    print_r($row );    
					  }    
			  $dbh  = null;    
	} catch (PDOException $e ) {
		    
		  print "Error!: "  .  $e ->getMessage() .  "<br/>" ;    
		    die ();    
	}    
?>  
 

错误处理
为适合你的应用开发，PDO 提供了3中不同的错误处理策略。
PDO::ERRMODE_SILENT
这是默认使用的模式。PDO会在statement和database对象上设定简单的错误代号，你可以使用PDO->errorCode() 和 PDO->errorInfo() 方法检查错误；如果错误是在对statement对象进行调用时导致的，你就可以在那个对象上使用 PDOStatement->errorCode() 或 PDOStatement->errorInfo() 方法取得错误信息。而如果错误是在对database对象调用时导致的，你就应该在这个database对象上调用那两个方法。
 
PDO::ERRMODE_WARNING
 作为设置错误代号的附加，PDO将会发出一个传统的E_WARNING信息。这种设置在除错和调试时是很有用的，如果你只是想看看发生了什么问题而不想中断程序的流程的话。
 PDO::ERRMODE_EXCEPTION
 作 为设置错误代号的附件，PDO会抛出一个PDOException异常并设置它的属性来反映错误代号和错误信息。这中设置在除错时也是很有用的， 因为他会有效的“放大（blow up）”脚本中的出错点，非常快速的指向一个你代码中可能出错区域。（记住：如果异常导致脚本中断，事务处理回自动回滚。）
 异常模式也是非常有用的，因为你可以使用比以前那种使用传统的PHP风格的错误处理结构更清晰的结构处理错误，比使用安静模式使用更少的代码及嵌套，也能够更加明确地检查每个数据库访问的返回值。
 关于PHP中异常的更多信息请看Exceptions章节
 PDO 使用基于SQL-92 SQLSTATE 的错误代号字符串；特定的PDO驱动应当将自己本身的代号对应到适当的SQLSTATE代号上。PDO->errorCode() 方法只返回单一的SQLSTATE代号。如果你需要关于一个错误的更加有针对性的信息，PDO也提供了一个PDO->errorInfo() 方法，它可以返回一个包含了SQLSTATE代号，特定数据库驱动的错误代号和特定数据库驱动的错误说明字符串。
 事务
 现在你已经通过PDO建立了连接，在部署查询之前你必须搞明白PDO是怎样管理事务的。如果你以前从未遇到过事务处理，（现在简单介绍一下：）它们提供了4个主要的特性：原子性 ，一致性 ，独立性 和持久性 （Atomicity, Consistency, Isolation and Durability，ACID）通俗一点讲，一个事务中所有的工作在提交时，即使它是分阶段执行的，也要保证安全地应用于数据库，不被其他的连接干扰。 事务工作也可以在请求发生错误时轻松地自动取消。
 事务的典型运用就是通过把批量的改变“保存起来”然后立即执行。这样就会有彻底地提高更新效率的好处。换句话说，事务可以使你的脚本更快速同时可能更健壮（要实现这个优点你仍然需要正确的使用它们）。
  
 不 幸运的是，并不是每个数据库都支持事务，因此PDO需要在建立连接时运行在被认为是“自动提交”的模式下。自动提交模式意味着你执行的每个查询都 有它自己隐含的事务处理，无论数据库支持事务还是因数据库不支持而不存在事务。如果你需要一个事务，你必须使用 PDO->beginTransaction() 方法创建一个。如果底层驱动不支持事务处理，一个PDOException就会被抛出（与你的异常处理设置无关，因为这总是一个严重的错误状态）。在一个 事物中，你可以使用 PDO->commit() 或 PDO->rollBack() 结束它，这取决于事务中代码运行是否成功。
 当脚本结束时或一个连接要关闭时，如果你还有一个未处理完的事务，PDO将会自动将其回滚。这是对于脚本意外终止的情况来说是一个安全的方案——如果你没有明确地提交事务，它将会假设发生了一些错误，为了你数据的安全，所以就执行回滚了。
 警告 
 自动回滚仅发生于你通过 PDO->beginTransaction() 建立的事务。如果你用手动方式执行了一个开始事务的查询，PDO就无法知道它的情况，这样在倒霉的事情发生时它将无法回滚。
 
   在下面的例子中，让我们假设我们正在创建一个新员工的一系列资 料，他被指定了一个 23 的ID，同时作为他的基本数据，我们也需要记录他的薪水。执行两个分开的更新操作非常简单，但通过使 用 PDO->beginTransaction() 和 PDO->commit() 围绕后调用，我们就可以保证在两个操作完成之前任何 人都无法看到这些改变。如果发生了什么错误，catch块就会将从事务开始后执行的所有改变回滚，然后打印一条错误信息。
   Php代码  收藏代码
   try {
	     
	     $dbh  =  new  PDO( 'odbc:SAMPLE' ,  'db2inst1' ,  'ibmdb2' ,  
				   array (PDO::ATTR_PERSISTENT => true));  
		   echo   "Connected\n" ;  
		     $dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
			   $dbh ->beginTransaction();  
			     $dbh -> exec ( "insert into staff (id, first, last) values(23, 'Joe', 'Bloggs')" );  
				   $dbh -> exec ("insert into salarychange (id, amount, changedate)  
						       values (23, 50000, NOW())");  
					     $dbh ->commit();  
   } catch (Exception  $e ) {
	     
	     $dbh ->rollBack();  
		   echo   "Failed: "  .  $e ->getMessage();  
   }  
 
数据库连接 

事务中执行的更新数并不受限；你可以执行复杂查询获取数据，如果可能的话也可以用获取的数据构建更多的更新和查询；当事务处于激活状态时，你将被保证在你 （操作数据库的）工作中没有人可以执行其他的改变。事实上，这也不是100%正确，但如果你从未听说过事务处理，这已经是一个足够好的介绍了。

连接是通过实例化PDO基类建立的。对建立连接来说，你使用哪个数据库驱动并没有关系，你只管用PDO这个类名就行了。PDO类的构造器接受一个可以指定数据源（DNS）的参数和可选的数据库用户名、密码参数。
例1：连接到MySQL：
$dbh  =  new  PDO( 'mysql:host=localhost;dbname=test' ,  $user ,  $pass );
如果发生了错误，一个PDOException异常对象将被抛出。如果你想处理这个错误，你应该捕获这个异常，或者你也可以选择将它交给一个通过set_exception_handler()设置的应用程序全局异常处理器。

例2：连接错误处理
Php代码  收藏代码
try {
	  
	  $dbh  =  new  PDO( 'mysql:host=localhost;dbname=test' ,  $user ,  $pass );  
	    foreach  ( $dbh ->query( 'SELECT * from FOO' )  as   $row ) {
			  
			    print_r( $row );  
				  }  
		  $dbh  = null;  
} catch (PDOException  $e ) {
	  
	  print  "Error!: "  .  $e ->getMessage() .  "" ;  
	    die ();  
}   
警告： 
如果你的应用程序没有捕获从PDO构造器中抛出的异 常，Zend引擎就会做出响应终端脚本的执行并显示一条跟踪信息。这条跟踪信息有可能会暴露完整的数据库连接信息，包括用户名和密码。捕获这个异常是你的 职责，无论是明确捕获（通过一个catch语句）还是通过set_exception_handler()隐含捕获。
成 功建立数据库连接之后，一个PDO类的实例就返回到了你的脚本中。连接在PDO对象的生存期内会一直保持活动状态。要关闭这个连接，你需要通过删 除所有指向它的引用来销毁这个对象。你可以通过向指向这个对象的变量赋一个NULL值做到这一点。如果你没有明确地这样做，PHP会在脚本结束时自动关闭 这个连接。
Php代码  收藏代码
//关闭连接：  
$dbh  =  new  PDO( 'mysql:host=localhost;dbname=test' ,  $user ,  $pass );  
// use the connection here  
// do something.  
// and now we're done; close it  
$dbh  = null;  
 
许 多Web应用会因为使用了向数据库的持久连接而得到优化。持久连接不会在脚本结束时关闭，相反它会被缓存起 来并在另一个脚本通过同样的标识请求一个连接时得以重新利用。持久连接的缓存可以使你避免在脚本每次需要与数据库对话时都要部署一个新的连接的资源消耗， 让你的Web应用更加快速。
 

Php代码  收藏代码
//持久连接  
$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass,  
		 array(    PDO::ATTR_PERSISTENT => true;));  
 
'')''')""""
}
		}''))'')
}'')""
   }"")"'''')")""'''''')
   }""""
	}
			}''))'')
	}"")''
	}
	}''''''
