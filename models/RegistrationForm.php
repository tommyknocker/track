<?php

namespace app\models;

use app\components\helpers\CookieHelper;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{
    public $phone;
    public $email;
    public $password;
    protected $user;

    public function rules(): array
    {
        return [
            // username and password are both required
            [['phone', 'email', 'password'], 'trim'],
            [['phone', 'email', 'password'], 'required'],
            [['phone', 'email'], 'string', 'max' => 45],
            [['email'], 'email'],
            [
                ['phone'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Пользователь с таким телефоном уже зарегистрирован'
            ],
            [
                ['email'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Пользователь с таким email уже зарегистрирован'
            ],
            ['password', 'string', 'min' => 6, 'max' => 72],
        ];
    }

    public function register($withTransaction = true): bool
    {
        if (!$this->validate()) {
            return false;
        }
        $user = new User();
        $user->setScenario('register');
        $user->setAttributes($this->attributes);

        if (!$user->register($withTransaction)) {
            return false;
        }

        return true;
    }

    public function getUser(): ?User
    {
        if (!$this->user) {
            $this->user = User::findByUsername($this->email);
        }

        return $this->user;
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}
