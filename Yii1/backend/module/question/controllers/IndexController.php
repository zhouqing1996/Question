<?php
namespace backend\module\question\controllers;

use yii\db\Exception;
use yii\web\Controller;
use yii\common\models\Question;
use yii\common\models\Type;
use yii\db\Query;
use yii\web\Response;
use yii\web\Request;
header("Access-Control-Allow-Origin: *");
file_get_contents("php://input");
class IndexController extends Controller
{
    public function actionIndex()
    {
        return "question"; // TODO: Change the autogenerated stub
    }
    /*
     * 管理员
     * 查找
     * 1:查找问题
     * 2：查找类型名
     * 3：模糊查找问题
     * 4；按照问题类型id查找对应问题
     * 5：按照w问题id查找问题
     */
    public function actionQuery()
    {
        $request = \Yii::$app->request;
        $flag = $request->post('flag');
        if($flag==1)
        {
            $query = (new Query())
                ->select('*')
                ->from('question')
                ->orderBy(['id'=>SORT_DESC])
                ->all();
            return array("data"=>$query,"msg"=>"全部问题");
        }
        else if($flag==2)
        {
            $query = (new Query())
                ->select('*')
                ->from('type')
                ->all();
            return array("data"=>$query,"msg"=>"全部类型");
        }
        else if($flag==3)
        {
            $search = $request->post('name');
            $query = (new Query())
                ->select('*')
                ->from('question')
                ->Where(['or',
                    ['like', 'title', $search],
                    ['like', 'content', $search],
                    ['like','id',$search],
                ])
                ->orderBy(['id'=>SORT_DESC])
                ->all();
            return array("data"=>$query,"msg"=>"查询".$search."问题");
        }
        else if($flag==4)
        {
            $id = $request->post('id');
            $query =(new Query())
                ->select('*')
                ->from('question')
                ->Where(['type'=>$id])
                ->orderBy(['id'=>SORT_DESC])
                ->all();
            return array("data"=>$query,"msg"=>$id."问题查找");
        }
        else if($flag==5)
        {
            $qid = $request->post('qid');
            $query =(new Query())
                ->select('*')
                ->from('question')
                ->Where(['id'=>$qid])
                ->all();
            return array("data"=>$query,"msg"=>$qid."问题查找");
        }

    }

    public function actionAddquestion()
    {
        $request = \Yii::$app->request;
        $title = $request->post('title');
        $content = $request->post('content');
        $typename = $request->post('type');
        $uid = $request->post('uid');
        $ctime = date('Y-m-d H:i:s',time());
        if($typename)
        {
//            $typename=$typename;
        }
        else{
            $typename='未知';
        }
        $query = (new Query())
            ->select('*')
            ->from('question')
            ->Where(['title'=>$title])
            ->orWhere(['content'=>$content])
            ->all();
        if($query)
        {
            return array("data"=>$query,"msg"=>"该问题已存在");
        }
        $type = (new Query())
            ->select('*')
            ->from('type')
            ->Where(['typename'=>$typename])
            ->one();
        $id = (new Query())
            ->select('*')
            ->from('question')
            ->max('id');
        $id = $id+1;
        if($type)
        {
            $insertU = \Yii::$app->db->createCommand()->insert('question',array('id'=>$id,'title'=>$title,
                'content'=>$content,'type'=>$type['id'],'uid'=>$uid,'ctime'=>$ctime))->execute();
        }
        else{
            $tid = (new Query())
                ->select('*')
                ->from('type')
                ->max('id');
            $tid = $tid+1;
            $insertT = \Yii::$app->db->createCommand()->insert('type',array('id'=>$tid,
                'typename'=>$typename,'uid'=>$uid,'ctime'=>$ctime))->execute();
            $insertU1 = \Yii::$app->db->createCommand()->insert('question',array('id'=>$id,'title'=>$title,
                'content'=>$content,'type'=>$tid,'uid'=>$uid,'ctime'=>$ctime))->execute();
        }
        return array("data"=>$title,"msg"=>"zhiz");
    }

    /*
     * 删除
     */
    public function actionDelete()
    {
        $request= \Yii::$app->request;
        $qid= $request->post('qid');
        $query = (new Query())
            ->select("*")
            ->from("question")
            ->Where(['id'=>$qid])
            ->all();
        if($query)
        {
            $updateUs = \Yii::$app->db->createCommand()->delete('question',['id'=>$qid])->execute();
            return array('data'=>$updateUs,"msg"=>"删除成功");
        }
    }

    /*
     * 普通人
     * 查找
     * 1:查找问题
     * 2：查找类型名
     * 3：模糊查找问题
     * 4；按照问题类型id查找对应问题
     * 5：按照w问题id查找问题
     */
    public function actionUquery()
    {
        $request = \Yii::$app->request;
        $flag = $request->post('flag');
        $uid = $request->post('uid');
        if($flag==1)
        {
            $query = (new Query())
                ->select('*')
                ->from('question')
                ->Where(['uid'=>$uid])
                ->orderBy(['id'=>SORT_DESC])
                ->all();
            return array("data"=>$query,"msg"=>"全部问题");
        }
        else if($flag==2)
        {
//            $query = (new Query())
//                ->select('*')
//                ->from('type')
//                ->where(['uid'=>$uid])
//                ->all();
//            $rt = array('id'=>1,'typename'=>'未知','uid'=>1);
//            array_push($query,$rt);
//            return array("data"=>$query,"msg"=>$uid."全部类型");
            $query = (new Query())
                ->select('*')
                ->from('question')
                ->where(['uid'=>$uid])
                ->all();
            $l = [];
            for($i=0;$i<count($query);$i++)
            {
                $l = $query[$i]['type'];
            }
            $nu = array_count_values($l);
            $type =[];
            $j =0;
            foreach ($nu as $k=>$v){
                $type[$j] = $k;
                $j++;
            }
            $list = [];
            for($k=0;$k<count($type);$k++)
            {
                $querys = (new Query())
                    ->select('*')
                    ->from('type')
                    ->Where(['id'=>$type[$k]])
                    ->one();
                array_push($querys,$list);
            }
            return array("data"=>$list,"msg"=>$uid."全部类型");
        }
        else if($flag==3)
        {
            $search = $request->post('name');
            $query = (new Query())
                ->select('*')
                ->from('question')
                ->Where(['or',
                    ['like', 'title', $search],
                    ['like', 'content', $search],
                    ['like','id',$search],
                ])
                ->andWhere(['uid'=>$uid])
                ->orderBy(['id'=>SORT_DESC])
                ->all();
            return array("data"=>$query,"msg"=>$uid."查询".$search."问题");
        }
        else if($flag==4)
        {
            $id = $request->post('id');
            $query =(new Query())
                ->select('*')
                ->from('question')
                ->Where(['type'=>$id])
                ->andWhere(['uid'=>$uid])
                ->all();
            return array("data"=>$query,"msg"=>$id."问题查找".$uid);
        }
        else if($flag==5)
        {
            $qid = $request->post('qid');
            $query =(new Query())
                ->select('*')
                ->from('question')
                ->Where(['id'=>$qid])
                ->andWhere(['uid'=>$uid])
                ->all();
            return array("data"=>$query,"msg"=>$qid."问题查找");
        }
        else if($flag==6)
        {
            $tid = $request->post('tid');
            $query = (new Query())
                ->select('*')
                ->from('type')
                ->where(['id'=>$tid])
                ->one();
            return array("data"=>$query,"msg"=>$tid);
        }

    }

    public function actionUaddquestion()
    {
        $request = \Yii::$app->request;
        $title = $request->post('title');
        $content = $request->post('content');
        $typename = $request->post('type');
        $uid = $request->post('uid');
        $ctime = date('Y-m-d H:i:s',time());
        if($typename===null)
        {
            $typename='未知';
        }
        $query = (new Query())
            ->select('*')
            ->from('question')
            ->Where(['title'=>$title])
            ->orWhere(['content'=>$content])
            ->all();
        if($query)
        {
            return array("data"=>$query,"msg"=>"该问题已存在");
        }
        $type = (new Query())
            ->select('*')
            ->from('type')
            ->Where(['typename'=>$typename])
            ->one();
        $id = (new Query())
            ->select('*')
            ->from('question')
            ->max('id');
        $id = $id+1;
        if($type)
        {
            $insertU = \Yii::$app->db->createCommand()->insert('question',array('id'=>$id,'title'=>$title,
                'content'=>$content,'type'=>$type['id'],'uid'=>$uid,'ctime'=>$ctime))->execute();
        }
        else{
            $tid = (new Query())
                ->select('*')
                ->from('type')
                ->max('id');
            $tid = $tid+1;
            $insertT = \Yii::$app->db->createCommand()->insert('type',array('id'=>$tid,
                'typename'=>$typename,'uid'=>$uid))->execute();
            $insertU1 = \Yii::$app->db->createCommand()->insert('question',array('id'=>$id,'title'=>$title,
                'content'=>$content,'type'=>$tid,'uid'=>$uid,'ctime'=>$ctime))->execute();
        }
        return array("data"=>$title,"msg"=>"zzzzz");
    }

    /*
     * 删除
     */
    public function actionUdelete()
    {
        $request= \Yii::$app->request;
        $qid= $request->post('qid');
        $uid = $request->post('uid');
        $query = (new Query())
            ->select("*")
            ->from("question")
            ->Where(['id'=>$qid])
            ->andWhere(['uid'=>$uid])
            ->all();
        if($query)
        {
            $updateUs = \Yii::$app->db->createCommand()->delete('question',['id'=>$qid])->execute();
            return array('data'=>$updateUs,"msg"=>"删除成功");
        }
    }
}
