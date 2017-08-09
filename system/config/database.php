<?php
//配置项文件，用于连接数据库----返回一个数组，方便内容的调用
//因为连接的数据库的主机，有户名，密码等是有可能会改变的，所以不能写死
return [
//    db_host表示要连接的服务器的主机，127.0.0.1表示的是本地服务器
//    可以被functions里面的c函数调用到
  "db_host"=>"127.0.0.1",
//    db_user表示要连接的mysql数据库的用户名，root是mysql数据库默认的用户名
//    可以被functions里面的c函数调用到
    "db_user"=>"root",
//    db_password表示要连接的mysql数据库的密码，root是mysql数据库默认的密码
//    可以被functions里面的c函数调用到
    "db_password"=>"root",
//    db_name表示的是mysql数据库里面的库名，c83是mysql数据库里面具体的库名
//    可以被functions里面的c函数调用到
    "db_name"=>"student",
//    db_charset表示我们要设置的mysql数据库的字符集，UTF8是要设置的具体的字符集--UFT8代表的是万国码
//    可以被functions里面的c函数调用到
    "db_charset"=>"UTF8",
];




