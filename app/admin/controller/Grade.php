<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/8/1
 * Time: 22:29
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\admin\controller;

//使用houdunwang\core\Controller 这个命名空间，可以继承这个命名空间下的Controller类
use houdunwang\core\Controller;
//使用houdunwang\view\View 这个命名空间，可以调用这个命名空间下的View类
use houdunwang\view\View;
//使用system\model\Grade 这个命名空间，可以调用这个命名空间下的Grade类
//因为当前的命名空间也有Grade类，所有需要别名来区分
use system\model\Grade as GradeModel;
//创建类：用来实现班级的管理功能
class Grade extends Common
{
//    创建方法：用来实现显示班级的相关信息的功能
    public function lists(){
//        获得GradeModel这个类里面的所有信息，方便在页面中调用
        $data=GradeModel::get();
//        $data这个数组需要返回到首页，所以需要传参到View方法里面与模板的路径一起返回来
//        make方法里组合模板的路径--最终返回的是make方法当前的Base类
//        with方法会把我们需要的值给返回来--最终返回的是with方法当前的Base类
//        make方法和with方法最终会返回到Boot，被echo输出是来，触发__toString这个方法，这个方法会加载make方法里组合的路径并且把需要返回的值返回过来

        return View::make()->with(compact("data"));
    }

//    创建方法：实现添加班级的功能
    public function add(){
//        判断用户是否用了post的方法提交数据
//        如果使用post方法提交的数据就会执行大括号里面的代码，否则不执行
        if(IS_POST){
//            调用GradeModel里面的save方法，并且把表单收集过来的数据传参过去
//            save这个方法用来实现数据的保存功能
            GradeModel::save($_POST);
//            提示用户添加成功并且页面跳转到显示班级信息的页面
//            最终会被返回到Boot类的run方法里，并且echo输出出来，会自动执行__toString这个方法，会加载提示用户操作成功的模板
            return $this->setRedirect('?s=admin/grade/lists')->success('添加成功');
        }
//        make方法里组合模板的路径--最终返回的是make方法当前的Base类
//        make方法最终会返回到Boot，被echo输出是来，触发__toString这个方法，这个方法会加载make方法里组合的路径
        return View::make();
    }

//    创建方法：实现删除班级的功能
    public function del(){
//        静态调用GradeModel
//        传入删除的文件的where条件，并且删除这条数据
        GradeModel::where("gid={$_GET['gid']}")->del();
//        提示用户添加成功并且跳转到显示显示班级信息的页面
//        最终会被返回到Boot类的run方法里，并且echo输出出来，会自动执行__toString这个方法，会加载提示用户操作成功的模板
        return $this->setRedirect("?s=admin/grade/lists")->success("删除成功");
    }

//    创建方法：实现编辑班级的功能
    public function update(){
//        用一个变量存着需要编辑的数据的相对应的序号
        $gid=$_GET["gid"];
//        判断用户是否用了post的方法提交数据
//        如果使用post方法提交的数据就会执行大括号里面的代码，否则不执行
        if(IS_POST){
//        静态调用GradeModel
//        传入替换的文件的where条件，并且修改这条数据
            GradeModel::where("gid=$gid")->update($_POST);
//            提示用户添加成功并且页面跳转到显示班级信息的页面
//            最终会被返回到Boot类的run方法里，并且echo输出出来，会自动执行__toString这个方法，会加载提示用户操作成功的模板
            return $this->setRedirect("?s=admin/grade/lists")->success("修改成功");
        }
//        获得旧数据，需要吧旧数据的内容添加到编辑的页面
        $olddata=GradeModel::find($gid);
//        $olddata这个数组需要返回到首页，所以需要传参到View方法里面与模板的路径一起返回来
//        make方法里组合模板的路径--最终返回的是make方法当前的Base类
//        with方法会把我们需要的值给返回来--最终返回的是with方法当前的Base类
//        make方法和with方法最终会返回到Boot，被echo输出是来，触发__toString这个方法，这个方法会加载make方法里组合的路径并且把需要返回的值返回过来
        return View::make()->with(compact('olddata'));
    }
}