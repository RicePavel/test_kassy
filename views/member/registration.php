<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registration';
$form = ActiveForm::begin(['id' => 'registration-form']); 

?>

<h1>Форма регистрации</h1>
    
<?php if ($saved) { ?>
    <h2>Вы успешно зарегистрировались!</h2>
<?php } else { ?>

    <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off'])->label('Email*'); ?> 
    <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off'])->label('Пароль*'); ?>    
    <?= $form->field($model, 'organization_name')->textInput()->label('Наименование организации*'); ?>
    <?= $form->field($model, 'inn')->textInput()->label('ИНН*'); ?>
    <?= $form->field($model, 'kpp')->textInput()->label('КПП (заполните это поле, если организация является ИП)'); ?>

    <?= Html::submitButton('регистрация', ['class' => 'btn btn-primary']); ?>
<?php } ?>
<?php ActiveForm::end() ?>