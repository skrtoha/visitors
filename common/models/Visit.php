<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "visitor".
 *
 * @property int $id
 * @property int $user_id
 * @property int $sum
 * @property int $discount
 *
 * @property User $user
 */
class Visit extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sum'], 'required'],
            [['user_id', 'sum', 'discount'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'sum' => 'Сумма',
            'discount' => 'Скидка',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Получает скидку в зависимости от количества посещений
     * @param $count
     * @return int
     */
    public static function getDiscount($count){
        if ($count % 3 === 0) return 5;
        if ($count % 5 === 0) return 10;
        if ($count % 8 === 0) return 5;
        if ($count % 10 === 0) return 10;
        return 0;
    }
}
