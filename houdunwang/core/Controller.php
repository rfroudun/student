<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/7/31
 * Time: 20:43
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace houdunwang\core;
/**
 * Class Controller 父类，当子类继承这个类的时候可以重复的调用这个类里面的属性和方法，减少代码量
 * @package houdunwang\core
 */
class Controller{
//    创建属性：给$url一个默认的值：当$url没有传参的时候就会返回上一级的历史记录并且刷新
    private $url="window.history.back()";
//    创建属性：用来保存模板的路径，方便我们加载模板
    private $template;
//    创建属性：用来保存提示用户的信息，提高用户的使用体验
    private $msg;

//    创建方法：实现跳转的功能
    public function setRedirect($url){
//        给$this->url赋值
//        当$url有值存在的时候页面就会跳转到$url这个页面，否则就会是默认值--返回上一级的页面
        $this->url="location.href='{$url}'";
//        返回Base这个类
//        最终会被返回到houhunwang\core\run 这个方法里，并且echo这个类，执行__tostring这个方法
        return $this;
    }

//    创建方法：用来实现提示用户的功能
//    当用户在页面操作某项功能并且成功的时候就会提示用户操作成功--比如添加留言
//    成功的时候
    public function success($msg){
//        把需要提示的信息保存到$this->msg这个属性里，方便后续的调用
        $this->msg=$msg;
//        组合模板路径
//        当用户操作成功的时候会加载模板提示用户操作成功
        $this->template="./view/success.php";
//        返回Base类
//        最终会被返回到houhunwang\core\run 这个方法里，并且echo这个类，执行__tostring这个方法
        return $this;
    }

//    创建方法：用来实现提示用户的功能
//    当用户在页面操作某项功能并且失败的时候就会提示用户操作失败--比如验证码
//    失败的时候
    protected function error($msg){
//        把需要提示的信息保存到$this->msg这个属性里，方便后续的调用
        $this->msg = $msg;
//        组合模板路径
//        当用户操作失败的时候会加载模板提示用户操作失败
        $this->template = './view/error.php';
//        返回Base类
//        最终会被返回到houhunwang\core\run 这个方法里，并且echo这个类，执行__tostring这个方法
        return $this;
    }

//    创建方法：当Base这个类被echo输出的时候就会自动执行这个方法
    public function __toString(){
//        加载模板
//        当Base这个类被echo输出的时候就会加载模板，模板的路径通过make方法组合
        include $this->template;
//        __toString这个方法必须要返回一个字符串，这里返回的是一个空字符串
        return "";
    }

}