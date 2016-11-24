<?php
namespace frontend\widgets\chat;

use frontend\models\FeedForm;
use Yii;
use yii\bootstrap\Widget;

class ChatWidget extends Widget
{
    public function run()
    {
        $feed = new FeedForm();
        $data['feed'] = $feed->getList();
        return $this->render('index', ['data' => $data]);
    }
}