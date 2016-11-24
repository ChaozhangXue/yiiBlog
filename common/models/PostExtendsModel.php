<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "post_extends".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class PostExtendsModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'browser' => 'Browser',
            'collect' => 'Collect',
            'praise' => 'Praise',
            'comment' => 'Comment',
        ];
    }

    /*
     * 文章统计
     */
    public function upCounter($condition, $attribute, $num)
    {
        $counter = $this->findOne($condition);
        if(!$counter){
            $this->setAttributes($condition);
            $this->$attribute = $num;
            $this->save();
        }else{
            $countData[$attribute] = $num;
            $counter->updateCounters($countData);
        }
    }
}
