<?php
namespace backend\module\question\controllers;

use Faker\Provider\Image;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;


class EditController extends Controller
{
    public function actionUpload()
    {
        $menu =str_replace('\\','/',dirname(Yii::$app->BasePath));
        $upload_path = $menu.'/'.@backend."/upload/";
        $filename = $_POST['file'];
        $fileArr = explode('.',$filename);
        $tempName = date("YmdHis".".".$fileArr[1]);
        move_uploaded_file($_FILES["file"]["tempName"],$upload_path.$tempName);
        $file = array('filename'=>'filename','dir'=>'filedir');
        $file['filename']=$filename;
        $file['dir']=$upload_path.$tempName;
        return array("data"=>[$tempName,$file],"msg"=>"上传成功");
//        $model = new UploadedFile();
//        if(isset($_POST['file']))
//        {
//            $model->image = UploadedFile::getInstance($model,'image');
//            $ext = $model->image->getExtension();
//            $filename = uniqid().'.'.$ext;
//            $model->image->saveAs('upload/'.$filename);
//            Image::thumb('upload/'.$filename,'upload/'.uniqid().'.'.$ext);
//        }
//        $this->renderPartial('index',array('model'=>$model));
    }
}