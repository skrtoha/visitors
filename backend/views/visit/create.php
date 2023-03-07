<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Visit $model */

$this->title = 'Создать посещение';
$this->params['breadcrumbs'][] = ['label' => 'Посещения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
