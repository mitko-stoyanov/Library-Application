<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
{
    public $email;
    public $full_name;
    public $phone_number;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat', 'phone_number', 'full_name'], 'required'],
            [['password', 'repeat_password'], 'string', 'max' => 32],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email']
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->email = $this->email;
        $user->full_name = $this->full_name;
        $user->phone_number = $this->phone_number;
        $user->password = md5($this->password);
        $user->access_token = Yii::$app->security->generateRandomString();
        $user->auth_key = Yii::$app->security->generateRandomString();
        

        if($user->save()) {
            $last_id = User::find()->select(['id'=>'MAX(`id`)'])->one()->id;
            $user->password = md5($this->password . $last_id);
            $user->save();
            return true;
        }
        Yii::error("User was not saved". VarDumper::dumpAsString($user->errors));
        return false;
    }
}

?>
