<?php include "./view/admin/header.php" ?>
<div class="container" style="width: 30%; margin-top: 50px">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">修改密码</h3>
        </div>
        <div class="panel-body" >
            <form action="" method="post" role="form">
                <div class="form-group">
                    <label for="">旧密码:</label>
                    <input type="password" class="form-control" name="oldPassword" required>
                </div>

                <div class="form-group">
                    <label for="">新密码:</label>
                    <input type="password" class="form-control" name="newPassword" required>
                </div>

                <div class="form-group">
                    <label for="">确认密码:</label>
                    <input type="password" class="form-control" name="confirmPassword" required>
                    <br>
                </div>

                <button type="submit" class="btn btn-primary">修改</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>