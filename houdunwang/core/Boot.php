<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/7/31
 * Time: 20:27
 */
//命名空间，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace houdunwang\core;

/**
* 框架的启动类，所有的操作都要通过这个类来启动
* Class Boot
 * @package houdunwang\core
*/
class Boot{
//    创建方法：用来实现启动框架的功能
    public static function run(){
//      注册错误处理
        self::handleError();
//        初始化框架
//        先设置并且准备好以后能用到的代码：比如说设置默认时区，开启session等
        self::init();
//        执行应用：通过appRun这个方法来调用相对应的控制器和控制器里面的方法
//        通过调用控制器和控制器里面的方法可以加载模板或者实现某些功能：比如添加留言，删除留言等等
        self::appRun();
    }
    private static function handleError(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

//    创建方法：通过get传参调用相对应的控制器来执行页面的加载和实现其他的功能
    public static function appRun(){
//        当有get传参的时候$s的值就是传参的值，否则默认值就是"home/entry/index"；
//        home表示前台应用，entry表示控制器的名称，index表示控制器里面的方法名
        $s=isset($_GET["s"]) ? $_GET["s"] : "home/entry/index";
//        把$s的值通过"/"放分界转换成数组，方方便数据的调用
        $arr=explode("/",$s);
//        设置常量：常量没有范围的限制
//        在houdunwang/view/View.php文件里的View类的make方法组合模板路径，需要用到这些值来指定相对应的模板
//        定义一个APP常量:组合模板路径的时候用来指定是前台应用还是后台应用
        define("APP",$arr[0]);
//        定义一个CONTROLLER常量：组合模板的时候用来指定控制器的文件目录
        define("CONTROLLER",$arr[1]);
//        定义一个ACTION常量：组合模板的时候用来指定具体的文件名
        define("ACTION",$arr[2]);
//        组合类名：
//        通过命名空间找到需要实例化的类
//        当没有get传参的时候，默认需要组合的类名：\app\home\controller\Entry
        $classname="\app\\{$arr[0]}\controller\\" .ucfirst($arr[1]);
//        实例化这个类，并且调用默认方法index
        echo call_user_func_array([new $classname,$arr[2]],[]);
    }


//    创建方法：初始化框架，先设置并且准备好以后能用到的代码
    public static function init(){
//        设置时区的默认值，时区的默认是为 东八区
        date_default_timezone_set("PRC");
//        开启session，因为这个来是框架的启动类，所以只需要在这里开启session框架内的有关联的类的session开关都会被开启
//        判断有没有session_id ，如果没有的话才会执行后面的代码，也就是开启session
        session_id()||session_start();
//        创建常量：判断用户使用post的请求方式点击的提交按钮
//        可以判断用户是否执行了这个操作来决定执不执行后续的代
        define("IS_POST",$_SERVER["REQUEST_METHOD"]== "POST" ?true : false);
    }
}