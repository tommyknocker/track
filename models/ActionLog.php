<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "action_log".
 *
 * @property int $id
 * @property string $entity
 * @property int|null $entity_id
 * @property string $action_id
 * @property string|null $old_state
 * @property string|null $new_state
 * @property int|null $user_id
 * @property int|null $created_at
 * @property-read User $user
 * @property-read string $userName
 * @property-read string $actionName
 */
class ActionLog extends Model
{
    public const int ACTION_ID_INSERT = 0;
    public const int ACTION_ID_UPDATE = 1;
    public const int ACTION_ID_DELETE = 2;

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ]
        ];
    }

    public static function tableName(): string
    {
        return 'action_log';
    }

    public function rules(): array
    {
        return [
            [['entity', 'action_id'], 'required'],
            [['entity_id', 'user_id', 'created_at', 'action_id'], 'integer'],
            [['old_state', 'new_state'], 'string'],
            [['entity'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'entity' => 'Сущность',
            'entity_id' => 'ID сущности',
            'action_id' => 'Действие',
            'old_state' => 'Старое состояние',
            'new_state' => 'Новое состояние',
            'user_id' => 'Пользователь',
            'created_at' => 'Дата',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getActionName(): string
    {
        return self::getActionList()[$this->action_id];
    }

    public function getUserName(): string
    {
        return $this->user_id ? $this->user->email : 'Система';
    }

    public static function getActionList(): array
    {
        return [
            self::ACTION_ID_INSERT => 'Добавление',
            self::ACTION_ID_UPDATE => 'Обновление',
            self::ACTION_ID_DELETE => 'Удаление'
        ];
    }
}
