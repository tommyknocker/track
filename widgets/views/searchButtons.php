<?php

use yii\helpers\Html;

/**
 * @var string $clearUrl
 * @var string $resetUrl
 * @var string $exportToCSV
 * @var string $exportToCSVRoute
 * @var string $extendedFilter
 * @var string $showHr
 */

?>
<div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Сбросить', $resetUrl, ['class' => 'btn btn-default']) ?>
    <?php if($clearUrl): ?>
    <?= Html::a('Очистить', $clearUrl, ['class' => 'btn btn-danger']) ?>
    <?php endif; ?>
    <?php if ($exportToCSV) { ?>
        <?= Html::submitButton('Экспорт в CSV', ['class' => 'btn btn-primary btn-export-csv', 'data-url' => $exportToCSVRoute]) ?>
    <?php } ?>
    <?php if ($extendedFilter) : ?>
        |
        <small>
            <?= \yii\bootstrap5\Html::a('Расширенный фильтр', 'javascript:void(0)', ['id' => 'show_extended_filter']); ?>
        </small>
    <?php endif; ?>
</div>

<?php if ($showHr): ?>
    <hr>
<?php endif; ?>