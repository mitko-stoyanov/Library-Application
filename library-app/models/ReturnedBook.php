<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "returned_book".
 *
 * @property int $id
 * @property int $user_id
 * @property int $taken_book_id
 * @property int $count
 * @property string $return_date
 * @property string $pick_up_date
 *
 * @property TakenBook $takenBook
 * @property User $user
 */
class ReturnedBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'returned_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'taken_book_id', 'count'], 'required'],
            [['user_id', 'taken_book_id', 'count'], 'integer'],
            [['return_date', 'pick_up_date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['taken_book_id'], 'exist', 'skipOnError' => true, 'targetClass' => TakenBook::class, 'targetAttribute' => ['taken_book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'user_id' => 'Потребител',
            'taken_book_id' => 'Взета Книга',
            'count' => 'Брой',
            'return_date' => 'Дата на връщане',
            'pick_up_date' => 'Дата на вземане',
        ];
    }

    /**
     * Gets query for [[TakenBook]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTakenBook()
    {
        return $this->hasOne(TakenBook::class, ['id' => 'taken_book_id']);
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
}
