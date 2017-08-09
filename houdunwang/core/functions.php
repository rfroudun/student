<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/7/31
 * Time: 20:18
 */

//打印函数，方便随时调用这个函数
function p($var){
//    输出pre标签，可以让被打印的数据在页面里原样输出--pre的头标签
    echo "<pre>";
//    打印函数，可以打印数据，数组也可以打印
    print_r($var);
//    输出pre标签的闭合标签
    echo "</pre>";
}

//配置器函数，方便我们调用配置器里面的数据
function c($path){
//    比如我们要调用c("database.db_name")
//    先把字符串转为数组，这样方便调取里面的数据
        $arr=explode(".",$path);
//    加载配置器里面相对应的文件，并且把文件的内容返给变量$config,想要加载的文件比如database
        $config=include "../system/config/" . $arr[0] . ".php";
//    判断配置器相对应的文件里面是否有$arr[1]，比如：db_name，如果存在的话返回的值就是db_name,否则返回的值就是null
        return isset($config[$arr[1]]) ? $config[$arr[1]] : null;
}

//创建方法：用来实现页面的跳转
 function go($url){
//    跳转到指定的页面
    header("Location: {$url}");
//    不在实行后面的代码
    die;
}






