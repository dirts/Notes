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
