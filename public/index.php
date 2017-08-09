<?php
//compact的自动载入，能根据相对应的命名空间来载入相对应的类和方法
include "../vendor/autoload.php";
//调用框架的启动方法，所有的操作都需要通过这个方法来启动，这样方便我们的管理
\houdunwang\core\Boot::run();
