<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Visit $model */

$this->title = 'Посещение №'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Посещения', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="visitor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
