<?php
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\admin\controller;
//使用houdunwang\core\Controller 这个命名空间，可以继承这个命名空间下的Controller类
use houdunwang\core\Controller;
//使用houdunwang\view\View 这个命名空间，可以调用这个命名空间下的View类
use houdunwang\view\View;


//实现默认首页的加载
class Entry extends Common {
//    创建方法：实现加载默认首页的功能
    public function index() {
//        调用View里面的make方法，可以组合模板的路径
//        最终会被返回到boot这个类被echo输出
//        应为make方法返回的是当前的类，被echo输出的时候会触发__toString这个方法，模板会被载入
        return View::make();
    }

}