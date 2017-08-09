<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/8/2
 * Time: 20:17
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\admin\controller;

//使用houdunwang\core\Controller 这个命名空间，可以继承这个命名空间下的Controller类
use houdunwang\core\Controller;
//使用houdunwang\view\View 这个命名空间，可以调用这个命名空间下的View类
use houdunwang\view\View;
//使用验证码的命名空间
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
//使用system\model\User 这个命名空间，可以调用这个命名空间下的User类
use system\model\User;
//创建类：实现登陆功能
class Login extends Controller
{

//    创建方法：实现登陆功能
    public function index()
    {
//        先把用户名和密码追加到数据库
//        $pass=password_hash("admin888",PASSWORD_DEFAULT);
//        echo $pass;die;

//        判断用户是否点击了提交按钮，并且提交的请求方式是post
        if (IS_POST) {
//           判断验证码是否正确
//            如果用户输入的验证码不正确，那个就会跳出这个函数，并且提示用户验证码错误
            if (strtolower($_POST["captcha"]) != $_SESSION["captcha"]) {
//                提示用户验证码错误
                return $this->error("验证码错误");
            }

//            判断用户名知否正确
//            自动转义上传上来的用户名，防止输入特殊字符的时候报错
            $_POST["username"]=addslashes($_POST["username"]);
//            如果用户名存在，那么会获得相对应的用户名信息，如果不存在，那么不会获得任何信息
            $data = User::where("username='{$_POST['username']}'")->get();
//            判断用户名是否存在，如果不存在会执行以下代码，并且提示用户用户性不存在
            if (!$data) {
//                跳出函数，并且提示用户  用户名不存在
                return $this->error("用户名不存在");
            }

//            判断密码是否正确
//            如果用户提交上来的密码不正确，会跳出这个函数并且提示用户密码错误、
            if (!password_verify($_POST["password"], $data[0]["password"])) {
//             跳出这个函数并且提示用户密码错误、
                return $this->error("密码错误");
            }

//            7天免登陆
//            如果用户勾上了七天免登陆按钮，那么就会执行以下代码
            if (isset($_POST["autologin"])) {
//                设置session的会话时间
//                把session的会话时间延长到7天
                setcookie(session_name(), session_id(), time() + 3600 * 24 * 7, "/");
            } else {
//                如果用户没有勾七天免登陆按钮，那么sesison的有效期就是一个会话时间
                setcookie(session_name(), session_id(), 0, "/");
            }
//            把用户名和用户名对应的序号存入session，
//            在修改密码的时候可以通过用户名的需要获得旧的密码
            $_SESSION["username"] = [
//                获得用户名的对应序号
                "uid" => $data[0]["uid"],
//                获得用户名
                "username" => $data[0]["username"]
            ];
//            以上代码都不成立则说明用户已经登陆成功
//            提示用户登陆成功，并且跳转到后台的首页
            return $this->success("登陆成功")->setRedirect("?s=admin/entry/index");
        }
//        加载登陆的模板
        return View::make();
    }

//    验证码方法
    public function captcha()
    {
        $str = substr(md5(microtime(true)), 0, 3);
        $captcha = new CaptchaBuilder($str);
        $captcha->build();
        header('Content-type: image/jpeg');
        $captcha->output();
        //把验证码存入到session
        //把值存入到session
        $_SESSION['captcha'] = strtolower($captcha->getPhrase());
    }

//    创建方法：异步检测验证码是否正确
    public function cheakCaptcha(){
//        判断用户名是否正确，如果不正确返回0
        if($_POST["c"] != $_SESSION["captcha"]){
//            返回0到前台页面，给js处理
            echo 0;
        }else{
//            返回1到前台页面，给js处理
            echo 1;
        }
    }


//    创建方法：退出登陆
    public function logout(){
//        删除session的文件
        session_unset();
//        删除sesison的目录
        session_destroy();
//        提示用户推出登陆成功，并且跳转到登陆页面
        return $this->success("退出成功")->setRedirect("?s=admin/login/index");
    }
}