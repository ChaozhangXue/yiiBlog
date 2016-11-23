<?php
namespace frontend\models;

use common\models\TagsModel;
use yii\base\Model;

/**
 * 标签的表单模型
 */

class TagForm extends Model
{
    public $id;
    public $tags;

    public function rules()
    {
        return [
            ['tags', 'required'],
            ['tags', 'each', 'rule'=> ['string']],
        ];
    }

    /*
     * 批量保存标签
     */
    public function saveTags(){

        $ids = [];
        if(!empty($this->tags)){
            foreach ($this->tags as $tag){
                $ids[] = $this->_saveTag($tag);
            }
        }

        return $ids;
    }

    /*
     * 保存标签
     */
    private function _saveTag($tag){

        $model = new TagsModel();
        $res = $model->find()->where(['tag_name' => $tag])->one();

        if(!$res){
            $model->tag_name = $tag;
            $model->post_num = 3;

//            $model->save();
//            var_dump($model);die;
            if(!$model->save()){
                throw new \Exception("保存标签失败");
            }
            $id = $model->id;
//            print_r($model->id);die;
//            $res->id = $model->id;

        }else{
            $res->updateCounters(['post_num' => 1]); //这个方式是在有这个model的情况下，可以让其中的一个字段加1的方法
            $id = $res->id;
        }
//        print_r($model);die;
        return $id;
    }
}