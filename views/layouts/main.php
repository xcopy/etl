<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Yii::$app->name ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><?= Yii::$app->name ?></a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= Url::to('csv') ?>" class="nav-link">Generate CSV file</a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="flex-fill">
        <?= $content ?>
    </main>
    <footer class="bg-light border-top text-center p-3"><?= Yii::powered() ?></footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
