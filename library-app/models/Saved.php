<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "saved_book".
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property int $count
 * @property string $save_date
 *
 * @property Book $book
 * @property User $user
 */
class Saved extends \yii\db\ActiveRecord
{
    public $books;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'saved_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'book_id', 'count'], 'required'],
            [['user_id', 'book_id'], 'required', 'on' => 'add'],
            [['user_id', 'book_id', 'count'], 'integer'],
            [['save_date', 'books'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
        
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['add'] = ['user_id','book_id'];
	return $scenarios;
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
            'count' => 'Брой',
            'save_date' => 'Дата на запазване',
        ];
    }

    public function checkUser() {
        $session = Yii::$app->session;
        if($session['user_id']) {
            return $session['user_id'];
        }

        return Yii::$app->user->identity->id;
    }

    public function checkQty() {
        $session = Yii::$app->session;
        if($session['user_id']) {
            $saved_books = Saved::findAll(['user_id' => $session['user_id']]);
        } else {
            $saved_books = Saved::findAll(['user_id' => Yii::$app->user->identity->id]);
        }
        return count($saved_books);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
