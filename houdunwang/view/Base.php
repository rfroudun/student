<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/7/31
 * Time: 21:17
 */
//命名空间，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace houdunwang\view;

/**实现返回数据并且加载模板的功能
 * Class Base
 * @package houdunwang\view
 */
class Base{
//    创建属性：用来保存分配的变量---需要把分配的变量跟着模板返回
    public $data=[];
//    创建属性：用来保存模板的路径,方便后续调用
    public $template;

//    创建方法：用来分配变量
    public function with($data){
//        把传进来的变量存起来，方便后续的输出
        $this->data=$data;
//        返回一个对象，最后会返回到\houdunwang\core\Boot这个类里面的appRun方法，并且被echo输出出来
        return $this;
    }

//    创建方法：组合完整的模板路径
    public function make(){
//        组合完整的模板路径，方便加载模板
//        默认的模板路径："../app/home/view/entry/index.php";
        $this->template="../app/".APP."/view/".CONTROLLER."/".ACTION.".php";
//        返回一个对象，最后会返回到\houdunwang\core\Boot这个类里面的appRun方法，并且被echo输出出来
        return $this;
    }

    //    创建方法：当这个类被echo输出的时候会自动执行这个方法
    public function __toString(){
//        因为$data被传过来的时候是一个数组
//        把键名变成变量名，键值变成变量值
//        ['data'=>123] 经过extract之后 $data = 123;，页面可以直接使用$data了
        extract($this->data);
//        加载模板，显示页面
//        make方法里已经组合了模板，所以这里直接加载即可
        include $this->template;
//        使用__toString这个方法的时候返回的值必须是有个字符串
        return "";
    }


}






