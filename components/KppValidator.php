<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use yii\validators\Validator;

class KppValidator extends Validator {
    
    public function validateAttribute($model, $attribute) {
        $kpp = $model->$attribute;
        $errorMessage = '';
        $errorCode = 0;
        if (!KppValidator::validateKpp($kpp, $errorMessage, $errorCode)) {
            $this->addError($model, $attribute, $errorMessage);
        }
    }
    
    public static function validateKpp($kpp, &$error_message = null, &$error_code = null) {
		$result = false;
		$kpp = (string) $kpp;
		if (strlen($kpp) !== 9) {
			$error_code = 2;
			$error_message = 'КПП может состоять только из 9 знаков (цифр или заглавных букв латинского алфавита от A до Z)';
		} elseif (!preg_match('/^[0-9]{4}[0-9A-Z]{2}[0-9]{3}$/', $kpp)) {
			$error_code = 3;
			$error_message = 'Неправильный формат КПП';
		} else {
			$result = true;
		}
		return $result;
    }
    
}
