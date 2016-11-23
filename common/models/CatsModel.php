<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $cat_name
 */
class CatsModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
        ];
    }


    public static function getAllCats()
    {
        //需要静态方法
        $cat = ['0' => '暂无分类'];
        $res = self::find()->asArray()->all();

        if($res){
            //如果拿不到数据 返回是空或者false的 所以能直接使用
            foreach ($res as $k => $list){
                $cat[$list['id']] = $list['cat_name'];
            }
        }

        return $cat;
    }
}
