<?php
namespace frontend\controllers;

use common\models\CatsModel;
use frontend\models\PostForm;
use Yii;
use frontend\controllers\base\BaseController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class PostController extends BaseController
{

    /**
     * 行为过滤
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'upload', 'ueditor'], //要把actions里面的也加进来
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
//                        'roles' => ['?'],//？表示不登录就能访问的
                    ],
                    [
                        'actions' => ['create', 'upload', 'ueditor'],
                        'allow' => true,
                        'roles' => ['@'],//@表示登录后能访问的方法
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*' => ['get','post'], //默认都可以post和get
                    'create' => ['get','post'], //指定单个方法
                ],
            ],
        ];
    }

    public function actions()
    {
        //其实actions就相当于 actionUpload这个方法一样
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new PostForm();//表单模型
        //定义场景
        $model->setScenario(PostForm::SCENARIOS_CREATE);//用常量定义 其实就是create的字符串
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if(!$model->create()){
                Yii::$app->session->setFlash('warning',$model->_lastError);
            }else{
                return $this->redirect(['post/view', 'id' => $model->id]);
            }
        }

        $cat = CatsModel::getAllCats();
        return $this->render('create', ['model' => $model, 'cat' => $cat]);
    }

    /*
     * 文章详情页
     */
    public function actionView($id){
        $model = new PostForm();
        $data = $model->getViewById($id);

        return $this->render('view', ['data' => $data]);
    }
}