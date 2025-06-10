<?php

namespace app\models;

use Exception;
use RuntimeException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 * @property int $id
 * @property int $is_active
 * @property string $email
 * @property string $phone
 * @property string $password_hash
 * @property string $access_token
 * @property string $recovery_token
 * @property string $auth_key
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property int $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $recovery_sent_at
 *
 * @property string $role
 * @property-read string $fullName
 * @property-read string $authKey
 * @property string $roleDescription
 */
class User extends Model implements IdentityInterface
{
    public $password;

    public $newPassword;

    public $newPasswordRepeat;

    public $role;

    public const MIN_PASSWORD_LENGTH = 6;
    public const MAX_PASSWORD_LENGTH = 64;

    public static function tableName(): string
    {
        return 'user';
    }

    public function rules(): array
    {
        return [
            [['is_deleted', 'is_active', 'created_at', 'updated_at', 'recovery_sent_at'], 'integer'],
            [['email'], 'required'],
            [['role'], 'safe'],
            [['email'], 'email'],
            [
                ['phone'],
                'unique',
                'message' => 'Пользователь с таким телефоном уже зарегистрирован'
            ],
            [
                ['email'],
                'unique',
                'message' => 'Пользователь с таким email уже зарегистрирован'
            ],
            [['password'], 'string', 'min' => self::MIN_PASSWORD_LENGTH, 'max' => self::MAX_PASSWORD_LENGTH],
            [
                'newPassword',
                'string',
                'min' => self::MIN_PASSWORD_LENGTH,
                'max' => self::MAX_PASSWORD_LENGTH,
                'on' => 'profile'
            ],
            [
                'newPasswordRepeat',
                'compare',
                'compareAttribute' => 'newPassword',
                'message' => "Пароли не совпадают",
                'on' => 'profile'
            ],
            [['phone', 'email', 'name', 'surname', 'patronymic'], 'string', 'max' => 45],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['recovery_token'], 'string', 'max' => 36],
        ];
    }

    public static function findIdentity($id): ?User
    {
        return self::find()->andWhere(['id' => $id, 'is_active' => 1])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        return self::find()->andWhere(['access_token' => $token, 'is_active' => 1])->one();
    }

    public static function findByUsername($username): ?User
    {
        return static::find()->andWhere(['email' => $username, 'is_active' => 1])->one();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }


    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            'register' => ['email', 'password'],
            'profile' => [
                'phone',
                'name',
                'surname',
                'patronymic',
                'password',
                'new_password',
                'new_password_repeat'
            ]
        ]);
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->is_active = 1;
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->access_token = Yii::$app->security->generateRandomString();
        }

        if ($this->scenario === 'profile') {
            if ($this->newPassword) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->newPassword);
                $this->recovery_token = null;
            }
        }

        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $this->recovery_token = null;
        }

        return true;
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активен',
            'email' => 'Email',
            'phone' => 'Телефон',
            'password_hash' => 'Password Hash',
            'password' => 'Пароль',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'role' => 'Роль',
            'roleDescription' => 'Роль',
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Новый пароль еще раз',
            'fullName' => 'ФИО'
        ];
    }

    public function register(bool $withTransaction = true): bool
    {
        if ($this->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = null;

        if ($withTransaction) {
            $transaction = self::getDb()->beginTransaction();

            if (!$transaction) {
                throw new \yii\db\Exception('Failed to initialize transaction');
            }
        }

        try {
            if (!$this->save()) {
                $transaction && $transaction->rollBack();
                return false;
            }

            $transaction && $transaction->commit();
            $this->initAfterRegister();
            return true;
        } catch (Exception $e) {
            $transaction && $transaction->rollBack();
            Yii::warning($e->getMessage());
            throw $e;
        }
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function initAfterRegister(): void
    {
    }

    public function getFullName(): string
    {
        $nameParts = [
            $this->surname,
            $this->name,
            $this->patronymic
        ];
        return implode(' ', array_filter($nameParts));
    }
}
