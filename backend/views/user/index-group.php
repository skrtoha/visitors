<?php

use common\models\Visit;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Информация о посещениях';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'user_id',
                'value' => function(Visit $model){
                    return $model->user->username;
                }
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Телефон',
                'value' => function(Visit $model){
                    return $model->user->phone;
                }
            ],
            'count_visits',
            [
                'attribute' => 'sum',
                'label' => 'Сумма'
            ],

        ],
    ]); ?>


</div>
