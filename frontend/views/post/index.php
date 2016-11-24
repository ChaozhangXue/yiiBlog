<?php
use frontend\widgets\post\PostWidget;
use yii\base\Widget;
?>


<div class="row">
    <div class="col-lg-9">
        <?= PostWidget::widget(['limit' => 1]); //最原始的引用方式，这里引用组件，然后组件调用run的方法，然后run方法里面渲染组件里面的index.php页面?>
    </div>
    <div class="col-lg-3">

    </div>
</div>
