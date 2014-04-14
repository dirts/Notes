Notes
=====
## 学习上的一些思考

* 如果还是基于web考虑的话，应该在实现方式的原理和性能上多做准备,比如：web server 的实现原理和具体实现方式，缓存的原理和实现方式，各种第三方库的特点和应用时如何搭配，取舍，为什么这么做
 
* 多思考积累：web交互中常见的问题和安全问题等

* 从web的本质思考一下，web用来做什么，为什么现在公司愿意用php,什么情况下用java,公司规模大了会遇到什么问题，如何从技术上改进，解决，要顺藤摸瓜。工作的事情还是有思考的空间比较好。

## shell监控进程
先了解一些命令：
 1. ps aux    显示系统全部进程，一行一个
 2. grep “abc” 从标准输入读取字符流，输出包含字符串“abc”的行
 3. grep -v "acb"   从标准输入读取字符流，输出不包含字符串“abc”的行
 4. wc -l        从标准输入读取字符流，输出行数

例如需要检测进程httpd是否存在，操作流程如下：
 1. 读取系统所有进程
 2. 判断包含指定进程名字的信息是否存在

通过管道连接，命令如下：

        ps axu      |    grep "httpd"           |      grep -v "grep"    |      wc -l

所有进程-->获取包含“httpd”的行-->删除grep进程信息-->输出最后的行数
通过判断命令的执行结果是否为 0 ，可以知道进程是否存在。
脚本如下:

        #!/bin/sh
        while true;do
                count=`ps -ef|grep http|grep -v grep`
                if [ "$?" != "0" ];then
        echo    ">>>>no httpd,run it"
        service httpd start
        else
        echo ">>>>httpd is runing..."
        fi
        sleep 5
        done
