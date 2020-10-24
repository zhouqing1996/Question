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
        if(file_exists($menu.'/'.@backend.'/upload/'.$_FILES['file']['name']))
        {

        }
        else{
            move_uploaded_file($_FILES['file']['name'],$menu.'/'.@backend.'/upload/'.$_FILES['file']['name']);
        }

//        $upload_path = $menu.'/'.@backend."/upload/";
//        $filename = $_POST['file'];
//        $fileArr = explode('.',$filename);
//        $tempName = date("YmdHis".".".$fileArr[1]);
//        move_uploaded_file($_FILES["file"]["tempName"],$upload_path.$tempName);
//        $file = array('filename'=>'filename','dir'=>'filedir');
//        $file['filename']=$filename;
//        $file['dir']=$upload_path.$tempName;
        return array("data"=>'',"msg"=>"上传成功");
    }
}