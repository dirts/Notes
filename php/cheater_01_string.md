PHP学习笔记 字符串 & 数组
=============

# 字符串 String函数

## 字符串转换类函数

* addcslashes函数：以C语言风格使用反斜线转义字符串中的字符
* addslashes函数：使用反斜线引用字符串
* chop: 清楚字符串中连续空格
* get_html_translation_table: 返回htmlspecualchars() 和 htmlentities() 的转换表
* chunk_split() : 将字符串分割成小块
* hebrev() ： 转换希伯来逻辑字符为可见字符
* hebreve() : 转换希伯来文本为可见文本，包括换行符
* html_entity_decode() 转换html字符编码为字符
* htmlentities() 转换字符为html字符编码

## 字符串查找类函数

* chr() : 将指定的序数转化为相应的ascii码字符
* implode() ： 将数组合并为字符串
* join() : 将数组转化为字符串
* explode() : 将字符串转发为数组
* str_split() 同上

* strrchr() ：首现到最后 
* strchr() : 首现到最后
* strstr() : 同上
* stristr() : 同上（不区分大小写）

	stristr('lishouyan@zhisland.com', '@zhisland'); // '@zhisland.com'
	strch('lishouyan@zhisland.com', '@zhisland'); // '@zhisland.com'

* strpos() 字符首现位置
* stripos() 字符首现位置，/i
* strrpos() 字符最后出现位置
* strripos() 字符最后出现位置？ /i


## 字符加密

* crypt() DES编码加密
* md5_file() 计算文件md5hash
* md5() md5加密
* sha1_file()  计算文件 sha1hash
* sha1() sha1hash加密

