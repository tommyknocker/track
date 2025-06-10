<?php

namespace app\behaviors;

use app\components\helpers\AppHelper;
use app\models\ActionLog;
use Yii;
use yii\base\Application;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;


class LoggableBehavior extends Behavior
{
    public array $ignoredAttributes = [];

    private static ?array $oldAttributes;

    public function events()
    {
        return [
//            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function afterInsert(): void
    {
        $actionLog = new ActionLog();
        $actionLog->entity = $this->getEntity();
        $actionLog->entity_id = $this->getEntityId();
        $actionLog->action_id = ActionLog::ACTION_ID_INSERT;
        $actionLog->new_state = $this->prepareAttributes($this->owner->attributes);
        $actionLog->user_id = $this->getUserId();
        $actionLog->save();
    }

    public function beforeUpdate(): void
    {
        self::$oldAttributes = $this->owner->getOldAttributes();
    }

    public function afterUpdate(): void
    {
        $actionLog = new ActionLog();
        $actionLog->entity = $this->getEntity();
        $actionLog->entity_id = $this->getEntityId();
        $actionLog->action_id = ActionLog::ACTION_ID_UPDATE;
        $actionLog->old_state = $this->prepareAttributes(self::$oldAttributes);
        $actionLog->new_state = $this->prepareAttributes($this->owner->attributes);
        $actionLog->user_id = $this->getUserId();
        if ($actionLog->save()) {
            self::$oldAttributes = null;
        }
    }

    public function beforeDelete(): void
    {
        $actionLog = new ActionLog();
        $actionLog->entity = $this->getEntity();
        $actionLog->entity_id = $this->getEntityId();
        $actionLog->action_id = ActionLog::ACTION_ID_DELETE;
        $actionLog->old_state = $this->prepareAttributes($this->owner->attributes);
        $actionLog->user_id = $this->getUserId();
        if ($actionLog->save()) {
            self::$oldAttributes = null;
        }
    }

    protected function getUserId(): ?int
    {
        if (AppHelper::isCLI()) {
            return null;
        }

        if (Yii::$app instanceof Application && Yii::$app->user) {
            return Yii::$app->user->id;
        }

        return null;
    }

    protected function getEntityId(): int
    {
        return $this->owner->id;
    }

    protected function getEntity(): string
    {
        return AppHelper::getClassName($this->owner::class);
    }

    protected function prepareAttributes(array $attributes): string
    {
        foreach ($this->ignoredAttributes as $attribute) {
            if (array_key_exists($attribute, $attributes)) {
                unset($attributes[$attribute]);
            }
        }
        return Json::encode($attributes);
    }
}