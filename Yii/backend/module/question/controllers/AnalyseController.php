<?php
namespace backend\module\question\controllers;

use yii\db\Exception;
use yii\web\Controller;
use yii\common\models\Question;
use yii\common\models\Type;
use yii\db\Query;
use yii\web\Response;
use yii\web\Request;

class AnalyseController extends Controller
{
    public function actionIndex()
    {
        return array('data'=>[],'msg'=>"数据分析");
    }
    /*
     * 个人创建分类中对应的问题数据分析
     * 输入：uid
     */
    public function actionPersonany()
    {
        $request = \Yii::$app->request;
        $uid = $request->post('uid');
        $query = (new Query())
            ->select('*')
            ->from('question')
            ->where(['uid'=>$uid])
            ->all();
        $lists = array();
        if($query)
        {
            for($i=0;$i<count($query);$i++)
            {
                $typename = (new Query())
                    ->select('*')
                    ->from('type')
                    ->where(['id'=>$query[$i]['type']])
                    ->one();
                $lists[$i]= $typename['typename'];
            }
            $num = array_count_values($lists);
            $list = array();
            $i=0;
            foreach ($num as $kv=>$v)
            {
                $list[$i]['tyname']=$kv;
                $list[$i]['num']=$v;
                $i++;
            }
            return array('data'=>$list,'msg'=>'个人分类数据');
        }
        else{
            return array('data'=>$uid,'msg'=>"该用户暂时尚未创建新的分类");
        }
    }
    /*
     * 个人热力图查看
     */
    public function actionPersonheat()
    {
        $request = \Yii::$app->request;
        $uid = $request->post('uid');

        $queryTime = (new Query())
            ->select('*')
            ->from('question')
            ->Where(['uid'=>$uid])
            ->all();
        $list = array();
        $time =array();
        for($j=0;$j<count($queryTime);$j++)
        {
            $time[$j] = explode(' ',$queryTime[$j]['ctime']);
            $time[$j] = $time[$j][0];
        }
        $time = array_count_values($time);
        $i=0;
        foreach ($time as $kv=>$v)
        {
            $list[$i]['key']=$kv;
            $list[$i]['num']=$v;
            $i++;
        }
        return array('data'=>$list,"msg"=>'用户时间表示');
    }

    /*
     * 管理员查看整个系统中问题数目
     *
     */
    public function actionQueryany()
    {
//        $queryTy = (new Query())
//            ->select('*')
//            ->from('type')
//            ->all();
//        $list = array();
//        for($i=0;$i<count($queryTy);$i++)
//        {
////
//            $queryq = (new Query())
//                ->select('*')
//                ->from('question')
//                ->where(['type'=>$queryTy[$i]['id']])
//                ->count();
//            $list[$i]['tyname'] = $queryTy[$i]['typename'];
//            $list[$i]['num'] = $queryq;
//        }
//        return array('data'=>$list,'msg'=>'网站问题数据');
//
        $query = (new Query())
            ->select('*')
            ->from('question')
            ->all();
        $lists = array();
        if($query)
        {
            for($i=0;$i<count($query);$i++)
            {
                $typename = (new Query())
                    ->select('*')
                    ->from('type')
                    ->where(['id'=>$query[$i]['type']])
                    ->one();
                $lists[$i]= $typename['typename'];
            }
            $num = array_count_values($lists);
            $list = array();
            $i=0;
            foreach ($num as $kv=>$v)
            {
                $list[$i]['tyname']=$kv;
                $list[$i]['num']=$v;
                $i++;
            }
            return array('data'=>$list,'msg'=>'网站分类数据');
        }
        else{
            return array('data'=>[],'msg'=>"未创建新的分类");
        }
    }
    /*
     * 管理员用户问题提交时间热力图
     */
    public function actionQueryheatmap()
    {
        $queryTime = (new Query())
            ->select('*')
            ->from('question')
            ->all();
        $list = array();
        $time =array();
        for($j=0;$j<count($queryTime);$j++)
        {
            $time[$j] = explode(' ',$queryTime[$j]['ctime']);
            $time[$j] = $time[$j][0];
        }
        $time = array_count_values($time);
        $lists = array();
        $i=0;
        foreach ($time as $kv=>$v)
        {
            $list[$i]['key']=$kv;
            $list[$i]['num']=$v;
            $i++;
        }
        return array('data'=>$list,"msg"=>'用户时间表示');
    }
}