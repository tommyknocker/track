<?php

namespace app\components\grid;

use yii\db\ActiveRecord;
use yii\grid\Column;

class DateColumn extends Column
{
    public $headerOptions = ['class' => 'date-column'];

    public $contentOptions = ['class' => 'text-nowrap'];

    public string $template = '{created_at}<br/>{updated_at}';

    public string $dateTemplate = '<span title="{label}"><i class="far fa-{icon}"></i> {date}</span>';

    public string $defaultIcon = 'calendar-alt';

    public string $defaultFormat = 'd.m.Y H:i:s';

    public array $icons = [
        'created_at' => 'calendar',
        'updated_at' => 'calendar-alt'
    ];

    public array $formats = [
        'created_at' => 'd.m.Y H:i:s',
        'updated_at' => 'd.m.Y H:i:s'
    ];

    public array $labels = [];

    /**
     * @param ActiveRecord $model
     * @param $attribute
     * @return string
     */
    protected function renderDate(ActiveRecord $model, $attribute): string
    {
        if ($model->hasAttribute($attribute)) {
            $icon = $this->icons[$attribute] ?? $this->defaultIcon;
            $format = $this->formats[$attribute] ?? $this->defaultFormat;
            $label = $this->label[$attribute] ?? $model->getAttributeLabel($attribute);
            $date = $model->{$attribute} ? date($format, $model->{$attribute}) : '-';
            return str_replace(['{icon}', '{date}', '{label}'], [$icon, $date, $label], $this->dateTemplate);
        }
        return '';
    }

    /**
     * @param ActiveRecord $model
     * @param $key
     * @param $index
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index): string
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model) {
            return $this->renderDate($model, $matches[1]);
        }, $this->template);
    }
}
