<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $phone_number
 * @property string $email
 * @property string $password
 * @property string $type
 * @property string|null $address
 * @property int|null $taken_book
 * @property int|null $books_to_return
 * @property string|null $notes
 * @property int $is_active
 * @property string $auth_key
 * @property string $access_token
 *
 * @property ReturnedBook $booksToReturn
 * @property ReturnedBook[] $returnedBooks
 * @property SavedBook[] $savedBooks
 * @property TakenBook $takenBook
 * @property TakenBook[] $takenBooks
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'phone_number', 'email', 'password', 'auth_key', 'access_token'], 'required'],
            [['type', 'notes'], 'string'],
            [['taken_book', 'books_to_return', 'is_active'], 'integer'],
            [['full_name'], 'string', 'max' => 40],
            [['phone_number'], 'string', 'max' => 19],
            [['email', 'auth_key', 'access_token'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 32],
            [['address'], 'string', 'max' => 200],
            [['books_to_return'], 'exist', 'skipOnError' => true, 'targetClass' => ReturnedBook::class, 'targetAttribute' => ['books_to_return' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Име и Фамилия',
            'phone_number' => 'Телефонен номер',
            'email' => 'Имейл',
            'password' => 'Парола',
            'type' => 'Тип потребител',
            'address' => 'Адрес',
            'taken_book' => 'Взети книги',
            'books_to_return' => 'Книги за връщане',
            'notes' => 'Бележки',
            'is_active' => 'Активен',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }

    /**
     * Gets query for [[BooksToReturn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooksToReturn()
    {
        return $this->hasOne(ReturnedBook::class, ['id' => 'books_to_return']);
    }

    /**
     * Gets query for [[ReturnedBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReturnedBooks()
    {
        return $this->hasMany(ReturnedBook::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[SavedBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSavedBooks()
    {
        return $this->hasMany(SavedBook::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TakenBook]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTakenBook()
    {
        return $this->hasOne(TakenBook::class, ['id' => 'taken_book']);
    }

    public function comparePass($id, $user, $new_pass, $old_pass, $conf_pass)
    {
        return $user->password == md5($old_pass . $id) && $new_pass == $conf_pass;
    }

    /**
     * Gets query for [[TakenBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTakenBooks()
    {
        return $this->hasMany(TakenBook::class, ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['access_token' => $token])->one();
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::find()->where(['email' => $email])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function getUserType() {
        return Yii::$app->user->identity->type;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password, $user_id)
    {
        return md5($password . $user_id) == $this->password;
        
    }
}
