# 主从分布带来的问题:
======================
* 数量并发写入，过大，从库过多导致数据同步延迟


# 分布式cache
======================
* hash 取模
* 一致性hash


# sql 写入优化
======================
* 先写入队列, mysql SQL 写入合并


# 实用命令:
======================
* explain
* show profile


# 引擎类型:
======================
* memery
* black hole


# transfomer
======================
*? 


# sharding (分片)
======================
垂直分表(扩充字段)， 水平分表

例子：用户相关
水平分表 1-5亿分，5-10亿分

水平分表的问题:


# 数据库连接数
=====================
* 每一个链接都占用一定内存和cpu ,数据库链接占用比较大，一个链接有几M ,
* 



# storage (连接池) 
=====================
* 可以达到几万;
* 全局自增id生成器;



# 多个机房
=====================
目前：
mysql 双主 : 北京(主键奇数) + 广州(主键偶数)
redis 选择性同步，同步代理

* 改善用户体验
* 容灾

其他机房便宜,便宜.

问题：
* 数据同步问题(redis 通过日志同步)
	1.抢购 



# 系统工具
=======================
strace
netstats
top
ps


总结：IO，CPU问题
=======================
* 解决cpu问题, 加机器
* 解决io问题, 加缓存加内存, 分片


# Search (搜索) cache + search 
========================
类目，属性，热榜


# memcache 还存在就是历史遗留问题;
=======================
* 高并发命中问题 50 %

