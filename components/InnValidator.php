<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use yii\validators\Validator;

class InnValidator extends Validator {
    
    public function validateAttribute($model, $attribute) {
        $inn = $model->$attribute;
        $errorMessage = '';
        $errorCode = 0;
        if (!InnValidator::validateInn($inn, $errorMessage, $errorCode)) {
            $this->addError($model, $attribute, $errorMessage);
        }
    }
    
    private static function validateInn($inn, &$error_message = null, &$error_code = null) {
		$result = false;
		$inn = (string) $inn;
		if (preg_match('/[^0-9]/', $inn)) {
			$error_code = 2;
			$error_message = 'ИНН может состоять только из цифр';
		} elseif (!in_array($inn_length = strlen($inn), [10, 12])) {
			$error_code = 3;
			$error_message = 'ИНН может состоять только из 10 или 12 цифр';
		} else {
			$check_digit = function($inn, $coefficients) {
				$n = 0;
				foreach ($coefficients as $i => $k) {
					$n += $k * (int) $inn{$i};
				}
				return $n % 11 % 10;
			};
			switch ($inn_length) {
				case 10:
					$n10 = $check_digit($inn, [2, 4, 10, 3, 5, 9, 4, 6, 8]);
					if ($n10 === (int) $inn{9}) {
						$result = true;
					}
					break;
				case 12:
					$n11 = $check_digit($inn, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
					$n12 = $check_digit($inn, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
					if (($n11 === (int) $inn{10}) && ($n12 === (int) $inn{11})) {
						$result = true;
					}
					break;
			}
			if (!$result) {
				$error_code = 4;
				$error_message = 'Неправильное контрольное число';
			}
		}
		return $result;
	}
    
}