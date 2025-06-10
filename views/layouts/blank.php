<?php

/* @var $this View */

/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap5\BootstrapAsset;
use yii\web\View;

AppAsset::register($this);
BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body class="text-center flex">
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
