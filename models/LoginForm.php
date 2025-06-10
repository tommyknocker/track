<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    protected $user = false;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword(string $attribute, ?array $params = []): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный логин или пароль.');
            }
        }
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();

        if ($user) {
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 30 * 60);
        }

        return false;
    }

    public function getUser(): ?User
    {
        if ($this->user === false) {
            $this->user = User::findByUsername($this->email);
        }
        return $this->user;
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }
}
