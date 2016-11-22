<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $leftMenu = [
        ['label' => '首页', 'url' => ['/site/index']],
        ['label' => '文章', 'url' => ['/post/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $rightMenu[] = ['label' => '注册', 'url' => ['/site/signup']];
        $rightMenu[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $rightMenu[] = [
            'label' => '<img src="/statics/images/avatar/small.jpg" alt="' .Yii::$app->user->identity->username . '">' ,
            'linkOptions' => ['class' => 'avatar'],
            'items' => [
                //i标签表示引入font-awesome的图标
                ['label' => '<i class="fa fa-sign-out"></i> 退出','url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
                //这里是加上下拉菜单的，然后linkOptions可以添加这个属性，这里表示通过post方式提交，url地址表示连接过去的url地址，最后展示出来的是a标签
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenu,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,//这个表示是html标间进行解析
        'items' => $rightMenu,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
