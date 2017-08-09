<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/7/30
 * Time: 11:54
 */
//名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace houdunwang\model;
//使用PDO命名空间
use PDO;
//使用PDOException;这个命名空间
use PDOException;
//创建一个类，用来实现连接数据库和获得数据库数据的功能
class Base{
//    创建静态属性，用来保存PDO对象的值
    public static $pdo=null;
//    保存表名的属性
    private $table;
//    保存where条件的属性
    private $where;


//    创建构造方法：一执行这个类的时候就会自动执行这个方法--自动连接数据库
    public function __construct($table){
//        调用Base这个类的时候就会自动调用connect这个方法--自动连接数据库
        $this->connect();
//        把传进来的表的名字赋值给$this->table这个属性；方便我们后期的调用
        $this->table = $table;
    }
//    创建方法：实现连接数据库的功能
    public function connect(){
//        连接数据库
//        判断，如果静态变量的值为null的时候才会执行大括号里面的代码
        if(is_null(self::$pdo)){
//            尝试连接数据库
            try{
//                设置数据可以的类型，主机，库名
//                数据通过functions 函数里面的c函数到配置文件里面调用出来的
                $dsn="mysql:host=".c("database.db_host").";dbname=".c("database.db_name");
//                实例化PDO这个类，连接数据库
                $pdo=new PDO($dsn,c("database.db_user"),c("database.db_password"));
//                设置错误属性：把错误的属性设置成异常错误，这样才能被catch捕捉到
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                设置字符集，只有当页面的字符集和编辑器的字符集相同的时候才不会显示乱码
                $pdo->exec("SET NAMES " .c("database.db_charset"));
//                把pdo对象放到静态属性中
//                因为静态属性在函数调用过一次后就会有一个初始值，利用初始值我们就不必再重复的连接数据库
                self::$pdo=$pdo;
//                当连接数据库数显异常错误的时候会被cathch捕捉到
            }catch(PDOException $e){
//                输出异常错误
//                $e表示的是异常对象
//                如果是异常错误字体的颜色是红色的，便于区分
                echo "<span style='color: red'>".$e->getMessage() ."</span>";
//                如果出现异常错误，就不在执行以下代码
                exit;
            }
        }
    }

//    创建方法：获取全部数据
    public function get(){
        if(is_null($this->where)){
//        获得全部数据的sql指令，并且把值返回给一个变量
            $sql="SELECT * FROM  {$this->table}";
        }else{
            $sql="SELECT * FROM {$this->table} WHERE {$this->where}";
        }

//        接收数据结果
        $result=self::$pdo->query($sql);
//        获得数据，并且获得的是关联数组
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
//        返回获得的数据
        return $data;
    }

//    执行有结果集的操作
    public function q($sql){
//        尝试执行有结果集的操作
        try {
//            接收数据的结果
            $result = self::$pdo->query( $sql );
//            返回获得的数据
            return $result->fetchAll( PDO::FETCH_ASSOC );
//            捕获PDO异常错误 $e 是异常对象
        } catch ( PDOException $e ) {//捕获PDO异常错误 $e 是异常对象
//            发生异常错误的时候不再执行后面的代码并且输出异常错误
            exit( "SQL错误：" . $e->getMessage() );
        }
    }

//    执行没有结果集的操作
    public function e( $sql ) {
//        尝试执行没有结果集的操作
        try {
//            执行没有结果集的操作
            $afRows = self::$pdo->exec( $sql );
//            返回结果
            return $afRows;
        } catch ( PDOException $e ) {//捕获PDO异常错误 $e 是异常对象
//            发生异常错误的时候不再执行后面的代码并且输出异常错误
            exit( "SQL错误：" . $e->getMessage() );
        }
    }

//    创建方法：是来实现添加数据的功能
    public function save($post){
//        查询当前表的结构
//        需要获得表里面的字段
        $tableInfo=$this->q("DESC {$this->table}");
//        打印查看当前表的结构
//        p($tableInfo);die;
//        打印出来的内容
//        [0] => Array
//        (
//            [Field] => aid
//            [Type] => smallint(6)
//            [Null] => NO
//            [Key] => PRI
//            [Default] =>
//            [Extra] => auto_increment
//        )
//        创建一个空数组
//        用来保存当前的字段
        $tableFields=[];
        foreach ($tableInfo as $info){
            $tableFields[] = $info['Field'];
        }
//        打印查看当前标的字段
//        p($tableFields);die;
//        打印出来的数据
//        Array
//        (
//            [0] => aid
//            [1] => title
//            [2] => click
//)
//        循环$_POST提交过来的数据
//        因为有的时候会有其他的字段被上传过来，所以需要把不是表里的字段过滤掉，比如验证码字段
//        创建一个变量：用来保存过滤之后的字段--过滤掉其他字段，因为已经获得表里的字段，去除别的字段过滤即可
        $filterData=[];
//        循环$post，获得每一个键名和键值
//        获得了具体的键名和键值方便我们的调用与赋值
        foreach($post as $k=>$v){
//            判断$post的键名，也是就字段是否属于当前的字段，属于就保留，否则就过滤
            if(in_array($k,$tableFields)){
//                保存属于当前字段的键值
//                $k是字段，$v是字段的值
                $filterData[$k]=$v;
            }
        }
//        获得所有过滤的字段,用于组合sql的时候
        $field=array_keys($filterData);
//        把获得的字段转为字符串，可以直接在sql语句里面调用
        $field=implode(",",$field);

//        获得所有过滤后的值，用于组合sql的时候
        $values=array_values($filterData);
//        把获得的值转为字符，可以直接在sql语句里面调用
        $values='"'. implode('","' , $values) .'"';
//        组合sql添加语句
//        应为需要添加内容的表会有可能有变化，添加的内用也有可能会变化，所以不能写死
        $sql = "INSERT INTO {$this->table} ({$field}) VALUES ({$values})";
//        返回添加数据后的数据库的数据
        return $this->e($sql);
    }

//    创建方法：定义where条件
    public function where($where){
//        给$this->where属性赋值，把传进来的where条件返给$this->where，这样就能在这个类里面方便的调用where条件了
        $this->where=$where;
//        返回当前的Base这个类
//        需要进行链式操作
        return $this;
    }

//    创建方法：用来实现删除数据的功能
    public function del(){
//        判断：如果没有where条件的时候就终止代码，不在执行以下的代码
//        避免错误的操作把所有的数据删除
        if(!$this->where){
//            不执行后面的代码，并且输出一个提示给用户
            exit("必须要有删除数据的条件");
        }
//        用一个变量保存删除数据的sql指令，方便传参
        $sql="DELETE FROM {$this->table} WHERE {$this->where}";
//        把删除的数据的sql指令传参给当前的e方法
//        会自动执行删除一条代码的指令
        return $this->e($sql);
    }

//    创建方法：用来实现数据的修改功能
    public function update($data){
//        判断，如果没有where条件不会执行后面的代码，并且输出一个提示给用户
        if(!$this->where){
//            不执行下面的代码，并且提示用户一个信息
            exit('必须要有修改数据的条件');
        }

//        定义一个空的变量，用于后面保存数据
        $set = '';
//        循环$data这个数组，获得所有的键名和键值
        foreach ( $data as $field => $value ) {
//            把键名和相对应的键值固执给$set
            $set .= "{$field}='{$value}',";
        }
//        去除$set右边的，
        $set = rtrim($set,',');
//        组合sql命令，替换一条数据
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->where}";
//        把sql语句传参给当前的e方法，就会替换想要替换的数据
        return $this->e($sql);
    }

    public function find($id){
//        用一个变量存着主键的值，方便后面的调用
        $priKey = $this->getPriKey();
//        组合sql命令，查询一条数据
        $sql = "SELECT * FROM {$this->table} WHERE {$priKey}={$id}";
//        把sql语句传参给当前的q方法，就会获得想要查询的数据
        $data = $this->q($sql);
//        需要查询的数据默认是一个二维数组，为了更方便的操作，需要转成一维数组
        return current($data);
    }

    /**
     * 获得主键
     */
    private function getPriKey(){
//        查询$this->table表的结构，需要获得主键
        $sql = "DESC {$this->table}";
//        查询当前表的结构
//        需要获得表里面的字段
        $data = $this->q($sql);
        //获得表的主键
//        创建一个变量，用来存着主键的字段
        $primaryKey = '';
//        循环数组，获得数组里面的所有数据，方便调用
        foreach ($data as $v){
//            判断，如果数组里的key有PRI这个值，说明是主键
            if($v['Key'] == 'PRI'){
//                把主键的字段返给变量$primaryKey
                $primaryKey = $v['Field'];
            }
        }
//        把主键的字段名返回去，方便调用
        return $primaryKey;
    }


}