<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sign-overlay"></div>
<div class="signpanel"></div>

<div class="panel signin">
    <div class="panel-heading">
        <h4 class="panel-title">欢迎登陆博客系统</h4>
    </div>
    <div class="panel-body">
        <button class="btn btn-primary btn-quirk btn-fb btn-block">联系我们</button>
        <div class="or">or</div>

    </div>


<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username',[
            'inputOptions' => [
                'placeholder' => '请输入账户',
            ],//添加css
            'inputTemplate' =>
                '<div class="input-group">
                    <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                    </span>
                    {input}
                </div>'
        ])->label(false); //{input} 表示input框的内容?>

        <?= $form->field($model, 'password',[
        'inputOptions' => [
            'placeholder' => '请输入密码',
        ],//添加css
            'inputTemplate' =>
                '<div class="input-group">
                    <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                    </span>
                    {input}
                </div>'
        ])->passwordInput()->label(false);//label(false)表示不显示标签 ?>

        <div>
            <a href="#" class="forgot">忘记密码？</a>
        </div>

<div class="form-group">
    <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-quirk btn-success btn-block', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div><!-- panel -->
