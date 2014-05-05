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



	yum -y install gcc gcc-c++ make autoconf libtool-ltdl-devel gd-devel freetype-devel libxml2-devel libjpeg-devel libpng-devel openssl-devel curl-devel bison patch unzip libmcrypt-devel libmhash-devel ncurses-devel binutils compat-libstdc++-33 elfutils-libelf elfutils-libelf-devel glibc glibc-common glibc-devel libaio-devel libaio libgcc libstdc++ libstdc++-devel unixODBC unixODBC-devel numactl-devel glibc-headers sudo bzip2 mlocate flex lrzsz sysstat lsof setuptool  system-config-network-tui system-config-firewall-tui ntsysv ntp libaio-devel wget ntp pv lz4 vim rsync dstat iotop innotop telnet iftop expect nc
