<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            [
                'attribute' => 'phone',
                'filter' =>  MaskedInput::widget([
                    'name' => 'phone',
                    'mask' => Yii::$app->params['phoneMask']
                ])
            ],
            'email:email',
            [
                'attribute' => 'type',
                'filter' => User::getListUserType(),
                'value' => function(User $model){
                    return $model->getTypeTitle();
                }
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


</div>
