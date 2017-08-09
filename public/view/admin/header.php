<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
    <script src="./static/js/jquery.min.js"></script>
    <script src="./static/bt3/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?s=admin/entry/index">学生管理系统</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li <?php if(CONTROLLER == 'grade'): ?> class="active" <?php endif ?>><a href="?s=admin/grade/lists">班级</a></li>
                <li <?php if(CONTROLLER == 'material'): ?> class="active" <?php endif ?>><a href="?s=admin/material/lists">素材</a></li>
                <li <?php if(CONTROLLER == 'stu'): ?> class="active" <?php endif ?>><a href="?s=admin/stu/lists">学生</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">返回前台</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span style="color: red;"><?php echo $_SESSION['username']['username'] ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?s=admin/user/changePassword">修改密码</a></li>
                        <li><a href="?s=admin/login/logout">退出登录</a></li>

                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
