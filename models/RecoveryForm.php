<?php

namespace app\models;

use app\components\helpers\AppHelper;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * RecoveryForm is the model behind the recovery form.
 */
class RecoveryForm extends Model
{
    public const SCENARIO_REQUEST = 'request';
    public const SCENARIO_RESET = 'reset';

    public $email;
    public $password;
    public $passwordRepeat;

    public function rules(): array
    {
        return [
            // username and password are both required
            [['email'], 'trim'],
            [['email'], 'required'],
            [['email'], 'string', 'max' => 45],
            [['email'], 'email'],
            [
                'email',
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['email' => 'email'],
                'message' => 'Пользователя с таким email не существует'
            ],
            [['password', 'passwordRepeat'], 'required'],
            [['password', 'passwordRepeat'], 'string', 'min' => 6, 'max' => 72],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
        ];
    }

    public function scenarios(): array
    {
        return [
            self::SCENARIO_REQUEST => ['email'],
            self::SCENARIO_RESET => ['password', 'passwordRepeat'],
        ];
    }

    public function sendRecoveryMessage(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            return false;
        }

        $user->recovery_token = Uuid::uuid4()->toString();
        $user->recovery_sent_at = new Expression('NOW()');
        $user->save();

        $link = AppHelper::getHost() . '/reset-password/' . $user->recovery_token . '/';
        $body = 'Для восстановления пароля перейдите по ссылке: ' .  $link;

        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($this->email)
            ->setSubject('Восстановление пароля')
            ->setHtmlBody($body)
            ->send();

        return true;
    }

    public function resetPassword(User $user): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user->password = $this->password;
        return $user->save();
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Новый пароль',
            'passwordRepeat' => 'Повторить пароль',
        ];
    }
}
