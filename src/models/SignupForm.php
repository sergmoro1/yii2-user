<?php
namespace sergmoro1\user\models;

use Yii;
use yii\base\Model;
use sergmoro1\user\Module;

use common\models\User;

/**
 * Signup form
 * @var string  $username
 * @var string  $email
 * @var string  $password
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Module::t('core', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Module::t('core', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('core', 'Username'),
            'password' => Module::t('core', 'Password'),
        ];
    }

    /**
     * Sends an email with a link, for user activating.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail($user)
    {
        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return Yii::$app->mailer->compose(['html' => 'userActivating-html', 'text' => 'userActivating-text'], ['user' => $user])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($this->email)
                    ->setSubject(Module::t('core', 'Robot: Account activating for ') . Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            
            $user->username = $this->username;
            $user->email    = $this->email;
            $user->group    = USER::GROUP_COMMENTATOR;
            $user->status   = USER::STATUS_ARCHIVED;
            
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
