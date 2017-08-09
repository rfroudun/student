<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/8/2
 * Time: 20:14
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\admin\controller;

//使用houdunwang\core\Controller 这个命名空间，可以继承这个命名空间下的Controller类
use houdunwang\core\Controller;
//创建父类，把除了后台登陆页面的所有后台内容全局锁定，必须要登陆后才能访问后台数据
class Common extends Controller
{
//    创建方法：判断是否已经登陆后台
    public function __construct(){
//        判断是否已经登陆后台，如果没有登陆后台将会跳转到登陆页面
        if(!isset($_SESSION["username"])){
//            跳转到登陆页面
            go("?s=admin/login/index");
        }

    }


}