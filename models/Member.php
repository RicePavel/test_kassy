<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\components\InnValidator;

class Member extends ActiveRecord {
   
    public function rules() {
        return [
            [['email', 'password', 'organization_name', 'inn', 'kpp'], 'safe'],
            [['email', 'password', 'organization_name', 'inn'], 'required', 'message' => 'Обязательное поле'],
            ['email', 'email', 'message' => 'Введите правильный email-адрес'],
            ['password', 'validatePassword'],
            ['email', 'unique', 'message' => 'такой email уже зарегистрирован, введите другое значение'],
            ['inn', InnValidator::className()],
            ['kpp', \app\components\KppValidator::className()]
        ];
    }
    
    public static function tableName() {
        return '{{member}}';
    }
    
    public function validatePassword($attribute, $params) {
        if (!preg_match('/^[а-яёА-ЯЁ\\w]+$/u', $this->$attribute)) {
            $this->addError($attribute, 'Пароль должен состоять из букв и цифр');
            return;
        }
        $errorMessage = '';
        $ok = true;
        if (!preg_match('/[а-яёa-z]/u', $this->$attribute)) {
            $ok = false;
            $errorMessage = 'Добавьте строчные буквы';
        }
        if ($ok && !preg_match('/[А-ЯЁA-Z]/u', $this->$attribute)) {
            $ok = false;
            $errorMessage = 'Добавьте заглавные буквы';
        }
        if ($ok && !preg_match('/[0-9]/', $this->$attribute)) {
            $ok = false;
            $errorMessage = 'Добавьте цифры';
        }
        if (!$ok) {
            $errorMessage = 'Пароль должен содержать: строчные буквы, заглавные буквы, цифры. ' . $errorMessage;
            $this->addError($attribute, $errorMessage);
        }
    }
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return true;
    }
   
}

