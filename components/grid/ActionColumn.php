<?php

namespace app\components\grid;

use app\components\helpers\AppHelper;
use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * {@inheritdoc}
     */
    public $contentOptions = ['class' => 'text-nowrap'];

    /**
     * {@inheritdoc}
     */
    public $buttonOptions = ['class' => 'btn btn-sm'];


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->initTemplate();
        $this->initDefaultButtons();
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('actionLog', 'clock', ['class' => 'btn-primary']);
        $this->initDefaultButton('view', 'eye', ['class' => 'btn-info']);
        $this->initDefaultButton('update', 'pencil-alt', ['class' => 'btn-warning']);
        $this->initDefaultButton('delete', 'trash', [
            'class' => 'btn-danger',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    protected function initTemplate()
    {
        if (Yii::$app->user->can(Yii::$app->id . '-action-log-index')) {
            $this->template = '{actionLog} ' . $this->template;
        }
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    case 'actionLog':
                        $title = 'Лог действий';
                        $url = [
                            'action-log/index',
                            'ActionLogSearch[entity]' => AppHelper::getClassName($model::class),
                            'ActionLogSearch[entity_id]' => $model->id
                        ];
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge_recursive([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "fas fa-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index)
                    : $this->visibleButtons[$name];
            } elseif (method_exists($model, 'can' . ucfirst($name))) {
                $isVisible = $model->{'can' . ucfirst($name)}();
            } else {
                $isVisible = true;
            }

            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            }

            return '';
        }, $this->template);
    }
}
