<?php include './view/admin/header.php' ?>
<div class="container">
    <div class="row">
        <?php include './view/admin/left.php' ?>
        <div class="col-xs-9">
            <a href="?s=admin/material/lists" class="btn btn-primary">列表</a>
            <a href="?s=admin/material/add" class="btn btn-default">添加</a>
            <hr>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>图像</th>
                    <th>素材</th>
                    <th>上传时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $v): ?>
                <tr>
                    <th><?php echo $v["mid"] ?></th>
                    <th>
                        <img src="<?php echo $v["path"] ?>" width="70">
                    </th>
                    <th><?php echo $v["path"] ?></th>
                    <th><?php echo date('Y-m-d H:i:s',$v['create_time']) ?></th>
                    <th>
                        <a href="javascript:if(confirm('要来真的吗？')) location.href='?s=admin/material/del&mid=<?php echo $v['mid'] ?>';">删除</a>
                    </th>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>



