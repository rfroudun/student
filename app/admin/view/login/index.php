<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/css/animate.css">
    <script src="./static/js/jquery.min.js"></script>
    <script>
        $(function(){
//            获得失去焦点事件
            $("input[name=captcha]").blur(function(){
//                获得用户填写的内容
                var captcha=$(this).val();
//                判断：用户不输入内容的时候不异步
                if(captcha==""){
                    return;
                }
//                发送异步
                $.ajax({
                    url:"?s=admin/login/cheakCaptcha",
                    data:{c:captcha},
                    type:"post",
                    success:function(phpdata){
                        if(phpdata==0){
                            $("#captchamsg").html("<span style='color: red;'>验证码错误</span>");
                            $("input[name=captcha]").addClass("error");
                        }else{
                            $("#captchamsg").html("<span style='color: green;'>验证码正确</span>");
                            $("input[name=captcha]").removeClass("error");
                        }
                    }
                })
            })

            $("#form").submit(function(){
                if($('.error').length > 0){
                    return false;
                }
            })

        })

    </script>

</head>
<body>
<div class="container animated  bounceInDown" style="width: 30%; margin-top: 50px">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">欢迎来到后台登陆</h3>
        </div>
        <div class="panel-body" >
            <form action="" method="post" role="form" id="form">
                <div class="form-group">
                    <label for="">用户名:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="form-group">
                    <label for="">密码:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label for="">验证码:</label>
                    <input type="text" class="form-control" name="captcha" required>
                    <div id="captchamsg" style="display: inline-block;"></div>
                    <br>
                    <img src="?s=admin/login/captcha" onclick="this.src=this.src+'&='+Math.random()">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"  name="autologin">
                        七天免登陆
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">登陆</button>
                <a href="index.php" style="float: right;" class="btn btn-info" >返回前台</a>
            </form>
        </div>
    </div>

</div>
</body>
</html>