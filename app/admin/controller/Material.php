<?php
/**
 * Created by PhpStorm.
 * User: liu jiehao
 * Date: 2017/8/1
 * Time: 23:26
 */
//命名空间的名称，如果想要调动这个命名空间里面的类利用命名空间的名称可以很快的找到这个类
namespace app\admin\controller;

//使用houdunwang\core\Controller 这个命名空间，可以继承这个命名空间下的Controller类
use houdunwang\core\Controller;
//使用houdunwang\view\View 这个命名空间，可以调用这个命名空间下的View类
use houdunwang\view\View;
//使用system\model\Material 这个命名空间，可以调用这个命名空间下的Material类
//因为当前的命名空间也有Material类，所有需要别名来区分
use system\model\Material as MaterialModel;
///创建类：用来实现素材的管理功能
class material extends Common
{
//    创建方法：显示素材列表
    public function lists(){
//        获得GradeModel这个类里面的所有信息，方便在页面中调用
        $data=MaterialModel::get();
//        $data这个数组需要返回到首页，所以需要传参到View方法里面与模板的路径一起返回来
//        make方法里组合模板的路径--最终返回的是make方法当前的Base类
//        with方法会把我们需要的值给返回来--最终返回的是with方法当前的Base类
//        make方法和with方法最终会返回到Boot，被echo输出是来，触发__toString这个方法，这个方法会加载make方法里组合的路径并且把需要返回的值返回过来
        return View::make()->with(compact("data"));
    }

//    创建方法：添加素材列表
    public function add(){
//        判断用户是否用了post的方法提交数据
//        如果使用post方法提交的数据就会执行大括号里面的代码，否则不执行
        if(IS_POST){
//            调用上传的方法：当用户点击了提交按钮并且是post传参的时候才会上传文件
            $info = $this->upload();
//            把上传上来的文件存入一个数组：比如存入文件的路径，上传文件的时候等等
            $data = [
//                文件被上传上来保存的路径
                'path'        => $info['path'],
//                上传文件时候的时间
                'create_time' => time()
            ];
//            调用MaterialModel里面的save方法，并且把表单收集过来的数据传参过去
//            save这个方法用来实现数据的保存功能
            MaterialModel::save( $data );
//            提示用户添加成功并且页面跳转到显示班级信息的页面
//            最终会被返回到Boot类的run方法里，并且echo输出出来，会自动执行__toString这个方法，会加载提示用户操作成功的模板
            return $this->setRedirect("?s=admin/material/lists")->success('上传成功');
        }
//        make方法里组合模板的路径--最终返回的是make方法当前的Base类
//        make方法最终会返回到Boot，被echo输出是来，触发__toString这个方法，这个方法会加载make方法里组合的路径
        return View::make();
    }


//    创建方法：删除素材列表
    public function del(){
//        用变量存着需要删除的数据的相对应的序号
        $mid = $_GET['mid'];
//        获得想要删除的内容，因为数据库里面的内容被删除还需要把上传上来的文件也删除
        $data = MaterialModel::find($mid);
//        判断需要删除的文件的路径是否存在，如果存在就删除这个文件
        is_file($data['path']) && unlink($data['path']);
//        静态调用GradeModel
//        传入删除的文件的where条件，并且删除这条数据
        MaterialModel::where("mid={$mid}")->del();
//        提示用户添加成功并且跳转到显示显示素材信息的页面
//        最终会被返回到Boot类的run方法里，并且echo输出出来，会自动执行__toString这个方法，会加载提示用户操作成功的模板
        return $this->setRedirect("?s=admin/material/lists")->success('删除成功');
    }

//    创建方法：上传素材列表
    public function upload(){
        //创建上传目录
        $dir = 'upload/' . date( 'ymd' );
        is_dir( $dir ) || mkdir( $dir, 0777, true );
        //设置上传目录
        $storage = new \Upload\Storage\FileSystem( $dir );
        $file    = new \Upload\File( 'upload', $storage );
        //设置上传文件名字唯一
        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName( $new_filename );

        //设置上传类型和大小
        // Validate file upload
        // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations( array(
            // Ensure file is of type "image/png"
            new \Upload\Validation\Mimetype( [ 'image/png', 'image/gif', 'image/jpeg' ] ),

            //You can also add multi mimetype validation
            //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size( '2M' )
        ) );

        //组合数组
        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions(),
            //自己组合的上传之后的完整路径
            'path'       => $dir . '/' . $file->getNameWithExtension(),
        );


        // Try to upload file
        try {
            // Success!
            $file->upload();

            return $data;
        } catch ( \Exception $e ) {
            // Fail!
            $errors = $file->getErrors();
            foreach ( $errors as $e ) {
                throw new \Exception( $e );
            }

        }
    }

}