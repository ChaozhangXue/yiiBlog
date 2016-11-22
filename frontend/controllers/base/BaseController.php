<?php
namespace frontend\controllers\base;

use yii\web\Controller;

class BaseController extends Controller{
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            //如果父类验证出错 则出错
            return false;
        }
        return true;
    }
}