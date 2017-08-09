<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/7/31
 * Time: 20:42
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\home\controller;
//使用houdunwang\core\Controller 这个命名空间，可以继承这个命名空间下的Controller类
use houdunwang\core\Controller;
//使用houdunwang\view\Model 这个命名空间，可以调用这个命名空间下的Model类
use houdunwang\model\Model;
//使用houdunwang\view\View 这个命名空间，可以调用这个命名空间下的View类
use houdunwang\view\View;
/**
 * Class Entry 默认执行的类
 * @package app\home\controller
 */
class Entry extends Controller{
//    创建方法：用来实现显示首页
    public function index()
    {
//        关联学生表和班级表，获得里面的数据
        $data=Model::q("SELECT * FROM stu s JOIN grade g ON  s.gid=g.gid");
//        加载模板，并且返回关联的学生表和班级表的内容
        return View::make()->with(compact("data"));
    }

    public function show(){
//        关联学生表和班级表，获得里面的数据
        $data = Model::q("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid WHERE sid=" . $_GET["sid"]);
//        加载模板，并且返回关联的学生表和班级表的内容
        return View::make()->with(compact('data'));

    }
}