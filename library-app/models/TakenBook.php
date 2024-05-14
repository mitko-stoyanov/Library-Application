<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "taken_book".
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property string $pick_up_date
 * @property int $count
 * @property string $return_date
 *
 * @property Book $book
 * @property ReturnedBook[] $returnedBooks
 * @property User $user
 */
class TakenBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taken_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'book_id', 'count'], 'required'],
            [['user_id', 'book_id', 'count'], 'integer'],
            [['pick_up_date', 'return_date'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'book_id' => 'Книга',
            'pick_up_date' => 'Дата на вземане',
            'count' => 'Брой',
            'return_date' => 'Дата на връщане',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[ReturnedBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReturnedBooks()
    {
        return $this->hasMany(ReturnedBook::class, ['taken_book_id' => 'id']);
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
