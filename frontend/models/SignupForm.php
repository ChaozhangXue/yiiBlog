<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rePassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //写属性的验证规则
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'], //检测唯一性 这里是展示用户名的唯一性 targetClass这个是调用数据库模型
            ['username', 'string', 'min' => 2, 'max' => 16],
            //正则匹配的写法 是match关键字
//            ['username', 'match', 'pattern' => '/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]8$/u','message' => '用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 16],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['password', 'rePassword'], 'required'],
            [['password', 'rePassword'], 'string', 'min' => 6],
            ['verifyCode', 'captcha'],//验证码有专门的属性

            //比较密码和确认密码是否一致 用compare关键字
            ['rePassword','compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一致']
        ];
    }

    public function attributeLabels()
    {
        //这个主要用于这些form表单的字段对应的label的配置
        return [
            'username' => '用户名',
            'email' => '邮箱',
            'password' => '密码',
            'rePassword' => '重置密码',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
