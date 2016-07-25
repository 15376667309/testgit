<?php
namespace frontend\controllers;

use common\models\Article;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use \frontend\components\CategoryQry;
use \frontend\components\ArticleQry;
use \frontend\components\ArticleCommentQry;


class SiteController extends Controller
{
    public $enableCsrfValidation = false;//csrf攻击，不关闭，post提交会报错
    /**
     * @inheritdoc
     */

    public function actionIndex($cid=0){
/*测试单例模式
 *      \frontend\components\ArticleQry::getInstance()->getA();
        \frontend\components\ArticleQry::getInstance()->getA();
        \frontend\components\ArticleQry::getInstance()->getA();
*/
        $cid =(int)$cid;

        //所有分类
        $categorys=CategoryQry::getInstance()->getCategorys();

        //获取当前筛选分类
        $nowCategory=[];
        if($cid!=0 && !isset($categorys[$cid])){
            $cid=0;
        }else{
            $nowCategory=$categorys[$cid];
        }
        //var_dump(ArticleQry::getInstance()->count(5));
        //print_r(ArticleQry::getInstance()->getArticles());

        //获取文章列表
        $pagination=new Pagination(['totalCount'=>ArticleQry::getInstance()->count($cid),'pageSize'=>5]);
        $articles=ArticleQry::getInstance()->getArticles($cid,$pagination->offset,$pagination->limit);

        //热门文章
        $hotArticles=ArticleQry::getInstance()->getHotArticles();
        //print_r($articles);
            return $this->render('index',['categorys'=>$categorys,'articles'=>$articles,'pagination'=>$pagination,'nowCategory'=>$nowCategory,'hotArticles'=>$hotArticles]);
        }

    public function actionArticle($id){
        $id=(int) $id;
        if($id>0 && ($article=ArticleQry::getInstance()->getArticle($id))){
            //添加浏览次数
            ArticleQry::getInstance()->incrArticleCount($id);
            return $this->render('article',['article'=>$article]);
        }
        return $this->redirect(['site/index']);
    }

    public function actionSearch($search=''){//$search 来自于http://127.0.0.1/yii2/frontend/web/index.php?r=site/search&search=66中的search值 get_['search']
        if($search=='' || mb_strlen($search,'utf-8')>255){
            return $this->redirect(['site/index']);
        }
        //查询出来的个数
        //echo $count= ArticleQry::getInstance()->getLikeArticleCount($search);
        $categorys=CategoryQry::getInstance()->getCategorys();
        $hotArticles=ArticleQry::getInstance()->getHotArticles();
        $pagination=new Pagination(['totalCount'=>ArticleQry::getInstance()->getLikeArticleCount($search),'pageSize'=>5]);
        $articles=ArticleQry::getInstance()->getLikeArticles($search,$pagination->offset,$pagination->limit);
        return $this->render('index',['categorys'=>$categorys,'articles'=>$articles,'pagination'=>$pagination,'nowCategory'=>[],'hotArticles'=>$hotArticles,'search'=>$search]);
    }

    /*
     * 点赞出来
     *@param int $id 文章id
     * **/
/*    public function actionUp($id=0){
        $id=(int) $id;
        if($id > 0 && Yii::$app->request->isAjax){
            ArticleQry::getInstance()->upArticle($id);
        }
        echo $id;die();
        return $this->redirect(['site/index']);
    }*/

    public function actionUp($id = 0)
    {
        $id = (int) $id;
        if ($id > 0 && Yii::$app->request->isAjax) {
            $status = ArticleQry::getInstance()->upArticle($id);
            exit(json_encode($status));//exit()等同于die('aaaa');输出字符串，并退出当前脚本
        }
        return $this->redirect(['site/index']);
    }

    /*
     * 提交用户评论
     * **/
    public function actionRecomment(){
        if(Yii::$app->request->isAjax){
            $data['name']=Yii::$app->request->post('name','');
            $data['content']=Yii::$app->request->post('content','');
            $data['article_id']=Yii::$app->request->post('rid',0);
            exit(json_encode(ArticleCommentQry::getInstance()->add($data)));
        }
        return $this->redirect(['site/index']);

    }

    public function actionRecommentList($article_id,$offset=0,$limit=2){
        $article_id=(int)Yii::$app->request->get('article_id',0);
        $count=ArticleCommentQry::getInstance()->count($article_id);
        $pagination=new Pagination(['totalCount'=>$count,'pageSize'=>2]);
        $data=ArticleCommentQry::getInstance()->articleCommentList($article_id,$pagination->offset,$pagination->limit);

        $pageStr=\yii\widgets\LinkPager::widget([
           'pagination'=>$pagination,
            'options'=>[
                'id'=>'yw0',
                'class'=>'yiiPager'
            ]
        ]);

        $pageStr=preg_replace('/href="[^"]+page=(\d+)[^"]+"/','onclick="ajaxData(\1)"',$pageStr);
        $pageStr=str_replace('class="active"','class="selected"',$pageStr);

        exit(json_encode(['pageStr'=>$pageStr,'count'=>$count,'data'=>$data]));

    }


}
