<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%news_categories}}".
 *
 * @property int $id
 * @property int $newsID
 * @property int $categoryID
 *
 * @property Category $category
 * @property News $news
 */
class NewsCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news_categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['newsID', 'categoryID'], 'required'],
            [['newsID', 'categoryID'], 'integer'],
            [['categoryID'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['categoryID' => 'id']],
            [['newsID'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['newsID' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'newsID' => 'News ID',
            'categoryID' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'categoryID']);
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'newsID']);
    }

    public static function create ($categories, $newsID){
        self::deleteAll(['newsID'=>$newsID]);
        foreach ($categories as $category) {
            $model = new self();
            $model->newsID = $newsID;
            $model->categoryID = $category;
            $model->save();
        }
    }
}
