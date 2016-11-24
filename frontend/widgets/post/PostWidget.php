<?php
namespace frontend\widgets\post;

use common\models\PostsModel;
use frontend\models\PostForm;
use Yii;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

class PostWidget extends Widget
{
    public $title = '';//文章标题
    public $limit = 6;//是否显示条数
    public $more = true;//是否显示更多
    public $page = false;//是否显示分页

    public function run()
    {
        //最重要的就是run方法

        $curPage = Yii::$app->request->get('page', 1);
        //查询条件
        $cond = ['=', 'is_valid', PostsModel::IS_VALID];
        $res = PostForm::getList($cond, $curPage, $this->limit);
        $result['title'] = $this->title? :"最新文章";
        $result['more'] = Url::to(['post/index']);//是跳转到这个页面
        $result['body'] = $res['data']? :[];//这个isset的写法很简便

        //是否显示分页
        if($this->page){
            $pages = new Pagination(['totalCount' => $res['count'], 'pageSize' => $res['pageSize']]); //Pagination 是yii2自带的分页，一个参数是总条数
            $result['page'] = $pages;
        }
        return $this->render('index', ['data' => $result]);
    }
}
