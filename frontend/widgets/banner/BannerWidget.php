<?php
namespace frontend\widgets\banner;

use Yii;
use yii\base\Widget;

class BannerWidget extends Widget
{
    public $item = [];

    public function init()
    {
        //获取数据的操作

        if(empty($this->item)){
            $this->item = [
                ['label' => 'demo1', 'image_url' => 'statics/images/banner/b_0.png', 'url' => ['site/index']],
                ['label' => 'demo1', 'image_url' => 'statics/images/banner/b_1.png', 'url' => ['site/index']],
                ['label' => 'demo1', 'image_url' => 'statics/images/banner/b_2.png', 'url' => ['site/index']],
            ];
        }
    }

    public function run()
    {
        $data['items'] = $this->item;
        return $this->render('index', ['data' => $data]);
    }
}