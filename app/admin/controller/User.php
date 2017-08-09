<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/8/2
 * Time: 22:40
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\admin\controller;

//使用houdunwang\view\View 这个命名空间，可以调用这个命名空间下的View类
use houdunwang\view\View;
//使用system\model\User 这个命名空间，可以调用这个命名空间下的Grade类
//因为当前的命名空间也有User类，所有需要别名来区分
use system\model\User as UserModel;
//创建类：实现修改密码的功能
class User extends Common
{
//    创建方法；实现修改密码的功能
    public function changePassword(){
//        判断用户是否通过post方法点击了修改密码的按钮
        if(IS_POST){
//            先对比旧密码是否正确
//            获得就的密码，用于比对新密码
            $user=UserModel::where("uid=" .$_SESSION["username"]["uid"])->get();
//            如果输入的旧密码错误，那么会给用户一个提示，并且跳出这个函数，不会执行之后的代码
            if(!password_verify($_POST["oldPassword"],$user[0]["password"])){
//                提示用户的旧密码错误
                return $this->error("旧密码错误");
            }
//            在比对两次输入的新密码是否一致
//            如果两次输入的密码不一致，那么会给用户一个提示，并且会跳出这个函数，不会再执行后面的代码
            if($_POST["newPassword"] != $_POST["confirmPassword"]){
//                提示用户两次输入的密码不正确
                return $this->error("两次密码不一致");
            }
//            修改密码
//            把经过哈希处理过的密码返回给变量$data
            $data=["password"=>password_hash($_POST["newPassword"],PASSWORD_DEFAULT)];
//            将数据库中的就密码替换掉，这样就实现了修改密码的功能
            UserModel::where("uid=" . $_SESSION["username"]["uid"])->update($data);
//            删除session的变量
            session_unset();
//            删除session的目录
            session_destroy();
//            提示用户密码修改成功 ，并且跳转到登陆页面
            return $this->success("修改成功")->setRedirect("?s=admin/login/index");
        }
//        加载修改密码的模板
        return View::make();
    }
}