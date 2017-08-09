<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/7/31
 * Time: 23:31
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace houdunwang\model;

//创建一个类：用来实现对数据库数据的操作，比如增删改查
class Model{
/**
* 当使用未找到的方法的时候会自动执行此方法
* @param $name 方法的名字
* @param $arguments 传过去的参数
*/
public static function __callStatic($name, $arguments){
//    获得触发字方法的类名
//    获得的类名比如是：system\model\Arc
    $classname=get_called_class();
//    strrchr字符串截取 变成 \Arc
//    ltrim 去除左边的\ 变成 Arc
//    strtolower 变成 arc
//    $table的值是数据库里面表的名字
    $table=strtolower(ltrim(strrchr($classname,'\\'),'\\'));
//    实例化这个Base这个类，并且执行$name这个方法--$name这个方法名就是是调动没有找到的方法名
    return call_user_func_array([new Base($table),$name],$arguments);
}


}