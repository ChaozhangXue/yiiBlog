<?php
namespace frontend\controllers;

use Yii;
use frontend\controllers\base\BaseController;

class PostController extends BaseController{
    public function actionIndex(){
        return $this->render('index');
    }
}