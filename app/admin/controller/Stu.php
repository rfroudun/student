<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/8/2
 * Time: 0:37
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\admin\controller;

//使用houdunwang\core\Controller 这个命名空间，可以继承这个命名空间下的Controller类
use houdunwang\core\Controller;
//使用houdunwang\model\Model 这个命名空间，可以调用这个命名空间下的Model类
use houdunwang\model\Model;
//使用houdunwang\view\View 这个命名空间，可以调用这个命名空间下的View类
use houdunwang\view\View;
//使用system\model\Grade 这个命名空间，可以调用这个命名空间下的Grade类
use system\model\Grade;
//使用system\model\Material 这个命名空间，可以调用这个命名空间下的Material类
use system\model\Material;
//使用system\model\Stu 这个命名空间，可以调用这个命名空间下的Stu类
//因为当前的命名空间也有Stu类，所有需要别名来区分
use system\model\Stu as StuModel;
//创建类：实习学生表的操作：比如增加，删除等等
class Stu extends Common
{
//    创建方法：显示学生
    public function lists(){
//        用一个变量存着学生表与班级表的关联sql
//        因为需要显示每一个学生所在的班级，所以需要关联着两张表
        $sql="SELECT * FROM stu s JOIN grade g ON s.gid=g.gid";
//        静态调用Model类里面的q方法，并且把关联学生表和班级表的sql传参过去
        $data=Model::q($sql);
//        $data这个数组需要返回到首页，所以需要传参到View方法里面与模板的路径一起返回来
//        make方法里组合模板的路径--最终返回的是make方法当前的Base类
//        with方法会把我们需要的值给返回来--最终返回的是with方法当前的Base类
//        make方法和with方法最终会返回到Boot，被echo输出是来，触发__toString这个方法，这个方法会加载make方法里组合的路径并且把需要返回的值返回过来
        return View::make()->with(compact("data"));
    }

//   创建方法： 添加学生
    public function add(){
//        判断用户是否用了post的方法提交数据
//        如果使用post方法提交的数据就会执行大括号里面的代码，否则不执行
        if(IS_POST){
//            判断用户是否填写了 hobby这一项
        if(isset($_POST['hobby'])){
//            如果用户填写了hobby这一项会执行大括号里面的代码
//            因为hobby这一项是多选，传过来的是一个数组，数组不能存入数据库
//            所以需要把数组转为字符串
             $_POST['hobby'] = implode(',',$_POST['hobby']);

         }
//            把用户上传上来的数据保存到数据库
            StuModel::save($_POST);
//            提示用户保存成功并且跳转到显示学生表的页面
        return $this->setRedirect('?s=admin/stu/lists')->success('保存成功');
        }
//        因为显示学生表需要显示学生所在的班级并且显示学生的头像，所以需要获得班级表和素材表的所有内容
//        把班级表和素材表的所有内容返回到页面里
//        获得班级表的所有内容
        $gradeData = Grade::get();
//        获得素材表的所有内容
        $materialData = Material::get();
//        加载模板并且把班级表和素材表的内容传过去，最后会被返回到页面中去
        return View::make()->with(compact('gradeData','materialData'));
    }

//   创建方法： 删除学生
    public function del(){
//        用变量存着需要删除的数据的相对应的序号
        $sid=$_GET["sid"];
//        调用 StuModel里面的静态方法
//        where方法给定删除数据的条件，有了条件只有再调用删除方法del，这样就能删除相对应的数据了
        StuModel::where("sid=$sid")->del();
//        提示用户添加成功并且跳转到显示显示素材信息的页面
//        最终会被返回到Boot类的run方法里，并且echo输出出来，会自动执行__toString这个方法，会加载提示用户操作成功的模板
        return $this->success("删除成功")->setRedirect("?s=admin/stu/lists");
    }

//   创建方法： 修改学生
    public function update(){
//        用一个变量存着需要编辑的数据的相对应的序号
        $sid=$_GET["sid"];
//        判断用户是否用了post的方法提交数据
//        如果使用post方法提交的数据就会执行大括号里面的代码，否则不执行
        if(IS_POST){
//            因为hobby这一项是多选，传过来的是一个数组，数组不能存入数据库
//            所以需要把数组转为字符串
            $_POST['hobby'] = implode(',',$_POST['hobby']);
//             静态调用StuModel
//             传入替换的文件的where条件，并且修改这条数据
            StuModel::where("sid=$sid")->update($_POST);
//            提示用户修改成功并且页面跳转到显示学生信息的页面
//            最终会被返回到Boot类的run方法里，并且echo输出出来，会自动执行__toString这个方法，会加载提示用户操作成功的模板
            return $this->setRedirect("?s=admin/stu/lists")->success("修改成功");
        }
//        获得一条需要修改的数据
//        需要在页面显示就数据内容
        $olddata=StuModel::find($sid);
//        因为修改页面也要获得旧的hobby值，数据库里面的hobby值不方便调用，转成数组用in_array这个函数会很方便
        $olddata['hobby'] = explode(',',$olddata['hobby']);
//        获得班级表里面的所有的数据，显示学生的所在班级
        $gradedata=Grade::get();
//        获得素材表里面的所有数据，显示学生的头像
        $material=Material::get();
//        make方法里组合模板的路径--最终返回的是make方法当前的Base类
//        make方法最终会返回到Boot，被echo输出是来，触发__toString这个方法，这个方法会加载make方法里组合的路径
        return View::make()->with(compact("olddata","gradedata","material"));
    }
}