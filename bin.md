 如果你不知道什么是位运算的话， 那么请你先去看看基础的C语言教程吧。 
 与运算 a & b  , 
 或运算 a | b ,  
 异或运算 a ^ b ,

 或者 
 你也可以将 与运算理解为 + 法  
 例如 
 1|2 = 3   （1+2 = 3）
 1|2|4 = 7 （1+2+4 = 7）

 将 异或运算理解为 - 法
 例如 
 3^2 = 1 （3-2 = 1）
 3^1 = 2  （3-1 = 2）

 最后将 与运算 作为判断
 例如 
 3&2 = 1    (3 = 1 + 2, 由 1和2组成 ，所以判断3&2 = 1 )  
	3&4 = 0   ( 3 没有由 4组成,所以判断3&4 = 0)

	那么位运算有何用处呢， 例如 UNIX系统中的权限， 通常我们所知  权限分为  r 读, w 写, x 执行,其中 它们的权值分别为4,2,1， 所以 如果用户要想拥有这三个权限 就必须  chomd 7  , 即 7=4+2+1 表明 这个用户具有rwx权限，如果只想这个用户具有r,x权限 那么就 chomd 5即可

	说道此处就要涉及到数据库了。

	通常 我们的数据表中 可能会包含各种状态属性， 例如 blog表中 ， 我们需要有字段表示其是否公开，是否有设置密码，是否被管理员封锁，是否被置顶等等。 也会遇到在后期运维中，策划要求增加新的功能而造成你需要增加新的字段。

	这样会造成后期的维护困难，数据库增大，索引增大的情况。 这时使用位运算就可以巧妙的解决。
