<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $creator
 * @property int|null $isDeleted
 * @property string|null $createdAt
 *
 * @property User $author
 * @property NewsCategories[] $newsCategories
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'creator'], 'required'],
            [['description'], 'string'],
            [['creator', 'isDeleted'], 'integer'],
            [['createdAt'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt'],
                ],
                'value' => date('Y-m-d H-i-s')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'creator' => 'Создал',
            'isDeleted' => 'Is Deleted',
            'createdAt' => 'Создан',
        ];
    }

    public function beforeValidate()
    {
        $this->creator = Yii::$app->user->id;
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    /**
     * Gets query for [[Creator0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }

    /**
     * Gets query for [[NewsCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategories()
    {
        return $this->hasMany(NewsCategories::className(), ['newsID' => 'id']);
    }

    public function delete()
    {
        $this->isDeleted = true;
        $this->save(false);
    }

    /**
     * Gets query for [[NewsCategories]].
     *
     */
    public function getNewsCategoriesId()
    {
        return ArrayHelper::getColumn($this->getNewsCategories()->select('id')->asArray()->all(),'id');
    }
}
