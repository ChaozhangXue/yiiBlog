<?php
namespace frontend\controllers;

use common\models\CatsModel;
use frontend\models\PostForm;
use Yii;
use frontend\controllers\base\BaseController;

class PostController extends BaseController
{
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

        $cat = CatsModel::getAllCats();
        return $this->render('create', ['model' => $model, 'cat' => $cat]);
    }
}