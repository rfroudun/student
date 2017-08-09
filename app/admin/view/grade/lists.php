<?php include './view/admin/header.php' ?>
<div class="container">
    <div class="row">
        <?php include './view/admin/left.php' ?>
        <div class="col-xs-9">
            <a href="?s=admin/grade/lists" class="btn btn-primary">列表</a>
            <a href="?s=admin/grade/add" class="btn btn-default">添加</a>
            <hr>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>班级名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $v): ?>
                    <tr>
                        <td><?php echo $v["gid"] ?></td>
                        <td><?php echo $v["gname"] ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="?s=admin/Grade/update&gid=<?php echo $v['gid'] ?>" class="btn btn-xs btn-info">编辑</a>
                                <a href="javascript:if(confirm('真的忍心删除吗？')) location.href='?s=admin/Grade/del&gid=<?php echo $v['gid'] ?>';" class="btn btn-xs btn-danger">删除</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>



