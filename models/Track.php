<?php

namespace app\models;

use app\behaviors\LoggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "track".
 *
 * @property int $id
 * @property string $track_number
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Track extends Model
{
    public const int STATUS_ID_NEW = 0;
    public const int STATUS_ID_IN_PROGRESS = 1;
    public const int STATUS_ID_COMPLETED = 2;
    public const int STATUS_ID_FAILED = 3;
    public const int STATUS_ID_CANCELLED = 4;


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'track';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => LoggableBehavior::class,
                'ignoredAttributes' => ['id', 'created_at', 'updated_at']
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_ID_NEW],
            [['track_number'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['status'], 'in', 'range' => array_keys(static::getStatusList())],
            [['track_number'], 'string', 'max' => 255],
            [['track_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'track_number' => 'Номер трека',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_ID_NEW => 'Новый',
            self::STATUS_ID_IN_PROGRESS => 'В процессе',
            self::STATUS_ID_COMPLETED => 'Завершен',
            self::STATUS_ID_FAILED => 'Ошибка',
            self::STATUS_ID_CANCELLED => 'Отменен',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate(): bool
    {
        $result = parent::beforeValidate();
        if (!$this->isSearchModel() && is_null($this->status)) {
            $this->status = self::STATUS_ID_NEW;
        }
        return $result;
    }
}