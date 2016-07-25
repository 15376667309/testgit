<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/19 0019
 * Time: 上午 9:41
 */
namespace frontend\components;

use common\models\ArticleComment;
use frontend\components\BaseDb;   //同级目录下 可以不写

class ArticleCommentQry extends BaseDb{

    public function add($data)
    {
        $ret = ['status' => 0, 'msg' => '非法操作'];
        //先判断文章是否存在
        if (!ArticleQry::getInstance()->articleExists($data['article_id'])) { //判断文章是否存在
            //return $ret;
        } elseif (empty($data['name']) || mb_strlen($data['name'], 'utf-8') > 20) {
            $ret['msg'] = '名称不能为空并且必须在20位以内';
        } elseif (empty($data['content']) || mb_strlen($data['content'], 'utf-8') > 200) {
            $ret['msg'] = '评论内容不能为空并且不能大于200位';
        } else {
            $comment = new ArticleComment();
            $comment->setAttributes($data);
            if ($comment->save()) {
                $ret = ['status' => 1, 'msg' => '谢谢您的评论'];
            } else {
                $ret['msg'] = '评论出错，请联系管理员';
            }
        }
        return $ret;
    }
    /*
     * 获取主评论个数
     *
     * @param int $id 文章的id
     * **/
    public function count($id){
        return ArticleComment::find()->where(['article_id'=>$id,'pid'=>0,'status'=>1])->count();
    }
    /*
     * 获取文章评论列表
     *
     * @param int $id 文章的id
     * @param int $offset 偏移量
     * @param int $limit 每页获取个数
     * **/
    public function articleCommentList($id,$offset=0,$limit=0){
        $data=ArticleComment::find()->select('id,name,content,date')->where(['article_id'=>$id,'pid'=>0,'status'=>1])->offset($offset)->limit($limit)->asArray()->all();
        foreach ($data as $k=>$v) {
            $data[$k]['date']=date('Y-m-d H:i:s',$v['date']);
        }
        return $data;
    }
}
