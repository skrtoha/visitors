<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'username')->textInput() ?>
    <?=$form->field($model, 'email')->textInput() ?>
    <?=$form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => Yii::$app->params['phoneMask']
    ])?>
    <?=$form->field($model, 'type')->dropDownList(User::getListUserType())?>

    <div class="form-group">
        <?=Html::submitButton('Сохранить', ['class' => 'btn btn-success mt-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
