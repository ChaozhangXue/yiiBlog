<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;


/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $cat_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property integer $created_at
 * @property integer $updated_at
 */
class PostsModel extends BaseModel
{
    const IS_VALID = 1;//已发布
    const NO_VALID = 0;//未发布
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cat_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
            'label_img' => 'Label Img',
            'cat_id' => 'Cat ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'is_valid' => 'Is Valid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /*
     * 设计到表的关联，体现在yii2里面就是 with的用法
     */
    public function getRelate(){
        return $this->hasMany(RelationPostTagsModel::className(), ['post_id' => 'id']);
        //第一个参数是关联关系表的表名, 第二个参数表示RelationPostTagsModel.post_id = postModel.id
    }

    public function getExtend(){
        return $this->hasOne(PostExtendsModel::className(), ['post_id' => 'id']);
    }
}
