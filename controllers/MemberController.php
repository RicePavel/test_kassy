<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\MemberRegistrationForm;
use app\models\Member;

class MemberController extends Controller 
{
    
    public function actionRegistration() {
        $saved = false;
        $model = new Member();
        if ($model->load(Yii::$app->request->post())) {
            $saved = $model->save();
        }
        return $this->render('registration', ['model' => $model, 'saved' => $saved]);
    }
    
}

