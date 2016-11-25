<?php
namespace frontend\widgets\banner;

use Yii;
use yii\base\Widget;

class BannerWidget extends Widget
{
    public $items = [];

    public function init()
    {
        //获取数据的操作

        if(empty($this->items)){
            $this->items = [
                [
                    'label' => 'demo1',
                    'image_url' => '/statics/images/banner/b_0.png',
                    'url' => ['site/index'],
                    'html' => '',
                    'active' => 'active',
                ],
                [
                    'label' => 'demo1',
                    'image_url' => '/statics/images/banner/b_1.png',
                    'url' => ['site/index'],
                    'html' => '',
                ],
                [
                    'label' => 'demo1',
                    'image_url' => '/statics/images/banner/b_2.png',
                    'url' => ['site/index'],
                    'html' => '',
                ],
            ];
        }
    }

    public function run()
    {
        $data['items'] = $this->items;
        return $this->render('index', ['data' => $data]);
    }
}