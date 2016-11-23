<?php
namespace frontend\models;

use common\models\PostsModel;
use common\models\RelationPostTagsModel;
use Yii; //引用yii的话 会有代码提示的
use yii\base\Model;
use yii\db\Exception;
use yii\db\Query;
use yii\web\NotFoundHttpException;

class PostForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;

    public $_lastError = "";

    /*
     * 定义场景
     * SCENARIOS_CREATE 创建
     * SCENARIOS_UPDATE 更新
     */
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    /*
     * 定义事件
     * EVENT_AFTER_CREATE 创建后的事件
     * EVENT_AFTER_UPDATE 修改后的事件
     */
    const EVENT_AFTER_CREATE = "eventAfterCreate";
    const EVENT_AFTER_UPDATE = "eventAfterUpdate";

    public function scenarios()
    {
        //场景的引用限制了你只能修改设置的几个属性。不能修改其他的
        $scennarios = [
            self::SCENARIOS_CREATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
            self::SCENARIOS_UPDATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
        ];
        return array_merge(parent::scenarios(), $scennarios);
    }

    public function rules()
    {
        return [
            [['id', 'title', 'content', 'cat_id'], 'required'],
            [['id', 'cat_id'], 'integer'],
            ['title', 'string', 'min' => 4, 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '编码',
            'title' => '标题',
            'content' => '内容',
            'label_img' => '标签图',
            'tags' => '标签',
            '$cat_id' => '分类',
        ];
    }

    public function getViewById($id)
    {
        $res = PostsModel::find()->with('relate')->where(['id' => $id])->asArray()->one(); //relate中表示关联的数据
        /*
         Array
        (
            [id] => 25
            [title] => 11111
            [summary] => 大叔大叔大叔大所大所
            [content] => <p>大叔大叔大叔大所大所</p>
            [label_img] => /image/20161123/1479882259114628.png
            [cat_id] => 2
            [user_id] => 560
            [user_name] => rodgexue
            [is_valid] => 1
            [created_at] => 1479885478
            [updated_at] => 1479885478
            [relate] => Array
                (
                    [0] => Array
                        (
                            [id] => 1
                            [post_id] => 25
                            [tag_id] => 12
                        )

                    [1] => Array
                        (
                            [id] => 2
                            [post_id] => 25
                            [tag_id] => 13
                        )
                    )
                )
         */
        if (!$res) {
            throw new NotFoundHttpException("文章不存在");
        }

        print_r($res);
        die;
    }

    public function create()
    {
        //事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new PostsModel();
            $model->setAttributes($this->attributes);
            $model->summary = $this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid = PostsModel::IS_VALID;
            $model->created_at = time();
            $model->updated_at = time();

            if (!$model->save()) {
                throw new \Exception("文章保存失败");
            }
            $this->id = $model->id;

            //调用事件
            //第一个this表示这个表单，然后getAttributes获取表单的数据，后面是model的数据，
            //然后合并 后面覆盖前面
            $data = array_merge($this->getAttributes(), $model->getAttributes());
            $this->_eventAfterCreate($data);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    /*
     * 截取文章摘要
     */
    private function _getSummary($start = 0, $end = 90, $char = 'utf-8')
    {
        if (empty($this->content)) {
            return null;
        }

        return (mb_substr(str_replace('&nbsp;', '', strip_tags($this->content)), $start, $end, $char));
    }

    public function _eventAfterCreate($data)
    {

        //添加事件 on是添加事件的方法, 然后后面表示将_eventAddTag这个时间绑定到当前的EVENT_AFTER_CREATE事件,然后将data放进去
        //其中this表示类  _eventAddTag表示加进去的方法名 $data表示数据
        $this->on(self::EVENT_AFTER_CREATE, [$this, '_eventAddTag'], $data);
//        $this->on(self::EVENT_AFTER_CREATE, [$this, '_eventAddTag'], $data);

        //触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    /*
     * 添加标签
     */
    public function _eventAddTag($event)
    {

        //保存标签
        $tag = new TagForm();
        $tag->tags = $event->data['tags'];
        $tagids = $tag->saveTags();


        //删除原先的关联
        RelationPostTagsModel::deleteAll(['post_id' => $event->data['id']]);

        //批量保存文章标签的关系
        if (!empty($tagids)) {
            foreach ($tagids as $k => $id) {
                $row[$k]['post_id'] = $this->id;
                $row[$k]['tag_id'] = $id;
            }

            //批量插入
            $res = (new Query())->createCommand()->batchInsert(RelationPostTagsModel::tableName(), ['post_id', 'tag_id'], $row)->execute();
            if (!$res) {
                throw new \Exception("关联关系保存失败");
            }
        }
    }


}