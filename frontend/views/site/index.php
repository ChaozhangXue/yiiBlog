<?php

/* @var $this yii\web\View */
use frontend\widgets\post\PostWidget;
use frontend\widgets\chat\ChatWidget;
$this->title = '博客-首页';
?>

<div class="row">
    <div class="col-lg-9">
        <!--图片轮播-->

        <!--文章列表-->
        <?= PostWidget::widget()?>
    </div>
    <div class="col-lg-3">
        <?= ChatWidget::widget()?>
    </div>
</div>
